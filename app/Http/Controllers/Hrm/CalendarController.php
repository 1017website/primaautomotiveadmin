<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CalendarController extends Controller
{
    public function index()
    {
        $year = request('year', now()->year);
        $month = request('month', now()->month);

        $currentYear = Carbon::now()->year;

        Mechanic::chunk(100, function ($mechanics) use ($currentYear) {
            foreach ($mechanics as $mechanic) {
                $birthdayThisYear = Carbon::parse($mechanic->birth_date)
                    ->setYear($currentYear)
                    ->toDateString();

                Note::firstOrCreate(
                    [
                        'date' => $birthdayThisYear,
                        'title' => "🎂 {$mechanic->name}'s Birthday",
                    ],
                    [
                        'description' => "Wish {$mechanic->name} a happy birthday!",
                        'color' => 'purple',
                    ]
                );
            }
        });

        $notes = Note::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get()
            ->groupBy(fn($note) => $note->date->toDateString());

        return view('hrm.calendar.index', compact('year', 'month', 'notes'));
    }


    public function events()
    {
        $notes = Note::all();

        return $notes->map(fn($n) => [
            'id' => $n->id,
            'title' => $n->title,
            'color' => $n->color,
            'start' => $n->date->toDateString(),
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|in:blue,red,green,yellow,purple,orange,gray,none',
        ]);

        try {
            Note::create($data);
            Session::flash('success', 'Note added for ' . $data['date'] . '!');
        } catch (\Throwable $e) {
            Session::flash('error', 'Could not save note. Please try again.');
        }

        return redirect()->back();
    }

    public function updateEvents(Request $request, Note $note)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => [
                'required',
                Rule::in([
                    'blue',
                    'red',
                    'green',
                    'yellow',
                    'purple',
                    'orange',
                    'gray',
                    'none'
                ])
            ],
        ]);

        try {
            $note->update($data);
            Session::flash('success', "Note updated for {$data['date']}!");

        } catch (\Throwable $e) {
            Session::flash('error', 'Could not update note. Please try again.');
        }

        return response()->json(['reload' => true]);
    }

    public function deleteEvents(Request $request)
    {
        try {
            $note = Note::findOrFail($request->id);
            $note->delete();

            Session::flash('success', "Note deleted for {$note->date}!");
        } catch (\Throwable $e) {
            Session::flash('error', 'Could not delete note. Please try again.');
        }
        return response()->json(['reload' => true]);
    }
}
