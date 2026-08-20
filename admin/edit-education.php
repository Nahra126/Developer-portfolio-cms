<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";

if (!isset($_GET['id'])) {

    header("Location: education.php");
    exit();

}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM education WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {

    mysqli_stmt_close($stmt);

    header("Location: education.php");
    exit();

}

$education = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);




if (isset($_POST['update_education'])) {

    $degree = trim($_POST['degree']);
    $institute = trim($_POST['institute']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $descripton = trim($_POST['descripton']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE education
         SET degree = ?,
             institute = ?,
             start_year = ?,
             end_year = ?,
             descripton = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $degree,
        $institute,
        $start_year,
        $end_year,
        $descripton,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: education.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <div class="container-fluid p-4">

    <h2>Edit Education Record</h2>

    <form action="" method="POST">

        <label>Degree</label><br>
        <input type="text"
               name="degree"
               value="<?php echo htmlspecialchars($education['degree']); ?>"><br><br>

        <label>Institute</label><br>
        <input type="text"
               name="institute"
               value="<?php echo htmlspecialchars($education['institute']); ?>"><br><br>

          <label>Start_year</label><br>
        <input type="number"
               name="start_year"
               value="<?php echo htmlspecialchars($education['start_year']); ?>"><br><br>

          <label>End_year</label><br>
        <input type="number"
               name="end_year"
               value="<?php echo htmlspecialchars($education['end_year']); ?>"><br><br>

         <label>Description</label><br>
        <input type="text"
               name="descripton"
               value="<?php echo htmlspecialchars($education['descripton']); ?>"><br><br>

        <button type="submit" name="update_education">
            Update Education
        </button>

    </form>

</div>
<?php

include "../includes/footer.php";

?>
</body>
</html>