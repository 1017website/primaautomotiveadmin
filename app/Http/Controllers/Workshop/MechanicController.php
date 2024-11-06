<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            'id_card' => 'image|file|max:2048',
            'id_finger' => 'required|unique:mechanic,id_finger,NULL,id,deleted_at,NULL',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if ($id_card = $request->file('id_card')) {
            $destinationPath2 = 'images/mechanic-images/';
            $profileImage2 = "mechanicIDCard" . "-" . date('YmdHis') . "." . $id_card->getClientOriginalExtension();
            $id_card->move($destinationPath2, $profileImage2);
            $validateData['id_card'] = $destinationPath2 . $profileImage2;
        }

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

        $create = Mechanic::create($validateData);
        /*if ($create) {
            //register fingerprint
            $url = 'https://developer.fingerspot.io/api/set_userinfo';
            $randKey = $this->rand_char(25);
            $request = '{"trans_id":"' . $randKey . '", "cloud_id":"C2630451071B1E34", "data":{"pin":"' . $create->id . '", "name":"' . $create->name . '", "privilege":"1", "password":"123456"}}';
            $authorization = "Authorization: Bearer ASC98HR77NKSYS0O";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            //add to logs
            $data = ['unique_id' => $randKey, 'type' => 'set_user_info', 'request' => $request, 'response' => $response, 'created_by' => Auth::id(), 'created_at' => time()];
            DB::table('finger_logs')->insert($data);
        }*/

        return redirect()->route('mechanic.index')->with('success', 'Mechanic created successfully.');
    }

    function rand_char($length)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(mt_rand(33, 126));
        }
        return $random;
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
            'id_card' => 'image|file|max:2048',
            'id_finger' => 'required|unique:mechanic,id_finger,' . $mechanic->id . ',id,deleted_at,NULL',
            'birth_date' => 'date_format:d-m-Y',
            'phone' => 'max:255',
            'address' => 'max:500',
            'image' => 'image|file|max:2048',
        ]);

        if (!empty($mechanic->id_card) && $request->hasFile('id_card')) {
            $imagePath2 = $mechanic->id_card;

            if (File::exists($imagePath2)) {
                File::delete($imagePath2);
            }
        }

        if (!empty($mechanic->image) && $request->hasFile('image')) {
            $imagePath = $mechanic->image_url;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        if ($id_card = $request->file('id_card')) {
            $destinationPath2 = 'images/mechanic-images/';
            $profileImage2 = "mechanicIDCard" . "-" . date('YmdHis') . "." . $id_card->getClientOriginalExtension();
            $id_card->move($destinationPath2, $profileImage2);
            $validateData['id_card'] = $destinationPath2 . $profileImage2;
        } elseif (!$request->hasFile('id_card') && !$mechanic->id_card) {
            unset($validateData['id_card']);
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
        if (!empty($mechanic->id_card)) {
            $imagePath2 = $mechanic->id_card;

            if (file_exists($imagePath2)) {
                unlink($imagePath2);
            }
        }

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
