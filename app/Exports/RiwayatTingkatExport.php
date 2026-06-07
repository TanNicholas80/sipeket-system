<?php

namespace App\Exports;

use App\Models\RiwayatTingkat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RiwayatTingkatExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return RiwayatTingkat::with(['siswa.user', 'tingkatAwal', 'tingkatAkhir'])
            ->orderByDesc('tanggal_naik')
            ->orderByDesc('created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Tingkat Awal',
            'Tingkat Akhir',
            'Tanggal',
            'Keterangan',
        ];
    }

    public function map($riwayat): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $riwayat->siswa?->user?->name ?? $riwayat->siswa?->nama_lengkap ?? '-',
            $riwayat->tingkatAwal?->nama_tingkat ?? '-',
            $riwayat->tingkatAkhir?->nama_tingkat ?? '-',
            $riwayat->tanggal_naik ? \Carbon\Carbon::parse($riwayat->tanggal_naik)->format('d/m/Y') : '-',
            $riwayat->isMengulang() ? 'Mengulang' : 'Naik Tingkat',
        ];
    }

    public function title(): string
    {
        return 'Riwayat Kenaikan Tingkat';
    }
}
