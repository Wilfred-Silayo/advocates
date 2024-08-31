<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Visitor;

class ChartController extends Controller
{
    public function userData()
    {
        // Define the days of the week
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Get user counts for this week
        $thisWeek = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('DAYNAME(created_at) as day, count(*) as count')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, ' . implode(',', array_map(fn($day) => "'" . $day . "'", $daysOfWeek)) . ')')
            ->get()
            ->keyBy('day');

        // Get user counts for last week
        $lastWeek = User::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->selectRaw('DAYNAME(created_at) as day, count(*) as count')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, ' . implode(',', array_map(fn($day) => "'" . $day . "'", $daysOfWeek)) . ')')
            ->get()
            ->keyBy('day');

        // Fill missing days with zero count
        $thisWeekData = array_map(fn($day) => ['day' => $day, 'count' => $thisWeek->get($day)->count ?? 0], $daysOfWeek);
        $lastWeekData = array_map(fn($day) => ['day' => $day, 'count' => $lastWeek->get($day)->count ?? 0], $daysOfWeek);

        $totalUsersThisWeek = array_sum(array_column($thisWeekData, 'count'));
        $totalUsersLastWeek = array_sum(array_column($lastWeekData, 'count'));
        $percentageIncrease = $totalUsersLastWeek ? (($totalUsersThisWeek - $totalUsersLastWeek) / $totalUsersLastWeek) * 100 : 0;

        return response()->json([
            'thisWeek' => $thisWeekData,
            'lastWeek' => $lastWeekData,
            'totalUsersThisWeek' => $totalUsersThisWeek,
            'percentageIncrease' => round($percentageIncrease, 2)
        ]);
    }

    public function getChartData()
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Get visit counts for this week
        $thisWeek = Visitor::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('DAYNAME(created_at) as day, count(*) as count')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, ' . implode(',', array_map(fn($day) => "'" . $day . "'", $daysOfWeek)) . ')')
            ->get()
            ->keyBy('day');

        // Get visit counts for last week
        $lastWeek = Visitor::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->selectRaw('DAYNAME(created_at) as day, count(*) as count')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, ' . implode(',', array_map(fn($day) => "'" . $day . "'", $daysOfWeek)) . ')')
            ->get()
            ->keyBy('day');

        // Fill missing days with zero count
        $thisWeekData = array_map(fn($day) => ['day' => $day, 'count' => $thisWeek->get($day)->count ?? 0], $daysOfWeek);
        $lastWeekData = array_map(fn($day) => ['day' => $day, 'count' => $lastWeek->get($day)->count ?? 0], $daysOfWeek);

        $totalVisitorsThisWeek = array_sum(array_column($thisWeekData, 'count'));
        $totalVisitorsLastWeek = array_sum(array_column($lastWeekData, 'count'));
        $percentageIncrease = $totalVisitorsLastWeek ? (($totalVisitorsThisWeek - $totalVisitorsLastWeek) / $totalVisitorsLastWeek) * 100 : 0;

        return response()->json([
            'thisWeek' => $thisWeekData,
            'lastWeek' => $lastWeekData,
            'totalVisitorsThisWeek' => $totalVisitorsThisWeek,
            'percentageIncrease' => round($percentageIncrease, 2)
        ]);
    }
}
