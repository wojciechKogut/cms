<?php

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
        if (isset($_SESSION['user_name']))
       {
            return true;
        }
        else
        {
            return false;
        }   
    }
    
    public function check_message()
    {
        if(isset($_SESSION['message']))
        {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        else
        {
            $this->message = "";
        }
    }
    
    public function message($msg="")
    {
        if(!empty($msg))
        {
            return $_SESSION['message'] = $msg;
        }
        else
        {
            return $this->message;
        }
    }
    
}