<?php
    include "../../config/baseurl.php";
    include "../../config/db.php";

    $blog_id = $_GET["id"];
    
    if(isset($_POST["title"], $_POST["description"]) &&
    strlen($_POST["title"]) > 0 && strlen($_POST["description"]) > 0){

        $title = $_POST["title"];
        $description = $_POST["description"];
        $file_name = "";

        if(isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0){
            $file_name = time() . ".";  
            $explode = explode(".", $_FILES["image"]["name"]);
            $end_file = end($explode); 

            $file_name = $file_name . $end_file;   

            move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/blogs/$file_name");
        }

        if(strlen($file_name) > 0){
            mysqli_query($con, "UPDATE blogs
                                SET title='$title', description='$description', image='$file_name'
                                WHERE id=$blog_id");
        }
        else{
            mysqli_query($con, "UPDATE blogs
            SET title='$title', description='$description'
            WHERE id=$blog_id");
        }

        header("Location: $BASE_URL/index.php?blog_title=$title");
    }
    else{
        header("Location: $BASE_URL/index.php?error=1");
    }
?>