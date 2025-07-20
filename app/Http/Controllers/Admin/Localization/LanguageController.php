<?php

namespace App\Http\Controllers\Admin\Localization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLanguageRequest;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:language-index,admin')->only('index');
        $this->middleware('permission:language-create,admin')->only('store');
        $this->middleware('permission:language-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:language-delete,admin')->only('destroy');
       
    }
    public function index()
    {
        $languages = Language::where('delete',0)->get();
        return view('backend.blade.language.index',compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data):JsonResponse
    {
        if($data->default){
            Language::where('default',1)->update([
                'default'=>0,
            ]);
        }
        $language = new Language();
        $language->name = $data->name;
        $language->slug = $data->slug;
        $language->lang = $data->language;
        $language->default = $data->default?1:0;
        $language->status = $data->status?1:0;
        $language->delete = 0;
        $language->save(); 

        $languages =  Language::where([['status',1],['delete',0]])->get();
        $langdata = [];
        foreach($languages as $lang){
            $name = $lang->lang!='en'?'name_'.$lang->lang:'name';
            if($data->$name==null){
                continue;
            }else{
                array_push($langdata, array(
                    'translationable_type'  => 'App\Models\Admin\Language',
                    'translationable_id'    => $language->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'name',
                    'value'                 => GoogleTranslate::trans($data->$name, $lang->lang, 'en'),
                    'created_at'            => Carbon::now(),
                ));
            }
            
        }
        Translation::insert($langdata);

        return response()->json([
            'language' =>Language::findOrFail($language->id),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Language create successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['language-update','language-delete']),
            'hasEditPermission' => hasPermission(['language-update']),
            'hasDeletePermission' => hasPermission(['language-delete']),
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : Response
    {
        $language = Language::withoutGlobalScope('translate')->findOrFail($id);
        return response($language);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $data, string $id)
    {
        if($data->default){
            Language::where('default',1)->update([
                'default'=>0,
            ]);
        }
        $language = Language::findOrFail($id);
        $language->name = $data->name;
        $language->slug = $data->slug;
        $language->lang = $data->language;
        $language->default = $data->default?1:0;
        $language->save();

        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            $name = $lang->lang != 'en' ? 'name_' . $lang->lang : 'name';
            if ($data->$name == null) {
                continue;
            }else{
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Language',
                    'translationable_id'    => $id,
                    'locale'                => $lang->lang,
                    'key'                   => 'name',
                ],[
                    'value'                 => GoogleTranslate::trans($data->$name, $lang->lang, 'en'),
                    'updated_at'            => Carbon::now(),
                ]);
            }
        }

        // return Language::findOrFail($id);
        return response()->json([
            'language' =>Language::findOrFail($id),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Language updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['language-update','language-delete']),
            'hasEditPermission' => hasPermission(['language-update']),
            'hasDeletePermission' => hasPermission(['language-delete']),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $language = Language::findOrFail($id);
        $language->default = 0;
        $language->status = 0;
        $language->delete = 1;
        $language->save();
        return 'deleted';
    }

    public function updateStatus(Request $data){
        Language::where('id',$data->id)->update(['status'=>$data->status,'updated_at'=>Carbon::now()]);
        $language = Language::where('id',$data->id)->first();
        return $language;
    }
}
