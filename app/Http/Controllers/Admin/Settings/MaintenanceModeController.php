<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenanceOnRequest;
use App\Models\Admin;
use App\Models\Admin\Maintenance;
use Illuminate\Console\Command;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MaintenanceModeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:maintenance-mode-index,admin');
    }

    public function maintenanceMode()  {
        $maintenances = Maintenance::with('admin')->orderBy('maintenances.id','DESC')->get();
        return view('backend.blade.settings.maintenance_mode',compact('maintenances'));
    }

    public function maintenanceModeOn(MaintenanceOnRequest $data) : Response{
        $this->down($data->makeCommand());
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Maintenance Mode Successfully Turned On'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }
    public function down(string $command) : Response {
        Artisan::call($command);
        return response([
            'ok'=>1,
        ]);
    }
    public function up() : RedirectResponse {
        Artisan::call('up');
        return to_route('admin.settings.server.maintenanceMode');
    }


    public function destroy(string $id):Response{
        try {
            $delete = Maintenance::where('id',$id)->delete();
            return response()->json([
                'delete'=>'done',
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Maintenance data successfully deleted'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],200);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }

    public function destroyAll() : Response {
        DB::beginTransaction();
        try {
            $delete = DB::table('maintenances')->truncate();
            DB::commit();
            return response([
                'delete'=>'done',
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Maintenance data successfully deleted'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }
}
