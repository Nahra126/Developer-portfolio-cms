<?php

session_start();

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
</head>
<body>
    <h2>Profile_Management</h2>

    <img src="../uploads/profile/<?php echo $profile['profile_image']; ?>" width="150" alt="">

    
<form action="" method="POST"  enctype="multipart/form-data">
    <label>Full Name</label><br>
    <input type="text" name="full_name" value="<?php echo $profile['full_name'] ?>"><br><br>

    <label>Professional Title</label><br>
    <input type="text" name="title" value="<?php echo $profile['title'] ?>" ><br><br>

    <label>About</label><br>
    <textarea name="about" rows="5" cols="40"  ><?php echo $profile['about']; ?></textarea><br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="<?php echo $profile['email'] ?>" ><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" value="<?php echo $profile['phone'] ?>"  ><br><br>

    <label>Address</label><br>
    <input type="text" name="address" value="<?php echo $profile['address'] ?>" ><br><br>

    <label>GitHub</label><br>
    <input type="text" name="github" value="<?php echo $profile['github'] ?>" ><br><br>

    <label>LinkedIn</label><br>
    <input type="text" name="linkedin" value="<?php echo $profile['linkedin'] ?>"  ><br><br>

    <label>Profile Image</label><br>
    <input type="file" name="profile_image"><br><br>

    <label>Resume (PDF)</label><br>
    <input type="file" name="resume"><br><br>

    <button type="submit" name="save_profile" >Save Profile</button>


</form>


</body>
</html>