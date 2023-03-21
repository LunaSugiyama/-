<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //use HasFactory;
    protected $guarded=array('id');
    public static $rules =array(
        'user_id'=>'required',
        'password'=>'required',
        'username'=>'required',
        //'edited_at'=>'required'
    );
    public function user()
    {
        return $this->belogsTo(User::class);
    }
}
