<?php
$con=mysqli_connect(“localhost”,”root”,””,”test”);
if (mysqli_connect_errno())
{
echo “Failed to connect to MySQL: ” . mysqli_connect_error();
}
$sql=”INSERT into blog_posts (post_title,content,author_name,post_date) values(‘”.$_POST[‘blogtitle’].”‘,'”.$_POST[‘content’].”‘,'”.$_POST[‘authorname’].”‘,now())”;
if (!mysqli_query($con,$sql))
{
die(‘Error: ‘ . mysqli_error($con));
}
echo “1 record added”;
mysqli_close($con);
?>