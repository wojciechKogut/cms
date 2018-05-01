<?php

class Comments extends Controller {

    public $comment;

    public function __construct() {
        $this->comment = $this->model('comment');
        $this->users = $this->model('user');
        $this->posts = $this->model('post');
        $this->session = $this->model('session');
        $this->comment_reply = $this->model('comment_reply');
    }
    
    

    public function index($id) {

        $pager = new Pager(5, $this->comment, $id);


        if (!$this->users->isAdmin()) {
            $user_id = $_SESSION['id'];
            $comments_per_page = $pager->data_per_page()->where("comment_user_id", $user_id);
            $count_rows = $this->comment->get_data()->where("comment_user_id", $user_id)->count();
            $pagination = new Pagination(5, $id, $count_rows);
            $data = [$comments_per_page, $pagination];
        } else {
            $comments_per_page = $pager->data_per_page();
            $all_comments = $this->comment->get_data();
            $count_rows = $all_comments->count();
            $pagination = new Pagination(5, $id, $count_rows);
            $data = [$comments_per_page, $pagination];
        }


        $this->view('comments', $data);
    }
    
    

    public function ajax() {

        if (isset($_POST)) {

            $this->comment->comment_date = \Illuminate\Support\Carbon::now()->diffForHumans();
            $this->comment->comment_status = 'approved';

            if ($this->session->session_check()) {
                $this->comment->comment_user_id = $_SESSION['id'];
                $this->comment->comment_email = $this->users->find_by_id($_SESSION['id'])->user_email;
                $this->comment->comment_author = $this->users->find_by_id($_SESSION['id'])->user_name;
            } else {
                $this->comment->comment_user_id = 0;
            }

            $form = new Form("save", $_POST, array(), array(), $this->comment);
            $form->proccess();

            //liczba komentarzy
            $post = $this->posts::findOrFail($_POST['comment_post_id']);
            $count = $post->comments()->count();
            $post->post_comment_count = $count;
            $post->save();


//            odp ajax
            echo $this->comment->add();
        }
    }
    
    

    public function status($status, $id) {
        $this->comment::findOrFail($id)->update(['comment_status' => $status]);
        redirect(ROOT . "comments");
    }
    
    
    

    public function select_option() {
//        gdy jest submit i gdy zaznaczylismy jakies rekordy w tabeli
        if (isset($_POST['apply'])) {
            $options = $_POST['options'];
            $checkboxes = $_POST['checkboxes'];

            if (isset($options) && !empty($options) && !empty($checkboxes)) {
                foreach ($checkboxes as $key => $commentId) {
                    $options = $_POST['options'];
                    switch ($options) {
                        case "approved":
                            $this->status("approved", $commentId);
                            break;
                        case "unapproved":
                            $this->status("unapproved", $commentId);
                            break;
                        case "delete":
                            $this->destroy($commentId);
                            break;
                    }
                }
            } else {
                redirect(ROOT . "comments");
            }
        }
    }
    
    

    public function destroy($id) {
        $comment = $this->comment::findOrFail($id);
        foreach($comment->replyComments as $reply) {
            $reply->delete();
        }
        redirect(ROOT . "comments/");
    }
    
    
    
    
    

    public function reply() {
        if (isset($_POST)) {

            $this->comment_reply->comment_reply_id = $_POST['comment_id'];
            $this->comment_reply->comment_post_id = $_POST['post_id'];
            $this->comment_reply->comment_user_id = $_POST['user_id'];
            $this->comment_reply->comment_content = $_POST['content'];

            $user_img = $this->comment->get_user_comm_img($_POST['user_id']);

            $this->comment_reply->save();

            echo $html = "<li class='mt-4' style='word-wrap:break-word; min-height:3rem; list-style-type:none; background-color: #fff;border-radius: 25px'>"
            ."<strong> ".$this->comment_reply->user->user_name ." </strong>"
            . $_POST['content']
            . " <img class='img-size img-circle pull-left'  src='$user_img' alt=''></li><span>".$this->comment_reply->created_at->diffForHumans() ."</span>";
        }
    }
    
    

}
