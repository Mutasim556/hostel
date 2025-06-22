<?php

namespace App\Http\Controllers\Admin\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ChangeLanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $lang)
    {
       try {
            Cookie::queue('language', $lang, 10);
            // session()->put('language',$lang);
            return back();
        } catch (\Throwable $th) {
            Cookie::queue('language','en',10);
            // session()->put('en');
            return back();
        }
    }
}
