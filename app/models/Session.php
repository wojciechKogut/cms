<?php
namespace App\Cms\models;

class Session
{
    public $message;
    public $session_start;
    
    public function __construct()
    {
        $this->session_start = session_start(); 
        $this->check_message();
    }   
    
    public function session_check()
    {
        if (isset($_SESSION['user_name'])){
            return true;
        } 

        return false;
    }
    
    public function check_message()
    {
        if(isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }  else {
            $this->message = "";
        }
    }
    
    public function message($msg = "", $type = "success")
    {
        if(!empty($msg)) {
            return $_SESSION['message'] = ['text' => $msg, 'type' => $type];
        } 

        return $this->message;
    }
}