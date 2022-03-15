<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MechanicController extends Controller {

    public function index() {
        $mechanic = Mechanic::all();
        return view('master.mechanic.index', compact('mechanic'));
    }

    public function create() {
        return view('master.mechanic.create');
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'id_card' => 'max:255',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->storeAs('mechanic-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $validateData['status'] = '1';
        $validateData['birth_date'] = (!empty($request->birth_date) ? date('Y-m-d', strtotime($request->birth_date)) : NULL);

        Mechanic::create($validateData);

        return redirect()->route('mechanic.index')
                        ->with('success', 'Mechanic created successfully.');
    }

    public function show(Mechanic $mechanic) {
        return view('master.mechanic.show', compact('mechanic'));
    }

    public function edit(Mechanic $mechanic) {
        return view('master.mechanic.edit', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic) {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'id_card' => 'max:255',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if ($request->file('image') && request('image') != '') {
            if (!empty($mechanic->image)) {
                if (Storage::exists($mechanic->image)) {
                    Storage::delete($mechanic->image);
                }
            }
            $validateData['image'] = $request->file('image')->storeAs('mechanic-images', date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $validateData['birth_date'] = (!empty($request->birth_date) ? date('Y-m-d', strtotime($request->birth_date)) : NULL);

        $mechanic->update($validateData);

        return redirect()->route('mechanic.index')
                        ->with('success', 'Mechanic updated successfully');
    }

    public function destroy(Mechanic $mechanic) {
        $mechanic->delete();

        return redirect()->route('mechanic.index')
                        ->with('success', 'Mechanic <b>' . $mechanic->name . '</b> deleted successfully');
    }

}
