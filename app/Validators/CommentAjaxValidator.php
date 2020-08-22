<?php
namespace App\Cms\Validators;

class CommentAjaxValidator
{
    private $commentPostId;
    private $commentContent;
    private $commentUserId;
    private $commentDate;
    private $postData;
    private const COMMENT_STATUS = 'approved';

    public function __construct(array $postData)
    {
        if (empty($postData)) {
            throw new \Exception('Invalid request. No data send');
        }

        if (!isset($postData['comment_post_id'])) {
            throw new \Exception('Comment post id missing');
        }

        if (!isset($postData['comment_content'])) {
            throw new \Exception('Please fill comment area.');
        }

        $this->postData = $postData;
        $this->commentContent = $postData['comment_content'];
        $this->commentPostId = $postData['comment_post_id'];
        $this->commentUserId = $_SESSION['id'];
        $this->commentDate = \Illuminate\Support\Carbon::now();
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function getCommentPostId()
    {
        return $this->commentPostId;
    }

    public function getCommentContent()
    {
        return $this->commentContent;
    }

    public function getCommentUserId()
    {
        return $this->commentUserId;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function getCommentStatus()
    {
        return self::COMMENT_STATUS;
    }
}