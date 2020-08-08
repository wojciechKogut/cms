<?php
namespace App\Cms\interfaces;

interface Model 
{
    public function get_data();    
    public function find_by_id($id);
}
