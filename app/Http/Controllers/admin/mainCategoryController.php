<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\mainCategoryRequest;
use App\Models\manCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class mainCategoryController extends Controller
{
        public function index(){
            $defaultLang = get_default_lang();
           $category =  manCategory::where("translation_lang",$defaultLang)->category()->get();
            return view("admin.mainCategory.index",compact("category"));
        }

        public function create(){
            return view("admin.mainCategory.create");
        }
        public function store(mainCategoryRequest $request)
        {
            //  return $request;
            try {


            $mainCategory = collect($request->category);
           $mainCategoryFilter =  $mainCategory->filter(function ($value,$key){
                return $value["abbr"] == get_default_lang();
            });
           $defaultCategory = array_values($mainCategoryFilter->all())[0];
           $filepath = "";
           if ($request->has("photo")){
               $filepath =uploadImage("mainCategories",$request->photo);
           }
           DB::beginTransaction();
          $default_category_id = manCategory::insertGetId([
              "name" =>  $defaultCategory["name"],
               "slug" => $defaultCategory["name"],
               "translation_lang" => $defaultCategory["abbr"],
               "translation_of" => 0,
               "photo" => $filepath
           ]);
           $filter =  $mainCategory->filter(function ($value,$key){
                return $value["abbr"] !=  get_default_lang();
            });
           $category = ($filter);
           if (isset($category) && $category ->count() ){
               $main_category = [];
               foreach ($category as $cat){
                    $main_category[] = [
                        "name" => $cat["name"],
                        "slug" => $cat["name"],
                        "translation_lang" => $cat["abbr"],
                        "translation_of" => $default_category_id,
                        "photo" => $filepath
                    ];
                }
               manCategory::insert($main_category);
           }
           DB::commit();
           return redirect()->route("admin.mainCategory")->with(["success" => "تم حفظ الاقسام بنجاح"]);
                }catch (\Exception $ex){
                DB::rollBack();
                return redirect()->route("admin.mainCategory")->with(["error"=>"هناك خطا فى الاعدادات"]);
            }
        }
        public function edit($mainCategoryId){
            $mainCategory = manCategory::with("Categories")->category()->find($mainCategoryId);
           // return $mainCategory;
            if (!$mainCategory){
                return redirect()->route("admin.mainCategory")->with(["error" => "هذا القسم غير موجود"]);

            }
                return view("admin.mainCategory.edit",compact("mainCategory"));
        }
        public function update($categoryId,mainCategoryRequest $request)
        {
            //return $request;
            // للتاكيد من id
           $manId =  manCategory::find($categoryId);
           if (!$manId){
               return redirect()->route("admin.mainCategory")->with(["error" => "هذا القسم غير موجود"]);
           }
            try {
                // update database
                if (!$request->has("category.0.active"))
                    $request->request->add(["active" => 0]);
                else
                    $request->request->add(["active" => 1]);

                $category = array_values($request->category)[0];
                manCategory::where("id", "$categoryId")->update([
                    "name" => $category["name"],
                    "active" => $request->active,
                ]);
                if ($request->has("photo")) {
                    $filepath = uploadImage("mainCategories", $request->photo);

                    manCategory::where("id", "$categoryId")->update([
                        "photo" => $filepath
                    ]);
                }
            }catch (\Exception $ex){
                return redirect()->route("admin.mainCategory")->with(["error" => "هناك خطا فى الاعدادت"]);

            }
            return redirect()->route("admin.mainCategory")->with(["success" => "تم تحديث القسم بنجاح"]);

        }
        public function destroy($cat_id){
           $manCategory = manCategory::find($cat_id);
            if (!$manCategory){
                return redirect()->route("admin.mainCategory")->with(["error" => "هذا القسم غير موجود"]);
            }
            ######################## not remove category because have vendor
            $vendors = $manCategory->vendor();
            if (isset($vendors) && $vendors->count() > 0){
                return  redirect()->route("admin.mainCategory")->with(["error" => "لا يمكن حذف هذا القسم "]);
            }
            ######################################################end
            ########################## remove photo from folder
            $photo = Str::after($manCategory->photo,"assets/") ;
            $photo = base_path("public/assets/" . $photo);
            unlink($photo);
            ##################################################end
            $manCategory->Categories()->delete();
            $manCategory->delete();

            return  redirect()->route("admin.mainCategory")->with(["success" => "تم حذف هذا القسم بنجاح "]);
        }
        public function changeStatus($cat_id){
             $manCategory = manCategory::find($cat_id);
            if (!$manCategory){
                return redirect()->route("admin.mainCategory")->with(["error" => "هذا القسم غير موجود"]);
            }
          $status =  $manCategory->active == 1 ? 0 :1 ;
            $manCategory->update(["active" =>  $status]);
            return  redirect()->route("admin.mainCategory")->with(["success" => "تم تحديث الحاله بنجاح "]);

        }
}
