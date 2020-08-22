<?php
namespace App\Cms\controllers;

use App\Cms\Validators\CategoryValidator;

class Categories extends \App\Cms\libraries\Controller
{
    /**
     *
     * @var \App\Cms\models\Category
     */
    private $category;

    /**
     * logger
     *
     * @var \App\Cms\helpers\Logger
     */
    private $logger;

    /**
     * @var \App\Cms\helpers\Session
     */
    private $session;
    
    public function __construct(
        \App\Cms\models\Category $category,
        \App\Cms\helpers\Session $session,
        \App\Cms\helpers\Logger $logger
    ) {
        $this->category = $category;
        $this->session = $session;
        $this->logger = $logger;
    }
    
    public function index($id)
    {
        $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE,$this->category,$id);       
        $categories_per_page = $pager->data_per_page();    
        $count_rows = $this->category->get_data()->count();   
        $pagination = new \App\Cms\helpers\Pagination(3, $id, $count_rows);
        $data = [$categories_per_page, $pagination, $this->session->message];

        $this->view('categories', $data);
    }
    
    public function update($id)
    {
        $the_category = $this->category->find_by_id($id);

        return $this->view("update_category", ["", $the_category]);
    }

    public function updateCategory($id)
    {
        try {
            $category = $this->category->find_by_id($id);
            $categoryValidator = new CategoryValidator($_POST);
            $category->setCategoryTitle($categoryValidator->getCategoryTitle());
            $category->save();
            $this->session->message("Category updated");
        } catch(\Exception $e) {
            $this->session->message($e->getMessage());
        }

        redirect(ROOT ."categories");
    }

    public function add()
    {
        return $this->view("add_category", [null]);
    }

    public function addCategory()
    {
        try {
            $categoryValidator = new CategoryValidator($_POST);
            $generator = new \Vnsdks\SlugGenerator\SlugGenerator;
            $catTitle = $categoryValidator->getCategoryTitle();
            $this->category->setCategoryTitle($catTitle);
            $this->category->setCategoryColor("rgb(".mt_rand(0,255).",".mt_rand(0,255).",".mt_rand(0,255).")");
            $this->category->setCategorySlug($generator->generate($catTitle));
            $this->category->save();
            $this->session->message("Category added");
        } catch (\Exception $e) {
            $this->session->message($e->getMessage());
        }
       
        redirect(ROOT ."categories");
    }

    public function destroy($id)
    {
        $this->category->find_by_id($id)->delete();
        header("location: " .ROOT. "categories/");
    }
}
