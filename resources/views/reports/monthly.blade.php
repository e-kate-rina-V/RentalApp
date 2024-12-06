<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>
</head>

<body>
    <div class="header">
        <h1>Monthly Report</h1>
        <p>Period: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <div class="section">
        <h2>General Statistics</h2>
        <p><strong>Total Listings:</strong> {{ $totalAds }}</p>
        <p><strong>Total Income:</strong> ${{ number_format($income, 2) }}</p>
    </div>

    <div class="section">
        <h2>Income Trend</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Income</th>
                </tr>
            </thead>
            <tbody>
                @if(count($incomeTrend) > 0)
                @foreach ($incomeTrend as $trend)
                <tr>
                    <td>{{ $trend->date }}</td>
                    <td>${{ number_format($trend->total_income, 2) }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">No data available.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Seasonal Booking Activity</h2>
        <table>
            <thead>
                <tr>
                    <th>Season</th>
                    <th>Number of Bookings</th>
                </tr>
            </thead>
            <tbody>
                @if (count($seasonalData) > 0 )
                @foreach ($seasonalData as $season)
                <tr>
                    <td>
                        @switch($season->season)
                        @case(1) Winter @break
                        @case(2) Spring @break
                        @case(3) Summer @break
                        @case(4) Autumn @break
                        @default Unknown
                        @endswitch
                    </td>
                    <td>{{ $season->bookings }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">No data available.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generated on {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>

</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 40px;
    }

    .header h1 {
        margin: 0;
    }

    .section {
        margin-bottom: 30px;
    }

    .section h2 {
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    table th {
        background-color: #f4f4f4;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        color: #888;
        margin-top: 50px;
    }
</style>