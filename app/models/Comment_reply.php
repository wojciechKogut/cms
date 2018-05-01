<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment_reply extends Eloquent {

    public $table = 'reply_comment';
    public $fillable = ['id', 'comment_post_id', 'comment_user_id', 'comment_reply_id', 'comment_content'];
    public $timestamps = ['updated_at', 'created_at'];

    public function get_data() {
        return static::all();
    }
    
    
    public function user() {
        return $this->belongsTo('User','comment_user_id');
    }

}
