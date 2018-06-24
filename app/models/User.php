<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent implements Model
{

    protected $table = "users"; 
    public $fillable = ['id','user_name','user_password','user_image','user_email','user_firstname','user_lastname','session_id','user_role']; 
    public $timestamps = ['updated_at','created_at'];
    
    

    public function user_validate() {
        if (isset($_POST)) {
            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));
            $user = static::where('user_name', $username)->first();

            if ($user) {
                $pass_verify = password_verify($password, $user->user_password);
                if ($user->user_name == $username && $pass_verify){
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
            return $user;
        }
    }

    

    public function get_data() {
        return static::all();
    }
    
    
    

    public function isAdmin() {
        if (isset($_SESSION['id'])) {
            if ($this->find_by_id($_SESSION['id'])->user_role == "admin") {
                return true;
            }
        }

        return false;
    }
    
    

    public function subscribers() {

        return static::all()->where('user_role', '=', 'subscriber');
    }
    
    

    public function posts() {
        return $this->hasMany('Post', 'post_user_id');
    }
    
    

    public function find_by_id($id) {
        return static::find($id);
    }
    
    

    public function options($checkboxes, $options) {
        die();
        foreach ($checkboxes as $key => $userId) {
            $this->id = $userId;
            $options = $_POST['options'];

            switch ($options) {
                case "subscriber":
                    $the_user = static::find($userId);
                    $the_user->user_role = "subscriber";
                    $the_user->save();
                    break;
                case "admin":
                    $the_user = static::find($userId);
                    $the_user->user_role = "admin";
                    $the_user->save();
                    break;
                case "delete":
                    $this->delete_record($userId);
                    break;
            }
        }
    }
    
    

    public function user_profile($id) {
        return $this->find_by_id($id);
    }
    
    

    public function delete_record($id) {
        $the_user = static::find($id);
        $img = $the_user->user_image; 
        if($img != "userplaceholder.png")  unlink(INCLUDES_PATH."images".DS."upload_img".DS. $img);
        $the_user->delete();
    }


    
    public function searchTable($term) {
           return self::where("user_name","like","%" . $term . "%")->get();   
    }

}
