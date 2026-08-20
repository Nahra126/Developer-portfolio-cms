<?php


require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";


/* Check ID */

if (!isset($_GET['id'])) {

    header("Location: project.php");
    exit();

}

$id = (int) $_GET['id'];


/* Fetch Project */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM projects WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {

    mysqli_stmt_close($stmt);

    header("Location: project.php");
    exit();

}

$project = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* Update Project */

if (isset($_POST['update_project'])) {

    $project_name = trim($_POST['project_name']);
    $technologies = trim($_POST['technologies']);
    $description = trim($_POST['description']);
    $github_link = trim($_POST['github_link']);
    $live_demo = trim($_POST['live_demo']);


    /* Keep old image by default */

    $project_image = $project['project_image'];


    /* If new image uploaded */

    if (
        isset($_FILES['project_image']) &&
        $_FILES['project_image']['error'] === UPLOAD_ERR_OK
    ) {

        $allowed_extensions = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        $allowed_types = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];


        $original_name = $_FILES['project_image']['name'];
        $tmp_name = $_FILES['project_image']['tmp_name'];

        $extension = strtolower(
            pathinfo($original_name, PATHINFO_EXTENSION)
        );

        $file_type = mime_content_type($tmp_name);


        if (
            !in_array($extension, $allowed_extensions) ||
            !in_array($file_type, $allowed_types)
        ) {

            echo "Only JPG, JPEG, PNG and WEBP images are allowed.";

            exit();

        }


        /* Generate unique filename */

        $new_image = uniqid(
            'project_',
            true
        ) . '.' . $extension;


        $folder = "../uploads/projects/" . $new_image;


        if (move_uploaded_file($tmp_name, $folder)) {

            /*
             * Delete old image
             */

            if (!empty($project['project_image'])) {

                $old_image_path =
                    "../uploads/projects/" .
                    $project['project_image'];

                if (file_exists($old_image_path)) {

                    unlink($old_image_path);

                }

            }


            $project_image = $new_image;

        } else {

            echo "Image upload failed.";

            exit();

        }

    }


    /* Update database */

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE projects SET
        project_name = ?,
        technologies = ?,
        description = ?,
        github_link = ?,
        live_demo = ?,
        project_image = ?
        WHERE id = ?"
    );


    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $project_name,
        $technologies,
        $description,
        $github_link,
        $live_demo,
        $project_image,
        $id
    );


    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: project.php");
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

    <title>Edit Project</title>

</head>


<body>


<div class="container-fluid p-4">

    <h2>Edit Project Record</h2>


    <form
        action=""
        method="POST"
        enctype="multipart/form-data"
    >


        <label>Project Name</label><br>

        <input
            type="text"
            name="project_name"
            class="form-control"
            value="<?php echo htmlspecialchars($project['project_name']); ?>"
            required
        >

        <br>


        <label>Technologies</label><br>

        <input
            type="text"
            name="technologies"
            class="form-control"
            value="<?php echo htmlspecialchars($project['technologies']); ?>"
            required
        >

        <br>


        <label>Description</label><br>

        <textarea
            name="description"
            class="form-control"
            rows="5"
            required
        ><?php echo htmlspecialchars($project['description']); ?></textarea>

        <br>


        <label>GitHub</label><br>

        <input
            type="url"
            name="github_link"
            class="form-control"
            value="<?php echo htmlspecialchars($project['github_link']); ?>"
        >

        <br>


        <label>Live Demo</label><br>

        <input
            type="url"
            name="live_demo"
            class="form-control"
            value="<?php echo htmlspecialchars($project['live_demo']); ?>"
        >

        <br>


        <label>Current Project Image</label><br>

        <?php if (!empty($project['project_image'])) { ?>

            <img
                src="../uploads/projects/<?php echo htmlspecialchars($project['project_image']); ?>"
                width="150"
                class="img-thumbnail mb-3"
            >

        <?php } ?>

        <br>


        <label>Change Project Image</label><br>

        <input
            type="file"
            name="project_image"
            class="form-control"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <br>


        <button
            type="submit"
            name="update_project"
            class="btn btn-success"
        >

            <i class="bi bi-check-circle"></i>

            Update Project

        </button>


        <a
            href="project.php"
            class="btn btn-secondary"
        >

            Cancel

        </a>


    </form>

</div>


<?php

include "../includes/footer.php";

?>


</body>
</html>