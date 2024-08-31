<?php
namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::paginate(15);
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|mimes:pdf|max:20480', // 20MB
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs('reports', Str::random(10) . '.' . $file->getClientOriginalExtension(), 'public');

        Report::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480', // 20MB
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($report->file_path);
            $file = $request->file('file');
            $filePath = $file->storeAs('reports', Str::random(10) . '.' . $file->getClientOriginalExtension(), 'public');
            $report->file_path = $filePath;
        }

        $report->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        Storage::disk('public')->delete($report->file_path);
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    public function download(Report $report)
    {
        return Storage::disk('public')->download($report->file_path);
    }
}
