<?php
namespace App\Cms\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Like extends Eloquent {

    protected $table = "likes"; 
    public $fillable = ['id','user_id','post_id','count']; 
    public $timestamps = ['updated_at','created_at'];

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }

}
