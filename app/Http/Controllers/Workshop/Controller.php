<?php

namespace App\Http\Controllers\Workshop;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public static function uploadImage($image, $path) {
        if (!file_exists('images')) {
            mkdir('images', 0777, true);
        }
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $nameImg = $image->getClientOriginalName();
        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        $upload = $image->move($destinationPath, $nameImg);
        
        return ['imgName' => $nameImg, 'imgUrl' => asset('images/car-images/' . $nameImg), 'imgSize' => $image->getSize()];
    }

}
