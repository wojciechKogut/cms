<?php
namespace App\Cms\controllers;

use App\Cms\libraries\Controller as BaseController;

class Posts extends BaseController {

    /**
     * @var \App\Cms\models\Post
     */
    private $post;

     /**
     * @var \App\Cms\helpers\Session
     */
    public $session;

    /**
     * @var \App\Cms\models\User
     */
    public $user;

    /**
     * @var \App\Cms\models\Comment
     */
    public $comments;

     /**
     * @var \App\Cms\models\Category
     */
    public $categories;

    /**
     * @var \App\Cms\models\Like
     */
    public $likes;

    public $postManagement;

    public function __construct(
        \App\Cms\models\Post $post,
        \App\Cms\helpers\Session $session,
        \App\Cms\models\User $user,
        \App\Cms\models\Comment $comment,
        \App\Cms\models\Category $category,
        \App\Cms\models\Comment_reply $comment_reply,
        \App\Cms\models\Like $like,
        \App\Cms\Services\PostManagement $postManagement
    ) {
        $this->post = $post;
        $this->session = $session; 
        $this->user = $user;
        $this->comments = $comment;
        $this->categories = $category;
        $this->comment_reply = $comment_reply;   
        $this->likes = $like;  
        $this->postManagement = $postManagement;
    }
    
    public function index($id) 
    {   
        if (!$this->session->session_check()){
            redirect(ROOT);
        }  

        if (!$this->user->isAdmin()) {
            if($_SERVER['REQUEST_METHOD'] == "POST") { 
                if(isset($_POST['reset'])) {
                    $this->resetGrid($id);
                } else {
                    $this->searchTerm($id);
                }
            } else {
                $user = $this->user->find_by_id($_SESSION['id']);
                $user_posts = $user->post;
                $count_rows = $user_posts->count(); 
                $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE,$this->post,$id,false,$_SESSION['id']);
                $pagination = new \App\Cms\helpers\Pagination(5, $id, $count_rows);
                $data = [$user_posts,$pagination, $this->session->message];
                $this->view('sub_posts', $data);
            }    
        } else {
            /** filtrowanie tabeli */
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if(isset($_POST['reset'])) {
                    $this->resetGrid($id);
                } else {
                    $this->searchTerm($id);
                }     
            } else {
                $all_posts = $this->post->find_all_posts();
                $count_rows = $all_posts->count();
                $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE,$this->post,$id,true);
                $pagination = new \App\Cms\helpers\Pagination(5, $id, $count_rows);  
                $data = [$pager->data_per_page(),$pagination, $this->session->message];
                $this->view('adm_posts', $data);
            }
        }
    }

    public function sortBy($id,$sortBy) 
    {
        $all_posts = $this->posts->find_all_posts();
        $count_rows = $all_posts->count();
        $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE,$this->posts,$id,true);
        $pagination = new \App\Cms\helpers\Pagination(5, $id, $count_rows);  
        if($sortBy == "titleDesc") {
            $data = [$pager->sortByQuery("titleDesc"),$pagination, $this->session->message];
            $this->view('adm_posts', $data);
        } else if($sortBy == "titleAsc") {
            $data = [$pager->sortByQuery("titleAsc"),$pagination, $this->session->message];
            $this->view('adm_posts', $data);
        } else if($sortBy == "authorDesc") {
            $data = [$pager->sortByQuery("authorDesc"),$pagination, $this->session->message];
            $this->view('adm_posts', $data);
        } else if($sortBy == "authorAsc") {
            $data = [$pager->sortByQuery("authorAsc"),$pagination, $this->session->message];
            $this->view('adm_posts', $data);
        }
    }

    // public function filtrTable($isAdmin, $id=null) 
    // {
    //     if(isset($_POST['search'])) {
    //         $term = $_POST['searchTerm'];
    //         return $this->post->searchTable($term, $isAdmin, $id);
    //     }
    // }
    
    public function update($id) 
    {
        $form = "";
        $the_post = $this->posts->find_by_id($id);
        $author_post = $the_post->user;
        $rules = [
            "post_title" => array("required" => true),
            "post_category_id" => array("required" => true),
            "post_content" => array("required" => true)
        ];

        if (isset($_POST['update'])) {
            $form = new \App\Cms\helpers\Form("update_with_img", $_POST, $_FILES["post_image"], $rules, $the_post, $id);

            if ($form->proccess()) {
                $generator = new \Vnsdks\SlugGenerator\SlugGenerator;
                $postTitle = $generator->generate($form->form_values['post_title']);
                $the_post->update(['post_user_id'=>$_SESSION['id'],'slug'=>$postTitle . "-". $the_post->id]);
                $this->session->message("Post '" . $form->form_values["post_title"] . "' updated");
                redirect(ROOT . "posts");
            }
        } else {
            \App\Cms\helpers\Form::delete_tmp_img();
        }

        $data = [
            $the_post,
            $this->user->get_data(),
            $this->categories->get_data(),
            $this->categories->find_by_id($the_post->post_category_id),
            $form,
            $author_post
        ];

        $this->view('update_post', $data);
    }
    
    public function add_front() 
    {
        $form = "";
        $recent_posts = $this->posts::orderBy('id', 'desc')->where("post_status", "published")->limit(5)->get();
        $rules = [
            "post_title"       => array("required" => true),
            "post_category_id" => array("required" => true),
            "post_content"     => array("required" => true),
            "post_author"      => array("required" => true),
            "user_email"       => array("required" => true)
        ];

        if (isset($_POST['submit'])) {

            $this->posts->post_status = "draft";
            $form = new \App\Cms\helpers\Form("add_with_img", $_POST, $_FILES["post_image"], $rules, $this->posts);
            if ($form->proccess()) {
                $this->session->message("Thanks for add post '" . $form->form_values["post_title"] . " '. This post waiting moderation ");
                $generator = new \Vnsdks\SlugGenerator\SlugGenerator;
                $postTitle = $generator->generate($form->form_values['post_title']);
                $this->posts->update(['post_user_id'=>$_SESSION['id'],'slug'=>$postTitle . "-". $this->posts->id]);
                redirect(ROOT . "posts/add_front");
            }
        } else {
            \App\Cms\helpers\Form::delete_tmp_img();
        }

        if (isset($_SESSION['id'])) $user_logged = $this->user->find_by_id($_SESSION['id']);
        else  $user_logged = "";
        
        $data = [
            $this->categories->get_data(),
            $this->user->get_data(),
            $form,
            $this->session->message,
            $user_logged,
            $recent_posts
        ];

        $this->view('add_post_front', $data);
    }

    public function select_option($id) 
    {
        if (isset($_POST['apply'])) {
            $checkboxes = $_POST['checkboxes'];
            $options = $_POST['options'];
            if (isset($options) && $options != "") {               
                 foreach ($checkboxes as $key => $post_id) {
                    $the_post = $this->posts->find_by_id($post_id);
                    switch ($options) {
                        case "published": 
                            $the_post->post_status = "published";
                            $the_post->save();
                            break;
                        case "draft":
                            $the_post->post_status = "draft";
                            $the_post->save();
                            break;
                        case "delete":
                            $this->destroy($post_id);
                            break;
                    }
                }
                if ($id == 0)  redirect(ROOT . "posts/");
                else  redirect(ROOT . "posts/index/" . $id);    
            } 
            else redirect(ROOT . "posts/");    
        }
    }

    public function add() 
    {
        $form = "";
        $rules = [
            "post_title" => array("required" => true),
            "post_category_id" => array("required" => true),
            "post_content" => array("required" => true)
        ];

        if (isset($_POST['submit'])) {
            $form = new \App\Cms\helpers\Form("add_with_img", $_POST, $_FILES["post_image"], $rules, $this->posts);
            if ($form->proccess()) {
                $this->posts->post_date = date('Y-m-d H:i:s');
                $this->session->message("Post '" . $form->form_values["post_title"] . "' added"); 
                $generator = new \Vnsdks\SlugGenerator\SlugGenerator;
                $postTitle = $generator->generate($form->form_values['post_title']);
                $this->posts->update(['post_user_id'=>$_SESSION['id'],'slug'=>$postTitle . "-". $this->posts->id,'post_author'=>$_SESSION['user_name']]);
                redirect(ROOT . "posts");
            }
        } else {
            \App\Cms\helpers\Form::delete_tmp_img();
        }

        $data = [$this->categories->get_data(), $this->user->get_data(), $form];
        $this->view('add_post', $data);
    }
    
    public function post_cat($slug, $nr = 1)
    {
        $cat = $this->categories::where('slug',$slug)->first();
        $id = $cat->id;

        $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE, $this->posts, $nr);
        $posts_per_page = $pager->data_per_page()->where('post_category_id', $id);
        $post_by_category = $this->posts->get_data()->where('post_category_id', $id);
        $count_rows = $post_by_category->count();

        $recent_posts = $this->posts::orderBy('id', 'desc')->where("post_status", "published")->limit(5)->get();
        $pagination = new \App\Cms\helpers\Pagination(5, $nr, $count_rows);
        if ($count_rows == 0) {
            $message = "No posts available";
            $data = [$posts_per_page, $this->categories->get_data(), $count_rows, $slug, $pagination, $recent_posts, $message];
        } else {
            $data = [$posts_per_page, $this->categories->get_data(), $count_rows, $slug, $pagination, $recent_posts];
        }

        $this->view('posts_category', $data);
    }

    public function destroy($id) 
    {
        $post = $this->posts->find_by_id($id);
        $post->likes()->delete();
        foreach($post->comments as $comment) {
            foreach($comment->replyComments as $reply) {
                $reply->delete();
            }
            $comment->delete();
        }
        $img = $post->post_image;
        unlink( INCLUDES_PATH."images".DS."upload_img".DS.$img); 
        $post->delete();
        redirect(ROOT . "posts");
    }
    
    public function search() 
    {
        $results = "";
        $msg = "";
        $count_results = [];
        $keywords = "";
        $recent_posts = $this->posts::orderBy('id', 'desc')->where("post_status", "published")->limit(5)->get();

        if (isset($_POST['search'])) {  $keywords = strip_tags($_POST['keywords']);
            if (!empty($keywords)) {  $results = $this->posts->search_posts($keywords); $count_results = $results->count();
                if (empty($count_results)) $msg = "No results for" . " '" . "<b>" . $keywords . "</b>" . "'";     
            } else $msg = "No results. Give some data"; 
        }

        $data = [
            $results,
            $this->categories->get_data(),
            $msg,
            $count_results,
            $keywords,
            $recent_posts
        ];

        $this->view('search_post', $data);
    }

    private function resetGrid(int $postId)
    {
        $user = $this->user->find_by_id($_SESSION['id']);
        $user_posts = $user->posts;
        $count_rows = $user_posts->count(); 
        $pagination = new \App\Cms\helpers\Pagination(5, $postId, $count_rows);
        $data = [$user_posts, $pagination, $this->session->message];

        return $this->view('adm_posts', $data);
    }

    private function searchTerm($nrPage)
    {
        $term = $_POST['searchTerm'];
        $filteredData = $this->postManagement->filterData($term, (int) $_SESSION['id'], (int) $nrPage);
        $rows = $this->postManagement->getAllFilterData($term)->count();
        $pagination = new \App\Cms\helpers\Pagination(5, $nrPage, $rows);  
        $data = [$filteredData, $pagination, $this->session->message];

        return $this->view('adm_posts', $data);
    }
}
