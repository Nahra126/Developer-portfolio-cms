<?php


require_once "../includes/auth.php";
require_once "../includes/db.php";

include "../includes/header.php";
include "../includes/sidebar.php";


if (isset($_POST['add_skill'])) {

    $skill_name = trim($_POST['skill_name']);
    $skill_percentage = trim($_POST['skill_percentage']);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO skills (skill_name, skill_percentage)
         VALUES (?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $skill_name,
        $skill_percentage
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: skills.php");
        exit();

    } else {

        echo "Error: " . mysqli_stmt_error($stmt);

    }
}


if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM skills WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
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

<div class="container mt-4">

<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Education Management</h4>
    </div>

    <div class="card-body">

    <h2>Skills Management</h2>

    <form action="" method="POST">

    <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Skill Name</label>
        <input type="text"
               name="skill_name"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Skill Percentage</label>
        <input type="text"
               name="skill_percentage"
               class="form-control">
    </div>

</div>
           <button class="btn btn-success" name="add_skill">

           <i class="bi bi-plus-circle"></i>
            Add Skill

           </button>

</form>

 </div>
</div>

<?php

$sql = "SELECT * FROM skills";
$result = mysqli_query($conn, $sql);

?>
<div class="card shadow mt-4">

    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Skills Records</h4>
    </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" border="1" cellpadding="10">

                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Skill Name</th>
                            <th>Percentage</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <?php while($row = mysqli_fetch_assoc($result)){ ?>

                        <tr>

                            <td><?php echo $row['id']; ?></td>

                            <td><?php  echo htmlspecialchars($row['skill_name']); ?></td>

                            <td><?php echo htmlspecialchars($row['skill_percentage']); ?>%</td>

                            <td>
                            <a href="edit-skill.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                                <a href="skills.php?delete=<?php echo $row['id']; ?>"
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