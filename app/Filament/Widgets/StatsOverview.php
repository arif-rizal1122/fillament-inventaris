<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $pemasaukan = Transaction::incomes()->get()->sum('amount');
        $pengeluaran = Transaction::expenses()->get()->sum('amount');

        return [
            Stat::make('Total Pemasukan', $this->formatRupiah($pemasaukan))
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Pengeluaran', $this->formatRupiah($pengeluaran))
            ->descriptionIcon('heroicon-m-arrow-trending-down'),
            Stat::make('Selisih', $this->formatRupiah($pemasaukan - $pengeluaran))
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }

    private function formatRupiah($amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
