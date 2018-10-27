<?php session_start();ob_start();

include("includes/db.php");
include("includes/function.php");
if(isset($_POST['submit'])){
    echo $email = string_check($_POST['email']);
    echo $password = string_check($_POST['password']);
    
    $query = "select * from user where email = '$email'";
    $result = mysqli_query($conn,$query);
    
    query_check($result);
    
    $count = mysqli_num_rows($result);
    if($count > 0){
        while($row = mysqli_fetch_assoc($result)){
            $db_pass = $row['password']; 
        }
    
    if($db_pass == $password){
        echo "Successfully Logged in";
        header("Location: blog_view.php");
    }else{
        echo "incorrect pass";
    }
    }else{
        echo "email not available";
    }
    
    
    
}else{
    echo "get";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
   <form action="" method="posts">
   <input type="email" placeholder="Email" name="email">
   <br><input type="password" placeholder="Password" name="password" ><br>
   <button formmethod="post" name="submit">Submit</button>
    </form>
</body>
</html>