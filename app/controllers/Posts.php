<?php

class Posts extends Controller 
{

    private $posts;
    public $session;
    public $user;
    public $comments;
    public $categories;
    

    public function __construct()
    {
        $this->posts      = $this->model('post');
        $this->session    = $this->model("session"); 
        $this->user       = $this->model('user');
        $this->comments   = $this->model('comment');
        $this->categories = $this->model('category');
        $this->comment_reply = $this->model('comment_reply');
         
         
    }
    

    public function index($id)
    {   
        if (!$this->session->session_check())
         {
             redirect(ROOT);
         }
        
        $pager = new Pager(POSTS_PER_PAGE,$this->posts,$id);

        if(!$this->user->isAdmin())
        {
            $user = $this->user->find_by_id($_SESSION['id']);
            $user_posts = $user->posts;
            $count_rows = $user_posts->count(); 
            $pagination = new Pagination(5, $id, $count_rows);
            $data = [$user_posts,$pagination, $this->session->message];
            $this->view('sub_posts', $data);
        }
        else
        {
            
//            $posts_per_page = $pager->data_per_page();
            $all_posts = $this->posts->find_all_posts();
            $count_rows = $all_posts->count();
            $pagination = new Pagination(5, $id, $count_rows);  
            $data = [$all_posts,$pagination, $this->session->message];
            $this->view('adm_posts', $data);
        }
        

    }
    
    
    
    

    public function update($id) {
        $form = "";
        $the_post = $this->posts->find_by_id($id);
        $author_post = $the_post->user;

        $rules = [
            "post_title" => array("required" => true),
            "post_category_id" => array("required" => true),
            "post_content" => array("required" => true)
        ];

        if (isset($_POST['update'])) {
            $form = new Form("update_with_img", $_POST, $_FILES["post_image"], $rules, $the_post, $id);

            if ($form->proccess()) {
                $the_post->update(['post_user_id'=>$_SESSION['id']]);
                $this->session->message("Post '" . $form->form_values["post_title"] . "' updated");
                redirect(ROOT . "posts");
            }
        } else {
            Form::delete_tmp_img();
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
    
    
    
    

    public function add_front() {
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
            $form = new Form("add_with_img", $_POST, $_FILES["post_image"], $rules, $this->posts);

            if ($form->proccess()) {
                $this->session->message("Thanks for add post '" . $form->form_values["post_title"] . " '. This post waiting moderation ");
                $generator = new Vnsdks\SlugGenerator\SlugGenerator;
                $postTitle = $generator->generate($form->form_values['post_title']);
                $this->posts->update(['post_user_id'=>$_SESSION['id'],'slug'=>$postTitle . "-". $this->posts->id]);
                redirect(ROOT . "posts/add_front");
            }
        } else {
            Form::delete_tmp_img();
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
    
    
    

    public function select_option($id) {
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

                if ($id == 0) {
                    redirect(ROOT . "posts/");
                } else {
                    redirect(ROOT . "posts/index/" . $id);
                }
            } 
            else {
                redirect(ROOT . "posts/");
            }
        }
    }
    
    
    

    public function add() {
        $form = "";

        $rules = [
            "post_title" => array("required" => true),
            "post_category_id" => array("required" => true),
            "post_content" => array("required" => true)
        ];

        if (isset($_POST['submit'])) {
            
            $this->posts->post_date = date('Y-m-d H:i:s');

            $form = new Form("add_with_img", $_POST, $_FILES["post_image"], $rules, $this->posts);

            if ($form->proccess()) {
                $this->session->message("Post '" . $form->form_values["post_title"] . "' added"); 
                $generator = new Vnsdks\SlugGenerator\SlugGenerator;
                $postTitle = $generator->generate($form->form_values['post_title']);
                $this->posts->update(['post_user_id'=>$_SESSION['id'],'slug'=>$postTitle . "-". $this->posts->id]);
                redirect(ROOT . "posts");
            }
        } else {
            Form::delete_tmp_img();
        }


        $data = [$this->categories->get_data(), $this->user->get_data(), $form];
        $this->view('add_post', $data);
    }
    
    
    

//    posty z przypisana kategoria, 'nr' to nr paginacji
    public function post_cat($slug, $nr = 1)
    {
        $cat = $this->categories::where('slug',$slug)->first();
        $id = $cat->id;

        $pager = new Pager(POSTS_PER_PAGE, $this->posts, $nr);
        $posts_per_page = $pager->data_per_page()->where('post_category_id', $id);
        $post_by_category = $this->posts->get_data()->where('post_category_id', $id);
        $count_rows = $post_by_category->count();

        $recent_posts = $this->posts::orderBy('id', 'desc')->where("post_status", "published")->limit(5)->get();

        //id = aktualna strona
        $pagination = new Pagination(5, $nr, $count_rows);

        if ($count_rows == 0) {
            $message = "No posts available";
            $data = [$posts_per_page, $this->categories->get_data(), $count_rows, $id, $pagination, $recent_posts, $message];
        } else {
            $data = [$posts_per_page, $this->categories->get_data(), $count_rows, $id, $pagination, $recent_posts];
        }

        $this->view('posts_category', $data);
    }
    
    
    

    public function destroy($id) {
        $post = $this->posts->find_by_id($id);
        foreach($post->comments as $comment) {
            foreach($comment->replyComments as $reply) {
                $reply->delete();
            }
            $comment->delete();
        }
        $post->delete();
        redirect(ROOT . "posts");
    }
    
    
    

    public function search() {
        $results = "";
        $msg = "";
        $count_results = [];
        $keywords = "";
        $recent_posts = $this->posts::orderBy('id', 'desc')->where("post_status", "published")->limit(5)->get();

        if (isset($_POST['search'])) {
            $keywords = strip_tags($_POST['keywords']);

            if (!empty($keywords)) {
                $results = $this->posts->search_posts($keywords);
                $count_results = $results->count();

                if (empty($count_results)) {
                    $msg = "No results for" . " '" . "<b>" . $keywords . "</b>" . "'";
                }
            } else {
                $msg = "No results. Give some data";
            }
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

}
