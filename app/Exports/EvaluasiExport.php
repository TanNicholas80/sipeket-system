<?php

namespace App\Exports;

use App\Models\EvaluasiTingkat;
use App\Services\EvaluasiKenaikanTingkatService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EvaluasiExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return EvaluasiTingkat::with(['siswa.user', 'tingkat'])
            ->orderByDesc('tanggal_evaluasi')
            ->orderByDesc('created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Periode',
            'Tingkat',
            'Jenis Penilaian',
            'Nilai Akhir',
            'Status Kelulusan',
            'Keputusan',
            'Tanggal Evaluasi',
        ];
    }

    public function map($evaluasi): array
    {
        static $no = 0;
        $no++;

        $tingkat = $evaluasi->tingkat;
        $statusKelulusan = $evaluasi->status_kelulusan ?? '';
        $service = app(EvaluasiKenaikanTingkatService::class);

        return [
            $no,
            $evaluasi->siswa?->user?->name ?? $evaluasi->siswa?->nama_lengkap ?? '-',
            $evaluasi->tahun_periode ?? '-',
            $tingkat?->nama_tingkat ?? '-',
            $evaluasi->rekap_nilai_ujian_id ? 'Ujian' : 'Harian',
            (float) $evaluasi->rata_rata_nilai,
            $tingkat ? $tingkat->labelKelulusan($statusKelulusan) : '-',
            $service->labelKeputusan($evaluasi->status, $statusKelulusan, $tingkat),
            $evaluasi->tanggal_evaluasi?->format('d/m/Y') ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Hasil Evaluasi';
    }
}
