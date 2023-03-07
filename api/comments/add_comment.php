<?php
	include "../../config/db.php";
	include "../../config/baseurl.php";

    $blog_id = $_GET["blog_id"];

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

        mysqli_query($con, "INSERT INTO comments(blog_id, text, image) 
                                VALUES($blog_id, '$text', '$file_name')");

        header("Location: $BASE_URL/blog-details.php?id=$blog_id");
    }
    else{
        header("Location: $BASE_URL/blog-details.php?id=$blog_id&error=1");
    }
?>