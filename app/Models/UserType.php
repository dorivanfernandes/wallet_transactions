<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;
    protected $fillable = ["type_name"];
    protected $table = "user_type";
}
