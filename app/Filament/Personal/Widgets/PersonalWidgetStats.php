<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user()))
                ->description('Pending')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user()))
                ->description('Approved')
                ->descriptionIcon('heroicon-m-check')
                ->color('success'),
            Stat::make('Total Work', $this->getTotalWork(Auth::user()))
                ->description('Work Hours')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
        ];
    }

    protected function getPendingHolidays(User $user)
    {
        $totalPendingHolidays = Holiday::where('user_id', $user->id)
            ->where('type', 'pending')
            ->get()
            ->count();

        return $totalPendingHolidays;
    }

    protected function getApprovedHolidays(User $user)
    {
        $totalApprovedHolidays = Holiday::where('user_id', $user->id)
            ->where('type', 'approved')
            ->get()
            ->count();

        return $totalApprovedHolidays;
    }
    protected function getTotalWork(User $user)
    {
        $totalMinutes = Timesheet::where('user_id', $user->id)
            ->where('type', 'work')
            ->get()
            ->sum(function ($timesheet) {
                if (!$timesheet->day_in || !$timesheet->day_out) {
                    return 0;
                }

                $dayIn = Carbon::parse($timesheet->day_in);
                $dayOut = Carbon::parse($timesheet->day_out);

                return $dayIn->diffInMinutes($dayOut);
            });

        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes); // por ejemplo "07:45"
    }
}
