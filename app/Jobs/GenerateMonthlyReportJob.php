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
use Illuminate\Support\Facades\Log;

class GenerateMonthlyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private string $startDate, private string $endDate, private int $userId) {}

    public function handle()
    {
        $adIds = Ad::where('user_id', $this->userId)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->pluck('id')
            ->toArray();

        $totalAds = count($adIds);

        $income = Reservation::whereIn('ad_id', $adIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total_cost');

        $seasonalData = Reservation::whereIn('ad_id', $adIds)
            ->get()
            ->groupBy(function ($reservation) {
                $month = $reservation->arrival_date?->month;
                return match (true) {
                    $month && in_array($month, [12, 1, 2]) => 'Winter',
                    $month && in_array($month, [3, 4, 5]) => 'Spring',
                    $month && in_array($month, [6, 7, 8]) => 'Summer',
                    $month && in_array($month, [9, 10, 11]) => 'Autumn',
                    default => 'Unknown',
                };
            })
            ->map(fn($group, $season) => [
                'season' => $season,
                'bookings' => $group->count(),
            ])
            ->values();

        $incomeTrend = Reservation::selectRaw('DATE(created_at) as date, SUM(total_cost) as total_income')
            ->whereIn('ad_id', $adIds)
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
