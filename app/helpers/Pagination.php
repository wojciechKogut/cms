<?php
namespace App\Cms\helpers;

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