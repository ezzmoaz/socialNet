<?php 
include("includes/header.php");



if(isset($_POST['post2'])){
	$post = new POST($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'], 'none');
	if(isset($_POST['is_public'])){
		$postId = $post->getPostId();
		$post->makePrivate($postId);
	}
	
	header("Location: index.php");
}

// session_destroy();
 ?>
	<div class="user_details column">
		<a href="<?php echo "profile.php?profile_email=" . $user['email']; ?> "><img src="<?php echo $user['profile_pic']; ?>"></a>

		<div class="user_details_left_right">
			
		

			<a href="<?php echo "profile.php?profile_email=" . $user['email']; ?> ">
			<?php 
			echo $user['first_name'] . " " . $user['last_name'] . "<br>";
			?>
			</a>

			<?php 
			echo "Posts: " . $user['num_posts'] . "<br>";
			echo "Likes: " . $user['num_likes'];
			?>
		</div>
	</div>

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="What's On Your Mind?"></textarea>
			<input type="submit" name="post2" id="post_button" value="Post">
			<br>
			<input type="checkbox" name="is_public" value="YES" >Is Private?<br>


		
			
		</form>

		 <div class="posts_area"></div>
		 <img id="loading" src="assets/images/icons/loading.gif">

	</div>

	<script >
		var userLoggedIn = '<?php echo $userLoggedIn; ?>';
		//jquery 

		$(document).ready(function(){
			$('#loading').show();
			// ORIGINAL AJAX REQUEST FOR LOADING FIRST POSTS

			$.ajax({
				url: "includes/handlers/ajax_load_posts.php",
				type: "POST",
				data: "page=1&userLoggedIn=" + userLoggedIn,
				cache:false,

				success: function(data) {

					$('#loading').hide();
					$('.posts_area').html(data);
				}
		});

			$(window).scroll(function(){

				var height = $('.posts_area').height(); //Div containing all the posts
				var scroll_top = $(this).scrollTop();
				var page = $('.posts_area').find('.nextPage').val();
				var noMorePosts = $('.posts_area').find('.noMorePosts').val();
				if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {// the buttom of the paged is reached
					$('#loading').show();
					// alert("hel")

					var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache:false,

					success: function(response) {
						// alert("hel2")
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .noMorePosts 
						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});

				}//End if
				return false;
			});//End $(window).scroll(function(){

		});
	</script>

	</div>
</body>
</html>