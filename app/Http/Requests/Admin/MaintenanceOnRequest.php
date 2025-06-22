<?php

namespace App\Http\Requests\Admin;

use App\Mail\Admin\MaintenanceMail;
use App\Models\Admin;
use App\Models\Admin\Maintenance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;

class MaintenanceOnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'secret_code' =>['required'],
            'message' =>['required'],
            'mail_option' =>['required'],
            'mail_subject' =>['required'],
            'mail_body' =>['required'],
        ];
    }

    public function makeCommand() {
        $maintenance = new Maintenance();
        $maintenance->admin_id = LoggedAdmin()->id;
        $maintenance->secret_code = $this->secret_code;
        $maintenance->message = $this->message;
        $maintenance->mail_option = $this->mail_option;
        $maintenance->mail_subject = $this->mail_subject;
        $maintenance->mail_body = $this->mail_body;

        // send mail
        if(maintenanceMailSwitch()){
            if($this->mail_option==0){
                $admins = Admin::where([['status',1],['delete',0]])->get();
                foreach($admins as $admin){
                    Mail::to($admin->email)->send(new MaintenanceMail($this->mail_subject,$this->mail_body,$this->secret_code));
                }
            }elseif($this->mail_option==1){
                $admins = Admin::with('roles')->where([['status',1],['delete',0]])->get();
                foreach($admins as $admin){
                    if($admin->roles()->first()->name!='Super Admin'){
                        continue;
                    }
                    Mail::to($admin->email)->send(new MaintenanceMail($this->mail_subject,$this->mail_body,$this->secret_code));
                }
            }
        }

        $maintenance->save();

        $command = 'down --secret="'.$this->secret_code.'"';
        return $command;
    }   
}
