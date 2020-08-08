<?php
namespace App\Cms\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Cms\interfaces\model as Model;

class Category extends Eloquent implements Model
{
    protected $table = 'category';
    public $fillable = ['id','cat_title','slug','color'];
    public $timestamps = ['updated_at','created_at'];
    
    public function get_data()
    {
        return static::all();
    }

    public function find_by_id($id)
    { 
        return static::find($id);
    }
    
    public function posts()
    {
        return $this->hasMany('Post','post_category_id');
    }
    
}