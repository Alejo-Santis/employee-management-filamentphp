<?php

namespace App\Imports;

use App\Models\Calendar;
use App\Models\Timesheet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MyTimesheetImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $calendarId = Calendar::where('name', $row['calendario'])->first();
            if ($calendarId !== null) {
                Timesheet::create([
                    'calendar_id' => $calendarId->id,
                    'type' => $row['tipo'],
                    'day_in' => $row['día_de_entrada'],
                    'day_out' => $row['día_de_salida'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
