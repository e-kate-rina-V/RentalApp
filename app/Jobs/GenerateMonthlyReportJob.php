<?php

namespace App\Jobs;

use App\Events\ReportGenerated;
use App\Models\Ad;
use App\Models\Reservation;
use Spatie\LaravelPdf\Facades\Pdf;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Broadcast;

class GenerateMonthlyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $startDate;
    private $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function handle()
    {
        $totalAds = Ad::whereBetween('created_at', [$this->startDate, $this->endDate])->count();

        $income = Reservation::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total_cost');

        $seasonalData = Reservation::selectRaw('QUARTER(arrival_date) as season, COUNT(*) as bookings')
            ->groupBy('season')
            ->get();

        $incomeTrend = Reservation::selectRaw('DATE(created_at) as date, SUM(total_cost) as total_income')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('date')
            ->get();

        $pdf = PDF::loadView('reports.monthly', [
            'totalAds' => $totalAds,
            'income' => $income,
            'seasonalData' => $seasonalData,
            'incomeTrend' => $incomeTrend
        ]);

        $fileName = 'monthly_report_' . now()->format('Y_m_d_His') . '.pdf';
        Storage::put('reports/' . $fileName, $pdf->output());

        event(new ReportGenerated($fileName, 'Report generated successfully'));
    }
}
