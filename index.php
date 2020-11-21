<?php 
	
	include("include/header.php");
	


	if(isset($_POST['post'])){


		$uploadOk=1;
		$imageName=$_FILES['fileToUpload']['name'];
		$errorMessage="";

		if($imageName!=""){
			$targetDir="assets/images/posts/";
			$imageName=$targetDir.uniqid().basename($imageName);

			$imageFileType=pathinfo($imageName,PATHINFO_EXTENSION);
			if($_FILES['fileToUpload']['size']>5000000){
				$errorMessage="Sorry your file is too large to upload";
				$uploadOk=0;
			}

			if(strtolower($imageFileType)!="jpeg" && strtolower($imageFileType)!="png" && strtolower($imageFileType)!="jpg"){

					$errorMessage="Sorry only jpeg and png files are allowed";
				$uploadOk=0;

			}

			if($uploadOk){
				if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)){



				}else{
					$uploadOk=0;
				}
			}
		}

		if($uploadOk){
			$post=new Post($con,$userLoggedIn);
			$post->submitPost($_POST['post_text'],'none',$imageName);
		}else{

			echo "<div style='text-align:center;' class='alert alert-danger'>

				$errorMessage

			</div>";
		}


		
	}

	
		
 ?>
		<div class="user_details column">
		<a href="<?php echo $userLoggedIn;?>"><img src="<?php echo $user['profile_pic']; ?>"></a>
		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php
				echo $user['first_name']." ".$user['last_name'];
			?>
			</a>
			<?php echo "Posts: ".$user['num_post']."<br>";
			echo "Likes: ".$user['num_likes'];

			?>

		</div>

		</div>
	
		<div class="main_column column">

			<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">

				<input type="file" name="fileToUpload" id="fileToUpload">

				<textarea name="post_text" id="post_text" placeholder="Got something to say?" style="resize: none"></textarea>

				<input type="submit" name="post" id="post_button" value="Post">
				<hr>
			</form>

			
			<div class="posts_area"></div>
			<img id="loading" src="assets/icons/loading.gif">
		</div>



		<div class="user_details column">

			<h4>Trending</h4>
			<hr style="margin-top: -5px;margin-bottom: 10px;">

			<div class="trends">
				<?php
					$query=mysqli_query($con,"Select * from trends order by hits desc limit 9");
					foreach($query as $row){
						$word=$row['title'];
						$word_dot=strlen($word)>=14?"...":"";
						$trimmed_word=str_split($word,14);

						$trimmed_word= $trimmed_word[0];

						echo "<div style='padding:1px'>";
						echo $trimmed_word.$word_dot;
						echo "<br></div>";


					}
				?>
			</div>
		</div>

		<script src="assets/js/lightbox.js"></script>
		<script>
		    lightbox.option({
		      'resizeDuration': 500,
		      'wrapAround': true
		    })
		</script>

		<script>
	   $(function(){

	   		
	 
	       var userLoggedIn = '<?php echo $userLoggedIn; ?>';
	       var inProgress = false;
	 
	       loadPosts(); //Load first posts
	 
	       $(window).scroll(function() {
	           var bottomElement = $(".status_post").last();
	           var noMorePosts = $('.posts_area').find('.noMorePosts').val();
	 
	           // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
	           if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
	               loadPosts();
	           }
	       });
	 
	       function loadPosts() {
	           if(inProgress) { //If it is already in the process of loading some posts, just return
	               return;
	           }
	          
	           inProgress = true;
	           $('#loading').show();
	 
	           var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
	 
	           $.ajax({
	               url: "include/handlers/ajax_load_posts.php",
	               type: "POST",
	               data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
	               cache:false,
	 
	               success: function(response) {
	                   $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
	                   $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage
	                   $('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage
	 
	                   $('#loading').hide();
	                   $(".posts_area").append(response);
	 
	                   inProgress = false;
	               }
	           });
	       }
	 
	       //Check if the element is in view
	       function isElementInView (el) {
	             if(el == null) {
	                return;
	            }
	 
	           var rect = el.getBoundingClientRect();
	 
	           return (
	               rect.top >= 0 &&
	               rect.left >= 0 &&
	               rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
	               rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
	           );
	       }
	   });
 
   </script>

	</div>
</body>
</html>