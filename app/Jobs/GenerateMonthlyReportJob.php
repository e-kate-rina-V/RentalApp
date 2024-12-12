<?php

namespace App\Jobs;

use App\Events\ReportGenerated;
use App\Models\Ad;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $startDate;
    private string $endDate;
    private int $userId;

    public function __construct(string $startDate, string $endDate, int $userId)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }

    public function handle()
    {
        $ads = Ad::where('user_id', $this->userId)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        $totalAds = $ads->count();

        $income = Reservation::whereIn('ad_id', $ads->pluck('id'))
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total_cost');

        $seasonalData = Reservation::selectRaw('QUARTER(arrival_date) as season, COUNT(*) as bookings')
            ->whereIn('ad_id', $ads->pluck('id'))
            ->groupBy('season')
            ->get();

        $incomeTrend = Reservation::selectRaw('DATE(created_at) as date, SUM(total_cost) as total_income')
            ->whereIn('ad_id', $ads->pluck('id'))
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('date')
            ->get();

        Log::info('PDF Data:', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'totalAds' => $totalAds,
            'income' => $income,
            'seasonalData' => $seasonalData,
            'incomeTrend' => $incomeTrend,
        ]);

        try {
            ob_start();

            $pdf = PDF::loadView('reports.monthly', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalAds' => $totalAds,
                'income' => $income,
                'seasonalData' => $seasonalData->toArray(),
                'incomeTrend' => $incomeTrend->toArray(),
            ]);

            ob_end_clean();

            $fileName = 'monthly_report_' . now()->format('Y_m_d_His') . '.pdf';

            Storage::disk('public')->put('reports/' . $fileName, $pdf->output());

            broadcast(new ReportGenerated($fileName, 'Звіт успішно згенерований'));
        } catch (\Exception $e) {
            Log::error('Ошибка при генерации отчета: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
