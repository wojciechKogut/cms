<?php
namespace App\Cms\models;

use App\Cms\interfaces\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Like extends Eloquent implements Model {

    protected $table = "likes"; 
    public $fillable = ['id','user_id','post_id','count']; 
    public $timestamps = ['updated_at','created_at'];

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }

    public function get_data(): \Illuminate\Database\Eloquent\Collection
    {
        return static::all();
    }

    public function find_by_id($id)
    {
        return static::find($id);
    }
}
