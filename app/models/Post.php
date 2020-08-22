<?php
namespace App\Cms\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Cms\interfaces\Model;

class Post extends Eloquent implements Model {

    public $table = "posts";
    public $fillable = [
        'post_category_id', 
        'post_user_id', 
        'post_title', 
        'post_author',
        'post_date',
        'post_image', 
        'post_content', 
        'post_tags', 
        'post_comment_count', 
        'post_status', 
        'post_views',
        'slug',
        'created_at',
        'updated_at'
    ];

    public $timestamps = ['updated_at','created_at'];
    
    public function find_by_id($id) {
        return static::find($id);
    }

    public function get_data() {
        return static::all();
    }
    
    public function category() {
        return $this->belongsTo('\\App\\Cms\\models\\Category', 'post_category_id');
    }
    
    public function likes() {
        return $this->hasMany('\\App\\Cms\\models\\Like','post_id');
    }
    

    public function user() {
        return $this->belongsTo('\\App\\Cms\\models\\User', 'post_user_id');
    }
    
    public function comments() {
        return $this->hasMany('\\App\\Cms\\models\\Comment', 'comment_post_id');
    }
    
    public function find_all_posts() {
        return static::all();
    }

    public function active_posts() {

        return static::all()->where('post_status', '=', 'published');
    }
    
    public function draft_posts() {

        return static::all()->where('post_status', '=', 'draft');
    }

    public function get_post_author($user_id) {
        return !empty($user_id) ? User::find($user_id)->user_name : $this->comment_author;
    }

    public function get_user_img($user_id) {
        $the_user = new User();
        $user_image = $the_user->find_by_id($user_id)->user_image;
        return !empty($user_image) ? ROOT . "public/images/upload_img/" . $user_image : ROOT . "public/images/userplaceholder.png";
    }
    
    public function search_posts($keywords) {
        return static::where("post_content", "like", "%{$keywords}%")->get();
    }

    public function delete_author_post($posts) {
        foreach ($posts as $post) {
            $post->delete();
        }
    }

    public function searchTable($term, $isAdmin, $id = null) {
        if($isAdmin) {
            return self::where("post_title","like","%" . $term . "%")->get();
        } else {
            $userPosts = self::where("post_title","like","%" . $term . "%")->get();
            return $userPosts->where("post_user_id", $id);
        }
        
    }
}
