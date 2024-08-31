<?php

namespace App\Http\Controllers;

use App\Models\Guideline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuidelineController extends Controller
{
    public function index()
    {
        $guidelines = Guideline::paginate(15);
        return view('guidelines.index', compact('guidelines'));
    }

    public function create()
    {
        return view('guidelines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|mimes:pdf|max:20480', // 20MB
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs('guidelines', Str::random(10) . '.' . $file->getClientOriginalExtension(), 'public');

        Guideline::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->route('guidelines.index')->with('success', 'Guideline created successfully.');
    }

    public function edit(Guideline $guideline)
    {
        return view('guidelines.edit', compact('guideline'));
    }

    public function update(Request $request, Guideline $guideline)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480', // 20MB
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($guideline->file_path);
            $file = $request->file('file');
            $filePath = $file->storeAs('guidelines', Str::random(10) . '.' . $file->getClientOriginalExtension(), 'public');
            $guideline->file_path = $filePath;
        }

        $guideline->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('guidelines.index')->with('success', 'Guideline updated successfully.');
    }

    public function destroy(Guideline $guideline)
    {
        Storage::disk('public')->delete($guideline->file_path);
        $guideline->delete();

        return redirect()->route('guidelines.index')->with('success', 'Guideline deleted successfully.');
    }

    public function download(Guideline $guideline)
    {
        return Storage::disk('public')->download($guideline->file_path);
    }
}
