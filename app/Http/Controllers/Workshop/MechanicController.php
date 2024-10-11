<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MechanicController extends Controller
{

    public function index()
    {
        $mechanic = Mechanic::all();
        return view('master.mechanic.index', compact('mechanic'));
    }

    public function create()
    {
        return view('master.mechanic.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'position' => 'max:255',
            'id_card' => 'max:255',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if ($image = $request->file('image')) {
            $destinationPath = 'images/mechanic-images/';
            $profileImage = "mechanicImages" . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $validateData['image'] = $profileImage;
            $validateData['image_url'] = $destinationPath . $profileImage;
        }

        $validateData['salary'] = substr(str_replace('.', '', $request->salary), 3);
        $validateData['positional_allowance'] = substr(str_replace('.', '', $request->positional_allowance), 3);
        $validateData['healthy_allowance'] = substr(str_replace('.', '', $request->healthy_allowance), 3);
        $validateData['other_allowance'] = substr(str_replace('.', '', $request->other_allowance), 3);
        $validateData['status'] = '1';
        $validateData['birth_date'] = (!empty($request->birth_date) ? date('Y-m-d', strtotime($request->birth_date)) : NULL);

        Mechanic::create($validateData);

        return redirect()->route('mechanic.index')->with('success', 'Mechanic created successfully.');
    }

    public function show(Mechanic $mechanic)
    {
        return view('master.mechanic.show', compact('mechanic'));
    }

    public function edit(Mechanic $mechanic)
    {
        return view('master.mechanic.edit', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'position' => 'max:255',
            'id_card' => 'max:255',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if (!empty($mechanic->image) && $request->hasFile('image')) {
            $imagePath = $mechanic->image_url;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        if ($image = $request->file('image')) {
            $destinationPath = 'images/mechanic-images/';
            $profileImage = "mechanicImages" . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $validateData['image'] = $profileImage;
            $validateData['image_url'] = $destinationPath . $profileImage;
        } elseif (!$request->hasFile('image') && !$mechanic->image) {
            unset($validateData['image_url']);
        }

        $validateData['salary'] = substr(str_replace('.', '', $request->salary), 3);
        $validateData['positional_allowance'] = substr(str_replace('.', '', $request->positional_allowance), 3);
        $validateData['healthy_allowance'] = substr(str_replace('.', '', $request->healthy_allowance), 3);
        $validateData['other_allowance'] = substr(str_replace('.', '', $request->other_allowance), 3);
        $validateData['birth_date'] = (!empty($request->birth_date) ? date('Y-m-d', strtotime($request->birth_date)) : NULL);

        $mechanic->update($validateData);

        return redirect()->route('mechanic.index')->with('success', 'Mechanic updated successfully');
    }

    public function destroy(Mechanic $mechanic)
    {

        if (!empty($mechanic->image)) {
            $imagePath = $mechanic->image_url;

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $mechanic->delete();

        return redirect()->route('mechanic.index')->with('success', 'Mechanic <b>' . $mechanic->name . '</b> deleted successfully');
    }

}
