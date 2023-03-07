<?php
	include "../../config/baseurl.php" ;
	include "../../config/db.php";

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

        mysqli_query($con, "INSERT INTO blogs (title, description, image)
                                VALUES('$title', '$description', '$file_name')");

        header("Location: $BASE_URL/index.php?post=$title");
    }
    else{
        header("Location: $BASE_URL/newblog.php?error=1");
    }
?>