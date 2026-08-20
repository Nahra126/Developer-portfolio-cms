<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";




if (isset($_POST['add_education'])) {

    $degree = trim($_POST['degree']);
    $institute = trim($_POST['institute']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $descripton = trim($_POST['descripton']);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO education
        (degree, institute, start_year, end_year, descripton)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $degree,
        $institute,
        $start_year,
        $end_year,
        $descripton
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: education.php");
        exit();

    } else {

        echo "Error: " . mysqli_stmt_error($stmt);

    }
    
}


if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM education WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

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
    <title>Education Management</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container mt-4">   

<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Education Management</h4>
    </div>

    <div class="card-body">

    <form action="" method="POST" >

    <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Degree</label>
        <input type="text"
               name="degree"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Institute</label>
        <input type="text"
               name="institute"
               class="form-control">
    </div>

</div>

    <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Start Year</label>
        <input type="number"
               name="start_year"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">End Year</label>
        <input type="number"
               name="end_year"
               class="form-control">
    </div>

</div>

    <label>Description</label><br>
    <textarea name="descripton" class="form-control" rows="5" cols="40"  required></textarea><br><br>

    <button class="btn btn-success" name="add_education">

           <i class="bi bi-plus-circle"></i>
            Add Education

    </button>

    </form>

      </div>
</div>
    <?php

$sql = "SELECT * FROM education";
$result = mysqli_query($conn, $sql);

?>
<div class="card shadow mt-4">

    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Education Records</h4>
    </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" border="1" cellpadding="10">
                    
                    <thead class="table-dark">
                    <tr>
                        <th>id</th>
                        <th>Degree</th>
                        <th>Institute</th>
                        <th>Start_year</th>
                        <th>End_year</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <?php while($row = mysqli_fetch_assoc($result)){ ?>

                    <tr>
                        <td><?php echo $row['id']; ?></td>

                        <td><?php echo htmlspecialchars($row['degree']); ?></td>

                        <td><?php echo htmlspecialchars($row['institute']); ?></td>

                        <td><?php echo htmlspecialchars($row['institute']); ?></td>

                        <td><?php echo htmlspecialchars($row['end_year']); ?></td>

                        <td><?php echo htmlspecialchars($row['descripton']); ?></td>
                        

                        <td>
                        
                        <a href="edit-education.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                            <a href="education.php?delete=<?php echo $row['id']; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this record?')">
                            <i class="bi bi-trash"></i> Delete
                            </a>
                
                        </td>

                    </tr>

                    <?php } ?>

                </table>
            </div>
        </div>

</div>

    

    <?php
    include "../includes/footer.php";
    ?>
</body>
</html>







