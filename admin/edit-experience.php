<?php



require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";


if (!isset($_GET['id'])) {

    header("Location: experience.php");
    exit();

}

$id = (int) $_GET['id'];


// Fetch experience record
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM experience WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {

    mysqli_stmt_close($stmt);

    header("Location: experience.php");
    exit();

}

$experience = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


// Update experience
if (isset($_POST['update_experience'])) {

    $job_title = trim($_POST['job_title']);
    $company = trim($_POST['company']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $description = trim($_POST['description']);


    $stmt = mysqli_prepare(
        $conn,
        "UPDATE experience
         SET job_title = ?,
             company = ?,
             start_year = ?,
             end_year = ?,
             description = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $job_title,
        $company,
        $start_year,
        $end_year,
        $description,
        $id
    );


    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: experience.php");
        exit();

    } else {

        echo "Error: " . mysqli_stmt_error($stmt);

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Experience</title>

</head>

<body>

<div class="container-fluid p-4">

    <h2>Edit Experience Record</h2>

    <form action="" method="POST">

        <label>Job Title</label><br>

        <input type="text"
               name="job_title"
               value="<?php echo htmlspecialchars($experience['job_title']); ?>"
               required>

        <br><br>


        <label>Company</label><br>

        <input type="text"
               name="company"
               value="<?php echo htmlspecialchars($experience['company']); ?>"
               required>

        <br><br>


        <label>Start Year</label><br>

        <input type="number"
               name="start_year"
               value="<?php echo htmlspecialchars($experience['start_year']); ?>"
               required>

        <br><br>


        <label>End Year</label><br>

        <input type="number"
               name="end_year"
               value="<?php echo htmlspecialchars($experience['end_year']); ?>"
               required>

        <br><br>


        <label>Description</label><br>

        <input type="text"
               name="description"
               value="<?php echo htmlspecialchars($experience['description']); ?>"
               required>

        <br><br>


        <button type="submit"
                name="update_experience">

            Update Experience

        </button>

    </form>

</div>


<?php

include "../includes/footer.php";

?>

</body>
</html>