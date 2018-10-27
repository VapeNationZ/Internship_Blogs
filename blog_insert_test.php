<?php

include("includes/db.php");
include("includes/function.php");

if(isset($_POST['blog_submit'])){
	$title = string_check($_POST['blogtitle']);
	$content = string_check($_POST['content']);
	$authorname = string_check($_POST['authorname']);

$sql="INSERT into blog (title,content,aurthor_name,date) values('$title','$content','$authorname',now())";
if (!mysqli_query($conn,$sql))
{
die('Error: ' . mysqli_error($conn));
}else{
	echo '<h1 class="bg-success">1 record added</h1>';
}
}
mysqli_close($conn);
	

?>

<html>

<head>
    <title>CC : Profile</title>
	
	<meta charset="utf-8">

<!--  mobile specific metas-->
<!-- ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="">
<!-- CSS
================================================== -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link href="styles/css/index.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link href="styles/css/normalize.css" rel="stylesheet" type="text/css">
	<style type="text/css">
    .noselect {
      -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
         -khtml-user-select: none; /* Konqueror HTML */
           -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently
                                      supported by Chrome and Opera */
    }
		
		input {
		  width: 100%;
		  border-color: 1px solid black !important;
		}

		.button {
		  width: 100%;
		}

		h2{
		  font-weight: 800;
		  padding-top : 5px;
		}
		h3 {
		  text-align: center;
		  padding-top: 5%;
		}

		#logout {
		  right: 0;
		}

		#blue-btn{
		  background: none repeat scroll 0 0 #0cbbfc;
		  border:1px solid #0cbbfc;
		  border-radius:5px;
		  color: white;
		  font-weight: 400;
		  padding: 0.8em 0.9em;
		  display: block;
		  margin:0.8em 0em;
		}
		#find_us{
		  padding-left:40px;
		}
		.other_links{
		  padding: 1px;
		}
		#others{
		  padding-left: 20%;
		}
		small{
		  color:white;
		}
		#blogs_area{
		  padding: 5%;
		}
		select{
		  width:100%;
		  padding:5px;
		}

		img{
		  justify-content: center;
		}
		#dp{
		  justify-content: center;
		  padding:10px;
		}          
		        
		.blog_content .more_text{
			display: none;
		}

		.read_more{
			color:blue;
		}
		.read_more:hover{
		  cursor: pointer;
		}

		#info{
		  padding:5px;
		}

		.likes_link{
		  margin:0;
		  padding-top:3px;
		  width: max-content;
		}

		.unlike{
			color: red;
		}		
	</style>								
<!-- CSS
================================================== -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		console.log(sessionStorage.getItem('status'));
		$(document).ready(function(){
			var maxLength = 300;
			$(".blog_content").each(function(){
				var myStr = $(this).text();
				if($.trim(myStr).length > maxLength){
					var newStr = myStr.substring(0, maxLength);
					var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
					$(this).empty().html(newStr);
					$(this).append('<span>... </span><span class="read_more">read more</span>');
					$(this).append('<span class="more_text">' + removedStr + '</span>');
				}
			});
			$(".read_more").click(function(){
				$(this).siblings(".more_text").contents().unwrap();
				$(this).prev().remove();
				$(this).remove();
			});
			
			// like and unlike click
		  $(".like, .unlike").click(function(){
		    if(sessionStorage.getItem('status')){ //check if user has logged in
		    
		      //diable the button
		      //$(this).attr('disabled',true);

		      var id = this.id;   // Getting Button id
		      var split_id = id.split("_");

		      var text = split_id[0];
		      var blogid = split_id[1];  // postid

		      // Finding click type
		      var type = 0;
		      if(text == "like"){
		          type = 1;									
		      }
		      else{
		          type = 0;
		      }
		      console.log(blogid+" "+type);
		      // AJAX Request
		      $.ajax({
		          url: 'blog_like.php',
		          type: 'post',
		          data: {b_id:blogid,action:type},
		          dataType: 'json',
		          success: function(data){
		            
		            console.log(data);

		            $("#likes_"+blogid).text(data["likes"]+" likes");
		                        
		            if(type == 1){
		                  $("#like_"+blogid).attr("class","unlike icon-heart icon-large");
		  								$("#like_"+blogid).attr("id","unlike_"+blogid);	
		            }
		            else{
		            	$("#unlike_"+blogid).attr("class","like icon-heart-empty icon-large");
		            	$("#unlike_"+blogid).attr("id","like_"+blogid);
		            }
		            //enable the button
		            //$(this).attr('disabled',false);
		          }                  	                  
		      });
		    }
		    else{
		      alert("You have to be logged in to save!");
		    }

		  });
				
			  // bookmark
		  $(".save, .remove").click(function(){
		  	if(sessionStorage.getItem('status')){
			    var id = this.id;   // Getting Button id
			    var split_id = id.split("_");

			    var text = split_id[0];
			    var blogid = split_id[1];  // postid

			    // Finding click type
			    var type = 0;
			    if(text == "save"){
			        type = 1;
			    }else{
			        type = 0;
			    }
			    console.log(blogid+" "+type);
			    $.ajax({
		        url: 'blog_save.php',
		        type: 'post',
		        data: {b_id:blogid,action:type},
		        dataType: 'json',
		        success: function(data){
		        	console.log(data);
		                        
	            if(type == 1){
	                  $("#save_"+blogid).attr("class","remove icon-bookmark icon-large");
	  								$("#save_"+blogid).attr("id","remove_"+blogid);	
	            }
	            else{
	            	$("#remove_"+blogid).attr("class","save icon-bookmark-empty icon-large");
	            	$("#remove_"+blogid).attr("id","save_"+blogid);
	            }
	            //enable the button
	            //$(this).attr('disabled',false);
		        }			                          	                  
			    });
			  }
			  else{
		    	alert("You have to be logged in to save blogs!");
		    }
		  });
			
		});
	</script>




	<title>Insert Blog</title>
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<style>
		body{
			margin-left: 50px;
			margin-right: 50px;
		}
	</style>
</head>

<body>
	<form  method="post">
		<div class="contianer">
			<div class="row">

				<table>
					<tr>
						<td>Post Title :</td>
						<td><input type="text" class="form-control" id="posttitle" name="blogtitle" /></td>
					</tr>
					<tr>
						<td>Content :</td>
						<td><textarea id="content" class="form-control" name="content"></textarea></td>
					</tr>
					<tr>
						<td>Author Name : </td>
						<td><input type="text" class="form-control" id="authorname" name="authorname" /></td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<input id="submit" class="form-control" name="blog_submit" type="submit" value="Save">
						</td>
					</tr>
				</table>

			</div>
		</div>
	</form>

<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12';
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>


				
						
				
					
					
						<div class="card-footer noselect">
							<i id="like_2" class="like icon-heart-empty icon-large"></i>&nbsp;							
							<i id="save_2" class="save icon-bookmark-empty icon-large"></i>&nbsp;
							<!--<i class="share icon-share-alt icon-large"></i>&nbsp;-->
							<!--Facebook share button-->
							<div class="fb-share-button" data-href="#" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="#" class="fb-xfbml-parse-ignore">Share</a></div>

							<div class="dropdown" style="display:inline;float:right">
								<button style="padding:0px" class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="icon-flag"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="#">Report</a>
								</div>
							</div>
						
				
						</div>
					






</body>

<script>
	tinymce.init({
		selector: 'textarea'
	});

</script>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>

</html>