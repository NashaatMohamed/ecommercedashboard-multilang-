<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = "languages";
    protected $fillable = ["abbr","direction","active","name","locale","created_at","updated_at"];

    // local scope for geting lang data
    public function scopeLanguages($query){
        return $query->select("id","abbr","direction","name","active");
    }

    // local scope geting active language
    public function scopeLang($query){
        return $query->where("active","1");
    }

    // ميثود لتحويل قيم اكتف من 1 و 0 الى مفعل وغير مفعل
    public function getActive(){
        return $this->active == 1 ?"مفعل" : "غير مفعل";
    }

}
