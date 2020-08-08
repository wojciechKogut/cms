<?php
namespace App\Cms\helpers;

class Form {

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
    public $user_img;
    public $post_img;

    public function __construct($form_role, $form_values, $files = [], $rules, $model, $id = "") {
        $this->form_values = $form_values;
        $this->files = $files;
        $this->rules = $rules;
        $this->form_role = $form_role;
        $this->tmp_file = "";
        $this->model = $model;
        $this->id = $id;
        $this->user_img = $model->user_image;
        $this->post_img = $model->post_image;
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
            $email_exists = $this->model->where('user_email', $this->form_values['user_email'])->get();
            $user_name_exists = $this->model->where('user_name', $this->form_values['user_name'])->get();

            if($this->form_role === "save") {
                if ($email_exists->count() > 0) {
                    $this->error["email_exists"] = "Email exists";
                    $this->style["email_exists"] = "required";
                }
                if ($user_name_exists->count() > 0) {
                    $this->error["user_exists"] = "Username exists";
                    $this->style["user_exists"] = "required";
                }
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

    public function form_rules() {
        foreach ($this->rules as $field => $rule) {
            $this->required_fields($field, $rule);
        }
    }

    public function required_fields($field, $rule) {
        foreach ($rule as $key => $value) {
            if ($key == "required" && $value == true) {
                if ($this->form_values[$field] === '') {
                    $this->error[$field] = "Field is required";
                    $this->style[$field] = "required";
                }
            }
        }
    }


    public function image($file) {
        switch ($file["error"]) {
            case UPLOAD_ERR_OK: $this->set_up_file($file); break;
            case UPLOAD_ERR_INI_SIZE: $this->upl_err = "The uploaded file exceeds the upload_max_filesize";  break;
            case UPLOAD_ERR_FORM_SIZE: $this->upl_err = "The uploaded file exceeds the MAX_FILE_SIZE directive";  break;
            case UPLOAD_ERR_PARTIAL: $this->upl_err = "The uploaded file was only partially uploaded."; break;
            case UPLOAD_ERR_NO_FILE: $this->upl_err = "No file was uploaded";  break;
            case UPLOAD_ERR_NO_TMP_DIR: $this->upl_err = "Missing a temporary folder."; break;
            case UPLOAD_ERR_CANT_WRITE: $this->upl_err = "Failed to write file to disk."; break;
            case UPLOAD_ERR_EXTENSION: $this->upl_err = "A PHP extension stopped the file upload."; break;
        }
    }


    public function set_up_file($file) {
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

    public static function delete_tmp_img() {
        $dir = INCLUDES_PATH . "tmp";
        if (!is_dir($dir)) {
            return;
        }
        
        if (!$fd = opendir($dir)) {
            exit("Cannot open directory");
        }
        while (($file = readdir($fd)) !== false) {
            if ($file == "." || $file == "..")
                continue;
            unlink($dir . DS . $file);
        }
    }



    public function img_after_submit() {
        $dir = INCLUDES_PATH . "tmp";
        if (!$fd = opendir($dir)) {
            exit("Cannot open directory");
        }

        while (($file = readdir($fd)) !== false) {
            if ($file == "." || $file == "..") {
                continue;
            }
                
            $this->tmp_file = $file;
        }
    }

    public function check_err() {
        foreach ($this->error as $field => $value) {
            if (!empty($value)) {
                return false;
            }
        }

        return true;
    }

    public function proccess() {

        $this->clean();
        $this->form_rules();
        if (!empty($this->files["name"])) {
            $this->image($this->files);
            $this->img_after_submit();
        } 

        if ($this->check_err()) {
            switch ($this->form_role) {

                case "add_with_img":
                    $classname = get_class($this->model);
                    $classnameArr = explode('\\', $classname);
                    $classname = end($classnameArr);
                    $img = strtolower($classname) . "_image";

                    foreach ($this->form_values as $property => $value) {
                        if (in_array($property, $this->model->fillable))  $this->model->$property = $value;
                    }

                    if (!empty($this->tmp_file)) {
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
                            if(!empty($value)) $this->model->$property = $value;  
                        }                          
                    }

                    $classname = strtolower(get_class($this->model));
                    $img = $classname . "_image";

                    if (!empty($this->files["name"])) $this->model->$img = $this->files["name"];
                    else if (!empty($this->tmp_file)) {
                        copy(INCLUDES_PATH . "tmp" . DS . $this->tmp_file, INCLUDES_PATH . DS . "images" . DS . "upload_img" . DS . $this->tmp_file);
                        $this->model->$img = $this->tmp_file;
                    } else {
                        if (empty($this->model->$img))  $this->model->$img = "placeholder.jpg";   
                    }

                    if($this->model->user_image != $this->user_img) unlink(INCLUDES_PATH . "images" . DS . "upload_img" . DS . $this->user_img);
                    if($this->model->post_image != $this->post_img) unlink(INCLUDES_PATH . "images" . DS . "upload_img" . DS . $this->post_img);
                                
                    $_SESSION['user_image'] = $this->model->user_image;

                    $this->model->save();
                    return true;


                case "save":
                    foreach ($this->form_values as $property => $value) {
                        if (in_array($property, $this->model->fillable)) $this->model->$property = $value;
                    }
                    if (!empty($this->files)) $this->model->post_image = $this->files["name"];
                    $this->model->save();
                    return true;
            }
        }

        return false;
    }
}