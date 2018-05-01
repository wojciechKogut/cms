<?php

class Categories extends Controller
{
    
    
    public $category;
    public $session;
    
    
    
    public function __construct()
    {
        $this->category = $this->model('category');
        $this->session = $this->model("session");
    }
    
    
    
    
    
    public function index($id)
    {
        $pager = new Pager(POSTS_PER_PAGE,$this->category,$id);       
        $categories_per_page = $pager->data_per_page();    
        $count_rows = $this->category->get_data()->count();   
        $pagination = new Pagination(5, $id, $count_rows);
        
        $data = [$categories_per_page,$pagination, $this->session->message];
        $this->view('categories', $data);
    }
    
    
  
    
    public function update($id)
    {
        $form = "";
        $the_category = $this->category->find_by_id($id);
        
        if(isset($_POST['update']))
        {
            $rules = [
                        "cat_title"  => array("required"=>true),
                     ];
            
            $form = new Form("save",$_POST,array(),$rules,$the_category,$id); 
            
            if($form->proccess())
            {
                $this->session->message("Category '".$form->form_values["cat_title"]."' updated");
                redirect(ROOT ."categories");
            }
            
        }
        
        $data=[$form,$the_category]; 
        $this->view("update_category",$data);
    }
    
    
    
    
    
    
    public function add()
    {
        $categories_all = $this->category->get_data();
        $form="";
        
        if(isset($_POST['add_cat']))
        {
            $color = "rgb(".mt_rand(0,255).",".mt_rand(0,255).",".mt_rand(0,255).")";
            $this->category->color = $color;
            
            $rules = [
                        "cat_title"  => array("required"=>true),
                     ];
            
            $form = new Form("save",$_POST,array(),$rules,$this->category);
            
            if($form->proccess())
            {
                $generator = new Vnsdks\SlugGenerator\SlugGenerator;
                $catTitle = $generator->generate($form->form_values['cat_title']);
                $this->category->update(['slug'=>$catTitle]);
                $this->session->message("Category '".$form->form_values["cat_title"]."' added");
                redirect(ROOT ."categories");
            }

        }
        
        $data=[$form];
        $this->view("add_category",$data);
    }
    
    
    
    
    public function destroy($id)
    {
        $this->category->find_by_id($id)->delete();
        header("location: ".ROOT."categories/");
    }
    
    
    
    
    
}
