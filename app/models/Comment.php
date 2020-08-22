<?php
namespace App\Cms\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Cms\interfaces\Model;

class Comment extends Eloquent implements Model {

    protected $table = 'comments';
    public $fillable = [
        'id',
        'comment_post_id',
        'comment_user_id',
        'comment_author',
        'comment_email', 
        'comment_content',
        'comment_status', 
        'comment_date', 
        'reply_author'
    ];
    public $timestamps = ['created_at', 'updated_at'];

    public function getCommentPostId()
    {
        return $this->comment_post_id;
    }

    public function getCommentUserId()
    {
        return $this->comment_user_id;
    }

    public function getCommentAuthor()
    {
        return $this->comment_author;
    }

    public function getCommentEmail()
    {
        return $this->comment_email;
    }

    public function getCommentContent()
    {
        return $this->comment_content;
    }

    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    public function getCommentDate()
    {
        return $this->comment_date;
    }

    public function getReplyAuthor()
    {
        return $this->reply_author;
    }

    public function setCommentPostId(int $id)
    {
        $this->comment_post_id = $id;
    }

    public function setCommentUserId(int $id)
    {
        $this->comment_user_id = $id;
    }

    public function setCommentAuthor(string $author)
    {
        $this->comment_author = $author;
    }

    public function setCommentEmail(string $email)
    {
        $this->comment_email = $email;
    }

    public function setCommentContent(string $content)
    {
        $this->comment_content = $content;
    }

    public function setCommentStatus(string $status)
    {
        $this->comment_status = $status;
    }

    public function setCommentDate(string $date)
    {
        $this->comment_date = $date;
    }

    public function setReplyAuthor(string $replyAuthor)
    {
        $this->reply_author = $replyAuthor;
    }

    public function get_data() {
        return static::orderBy('id', 'desc')->get();
    }

    public function find_by_id($id) {

        return static::where('comment_post_id', $id)->get();
    }

    public function options($checkboxes, $options) {
        foreach ($checkboxes as $key => $commentId) {
            $options = $_POST['options'];

            switch ($options) {
                case "approved":
                    $this->change_status("approved", $commentId);
                    break;
                case "unapproved":
                    $this->change_status("unapproved", $commentId);
                    break;
                case "delete":
                    $this->destroy($commentId);
                    break;
            }
        }
    }

    public function post() {
        return $this->belongsTo('Post','comment_post_id');
    }

    public function get_user_comm_img($user_id) {

        $user = new \App\Cms\models\User();

        //jezeli jest uzytkownik zalogwany
        if ($user_id != 0) {
            $user_img = $user->find_by_id($user_id)->user_image;
            return ROOT . "images/upload_img/" . $user_img;
        } else {
            return ROOT . "images/user.jpg";
        }
    }

    public function get_comm_author($user_id) {
        return !empty($user_id) ? \App\Cms\models\User::find($user_id)->user_name : $this->comment_author;
    }
    
    
    public function replyComments() {
        return $this->hasMany('Comment_reply','comment_reply_id');
    }
    
    public function add() {
        $img = $this->get_user_comm_img($this->comment_user_id);
        $html = "<li id='' class='' style='list-style-type: none'>   
        <div class='col-md-12 well' id='showComment'>
           <img class='img-size img-circle pull-left'  src='$img' alt=''>
              <div class='col-md-10'>
                    <h4 class=''>$this->comment_author
                      <small>$this->comment_date<i onclick='reply($this->id)' class='fa fa-reply'></i> </small>
                    </h4>
                   <ul style='display:block'> 
                       <li class='mt-4'  style='overflow:hidden; background-color: #fff;border-radius: 25px'>$this->comment_content</li>
                           <ul id='reply-list-$this->id'>
                               
                           </ul>
                  </ul>
                    
              </div>
              <form style='height:3rem;' id='reply_form-$this->id' method='post' action=''><input onclick='reply_content($this->id)' type='text' class='col-md-10 ml-5' id='answer-$this->id' placeholder='Enter reply' style='overflow:hidden; display:none; background-color: #fff;'></form>
          </div>    
        </li> 
        <input type='hidden' id='user-id' value='$this->comment_user_id'>
       <input type='hidden' id='post-id' value='<?php echo $this->comment_post_id ?>'>
              "
                ;
        return $html;
    }

}
