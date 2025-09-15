<?php

namespace App\Exports;

use App\Models\BookingsModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return BookingsModel::with(['lapangan', 'pemesan'])
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal Transaksi' => $item->created_at->format('Y-m-d'),
                    'Tanggal Booking'   => $item->tanggal,
                    'Nama Lapangan'     => $item->lapangan?->nama_lapangan ?? '-',
                    'Durasi (jam)'      => $item->durasi_jam,
                    'Uang Booking'      => 'Rp. ' . number_format($item->bayar_midtrans, 0, ',', '.'),
                    'Uang Tunai'        => 'Rp. ' . number_format($item->total_bayar - $item->bayar_midtrans, 0, ',', '.'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal Transaksi',
            'Tanggal Booking',
            'Nama Lapangan',
            'Durasi (jam)',
            'Uang Booking',
            'Uang Tunai'
        ];
    }
}
