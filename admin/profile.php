<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once "../includes/auth.php";
require_once "../includes/db.php";

$sql = "SELECT * FROM profile WHERE id=1";

$result = mysqli_query($conn,$sql);

$profile = mysqli_fetch_assoc($result);

if(isset($_POST['save_profile'])){


    $full_name = trim($_POST['full_name']);
    $title = trim($_POST['title']);
    $about = trim($_POST['about']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $github = trim($_POST['github']);
    $linkedin = trim($_POST['linkedin']);



if(!empty($_FILES['profile_image']['name'])){
    $profile_image = $_FILES['profile_image']['name'];
    $temp_name = $_FILES['profile_image']['tmp_name'];
    $folder = "../uploads/profile/" .$profile_image;

    move_uploaded_file($temp_name, $folder);

}else{
    $profile_image = $profile['profile_image'];
}


if(!empty($_FILES['resume']['name'])){
    $resume = $_FILES['resume']['name'];
    $temp_resume = $_FILES['resume']['tmp_name'];
    $resume_folder = "../uploads/resume/" .$resume;

    move_uploaded_file($temp_resume, $resume_folder);

}else{
    $resume = $profile['resume'];
}

    

    $sql = "UPDATE profile set

    full_name = '$full_name',
    title = '$title',
    about = '$about',
    email = '$email',
    phone = '$phone',
    address = '$address',
    github = '$github',
    linkedin = '$linkedin',
    profile_image = '$profile_image',
    resume = '$resume'

    WHERE id = 1";

    if(mysqli_query($conn, $sql)){
         header("Location: profile.php");
    exit();
    }else{
        echo "Error:". mysqli_error($conn);
    }

}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile_Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
   
<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-dark text-white">
<h2 class="mb-0">Profile Management</h2>
</div>

<div class="card-body">

    <div class="text-center mb-4">

<img
src="../uploads/profile/<?php echo $profile['profile_image']; ?>"
class="rounded-circle border shadow"
width="180"
height="180"
style="object-fit:cover;">

</div>

    
    <form action="" method="POST"  enctype="multipart/form-data">
       <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Full Name</label>
        <input type="text"
               name="full_name"
               class="form-control"
               value="<?php echo $profile['full_name']; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Professional Title</label>
        <input type="text"
               name="title"
               class="form-control"
               value="<?php echo $profile['title']; ?>">
    </div>

</div>

        <label>About</label><br>
        <textarea name="about" class="form-control" rows="5" cols="40"  ><?php echo $profile['about']; ?></textarea><br><br>

        <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="<?php echo $profile['email']; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="<?php echo $profile['phone']; ?>">
    </div>

</div>

        <label>Address</label><br>
        <input type="text" name="address" class="form-control" value="<?php echo $profile['address'] ?>" ><br><br>

       <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">GitHub</label>
        <input type="url"
               name="github"
               class="form-control"
               value="<?php echo $profile['github']; ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">LinkedIn</label>
        <input type="url"
               name="linkedin"
               class="form-control"
               value="<?php echo $profile['linkedin']; ?>">
    </div>

</div>

       <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Profile Image</label>
        <input type="file"
               name="profile_image"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Resume (PDF)</label>
        <input type="file"
               name="resume"
               class="form-control">
    </div>

</div>

        <button
                type="submit"
                name="save_profile"
                class="btn btn-success w-100 fw-bold">

                <i class="bi bi-check-circle-fill"></i>
                Save Profile

        </button>


    </form>

    </div>

</div>

</div>


</body>
</html>