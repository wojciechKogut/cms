<?php

class Pagination
{

    public $per_page;
    public $current_page;
    public $count;

    public function __construct($per_page, $curent_page, $count)
    {
        $this->per_page = $per_page;
        $this->current_page = $curent_page == null ? 1 : $curent_page;
        $this->count = ceil($count / $per_page);
    }



    public function show_pagination()
    {
        return ($this->count == 1) ? false : true;
    }



    public function next()
    {
        return $this->current_page + 1;
    }



    public function previous()
    {
        return $this->current_page - 1;
    }



    public function has_next()
    {


        if ($this->current_page < $this->count) {
            return true;
        } else
            return false;
    }



    public function has_previous()
    {
        if ($this->current_page <= 1) {
            return false;
        } else {
            return true;
        }
    }


}

class Form
{

    public $form_values;
    public $error = [];
    public $upl_err;
    public $files;
    public $rules;
    public $form_role;
    public $style = [];
    public $tmp_file;
    public $model;
    public $id;

    public function __construct($form_role, $form_values, $files = [], $rules, $model, $id = "")
    {
        $this->form_values = $form_values;
        $this->files = $files;
        $this->rules = $rules;
        $this->form_role = $form_role;
        $this->tmp_file = "";
        $this->model = $model;
        $this->id = $id;
    }

    public function clean()
    {
        if (filter_has_var(INPUT_POST, "user_email")) {
            $email = filter_var($this->form_values["user_email"], FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error["user_email"] = "Invalid email";
                $this->style["user_email"] = "required";
            } else {
                unset($this->error["user_email"]);
            }
//                        czy email istnieje
            $email_exists = $this->model->where('user_email', $this->form_values['user_email'])->get();
//                        czy uzytkownik istnieje
            $user_name_exists = $this->model->where('user_name', $this->form_values['user_name'])->get();

            if ($email_exists->count() > 0) {
                $this->error["email_exists"] = "Email exists";
                $this->style["email_exists"] = "required";
            }
            if ($user_name_exists->count() > 0) {
                $this->error["user_exists"] = "Username exists";
                $this->style["user_exists"] = "required";
            }
        }


        foreach ($this->form_values as $field => $value) {
            
            if($field != "post_content") {
                $this->form_values[$field] = strip_tags($value);
                $this->form_values[$field] = filter_var($value, FILTER_SANITIZE_STRING);
                $this->form_values[$field] = htmlspecialchars($value);
            } else {
                $this->form_values[$field] = filter_var($value, FILTER_SANITIZE_STRING);
                $this->form_values[$field] = htmlspecialchars($value);
            }
            



            if ($field == "user_password") {
                if (!empty($value)) {
                    $this->form_values[$field] = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
                }
            }
        }
    }

    public function form_rules()
    {
        foreach ($this->rules as $field => $rule) {
            $this->required_fields($field, $rule);
        }
    }

    public function required_fields($field, $rule)
    {
        foreach ($rule as $key => $value) {
            if ($key == "required" && $value == true) {
                if (empty($this->form_values[$field])) {
                    $this->error[$field] = "Field is required";
                    $this->style[$field] = "required";
                }
//                                else
//                                {
//                                        $this->error[$field] = "";
//                                        $this->style[$field] = "";
//                                }
            }
        }
    }


    public function image($file)
    {
        switch ($file["error"]) {
            case UPLOAD_ERR_OK:
                $this->set_up_file($file);
                break;
            case UPLOAD_ERR_INI_SIZE:
                $this->upl_err = "The uploaded file exceeds the upload_max_filesize";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->upl_err = "The uploaded file exceeds the MAX_FILE_SIZE directive";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->upl_err = "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->upl_err = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->upl_err = "Missing a temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->upl_err = "Failed to write file to disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->upl_err = "A PHP extension stopped the file upload.";
                break;
        }
    }


    public function set_up_file($file)
    {


        if ($this->check_err()) {
            $dir = INCLUDES_PATH;
            move_uploaded_file($file["tmp_name"], $dir . "images" . DS . "upload_img" . DS . $file["name"]);
        } else {
            $dir = INCLUDES_PATH . "tmp";
//          $_SESSION["nr_img"] = $_SESSION["nr_img"]+1;
            move_uploaded_file($file["tmp_name"], $dir . DS . time() . $file["name"]);
            $this->tmp_file = time() . $file["name"];
        }
    }

    public static function delete_tmp_img()
    {


        $dir = INCLUDES_PATH . "tmp";
        if (!$fd = opendir($dir)) {
            exit("Cannot open directory");
        }
        while (($file = readdir($fd)) !== false) {
            if ($file == "." || $file == "..")
                continue;
            unlink($dir . DS . $file);
        }
    }



    public function img_after_submit()
    {
        $dir = INCLUDES_PATH . "tmp";
        if (!$fd = opendir($dir)) {
            exit("Cannot open directory");
        }
        while (($file = readdir($fd)) !== false) {
            if ($file == "." || $file == "..")
                continue;
            $this->tmp_file = $file;
        }
    }




    public function check_err()
    {
        foreach ($this->error as $field => $value) {
            if (!empty($value)) {
                return false;
            }
        }

        return true;
    }



    public function proccess()
    {

        $this->clean();
        $this->form_rules();

        if (!empty($this->files["name"])) {
            $this->image($this->files);
        }

        $this->img_after_submit();

        if ($this->check_err()) {
            switch ($this->form_role) {


                case "add_with_img":

                    $classname = get_class($this->model);
                    $img = $classname . "_image";


                    foreach ($this->form_values as $property => $value) {
                        if (in_array($property, $this->model->fillable)) {
                            $this->model->$property = $value;
                        }
                    }


                    if (!empty($this->tmp_file)) {
//                                                $final_img = preg_replace('/\d+/u', '', $this->tmp_file);
                        copy(INCLUDES_PATH . "tmp" . DS . $this->tmp_file, INCLUDES_PATH . DS . "images" . DS . "upload_img" . DS . $this->tmp_file);
                        $this->model->$img = $this->tmp_file;
                    } else if (!empty($this->files["name"])) {
                        $this->model->$img = $this->files["name"];
                    } else {
                        $this->model->$img = "placeholder.jpg";
                    }



                    $this->model->save();

                    return true;



                case "update_with_img":

                    foreach ($this->form_values as $property => $value) {
                        if (in_array($property, $this->model->fillable)) {
                            $this->model->$property = $value;
                        }
                    }

                    $classname = strtolower(get_class($this->model));
                    $img = $classname . "_image";

                    if (!empty($this->files["name"])) {
                        $this->model->$img = $this->files["name"];
                    } else if (!empty($this->tmp_file)) {
//                      $final_img = preg_replace('/\d+/u', '', $this->tmp_file);
                        copy(INCLUDES_PATH . "tmp" . DS . $this->tmp_file, INCLUDES_PATH . DS . "images" . DS . "upload_img" . DS . $this->tmp_file);
                        $this->model->$img = $this->tmp_file;
                    } else {
                        if (empty($this->model->$img)) {
                            $this->model->$img = "placeholder.jpg";
                        }
                    }


                    $this->model->save();

                    return true;




                case "save":


                    foreach ($this->form_values as $property => $value) {
                        if (in_array($property, $this->model->fillable)) $this->model->$property = $value;
                    }

                    if (!empty($this->files)) {
                        $this->model->post_image = $this->files["name"];
                    }

                    $this->model->save();
                    return true;
            }
        }


        return false;
    }

}





class Pager
{

    public $per_page;
    public $model;
    public $nr_page;
    public $adm;
    public $user_id;


    public function __construct($per_page, $model, $nr_page, $adm = null, $user_id = null)
    {
        $this->per_page = $per_page;
        $this->model = $model;
        $this->nr_page = $nr_page;
        // $this->link = $link;
        $this->adm = $adm;
        $this->user_id = $user_id;
    }



    public function offset()
    {
        if ($this->nr_page == null) {
            return ($this->per_page * 1) - $this->per_page;
        } else {
            return ($this->per_page * $this->nr_page) - $this->per_page;
        }
    }





    public function data_per_page()
    {
        $offset = $this->offset();

        if (strtolower(get_class($this->model)) == "post" && $this->adm) {
            return $this->model::orderBy('id', 'desc')->offset($offset)->limit(POSTS_PER_PAGE)->get();
        } else if (strtolower(get_class($this->model)) == "post") {
            return $this->model::orderBy('id', 'desc')->where("post_status", "published")->offset($offset)->limit(POSTS_PER_PAGE)->get();
        } else if (strtolower(get_class($this->model)) == "post" && !$this->adm) {
            return $this->model::orderBy('id', 'desc')->where("post_user_id", $this->user_id)->offset($offset)->limit(POSTS_PER_PAGE)->get();
        }


        return $this->model::orderBy('id', 'desc')->offset($offset)->limit(POSTS_PER_PAGE)->get();
    }

    public function filtrData($term) {
        $offset = $this->offset();
        return $this->model::where("post_title","like","%" . $term . "%")->offset($offset)->limit(POSTS_PER_PAGE)->get();
    }

    public function sortByQuery($sortBy) {
        $offset = $this->offset();
        if($sortBy == "titleDesc") {
            return $this->model::orderByDesc("post_title")->offset($offset)->limit(POSTS_PER_PAGE)->get();  
        } else if($sortBy == "titleAsc") {
            return $this->model::orderBy("post_title")->offset($offset)->limit(POSTS_PER_PAGE)->get();  
        } else if($sortBy == "authorDesc") {
            return $this->model::orderByDesc("post_author")->offset($offset)->limit(POSTS_PER_PAGE)->get(); 
        } else if($sortBy == "authorAsc") {
            return $this->model::orderBy("post_author")->offset($offset)->limit(POSTS_PER_PAGE)->get(); 
        }
         
    }

}





function redirect($path)
{

    return header("location: " . $path);
}



function truncate($post_content)
{
    return $post_content = (strlen($post_content) > 100) ? substr($post_content, 0, 200) . " (..)" : $post_content;
}

