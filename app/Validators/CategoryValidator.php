<?php
namespace App\Cms\Validators;

class CategoryValidator
{
    private $postData;
    private $categoryTitle;
    public function __construct(array $postData)
    {
        if (empty($postData)) {
            throw new \Exception('Invalid request. No data send');
        }

        if ($postData['cat_title'] === '') {
            throw new \Exception('Category Title required');
        }

        $this->postData = $postData;
        $this->categoryTitle = $postData['cat_title'];
    }

    public function getCategoryTitle()
    {
        return $this->categoryTitle;
    }

    public function getPostData()
    {
        return $this->postData;
    }
}