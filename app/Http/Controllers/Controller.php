<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function my_unique_id($forget=null) {
        if($forget == null) {
            if (!Session::has('unique_id_time')) {
                Session::put('unique_id_time', time(). rand(00, 99));
            }
            return Session::get('unique_id_time');
        }

        return Session::forget('unique_id_time');
    }
}