<?php
namespace App\Cms\controllers;
class Categories extends \App\Cms\libraries\Controller
{
    /**
     *
     * @var \App\Cms\models\Category
     */
    public $category;

    /**
     * @var \App\Cms\models\Session
     */
    public $session;
    
    public function __construct()
    {
        $this->category = $this->model('category');
        $this->session = $this->model("session");
    }
    
    public function index($id)
    {
        $pager = new \App\Cms\helpers\Pager(POSTS_PER_PAGE,$this->category,$id);       
        $categories_per_page = $pager->data_per_page();    
        $count_rows = $this->category->get_data()->count();   
        $pagination = new \App\Cms\helpers\Pagination(5, $id, $count_rows);
        $data = [$categories_per_page, $pagination, $this->session->message];

        $this->view('categories', $data);
    }
    
    public function update($id)
    {
        $the_category = $this->category->find_by_id($id);
        if (!isset($_POST['update'])) {
            return $this->view("update_category", ["", $the_category]);
        }

        $rules = ["cat_title"  => ["required" => true]];
        $form = new \App\Cms\helpers\Form("save", $_POST, [], $rules, $the_category, $id); 
        if (!(bool) $form->proccess()) {
            $this->session->message("Category Title is required. Please try again", 'error');
            redirect(ROOT ."categories");
            return;
        }

        $this->session->message("Category '". $form->form_values["cat_title"]. "' updated");
        redirect(ROOT ."categories");
    }

    public function add()
    {
        if (!isset($_POST['add_cat'])) {
            return $this->view("add_category", [null]);
        }

        $this->category->color = "rgb(".mt_rand(0,255).",".mt_rand(0,255).",".mt_rand(0,255).")";
        $rules = ["cat_title"  => ["required" => true]];
        $form = new \App\Cms\helpers\Form("save", $_POST, [], $rules, $this->category); 
        if (!(bool) $form->proccess()) {
            $this->session->message("Category Title is required. Please try again", "error");
            redirect(ROOT ."categories");
            return;
        }

        $generator = new \Vnsdks\SlugGenerator\SlugGenerator;
        $catTitle = $generator->generate($form->form_values['cat_title']);
        $this->category->update(['slug' => $catTitle]);
        $this->session->message("Category '". $form->form_values["cat_title"]. "' added");

        redirect(ROOT ."categories");
    }

    public function destroy($id)
    {
        $this->category->find_by_id($id)->delete();
        header("location: " .ROOT. "categories/");
    }
}
