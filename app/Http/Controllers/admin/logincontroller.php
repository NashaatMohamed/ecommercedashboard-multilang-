<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Models\Admin;

class logincontroller extends Controller
{

    public function getLogin(){
        return view("admin.dashboardLogin");
    }

        // tinker
//    public function save(){
//        $admin = new App\Models\Admin();
//        $admin->email = "nashaat.mm@gmail.com";
//        $admin->password = bcrypt("nashaatMo");
//        $admin->save();
//    }
    public function login(loginRequest $request){
        // make validation
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('admin.dashboard');
        }
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    }
}
