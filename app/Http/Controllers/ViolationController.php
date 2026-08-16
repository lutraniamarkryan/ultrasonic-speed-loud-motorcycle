<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use Illuminate\Support\Facades\DB;
use App\Models\SystemLog;

class ViolationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $totalCount = Violation::count();

        $recentViolations = Violation::orderBy(
            'created_at',
            'desc'
        )->get();

        return view('MainDashboard', [
            'totalCount' => $totalCount,
            'violations' => $recentViolations,
            'violation'  => $recentViolations
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VIOLATION RECORDS PANEL
    |--------------------------------------------------------------------------
    */

    public function recordsPanel()
    {
        $allRecords = Violation::orderBy(
            'created_at',
            'desc'
        )->get();

        return view('partials.violations_table', [
            'violations' => $allRecords,
            'violation'  => $allRecords
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE VIOLATION
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('violations.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE VIOLATION
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255',
            'violation_type' => 'required|string',
            'recorded_speed' => 'nullable|integer',
            'decibel_level' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $violation = Violation::create($validated);

        SystemLog::create([
            'user' => auth()->user()->email ?? 'Admin',
            'action' => 'Added Violation',
            'description' =>
                'Added violation for plate number ' .
                $violation->plate_number,
            'violation_id' => $violation->id,
            'location' =>
                $violation->location ??
                'Binalonan, Pangasinan',
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Violation added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT VIOLATION
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $violation = Violation::findOrFail($id);

        return view(
            'violations.edit',
            compact('violation')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE VIOLATION
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        $validated = $request->validate([
            'plate_number' => 'required|string|max:255',
            'violation_type' => 'required|string',
            'recorded_speed' => 'nullable|integer',
            'decibel_level' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $violation->update($validated);

        SystemLog::create([
            'user' => auth()->user()->email ?? 'Admin',
            'action' => 'Updated Violation',
            'description' =>
                'Updated violation for plate number ' .
                $violation->plate_number,
            'violation_id' => $violation->id,
            'location' =>
                $violation->location ??
                'Binalonan, Pangasinan',
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Violation updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE VIOLATION
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $violation = Violation::findOrFail($id);

        $plateNumber = $violation->plate_number;
        $location =
            $violation->location ??
            'Binalonan, Pangasinan';
        $violationId = $violation->id;

        $violation->delete();

        SystemLog::create([
            'user' => auth()->user()->email ?? 'Admin',
            'action' => 'Deleted Violation',
            'description' =>
                'Deleted violation for plate number ' .
                $plateNumber,
            'violation_id' => $violationId,
            'location' => $location,
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Violation deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RESOLVE VIOLATION
    |--------------------------------------------------------------------------
    */

    public function resolve($id)
    {
        $violation = Violation::findOrFail($id);

        $violation->update([
            'status' => 'Resolved'
        ]);

        SystemLog::create([
            'user' => auth()->user()->email ?? 'Admin',
            'action' => 'Resolved Violation',
            'description' =>
                'Marked violation for plate number ' .
                $violation->plate_number .
                ' as resolved',
            'violation_id' => $violation->id,
            'location' =>
                $violation->location ??
                'Binalonan, Pangasinan',
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Violation marked as resolved.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ANALYTICS PANEL
    |--------------------------------------------------------------------------
    */

    public function analyticsPanel()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL VIOLATIONS
        |--------------------------------------------------------------------------
        */

        $totalViolations = Violation::count();


        /*
        |--------------------------------------------------------------------------
        | OVER-SPEEDING - TODAY
        |
        | Overspeeding + Both
        |--------------------------------------------------------------------------
        */

        $speedDaily = Violation::whereIn(
            'violation_type',
            [
                'Overspeeding',
                'Both'
            ]
        )
        ->whereDate(
            'created_at',
            today()
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | OVER-SPEEDING - THIS MONTH
        |--------------------------------------------------------------------------
        */

        $speedMonthly = Violation::whereIn(
            'violation_type',
            [
                'Overspeeding',
                'Both'
            ]
        )
        ->whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | LOUD MOTORCYCLE - TODAY
        |
        | Database value is "Loud Pipe"
        |--------------------------------------------------------------------------
        */

        $loudDaily = Violation::whereIn(
            'violation_type',
            [
                'Loud Pipe',
                'Both'
            ]
        )
        ->whereDate(
            'created_at',
            today()
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | LOUD MOTORCYCLE - THIS MONTH
        |--------------------------------------------------------------------------
        */

        $loudMonthly = Violation::whereIn(
            'violation_type',
            [
                'Loud Pipe',
                'Both'
            ]
        )
        ->whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL OVER-SPEEDING
        |
        | Used by the comparison chart
        |--------------------------------------------------------------------------
        */

        $speedTotal = Violation::whereIn(
            'violation_type',
            [
                'Overspeeding',
                'Both'
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL LOUD MOTORCYCLE
        |
        | Used by the comparison chart
        |--------------------------------------------------------------------------
        */

        $loudTotal = Violation::whereIn(
            'violation_type',
            [
                'Loud Pipe',
                'Both'
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | 24-HOUR PEAK HOURS
        |--------------------------------------------------------------------------
        */

        $hourlyDataset = array_fill(
            0,
            24,
            0
        );

        $rawHours = Violation::selectRaw(
            'HOUR(created_at) as hour, COUNT(*) as total'
        )
        ->groupBy('hour')
        ->get();

        foreach ($rawHours as $record) {

            if ($record->hour !== null) {

                $hour = (int) $record->hour;

                $hourlyDataset[$hour] =
                    (int) $record->total;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | REPEAT OFFENDERS
        |--------------------------------------------------------------------------
        */

        $repeatOffenders = Violation::select(
            'plate_number'
        )
        ->selectRaw(
            'COUNT(*) as total_offenses'
        )
        ->whereNotNull(
            'plate_number'
        )
        ->where(
            'plate_number',
            '!=',
            'N/A'
        )
        ->where(
            'plate_number',
            '!=',
            ''
        )
        ->groupBy(
            'plate_number'
        )
        ->having(
            'total_offenses',
            '>',
            1
        )
        ->orderBy(
            'total_offenses',
            'desc'
        )
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN ANALYTICS PANEL
        |--------------------------------------------------------------------------
        */

        return view(
            'partials.analytics_panel',
            [
                'totalViolations' =>
                    $totalViolations,

                'speedDaily' =>
                    $speedDaily,

                'speedMonthly' =>
                    $speedMonthly,

                'loudDaily' =>
                    $loudDaily,

                'loudMonthly' =>
                    $loudMonthly,

                /*
                | New variables for:
                | Overspeeding vs Loud Motorcycle
                */

                'speedTotal' =>
                    $speedTotal,

                'loudTotal' =>
                    $loudTotal,

                /*
                | Peak Hours
                */

                'hourlyData' =>
                    array_values(
                        $hourlyDataset
                    ),

                /*
                | Repeat offenders
                */

                'repeatOffenders' =>
                    $repeatOffenders
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT CSV
    |--------------------------------------------------------------------------
    */

    public function exportCSV()
    {
        $records = Violation::orderBy(
            'created_at',
            'desc'
        )->get();

        $csvFileName =
            'traffic_device_report_' .
            date('Y-m-d') .
            '.csv';

        $headers = [
            'Content-type' =>
                'text/csv',

            'Content-Disposition' =>
                "attachment; filename=$csvFileName",

            'Pragma' =>
                'no-cache',

            'Cache-Control' =>
                'must-revalidate, post-check=0, pre-check=0',

            'Expires' =>
                '0'
        ];

        $columns = [
            'Violation ID',
            'Plate Number',
            'Violation Type',
            'Speed (km/h)',
            'Noise (dB)',
            'Timestamp',
            'Status'
        ];

        $callback = function () use (
            $records,
            $columns
        ) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv(
                $file,
                $columns
            );

            foreach ($records as $task) {

                fputcsv(
                    $file,
                    [
                        $task->id,

                        $task->plate_number ??
                            'N/A',

                        $task->violation_type ??
                            'N/A',

                        ($task->recorded_speed ?? 0) .
                            ' km/h',

                        ($task->decibel_level ?? 0) .
                            ' dB',

                        $task->created_at,

                        $task->status ??
                            'Pending'
                    ]
                );
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SYSTEM LOGS
    |--------------------------------------------------------------------------
    */

    public function recordsLogs()
    {
        $logs = SystemLog::orderBy(
            'created_at',
            'desc'
        )->get();

        return view(
            'partials.logs_panel',
            [
                'logs' => $logs
            ]
        );
    }
}