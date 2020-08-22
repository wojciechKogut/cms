<?php

function redirect($path){
    return header("location: " . $path);
}


function truncate($post_content) {
    return $post_content = (strlen($post_content) > 100) ? substr($post_content, 0, 200) . " (..)" : $post_content;
}
