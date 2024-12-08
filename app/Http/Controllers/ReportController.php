<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateMonthlyReportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function generateReport(Request $request): JsonResponse
    {
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        dispatch(new GenerateMonthlyReportJob($startDate, $endDate, Auth::id()));

        return response()->json([
            'message' => 'Отчет генерируется. Ожидайте уведомления.',
        ], 202);
    }
}
