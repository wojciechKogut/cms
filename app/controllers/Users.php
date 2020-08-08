<?php
namespace App\Cms\controllers;

use App\Cms\libraries\Controller as BaseController;

class Users extends BaseController {

    public $session;
    public $count_comment = 0;
    public $user;
    public $posts;
    public $comments;
    public $categories;
    private $admin_id = [1];
    public $reply_comment;

    public function __construct() {    
        $this->session = $this->model('session');
        $this->session->session_start;
        $this->user = $this->model('user');
        $this->posts = $this->model('post');
        $this->comments = $this->model('comment');
        $this->categories = $this->model('category');
        $this->reply_comment = $this->model('comment_reply');
        $this->likes = $this->model('like');
    }
    
    
    
    
    /* return view - login*/
    public function login() {
        if (isset($_SESSION['user_name'])) {
            redirect(ROOT . "pages/admin");
        } else {
            $this->view('login');
            unset($_SESSION['msg']);
        }
    }
    
 

    public function find_by_id($id) {
        return static::find($id);
    }

    
    /* login user and redirect */
    public function check_user() {
        if ($row = $this->user->user_validate()) {          
            $_SESSION['user_name'] = $row->user_name;
            $_SESSION['id'] = $row->id;
            if (in_array($row->id, $this->admin_id)) $_SESSION['user_role'] = "admin";     
            else $_SESSION['user_role'] = "subscriber";
            redirect(ROOT. "pages/admin");        
        } else {        
            if (isset($_SESSION['msg'])) unset($_SESSION['msg']);
            $_SESSION['msg'] = "Incorrect username or password. Try again";
            $previous_url = $_SERVER['HTTP_REFERER'];
            redirect($previous_url);
        }
    }
    
    
    /* login user and redirect via ajax */
    public function ajaxCheck() {
        if ($row = $this->user->user_validate()) {          
            $_SESSION['user_name'] = $row->user_name;
            $_SESSION['id'] = $row->id;
            if (in_array($row->id, $this->admin_id)) $_SESSION['user_role'] = "admin";    
            else $_SESSION['user_role'] = "subscriber";
            echo ROOT . "pages/admin";          
        } else {          
            $previous_url = $_SERVER['HTTP_REFERER'];
            echo $previous_url;           
        }       
    }
    
    

    /* user posts */
    public function post($slug) {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

//        $the_post = $this->posts->find_by_id($id);
        $the_post = $this->posts::where('slug',$slug)->first();
        $views = $the_post->post_views; $views++;
        $the_post->update(['post_views'=>$views]);
        $user = $the_post->user;
        $reply_comment = $this->reply_comment->get_data();
        $recent_posts = $this->posts::orderBy('id', 'desc')->where("post_status", "published")->limit(5)->get();
        $like = $this->likes::where([['user_id','=', $user_id], ['post_id', '=', $the_post->id]])->first();
        $likesToPost = $this->likes::where('post_id', $the_post->id)->get();
        
        /* post category */
        $the_category = $the_post->category;
        $data = [
            $the_post,
            $the_post->id,
            $this->comments->find_by_id($the_post->id),
            $this->categories->get_data(),
            $the_category,
            $user,
            $reply_comment,
            $recent_posts,
            $like,
            $likesToPost->count(),
            $likesToPost
        ];
        $this->view('author_post', $data);
    }
    


    
    /* register user and redirect */
    public function register() {
        $form = "";
        if (isset($_POST['wyslij'])) {
            $this->user->user_role = 'subscriber';
            $this->user->session_id = session_id();
            $this->user->user_image = "userplaceholder.png";
            $rules = [
                "user_name"     => array("required" => true),
                "user_email"    => array("required" => true),
                "user_password" => array("required" => true),
            ];
            $form = new Form("save", $_POST, array(), $rules, $this->user);
            if ($form->proccess()) {
                $_SESSION['user_name'] = $this->user->user_name;
                $_SESSION['id'] = $this->user->id;
                $_SESSION['user_role'] = "subscriber";
                redirect(ROOT . "pages/admin");
            }
        }
        $data = [$form];
        $this->view('register', $data);
    }
    
    

    
    /* logout user */
    public function logout() {
        unset($_SESSION['user_name']);
        session_destroy();
        redirect(ROOT);
    }


    
    /* show all users in table */
    public function index($id) {   
        if (isset($_SESSION['msg']))unset($_SESSION['msg']);    
        
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_POST['reset'])) {
                $pager = new Pager(5, $this->user, $id);
                $users_per_page = $pager->data_per_page();
                $all_users = $this->user->get_data();
                $count_rows = $all_users->count();
                $pagination = new Pagination(5, $id, $count_rows);
                $data = [$users_per_page, $pagination, $this->session->message];
                $this->view('users', $data);
            } else {
                $all_users = $this->filtrTable();
                $count_rows = $all_users->count();
                $pager = new Pager(POSTS_PER_PAGE,$this->user,$id);
                $pagination = new Pagination(5, $id, $count_rows);  
                $data = [$pager->filtrData($_POST['searchTerm'],true),$pagination, $this->session->message];
                $this->view('users', $data);
            }
        } else {
            $pager = new Pager(5, $this->user, $id);
            $users_per_page = $pager->data_per_page();
            $count_rows = $this->user->get_data()->count();
            // $count_rows = $all_users->count();
            $pagination = new Pagination(5, $id, $count_rows);

            /* if user isnt admin redirect do dashboard */ 
            if ($this->user->find_by_id($_SESSION['id'])->user_role != "subscriber") {
                $data = [$users_per_page, $pagination, $this->session->message];
                $this->view('users', $data);
            } else redirect(ROOT . "pages/admin");  
        }     
    }
    
    
    public function filtrTable() {
        if(isset($_POST['search'])) {
            $term = $_POST['searchTerm'];
            return $this->user->searchTable($term);
        }
    }
    
    
    
    /* 
     * update user 
     * param: id - user id
     */

    public function update($id) {
        $the_user = $this->user->find_by_id($id);
        $form = "";
        if (isset($_POST['update_user'])) {           
            $rules = [
                "user_firstname" => array("required" => true),
                "user_lastname"  => array("required" => true),
                "user_name"      => array("required" => true),
                "user_email"     => array("required" => true),
                "user_password"  => array("required" => true)
            ];
            $form = new Form("save", $_POST, array(), $rules, $the_user, $id);
            if ($form->proccess()) {
                $this->session->message("User '" . $form->form_values["user_name"] . "' updated");
                redirect(ROOT . "users");
            }
        }
        $data = [$the_user, $id, $this->session->message, $form];
        $this->view('update_user', $data);
    }
    
    
    
    /* 
     * delete user
     * param : id - user id
     */

    public function destroy($id) {
        $this->user->delete_record($id);
        $posts = $this->posts::where('post_user_id', $id)->get();
        $this->posts->delete_author_post($posts);
        if ($_SESSION['id'] == $id) $this->logout();
        else redirect(ROOT . "users/");
    }
    
    
    /* options in users talbe */

    public function select_option($id) {
        if (isset($_POST['apply'])) {
            if (isset($_POST['options']) && $_POST['options'] != "") {
                   $this->user->options($_POST['checkboxes'], $_POST['options']);
                   redirect(ROOT . "users/index/" . $id);
            } else redirect(ROOT . "users/");      
        }
    }
    
    
    /* add user */

    public function add() {
        $form = "";
        if (isset($_POST['create_user'])) {
            $rules = [
                "user_firstname" => array("required" => true),
                "user_lastname" => array("required" => true),
                "user_name" => array("required" => true),
                "user_email" => array("required" => true),
                "user_password" => array("required" => true)
            ];
            $form = new Form("save", $_POST, array(), $rules, $this->user);
            if ($form->proccess()) {
                $this->user->user_image = "userplaceholder.png";
                $this->session->message("User '" . $form->form_values["user_name"] . "' added");
                redirect(ROOT . "users");
            }
        }
        $data = [$this->session->message, $form];
        $this->view('add_user', $data);
    }
    
    
    
    
    public function profile() {
        $form = "";
        $user_id = $_SESSION['id'];

        /* edit user */
        $edit_user = $this->user->user_profile($user_id);
        if (isset($_POST['user_profile'])) {
            $rules = [
                "user_firstname" => array("required" => true),
                "user_lastname"  => array("required" => true),
                "user_name"      => array("required" => true),
                "user_email"     => array("required" => true),
                // "user_password"  => array("required" => true)
            ];
            $form = new Form("update_with_img", $_POST, $_FILES['user_image'], $rules, $edit_user);
            if ($form->proccess()) {
                $_SESSION["user_name"] = $form->form_values["user_name"];
                $this->session->message("User updated");
                redirect(ROOT . "users");
            }
        } else  Form::delete_tmp_img();
        $data = [$edit_user, $form];
        $this->view('profile', $data);
    }



    public function like() {
        header("Content-Type: application/json");
        $data = [];
        if(isset($_POST)){
            if($_POST['userId'] == 0) {
                $data['userId'] = 0;
                echo json_encode($data);
            }
            else {
                try {
                    
                    $like = $this->likes::where([['user_id','=', $_POST['userId']], ['post_id', '=', $_POST['postId']]])->first();
                    if(!$like) {  
                        $like = $this->likes::create(['user_id' => $_POST['userId'], 'post_id' => $_POST['postId'], 'count' => 1 ]);
                        $likesToPost = $this->likes::where('post_id', $_POST['postId'])->count();
                        $data["userId"] = $_POST['userId'];
                        $data["likesToPost"] = $likesToPost;
                        echo json_encode($data);
                    }  
                    
                } catch(Exception $e) {
                    echo "Caught exceptionn: " . $e->getMessage();
                }
                
            }
        }
    }









}
