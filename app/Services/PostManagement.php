<?php
namespace App\Cms\Services;

use App\Cms\models\Post;
use App\Cms\models\User;

class PostManagement
{
    private $post;
    private $user;
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function filterData(string $term, int $userId, int $nrPage)
    {
        if ($this->user->isAdmin()) {
            return $this->getAllFilterData($term)
                // ->offset($this->getOffset($nrPage))
                ->limit(POSTS_PER_PAGE)
                ->get();
        }

        return $this->getAllFilterData($term)
            ->where('post_user_id', $userId)
            // ->offset($this->getOffset($nrPage))
            ->limit(POSTS_PER_PAGE)
            ->get();
    }

    public function getOffset(int $nrPage) {
        if ($nrPage == null) {
            return (POSTS_PER_PAGE * 1) - $this->per_page;
        } 

        return (POSTS_PER_PAGE * $this->nrPage) - POSTS_PER_PAGE;
    }

    public function getAllFilterData(string $term)
    {
        return $this->post::where('post_title', 'like', '%' . $term . '%');
    }
}