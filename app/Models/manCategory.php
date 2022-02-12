<?php

namespace App\Models;

use App\Observers\mainCategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manCategory extends Model
{
    use HasFactory;

    protected $table = "man_categories";
    protected $fillable = ["name","translation_lang","translation_of","active","photo","slug","created_at","updated_at"];

    public function scopeCategory($query){
        return $query->select("id","name","translation_lang","photo","active","translation_of");
    }
    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }
    protected static function boot()
    {
        parent::boot();
       manCategory::observe(mainCategoryObserver::class);
    }
    public function scopeActivation($query){
        return $query->where("active",1);
    }
    public function getActive(){

        return $this->active == 1?"مفعل":"غير مفعل ";
    }
    public function Categories(){
       return $this->hasMany(self::class,"translation_of");
    }
    public function vendor(){
       return $this->hasMany(Vendor::class,"category_id","id");
    }

}
