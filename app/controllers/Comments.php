<?php
namespace App\Cms\controllers;

use App\Cms\libraries\Controller as BaseController;
use App\Cms\helpers\Form;
use App\Cms\helpers\Pagination;
use App\Cms\helpers\Pager;
use App\Cms\models\Comment;
use App\Cms\models\User;
use App\Cms\models\Post;
use App\Cms\helpers\Session;
use App\Cms\models\Comment_reply;

class Comments extends BaseController {

    /**
     * @var Comment $comment
     */
    public $comment;

    /**
     * @var User $user
     */
    public $user;

     /**
     * @var Post $post
     */
    public $post;

    /**
     * @var Session $session
     */
    public $session;

    /**
     * @var Comment_reply $commentReply
     */
    public $commnetReply;

    public function __construct(
        Comment $comment,
        User $user,
        Post $post,
        Session $session,
        Comment_reply $commentReply
    ) {
        $this->comment = $comment;
        $this->user = $user;
        $this->post = $post;
        $this->session = $session;
        $this->commentReply = $commentReply;
    }

    public function index($id)
    {
        $pager = new Pager(5, $this->comment, $id);
        if (!$this->user->isAdmin()) {
            $userId = $_SESSION['id'];
            $commentsPerPage = $pager->data_per_page()->where("comment_user_id", $userId);
            $countRows = $this->comment->get_data()->where("comment_user_id", $userId)->count();
        } else {
            $commentsPerPage = $pager->data_per_page();
            $countRows = $this->comment->get_data()->count();
        }

        $pagination = new Pagination(5, $id, $countRows);
        $data = [$commentsPerPage, $pagination];

        $this->view('comments', $data);
    }

    public function ajax()
    {
        $commentAjaxValidator = new \App\Cms\Validators\CommentAjaxValidator($_POST);
        $this->comment->setCommentDate($commentAjaxValidator->getCommentDate());
        $this->comment->setCommentStatus($commentAjaxValidator->getCommentStatus());
        if ($this->session->session_check()) {
            $userId = $_SESSION['id'];
            $this->comment->setCommentUserId($commentAjaxValidator->getCommentUserId());
            $this->comment->setCommentEmail($this->user->find_by_id($userId)->user_email);
            $this->comment->setCommentAuthor($this->user->find_by_id($userId)->user_name);
        }

        $form = new Form("save", $_POST, array(), array(), $this->comment);
        $form->proccess();

        $post = $this->post::findOrFail($commentAjaxValidator->getCommentPostId());
        $count = $post->comments()->count();
        $post->post_comment_count = $count;
        $post->save();

        echo json_encode($this->comment->add());
        
    }
    
    public function status($status, $id)
    {
        $this->comment::findOrFail($id)->update(['comment_status' => $status]);
        redirect(ROOT . "comments");
    }

    public function select_option()
    {
        if (!isset($_POST['apply'])) {
           return null;
        }

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

    public function destroy($id)
    {
        $comment = $this->comment::find($id);
        foreach($comment->replyComments as $reply) {
            $reply->delete();
        }
        $comment->delete();
        redirect(ROOT . "comments/");
    }
    
    public function reply()
    {
        if (isset($_POST)) {
            $this->commentReply->comment_reply_id = $_POST['comment_id'];
            $this->commentReply->comment_post_id = $_POST['post_id'];
            $this->commentReply->comment_user_id = $_POST['user_id'];
            $this->commentReply->comment_content = $_POST['content'];
            $user_img = $this->comment->get_user_comm_img($_POST['user_id']);
            $this->commentReply->save();

            echo "<li class='mt-4' style='word-wrap:break-word; min-height:3rem; list-style-type:none; background-color: #fff;border-radius: 25px'>"
            ."<strong> ".$this->commentReply->user->user_name ." </strong>"
            . $_POST['content']
            . " <img class='img-size img-circle pull-left'  src='$user_img' alt=''></li><span>".$this->commentReply->created_at->diffForHumans() ."</span>";
        }
    }
}
