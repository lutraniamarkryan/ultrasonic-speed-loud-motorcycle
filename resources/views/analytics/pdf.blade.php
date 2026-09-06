<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Device Analytics Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0;
        }

        .section {
            margin-top: 20px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 7px;
            text-align: center;
        }

        th {
            font-weight: bold;
            background-color: #eeeeee;
        }

        .summary {
            width: 100%;
        }

        .summary td {
            width: 33.33%;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Traffic Device Analytics Report</h1>
    <p>Ultrasonic Speed and Loud Motorcycle Detection System</p>
    <p>Binalonan, Pangasinan</p>
    <p>Date Generated: {{ date('F d, Y') }}</p>
</div>

<div class="section">
    <div class="section-title">Summary</div>

    <table class="summary">
        <tr>
            <td>
                Total Violations<br>
                {{ $totalViolations }}
            </td>

            <td>
                Overspeeding<br>
                {{ $speedTotal }}
            </td>

            <td>
                Loud Motorcycle<br>
                {{ $loudTotal }}
            </td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Violation Statistics</div>

    <table>
        <tr>
            <th>Violation Type</th>
            <th>Today</th>
            <th>This Month</th>
            <th>Total</th>
        </tr>

        <tr>
            <td>Overspeeding</td>
            <td>{{ $speedDaily }}</td>
            <td>{{ $speedMonthly }}</td>
            <td>{{ $speedTotal }}</td>
        </tr>

        <tr>
            <td>Loud Motorcycle</td>
            <td>{{ $loudDaily }}</td>
            <td>{{ $loudMonthly }}</td>
            <td>{{ $loudTotal }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Peak Hours</div>

    <table>
        <tr>
            <th>Hour</th>
            <th>Violations</th>
        </tr>

        @foreach($hourlyData as $hour => $total)
            <tr>
                <td>{{ $hour }}:00</td>
                <td>{{ $total }}</td>
            </tr>
        @endforeach
    </table>
</div>

<div class="section">
    <div class="section-title">Overspeeding vs Loud Motorcycle</div>

    <table>
        <tr>
            <th>Violation Type</th>
            <th>Total</th>
        </tr>

        <tr>
            <td>Overspeeding</td>
            <td>{{ $speedTotal }}</td>
        </tr>

        <tr>
            <td>Loud Motorcycle</td>
            <td>{{ $loudTotal }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Top Repeat Offenders</div>

    <table>
        <tr>
            <th>Plate Number</th>
            <th>Total Offenses</th>
        </tr>

        @forelse($repeatOffenders as $offender)
            <tr>
                <td>{{ $offender->plate_number }}</td>
                <td>{{ $offender->total_offenses }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No repeat offenders found.</td>
            </tr>
        @endforelse
    </table>
</div>

<div class="footer">
    Ultrasonic Speed and Loud Motorcycle Detection System
</div>

</body>
</html>

