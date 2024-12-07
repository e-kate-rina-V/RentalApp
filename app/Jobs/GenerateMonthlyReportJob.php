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

    private $startDate;
    private $endDate;
    private $userId;

    public function __construct($startDate, $endDate, $userId)
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
            $pdf = PDF::loadView('reports.monthly', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalAds' => $totalAds,
                'income' => $income,
                'seasonalData' => $seasonalData->toArray(),
                'incomeTrend' => $incomeTrend->toArray(),
            ]);

            $pdfContent = $pdf->output();
            $fileName = 'monthly_report_' . now()->format('Y_m_d_His') . '.pdf';

            Storage::put('reports/' . $fileName, $pdfContent);
            Log::info('PDF сохранён в: ' . storage_path('app/reports/' . $fileName));

            broadcast(new ReportGenerated($fileName, 'Отчет успешно сгенерирован.'));
        } catch (\Exception $e) {
            Log::error('Ошибка при генерации отчета: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
