<?php 
include("includes/header.php");

if(isset($_GET['profile_email'])) {
	$email = $_GET['profile_email'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	$user_array = mysqli_fetch_array($user_details_query);
	$row = mysqli_num_rows($user_details_query);
	// echo $row ;
	if ($row == 0 ){
		header("Location: index.php");
	}

	$num_friends = (substr_count($user_array['friend_array'], ",")) - 1;
}
	




if(isset($_POST['remove_friend'])) {

	// echo "stringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstringstring";
	$user = new User($con, $userLoggedIn);
	$user->removeFriend($email);
}

if(isset($_POST['add_friend'])) {

	$user = new User($con, $userLoggedIn);
	$user->sendRequest($email);
	header("Location: profile.php?profile_email=" . $email);
}
if(isset($_POST['respond_request'])) {

	header("Location: requests.php");
	
}

 ?>

 	<style type="text/css">
	 	.wrapper {
	 		margin-left: 0px;
			padding-left: 0px;
	 	}

 	</style>
	
 	<div class="profile_left">
 		<img src="<?php echo $user_array['profile_pic']; ?>">

 		<div class="profile_info">
 			<p><?php echo "Posts: " . $user_array['num_posts']; ?></p>
 			<p><?php echo "Likes: " . $user_array['num_likes']; ?></p>
 			<p><a href="friendsList.php">
				<?php echo "Friends: " . $num_friends ?>
			</a></p>
 		</div>

 		<form action="<?php echo "profile.php?profile_email=" . $email; ?>" method="POST">
 			<?php 
 			// if the user is closed go to user_closed.php
 			$profile_user_obj = new User($con, $email); 
 			if($profile_user_obj->isClosed()) {
 				header("Location: user_closed.php");
 			}

 			$logged_in_user_obj = new User($con, $userLoggedIn); 

 			if($userLoggedIn != $email) {
 				// show the addFrind button if is not friend
 				// echo $email;
 				if($logged_in_user_obj->isFriend($email)) {
 					echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';
 				}
 				else if ($logged_in_user_obj->didReceiveRequest($email)) {
 					echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"><br>';
 				}
 				else if ($logged_in_user_obj->didSendRequest($email)) {
 					echo '<input type="submit" name="" class="default" value="Request Sent"><br>';
 				}
 				else 
 					echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>';
 			}

 			?>
 		</form>
 		<input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post Something">

    <?php  
    if($userLoggedIn != $email) {
      echo '<div class="profile_info_bottom">';
        echo $logged_in_user_obj->getMutualFriends($email) . " Mutual friends";
      echo '</div>';
    }


    ?>

 	</div>


	<div class="profile_main_column column">
		<div class="posts_area"></div>
    <img id="loading" src="assets/images/icons/loading.gif">


	</div>

<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModalLabel">Post something!</h4>
      </div>

      <div class="modal-body">
      	<p>This will appear on the user's profile page and also their newsfeed for your friends to see!</p>

      	<form class="profile_post" action="" method="POST">
      		<div class="form-group">
      			<textarea class="form-control" name="post_body"></textarea>
      			<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
      			<input type="hidden" name="user_to" value="<?php echo $email; ?>">
      		</div>
      	</form>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>


<script >
		var userLoggedIn = '<?php echo $userLoggedIn; ?>';
		var profileEmail = '<?php echo $email; ?>';
		//jquery 

		$(document).ready(function(){
			$('#loading').show();
			// ORIGINAL AJAX REQUEST FOR LOADING FIRST POSTS

			$.ajax({
				url: "includes/handlers/ajax_load_profile_posts.php",
				type: "POST",
				data: "page=1&userLoggedIn=" + userLoggedIn + "&profileEmail=" + profileEmail,
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
					url: "includes/handlers/ajax_load_profile_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileEmail=" + profileEmail,
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