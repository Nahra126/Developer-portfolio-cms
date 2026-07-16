<?php
session_start();
require_once "../includes/db.php";

if(isset($_POST["login"])){


    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // echo "$email";
    // echo "<br>";
    // echo "$password";


    $sql = "SELECT * FROM users WHERE email  = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt,"s",$email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)==1){
     $user = mysqli_fetch_assoc($result);
     if(password_verify($password,$user['password'])){
        
        $_SESSION['user_id']=$user['id'];
        $_SESSION['username']=$user['username'];

        header("Location: dashboard.php");
        exit();

     }else{
        echo "invalid password";
     }
    
}else{
    echo "Email Not Found";
}

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>

    <h2>Admin Login</h2>

    <form action="" method="POST">

        <label for="">Email</label><br>
        <input type="email" name="email"><br><br>

        <label for="">Password</label><br>
        <input type="password" name="password"><br><br>
         
        <button type="submit" name="login">Login</button>

    </form>
</body>
</html>