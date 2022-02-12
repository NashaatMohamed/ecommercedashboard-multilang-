<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{

    use HasFactory,Notifiable;


    protected $table = "vendors";
    protected $fillable = ["name","email","logo","mobile","address","active","category_id","password","created_at","updated_at"];
    protected $hidden = ["category_id","password"];

    public function scopeVendor($query){
        return $query->select("id","name","logo","mobile","email","address","active","password","category_id");
    }
    public function scopeActivation($query){
        $query -> where("active,1");
    }
    public function getActive(){
        return $this->active == 1 ?"مفعل": "غير مقعل";
    }
    public function category(){
       return $this->belongsTo(manCategory::class,"category_id","id");
    }
    public function setPasswordAttribute($password){
        if (!empty($password)){
            $this->attributes["password"] = bcrypt($password);
        }
    }
    public function getLogoAttribute($val){
        return ($val !== null) ? asset('assets/' . $val) : "";
    }
}
