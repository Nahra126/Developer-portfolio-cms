<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

include "../includes/header.php";
include "../includes/sidebar.php";


if (!isset($_GET['id'])) {

    header("Location: skills.php");
    exit();

}

$id = (int) $_GET['id'];


// Fetch skill
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM skills WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {

    mysqli_stmt_close($stmt);

    header("Location: skills.php");
    exit();

}

$skill = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


// Update skill
if (isset($_POST['update_skill'])) {

    $skill_name = trim($_POST['skill_name']);
    $skill_percentage = trim($_POST['skill_percentage']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE skills
         SET skill_name = ?, skill_percentage = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $skill_name,
        $skill_percentage,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: skills.php");
        exit();

    } else {

        echo "Error: " . mysqli_stmt_error($stmt);

    }

}

?>

<div class="container-fluid p-4">

    <h2>Edit Skill</h2>

    <form action="" method="POST">

        <label>Skill Name</label><br>

        <input type="text"
               name="skill_name"
               value="<?php echo htmlspecialchars($skill['skill_name']); ?>"
               required>

        <br><br>

        <label>Skill Percentage</label><br>

        <input type="number"
               name="skill_percentage"
               value="<?php echo htmlspecialchars($skill['skill_percentage']); ?>"
               min="0"
               max="100"
               required>

        <br><br>

        <button type="submit" name="update_skill">
            Update Skill
        </button>

    </form>

</div>

<?php

include "../includes/footer.php";

?>