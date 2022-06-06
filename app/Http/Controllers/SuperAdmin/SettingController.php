<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Classes\ImageSaverToStorage;

use App\Models\Setting;

use Carbon\Carbon;

use Illuminate\Http\Request;

/**
 * Class SettingController
 * @package App\Http\Controllers\SuperAdmin
 */
class SettingController extends Controller
{
    /**
     * SettingController constructor.
     */
    private $storeImage;

    public function __construct()
    {
        ini_set('post_max_size', 99999);
        ini_set('max_execution_time', 99999);
        ini_set('upload_max_filesize', 99999);
        ini_set('max_file_uploads', 444);

        $this->storeImage = new ImageSaverToStorage();
    }
}