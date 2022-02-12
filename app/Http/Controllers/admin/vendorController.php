<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\vendorRequest;
use App\Models\manCategory;
use App\Models\Vendor;
use App\Notifications\vendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use mysql_xdevapi\Exception;
use Illuminate\Support\Str;

class vendorController extends Controller
{
        public function index(){
         $vendors =    Vendor::vendor()->paginate(PAGINATION_COUNT);
         return view("admin.vendors.index",compact("vendors"));
        }
        public function create(){
            $categories = manCategory::activation()->where("translation_of",0)->get();
            return view("admin.vendors.create",compact("categories"));
        }
        public function store(vendorRequest $request){
            try {

                    if (!$request->has("active")){
                        $request->request->add(["active" => 0]);
                    }
                $filepath = "";
                if ($request->has("logo")) {
                    $filepath = uploadImage("vendors", $request->logo);
                }
                $vendor = Vendor::create([
                    "name" => $request->name,
                    "address" => $request->address,
                    "password" => $request->password,
                    "mobile" => $request->mobile,
                    "category_id" => $request->category_id,
                    "logo" => $filepath,
                    "email" => $request->email,
                    "active" => $request->active
                ]);
                notification::send($vendor, new vendorCreated ($vendor));
                return  redirect()->route("admin.vendor")->with(["success" => "تم حفظ المتجر بنجاح"]);
            }catch(\Exception $ex){
                return redirect()->route("admin.vendor")->with(["error" => "هناك خطا فى البيانات"]);
            }
        }
        public function edit($id){
            $vendor = Vendor::vendor()->find($id);
            if (!$vendor){
                return redirect()->route("admin.vendor")->with(["error" => "هذا القسم غير موجود"]);
            }
          $categories =  manCategory::activation()->where("translation_of",0)->get();
            return view("admin.vendors.edit",compact("vendor","categories"));
        }
    public function update($id,vendorRequest $request){
                // validation
        try {

            $vendor = Vendor::find($id);
            if (!$vendor) {
                return redirect()->route("admin.vendor")->with(["error" => "هذا القسم غير موجود"]);
            }
            // update to database
            DB::beginTransaction();
            if ($request->has("logo")) {
                $filepath = uploadImage("vendors", "$request->logo");
                Vendor::where("id", $id)->update([
                    "logo" => $filepath
                ]);
            }
            $data = $request->except(["password", "id", "logo", "_token"]);
            if ($request->has("password") && !is_null($request->password)) {
                $data["password"] = $request->password;
            }
            Vendor::where('id', $id)->update($data);
            DB::commit();
            return redirect()->route("admin.vendor")->with(["success" => "تم تحديث البيانات بنجاح"]);
        }catch (\Exception $ex){
            return redirect()->route("admin.vendor")->with(["error" => "حدث خطا ما برجاء المحاوله فى وقت لاحقا"]);
        }
        }
        public function destroy($id){
            try {
                $vendor = Vendor::find($id);
                if (!$vendor) {
                    return redirect()->route("admin.vendor")->with(["error" => "هذا المتجر غير موجود"]);
                }
                $images = Str::after($vendor->logo, "assets/");
                $images = base_path("public/assets/" . $images);
                unlink($images);
                $vendor->delete();
                return redirect()->route("admin.vendor")->with(["success" => "تم حذف المتجر بنجاح"]);
            }catch (\Exception $ex){
                return redirect()->route("admin.vendor")->with(["error" => "حدث خطا ما برجاء المحاوله فى وقت لاحقا"]);
            }
        }
        public function changeStatus($id){
            try {


                $vendor = Vendor::find($id);
                if (!$vendor) {
                    return redirect()->route("admin.vendor")->with(["error" => "هذا المتجر غير موجود"]);
                }
                $status = $vendor->active == 0 ? 1 : 0;
                $vendor->update(["active" => $status]);
                return redirect()->route("admin.vendor")->with(["success" => "تم تحديث الحاله بنجاح"]);
            }catch (\Exception $ex){
                return redirect()->route("admin.vendor")->with(["error" => "حدث خطا ما برجاء المحاوله فى وقت لاحقا"]);
            }
        }
}
