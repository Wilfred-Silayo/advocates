<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function getVisitorsChartData(Request $request)
    {
        $filterType = $request->input('filter_type');
        $value = $request->input('value');

        if ($filterType === 'week') {
            $year = $value;
            $data = ['labels' => [], 'data' => []];
            $visitorsData = Visitor::whereYear('created_at', $year)
                ->selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day')
                ->toArray();

            $labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $data = array_values(array_map(fn($day) => $visitorsData[$day] ?? 0, range(1, 7)));

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);
        } elseif ($filterType === 'year') {
            $currentYear = Carbon::now()->year;
            $data = ['labels' => [], 'data' => []];
            $visitorsData = Visitor::whereYear('created_at', $currentYear)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $labels = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ]; // Months
            $data = array_values(array_map(fn($month) => $visitorsData[$month] ?? 0, range(1, 12)));

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);
        }

        return response()->json([
            'labels' => [],
            'data' => []
        ]);
    }

    public function getYearlyVisitorsChartData()
    {
        $currentYear = Carbon::now()->year;
        $data = ['labels' => [], 'data' => []];
        $visitorsData = Visitor::whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ]; // Months
        $data = array_values(array_map(fn($month) => $visitorsData[$month] ?? 0, range(1, 12)));

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getUsersChartData(Request $request)
    {
        $filterType = $request->input('filter_type');
        $value = $request->input('value');

        if ($filterType === 'week') {
            $year = $value;
            $data = ['labels' => [], 'data' => []];
            $usersData = User::whereYear('created_at', $year)
                ->selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day')
                ->toArray();

            $labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $data = array_values(array_map(fn($day) => $usersData[$day] ?? 0, range(1, 7)));

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);
        } elseif ($filterType === 'year') {
            $currentYear = Carbon::now()->year;
            $data = ['labels' => [], 'data' => []];
            $usersData = User::whereYear('created_at', $currentYear)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $labels = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            $data = array_values(array_map(fn($month) => $usersData[$month] ?? 0, range(1, 12)));

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);
        }

        return response()->json([
            'labels' => [],
            'data' => []
        ]);
    }
}
