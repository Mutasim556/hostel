<?php

use App\Models\Admin\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

function userRoleName(){
    return auth()->guard('admin')->user()->getRoleNames()->first();
}


function hasPermission(array $permission){
    if(userRoleName()==='Super Admin'){
        return true;
    }else{
        return auth()->guard('admin')->user()->hasAnyPermission($permission);
    }
}


function generateRandomString(){
    $key = random_int(0, 999999);
    $key = str_pad($key, 6, 0, STR_PAD_LEFT);
    return $key;
}

function LoggedAdmin(){
    return Auth::guard('admin')->user();
}

function setLanguage(string $lang) : void{
    Cookie::queue('language', $lang, 10);
    // session(['language'=>$code]);
}
function getLanguageSession() : string {
    if(Cookie::get('language') !== null){
        return Cookie::get('language');
    }else{
        try {
            $language = Language::where('default',1)->first();
            setLanguage($language->lang);
            return $language->lang;
        } catch (\Throwable $th) {
            setLanguage('en');
            return Cookie::get('language');
        }
    }
}

function routeExist(string $routeName){

}

//turn of/on maintenance mail
function maintenanceMailSwitch(){
    return false;
} 


function getDirectoryLink($dirName){
    $dir = env('ASSET_DIRECTORY').'/admin/file/'.$dirName;
    return $dir;
}
function baseUrl(){
    return URL::to('/');
}

function createDirectory($dir){
    if (!File::isDirectory($dir)) {
        File::makeDirectory($dir, 0755, true);
    }
    return true;
}

function getLangs(){
    $languages = Language::where([['status',1],['delete',0],['lang','!=','en']])->get();
    return $languages;
}