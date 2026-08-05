<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\PasswordChangeRequest;
use Hash;

class SettingController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function changePassword()
    {
        return view('settings.change_password');
    }

    public function passwordChange(PasswordChangeRequest $request)
    {
        try
        {
            $user = User::find(user()->id);
            //$message = $user->changePassword($request,$user);

            if (!Hash::check($request->current_password, $user->password)) {
            
               $message = ['message'=>'The current password is incorrect.', 'type'=>'error'];
            }

            $user->password = Hash::make($request->new_password);
            $user->update();

            $message = ['message'=>'Your password has been changed', 'type'=>'success'];

            $notification=array(
                 'messege'=>"Successfully Change Password",
                 'alert-type'=>"succes"
            );

            return redirect()->back()->with($notification);


        }catch(\Exception $e){
                  
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
