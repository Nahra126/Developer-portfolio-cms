<?php
session_start();
require_once "../includes/db.php";



$error = "";
$error = "";

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
            
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit();

     }else{
        $error = "Invalid Password!";
     }
    
}else{
    $error = "Email Not Found!";
}

}


?>


<?php if(!empty($error)) { ?>


<div class="alert alert-danger">
<?php
echo $error ;   
?>
</div>

<?php } ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-dark text-white text-center">
                    <h3>Portfolio CMS Admin Login</h3>
                </div>

                <div class="card-body">

                    <form action="" method="POST">

                        <div class="mb-3">
                           <label class="form-label">Email</label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                               <label class="form-label">Password</label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        required>
                                </div>
                        </div>

                        <button
                            type="submit"
                            name="login" class="btn btn-success w-100 fw-bold"z
                             class="bi bi-box-arrow-in-right">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>