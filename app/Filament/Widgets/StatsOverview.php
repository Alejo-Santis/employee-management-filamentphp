<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Timesheet;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEmployees = User::all()->count();
        $totalHolidays = Holiday::where('type', 'pending')->count();
        $totalTimesheets = Timesheet::all()->count();

        return [
            Stat::make('Employees', $totalEmployees)
                ->description("$totalEmployees increase")
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Pending Holidays', $totalHolidays)
                ->description("$totalHolidays increase")
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Timesheets', $totalTimesheets)
                ->description("$totalTimesheets increase")
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
