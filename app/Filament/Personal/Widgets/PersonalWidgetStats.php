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
                ->description('Work Hours | Minutes')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
            Stat::make('Total Pause', $this->getTotalPause(Auth::user()))
                ->description('Pause Hours | Minutes')
                ->descriptionIcon('heroicon-m-pause')
                ->color('warning'),
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
        $timesheets = Timesheet::where('user_id', $user->id)
            ->where('type', 'work')
            ->whereDate('created_at', Carbon::today())
            ->get();
        $sumSeconds = 0;
        foreach ($timesheets as $timesheet) {
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSeconds += $totalDuration;
        }
        $formatTime = gmdate('H:i:s', $sumSeconds);

        return $formatTime;
    }

    protected function getTotalPause(User $user)
    {
        $timesheets = Timesheet::where('user_id', $user->id)
            ->where('type', 'pause')
            ->whereDate('created_at', Carbon::today())
            ->get();
        $sumSeconds = 0;
        foreach ($timesheets as $timesheet) {
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSeconds += $totalDuration;
        }
        $formatTime = gmdate('H:i:s', $sumSeconds);

        return $formatTime;
    }
}
