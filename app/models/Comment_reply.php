<?php
namespace App\Cms\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Cms\interfaces\Model;

class Comment_reply extends Eloquent implements Model {

    public $table = 'reply_comment';
    public $fillable = ['id', 'comment_post_id', 'comment_user_id', 'comment_reply_id', 'comment_content'];
    public $timestamps = ['updated_at', 'created_at'];
    
    public function user() {
        return $this->belongsTo('User','comment_user_id');
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
