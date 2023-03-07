<!DOCTYPE html>
<html lang="en">
<head>
	<title>Редактировать комментарии</title>
	<?php include "views/head.php" ?>
</head>
<body>
<?php 
	include "config/db.php";
	include "config/baseurl.php";
	include 'views/header.php';
	$blog_details_query = mysqli_query($con, "SELECT * FROM blogs");
	$blog_details = mysqli_fetch_assoc($blog_details_query);

	$id = $_GET["id"];
	$comments_query = mysqli_query($con, "SELECT * FROM comments WHERE blog_id=$id");
?>

<section class="container page blog-detais-page">
	<div class="page-content">
		<div class="blogs">
			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL?>/images/blogs/<?=$blog_details["image"]?>" alt="">

                <div class="blog-info">
					<span class="link">
						<img src="images/date.svg" alt="">
						<?=$blog_details["created_at"]?>
					</span>
					
					<a class="link">
						<img src="images/message.svg" alt="">
						<?=mysqli_num_rows($comments_query)?>
					</a>
				</div>

				<div class="blog-header">
					<h3><?=$blog_details['title']?></h3>
				</div>
				<p class="blog-desc">
					<?=$blog_details["description"]?>
				</p>
			</div>
		</div>

        <div class="comments">
			<?php
				$comments_query = mysqli_query($con, "SELECT * FROM comments WHERE blog_id=$id");
			?>
            <h2>
                комментарии: <?=mysqli_num_rows($comments_query)?>
            </h2>
			
			<?php
				if(mysqli_num_rows($comments_query) == 0){
					echo '<p class="text-info" style="margin: 5px 10px;">Пока нет комментариев!</p>';
				}
				else{
					while($row = mysqli_fetch_assoc($comments_query)){
				?>
					<div class="comment">
					<?php
						if(strlen($row["image"]) > 0){
					?>
						<img class="comment-item--img" src="images/comments/<?=$row['image']?>" alt="">
					<?php
						}
					?>
						<p>
							<?=$row["text"]?>
						</p>
						<div class="comment-header">
						<span class="link">
							<img src="<?=$BASE_URL?>/images/dots.svg" alt="">
							Еще
							<ul class="dropdown">
								<li> <a href="<?=$BASE_URL?>/blog-details.php?id=<?=$row['blog_id']?>&comment_id=<?=$row['id']?>">Редактировать</a> </li>
								<li><a href="<?=$BASE_URL?>/api/comments/delete_comment.php?id=<?=$row['id']?>" class="danger">Удалить</a></li>
							</ul>
						</span>
						</div>
					</div>
				<?php
					}
				}
			?>
				<?php
				if(isset($_GET['id']) && isset($_GET['comment_id'])){
					$comment_id = $_GET["comment_id"];
					$comment_details_query = mysqli_query($con, "SELECT * FROM comments WHERE id=$comment_id");
					$comment_details = mysqli_fetch_assoc($comment_details_query);
			?>
				<form class="comment-add" action="<?=$BASE_URL?>/api/comments/update_comment.php?id=<?=$comment_id?>" method="POST">
					<fieldset class="fieldset">
						<button class="button button-yellow input-file">
							<input type="file" name="image">	
							Выберите картинку
						</button>
					</fieldset>
					<textarea name="text" class="comment-textarea" placeholder="Введит текст комментария"><?=$comment_details['text']?></textarea>
					<?php
						if(isset($_GET["error"]) && $_GET["error"] == 1){
							echo '<p class="text-danger">Заполните поле</p>';
						}
			?>
					<button class="button" style="margin-top: 10px;" type="submit">Отправить</button>
				</form>
			<?php
				} else{
			?>
				<form class="comment-add" action="<?=$BASE_URL?>/api/comments/add_comment.php?blog_id=<?=$blog_details['id']?>" method="POST">
					<fieldset class="fieldset">
						<button class="button button-yellow input-file">
							<input type="file" name="image">	
							Выберите картинку
						</button>
					</fieldset>
					<textarea name="text" class="comment-textarea" placeholder="Введит текст комментария"></textarea>
					<?php
						if(isset($_GET["error"]) && $_GET["error"] == 1){
							echo '<p class="text-danger">Заполните поле</p>';
						}
					?>
					<button class="button" style="margin-top: 10px;" type="submit">Отправить</button>
				</form>
			<?php
				}
			?>
        </div>
	</div>
	
</section>	
</body>
</html>