<?php
namespace App\Cms\helpers;

class Pager
{
    public $per_page;
    public $model;
    public $nr_page;
    public $adm;
    public $user_id;
    
    public function __construct($per_page, $model, $nr_page, $adm = null, $user_id = null) {
        $this->per_page = $per_page;
        $this->model = $model;
        $this->nr_page = $nr_page;
        $this->adm = $adm;
        $this->user_id = $user_id;
    }

    public function offset() {
        if ($this->nr_page == null) return ($this->per_page * 1) - $this->per_page;
        else  return ($this->per_page * $this->nr_page) - $this->per_page;
    }

    public function data_per_page() {
        $offset = $this->offset();

        if (strtolower(get_class($this->model)) == "post" && $this->adm) {
            return $this->model::orderBy('id', 'desc')->offset($offset)->limit(POSTS_PER_PAGE)->get();
        } else if (strtolower(get_class($this->model)) == "post") {
            return $this->model::orderBy('id', 'desc')->where("post_status", "published")->offset($offset)->limit(POSTS_PER_PAGE)->get();
        } else if (strtolower(get_class($this->model)) == "post" && !$this->adm) {
            return $this->model::orderBy('id', 'desc')->where("post_user_id", $this->user_id)->offset($offset)->limit(POSTS_PER_PAGE)->get();
        }


        return $this->model::orderBy('id', 'desc')->offset($offset)->limit(POSTS_PER_PAGE)->get();
    }

    public function filtrData($term, $isAdmin,$id = null) {
        $classname = get_class($this->model);
        $offset = $this->offset();
        if($classname === "Post") {
            if($isAdmin) { 
                return $this->model::where("post_title","like","%" . $term . "%")->offset($offset)->limit(POSTS_PER_PAGE)->get();
            } else {
                $offset = $this->offset();
                $userPosts = $this->model::where("post_title","like","%" . $term . "%");
                return $userPosts->where("post_user_id",$id)->offset($offset)->limit(POSTS_PER_PAGE)->get();
            }
        } else if($classname == "User") {
            return $this->model::where("user_name","like","%" . $term . "%")->offset($offset)->limit(POSTS_PER_PAGE)->get();
        }
        
        
    }

    public function sortByQuery($sortBy) {
        $offset = $this->offset();
        if($sortBy == "titleDesc") {
            return $this->model::orderByDesc("post_title")->offset($offset)->limit(POSTS_PER_PAGE)->get();  
        } else if($sortBy == "titleAsc") {
            return $this->model::orderBy("post_title")->offset($offset)->limit(POSTS_PER_PAGE)->get();  
        } else if($sortBy == "authorDesc") {
            return $this->model::orderByDesc("post_author")->offset($offset)->limit(POSTS_PER_PAGE)->get(); 
        } else if($sortBy == "authorAsc") {
            return $this->model::orderBy("post_author")->offset($offset)->limit(POSTS_PER_PAGE)->get(); 
        }
        
    }

}