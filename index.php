<!DOCTYPE html>
<html lang="en">
<head>
	<title>Главная</title>
	<?php include "views/head.php" ?>
</head>
<body>

<?php
	include "config/db.php";
	include "config/baseurl.php";
	$blogs_query = mysqli_query($con, "SELECT * FROM blogs");
?>

<?php include 'views/header.php' ?>

<section class="container page">
	<div class="page-content">
			<h2 class="page-title">Блоги</h2>
	<div class="blogs">

<?php	
	$blogs_count = mysqli_num_rows($blogs_query);
	if($blogs_count == 0){
		echo '<h2 class="text-info"> пока нет постов!</h2>';
	}
	else{
		while($row = mysqli_fetch_assoc($blogs_query)){
			
?>
		<div class="blog-item">
			<?php
				if(strlen($row["image"]) > 0){
			?>
				<img class="blog-item--img" src="images/blogs/<?=$row['image']?>" alt="">
			<?php
				}
			?>

		<div class="blog-header">
			<h3><?=$row["title"]?></h3>
			<span class="link">
				<img src="<?=$BASE_URL?>/images/dots.svg" alt="">
				Еще
				<ul class="dropdown">
					<li> <a href="<?=$BASE_URL?>/editblog.php?id=<?=$row['id']?>">Редактировать</a> </li>
					<li><a href="<?=$BASE_URL?>/api/blogs/delete_blog.php?id=<?=$row['id']?>" class="danger">Удалить</a></li>
				</ul>
			</span>
		</div>
		<p class="blog-desc">
		<?= $row["description"]?>
		</p>

		<div class="blog-info">
			<span class="link">
				<img src="images/date.svg" alt="">
				<?=$row["created_at"]?>
			</span>
			<a class="link" href="<?=$BASE_URL?>/blog-details.php?id=<?=$row['id']?>">
				<img src="images/message.svg" alt="">
				<?php
					$comments_query = mysqli_query($con, "SELECT * FROM comments WHERE blog_id=".$row['id']);
					echo mysqli_num_rows($comments_query);
				?>
			</a>
		</div>
	</div>
<?php
		}
	}
?>
		</div>
</section>	

</body>
</html>