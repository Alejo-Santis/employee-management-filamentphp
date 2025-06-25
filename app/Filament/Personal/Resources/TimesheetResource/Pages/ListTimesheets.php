<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Imports\MyTimesheetImport;
use App\Models\Timesheet;
use Carbon\Carbon;
use EightyNine\ExcelImport\ExcelImportAction;
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
        $lastTimesheet = Timesheet::where('user_id', Auth::user()->id)
            ->orderBy('day_in', 'desc')
            ->first();

        if ($lastTimesheet == null) {
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
                        /* $thimesheet->day_out = Carbon::now()->addHours(8); */
                        $thimesheet->save();
                        Notification::make()
                            ->title('Timesheet Created')
                            ->body('Your timesheet type work has been created successfully.')
                            ->success()
                            ->send();
                    }),
                Actions\CreateAction::make()
                    ->label('New Timesheet')
                    ->color('primary')
                    ->icon('heroicon-o-plus'),
            ];
        }

        return [
            Action::make('inwork')
                ->label('Enter Work')
                ->color('success')
                ->visible(!$lastTimesheet->day_out == null)
                ->disabled($lastTimesheet->day_out == null)
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
                    /* $thimesheet->day_out = Carbon::now()->addHours(8); */
                    $thimesheet->save();
                    Notification::make()
                        ->title('Timesheet Created')
                        ->body('Your timesheet type work has been created successfully.')
                        ->success()
                        ->send();
                }),
            Action::make('stopwork')
                ->label('Stop Work')
                ->color('warning')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->icon('heroicon-o-stop')
                ->keyBindings(['command+o', 'ctrl+o'])
                ->requiresConfirmation()
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    Notification::make()
                        ->title('Timesheet Created')
                        ->body('Your timesheet type stop work has been created successfully.')
                        ->success()
                        ->send();
                }),
            Action::make('inpause')
                ->label('Enter Pause')
                ->color('info')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type != 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->icon('heroicon-o-pause')
                ->requiresConfirmation()
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $thimesheet = new Timesheet();
                    $thimesheet->calendar_id = 1;
                    $thimesheet->user_id = Auth::user()->id;
                    $thimesheet->day_in = Carbon::now();
                    $thimesheet->type = 'pause';
                    $thimesheet->save();
                    Notification::make()
                        ->title('Timesheet Created')
                        ->body('Your timesheet type pause has been created successfully.')
                        ->success()
                        ->send();
                }),
            Action::make('stoppause')
                ->label('Stop Pause')
                ->color('danger')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type == 'pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->icon('heroicon-o-stop')
                ->requiresConfirmation()
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $thimesheet = new Timesheet();
                    $thimesheet->calendar_id = 1;
                    $thimesheet->user_id = Auth::user()->id;
                    $thimesheet->day_in = Carbon::now();
                    $thimesheet->type = 'work';
                    $thimesheet->save();
                    Notification::make()
                        ->title('Timesheet Created')
                        ->body('Your timesheet type stop pause has been created successfully.')
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make()
                ->label('New Timesheet')
                ->color('primary')
                ->icon('heroicon-o-plus'),
            ExcelImportAction::make()
                ->label('Import Timesheet')
                ->color('success')
                ->use(MyTimesheetImport::class),
        ];
    }
}
