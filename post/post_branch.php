<?php

// $postId = $_POST['post_id'];

// 追加

if(isset($_POST['add']) == true) {
    
    header('location:add/staff_add.php');
    exit();
    
}

// 修正

if(isset($_POST['edit']) == true) {

    if(isset($_POST['post_id'])==false)
    {
        var_dump($_POST['post_id']);
        // header('location:staff_ng.php');
        exit();
    }
    $post_code = $_POST['post_id'];
    header('location:edit_post.php?post_id='.$post_code);
    exit();
}

// 削除

if(isset($_POST['delete']) == true) {

    if(isset($_POST['post_id'])==false)
    {   
        header('location:staff_ng.php');
        exit();
    }
    $post_code = $_POST['post_id'];
    header('location:delete_post.php?post_id='.$post_code);
    exit();
    
}



?>