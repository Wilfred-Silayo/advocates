<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(15);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'date_time' => 'required|date',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/events');

                $images[] = 'events/' . basename($path);
            }
        }

        Event::create([
            'name' => $request->name,
            'content' => $request->content,
            'date_time' => Carbon::parse($request->date_time),
            'images' => $images,
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'date_time' => 'required|date',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = $event->images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/events');

                $images[] = 'events/' . basename($path);
            }
        }

        $event->update([
            'name' => $request->name,
            'content' => $request->content,
            'date_time' => Carbon::parse($request->date_time),
            'images' => $images,
        ]);
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }


    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        foreach ($event->images as $image) {
            Storage::delete($image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
