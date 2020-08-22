<?php
namespace App\Cms\controllers;

class PostValidator 
{
    private $postData;

    public function __construct(array $postData)
    {
        if (empty($postData)) {
            throw new \Exception('Invalid request. No data send');
        }   

        $this->postData = $postData;
    }

    public function getPostData()
    {
        return $this->postData;
    }
}