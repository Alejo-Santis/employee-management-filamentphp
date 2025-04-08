<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('inwork')
                ->label('Enter Work')
                ->color('success')
                ->icon('heroicon-o-play')
                ->keyBindings(['command+s', 'ctrl+s'])
                ->requiresConfirmation()
                ->action(function () {
                    $user = Auth::user();
                    $thimesheet = new Timesheet();
                    $thimesheet->calendar_id = 1;
                    $thimesheet->user_id = $user->id;
                    $thimesheet->type = 'work';
                    $thimesheet->day_in = Carbon::now();
                    $thimesheet->day_out = Carbon::now()->addHours(8);
                    $thimesheet->save();
                    Notification::make()
                        ->title('Timesheet Created')
                        ->body('Your timesheet has been created successfully.')
                        ->success()
                        ->send();
                }),
            Action::make('inpause')
                ->label('Enter Pause')
                ->color('danger')
                ->icon('heroicon-o-pause')
                ->requiresConfirmation(),
            Actions\CreateAction::make()
                ->label('New Timesheet')
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }
}
