<?php
    include "../../config/db.php";
    include "../../config/baseurl.php";

    $comment_id = $_GET["id"];

    $blog_id_query = mysqli_query($con, "SELECT blog_id FROM comments WHERE id=$comment_id");
    $blog_id = mysqli_fetch_assoc($blog_id_query)["blog_id"];

    if(isset($_POST["text"]) && strlen($_POST["text"]) > 0){
    $text = $_POST["text"];
    $file_name = "";

        if(isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0){
            $file_name = time() . ".";  
            $explode = explode(".", $_FILES["image"]["name"]);
            $end_file = end($explode); 

            $file_name = $file_name . $end_file;   

            move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/comments/$file_name");
        }

        mysqli_query($con, "UPDATE comments
                                SET text='$text', image='$file_name'
                                WHERE id=$comment_id ");
        header("Location: $BASE_URL/blog-details.php?id=$blog_id");
    }
    else{
        header("Location: $BASE_URL/blog-details.php?id=$blog_id&error=1");
    }
?>