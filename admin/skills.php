<?php

session_start();

require_once "../includes/auth.php";
require_once "../includes/db.php";

include "../includes/header.php";
include "../includes/sidebar.php";


if(isset($_POST['add_skill'])){

    $skill_name = trim($_POST['skill_name']);
    $skill_percentage = trim($_POST['skill_percentage']);

    $sql = "INSERT INTO skills (skill_name, skill_percentage)
            VALUES ('$skill_name', '$skill_percentage')";

    if(mysqli_query($conn, $sql)){
        header("Location: skills.php");
exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }
    

}
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $sql = "DELETE FROM skills WHERE id = '$id'";

    if(mysqli_query($conn, $sql)){
        header("Location: skills.php");
exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }

}


?>

<div class="container-fluid p-4">

    <h2>Skills Management</h2>

    <form action="" method="POST">

    <label>Skill Name</label><br>
    <input type="text" class="form-control" name="skill_name"><br><br>

    <label>Skill Percentage</label><br>
    <input type="number"  class="form-control" name="skill_percentage" min="0" max="100" required><br><br>

            <button type="submit" class="btn btn-success" name="add_skill">
            Add Skills
        </button>

</form>

<?php

$sql = "SELECT * FROM skills";
$result = mysqli_query($conn, $sql);

?>

<table class="table table-bordered table-hover" border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Skill Name</th>
        <th>Percentage</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

    <tr>

        <td><?php echo $row['id']; ?></td>

        <td><?php echo $row['skill_name']; ?></td>

        <td><?php echo $row['skill_percentage']; ?>%</td>

        <td>
            <a href="edit-skill.php?id=<?php echo $row['id']; ?>">Edit</a> |
           <a href="skills.php?delete=<?php echo $row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this skill?')">
    Delete
</a>
        </td>

    </tr>

    <?php } ?>

</table>

<hr>

</div>

<?php

include "../includes/footer.php";

?>