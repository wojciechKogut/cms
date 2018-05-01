<?php



class Pages extends Controller
{
    
    public $posts;
    public $categories;
    public $user;
    public $comment;
    
    public function __construct()
    {
        $this->posts      = $this->model('post');
        $this->categories = $this->model('category');
        $this->user       = $this->model('user');
        $this->comment    = $this->model('comment');
    }
    
    

//    gdy url jest pusty to wczytujemy strone startowa, metoda index jest domyslna metoda gdy nie podamy w url nazwy metody
    public function index($id = 1)
    {  
                $all_posts = $this->posts->get_data()->where("post_status","published");
                $count_rows = $all_posts->count();
                //id = aktualna strona
                $pagination = new Pagination(POSTS_PER_PAGE, $id, $count_rows);
                //ostatni argument pozwali na polaczenie tabel post i category
                $pager = new Pager(POSTS_PER_PAGE,$this->posts,$id);
                $posts_per_page = $pager->data_per_page();
                
                $recent_posts = $this->posts::orderBy('id','desc')->where("post_status","published")->limit(5)->get();
                
                $data = [$posts_per_page, $count_rows, $id, $this->categories->get_data(),$pagination,$recent_posts];
                $this->view('home', $data);
    }
    

    
//    gdy url = pages/admin wczytujemy view  -  admin
    public function admin()
    {

        $session = $this->model('session');

        if ($session->session_check())
        {
            $data = [
                        $this->user->get_data()->count(),
                        $this->posts->get_data()->count(),
                        $this->categories->get_data()->count(),
                        $this->comment->get_data()->count(),
                        $this->user->subscribers()->count(),
                        $this->posts->active_posts()->count(),
                        $this->posts->draft_posts()->count()
                    ];
            $this->view('admin', $data);
        }
        else
        {
            redirect(ROOT);
        }
    }

}
