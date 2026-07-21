<?php

session_start();

require_once "../includes/auth.php";
require_once "../includes/db.php";

include "../includes/header.php";
include "../includes/sidebar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM skills WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$skill = mysqli_fetch_assoc($result);
if(isset($_POST['update_skill'])){

    $skill_name = trim($_POST['skill_name']);
    $skill_percentage = trim($_POST['skill_percentage']);

    $sql = "UPDATE skills SET

    skill_name = '$skill_name',
    skill_percentage = '$skill_percentage'

    WHERE id = '$id'";

    if(mysqli_query($conn, $sql)){
        echo "Skill Updated Successfully";
    }else{
        echo "Error: " . mysqli_error($conn);
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid p-4">

    <h2>Edit Skill</h2>

    <form action="" method="POST">

        <label>Skill Name</label><br>
        <input type="text"
               name="skill_name"
               value="<?php echo $skill['skill_name']; ?>"><br><br>

        <label>Skill Percentage</label><br>
        <input type="number"
               name="skill_percentage"
               value="<?php echo $skill['skill_percentage']; ?>"><br><br>

        <button type="submit" name="update_skill">
            Update Skill
        </button>

    </form>

</div>
<?php

include "../includes/footer.php";

?>

</body>
</html>