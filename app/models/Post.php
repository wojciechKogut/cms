<?php

use Illuminate\Database\Eloquent\Model as Eloquent;


class Post extends Eloquent implements Model {

    public $table = "posts";
    public $fillable = ['post_category_id', 'post_user_id', 'post_title', 'post_author','post_date','post_image', 'post_content', 'post_tags', 'post_comment_count', 'post_status', 'post_views','slug'];
    public $timestamps = true;
    
    

    public function find_by_id($id) {
        return static::find($id);
    }

    public function get_data() {
//        return static::leftJoin('category',function($join) {
//            $join->on('category.id','=','posts.post_category_id');
//        })->get([
//                'category.cat_title',
//                'category.color',
//                'posts.post_title',
//                'posts.post_author',
//                'posts.post_date',
//                'posts.post_image',
//                'posts.post_category_id',
//                'posts.post_status',
//                'posts.post_content',
//                'posts.id'
//            
//            ]);
        return static::all();
    }
    
    

    public function category() {
        return $this->belongsTo('Category', 'post_category_id');
    }
    
    
    

    public function user() {
        return $this->belongsTo('User', 'post_user_id');
    }
    
    

    public function comments() {
        return $this->hasMany('Comment', 'comment_post_id');
    }
    
    

    public function find_all_posts() {
        return static::all();
    }
    
    

    public function active_posts() {

        return static::all()->where('post_status', '=', 'publish');
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
        return !empty($user_image) ? ROOT . "images/upload_img/" . $user_image : ROOT . "images/userplaceholder.png";
    }
    
    
    

//    public function options($checkboxes, $options, $comment) {
//        foreach ($checkboxes as $key => $post_id) {
//            $this->id = $post_id;
//            $options = $_POST['options'];
//
//            switch ($options) {
//                case "published":
//                    $the_post = static::find($post_id);
//                    $the_post->post_status = "published";
//                    $the_post->save();
//                    break;
//                case "draft":
//                    $the_post = static::find($post_id);
//                    $the_post->post_status = "draft";
//                    $the_post->save();
//                    break;
//                case "delete":
//                    $the_post->destroy($post_id);
//                    $comment->delete_comment_to_post($post_id);
//                    break;
//            }
//        }
//    }
//    
    
    

    public function search_posts($keywords) {
        return static::where("post_content", "like", "%{$keywords}%")->get();
    }


    public function delete_author_post($posts) {
        foreach ($posts as $post) {
            $post->delete();
        }
    }

}
