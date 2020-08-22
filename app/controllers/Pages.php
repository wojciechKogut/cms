<?php
namespace App\Cms\controllers;

use App\Cms\libraries\Controller as BaseController;

class Pages extends BaseController {
    public $posts;
    public $categories;
    public $user;
    public $comment;
    
    public function __construct(
        \App\Cms\helpers\Logger $logger,
        \App\Cms\models\Post $post,
        \App\Cms\models\Category $categories,
        \App\Cms\models\User $user,
        \App\Cms\models\Comment $comment,
        \App\Cms\models\Like $like
    ) {
        $this->posts      = $post;
        $this->categories = $categories;
        $this->user       = $user;
        $this->comment    = $comment;
        $this->likes      = $like;
        $this->logger     = $logger;
    }
    
    public function index($id = 1)
     {  
        $all_posts = $this->posts->get_data()->where("post_status","published");
        $count_rows = $all_posts->count();
        $pagination = new \App\Cms\helpers\Pagination(POSTS_PER_PAGE, $id, $count_rows);
        $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE,$this->posts, $id);
        $posts_per_page = $pager->data_per_page();              
        $recent_posts = $this->posts::orderBy('id','desc')->where("post_status","published")->limit(5)->get();              
        $data = [$posts_per_page, $count_rows, $id, $this->categories->get_data(),$pagination,$recent_posts];
        
        $this->view('home', $data);
    }
    
    public function admin()
    {
        $session = $this->session = new \App\Cms\helpers\Session();
        if ($session->session_check()) {
            $userLogged = $this->user::find($_SESSION['id']);
            $data = [
                $this->user->get_data()->count(),
                $this->posts->get_data()->count(),
                $this->categories->get_data()->count(),
                $this->comment->get_data()->count(),
                $this->user->subscribers()->count(),
                $this->posts->active_posts()->count(),
                $this->posts->draft_posts()->count(),
                $userLogged
            ];

            $this->view('admin', $data);
        } else {
            redirect(ROOT);
        }  
    }
}
