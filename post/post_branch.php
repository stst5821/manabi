<?php

// $postId = $_POST['post_id'];

// 追加

if(isset($_POST['new']) == true) {
    
    header('location:new_post.php');
    exit();
    
}

// 修正

if(isset($_POST['edit']) == true) {

    if(isset($_POST['post_id'])==false)
    {
        header('location:post_ng.php');
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
        header('location:post_ng.php');
        exit();
    }
    $post_code = $_POST['post_id'];
    header('location:delete_post.php?post_id='.$post_code);
    exit();
    
}



?>