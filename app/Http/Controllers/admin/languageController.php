<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\languageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;


class languageController extends Controller
{
    public function index(){
        // local scope
        $language = Language::languages()->paginate(PAGINATION_COUNT);
        return view ("admin.language.index",compact("language"));
    }
    public function create(){
        return view("admin.language.create");
    }
    public function store(languageRequest $request){
        // validation
        // save in database
        try {
            Language::create($request->except(['_token']));
            return redirect()->route("admin.language")->with(["success" => "تم اضافه اللغه بنجاح"]);
        }catch (\Exception $e){
            return redirect()->route("admin.language")->with(["error" => "هناك خطا فى البيانات"]);

        }
    }
    public function edit($id){

        $language = Language::languages()->find($id);
        if (!$language){
            return redirect()->route("admin.language")->with(["error" => "هناك خطا فى البيانات"]);
        }
        return view("admin.language.edit" , compact("language"));
    }
    public function update($id,languageRequest $request){

        try {
            $language = Language::find($id);

            if (!$language){
                return redirect()->route("admin.language")->with(["error" => "هناك خطا فى البيانات"]);
            }

            if (!$request->has("active"))
                $request->request->add(["active"=> 0]);  // دول خاصيين بتحويل الاكتف من 1 الى 0

            $language->update($request->except(['_token']));

            return redirect()->route("admin.language")->with(["success" => "تم تعديل  اللغه بنجاح"]);
        }catch (\Exception $e){
            return redirect()->route("admin.language")->with(["error" => "هناك خطا فى البيانات"]);

        }
    }
    public function destroy($id){
        try {
            $language = Language::find($id);

            if (!$language){
                return redirect()->route("admin.language")->with(["error" => "هناك خطا فى البيانات"]);
            }

            $language->delete();

            return redirect()->route("admin.language")->with(["success" => "تم حذف  اللغه بنجاح"]);
        }catch (\Exception $e){
            return redirect()->route("admin.language")->with(["error" => "هناك خطا فى البيانات"]);

        }
    }
    }

