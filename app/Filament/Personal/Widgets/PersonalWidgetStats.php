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
        $totalMinutes = 0;

        // Obtener todas las entradas de trabajo del usuario
        $workTimesheets = Timesheet::where('user_id', $user->id)
            ->where('type', 'work')
            ->get();

        foreach ($workTimesheets as $timesheet) {
            $dayIn = Carbon::parse($timesheet->day_in);

            // Si hay day_out, calculamos la diferencia
            if ($timesheet->day_out) {
                $dayOut = Carbon::parse($timesheet->day_out);
                $totalMinutes += $dayIn->diffInMinutes($dayOut);
            } else {
                // Si no hay day_out y la sesión está activa, calculamos hasta ahora
                $totalMinutes += $dayIn->diffInMinutes(now());
            }
        }

        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    protected function getTotalPause(User $user)
    {
        $totalMinutes = 0;

        // Obtener todas las entradas de pausa del usuario
        $pauseTimesheets = Timesheet::where('user_id', $user->id)
            ->where('type', 'pause')
            ->get();

        foreach ($pauseTimesheets as $timesheet) {
            $dayIn = Carbon::parse($timesheet->day_in);

            // Si hay day_out, calculamos la diferencia
            if ($timesheet->day_out) {
                $dayOut = Carbon::parse($timesheet->day_out);
                $totalMinutes += $dayIn->diffInMinutes($dayOut);
            } else {
                // Si no hay day_out y la pausa está activa, calculamos hasta ahora
                $totalMinutes += $dayIn->diffInMinutes(now());
            }
        }

        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
