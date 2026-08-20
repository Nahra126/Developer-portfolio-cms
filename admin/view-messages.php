<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once "../includes/auth.php";
require_once "../includes/db.php";

include "../includes/header.php";
include "../includes/sidebar.php";


if (!isset($_GET['id'])) {

    header("Location: messages.php");
    exit();

}

$id = $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM messages WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$message = mysqli_fetch_assoc($result);

if (!$message) {

    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger'>Message not found.</div>";
    echo "</div>";

    include "../includes/footer.php";
    exit();

}

?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h4 class="mb-0">
                Message Details
            </h4>

        </div>

        <div class="card-body">

            <div class="mb-3">

                <strong>Name:</strong>

                <p class="mt-1">
                    <?php echo htmlspecialchars($message['name']); ?>
                </p>

            </div>


            <div class="mb-3">

                <strong>Email:</strong>

                <p class="mt-1">
                    <?php echo htmlspecialchars($message['email']); ?>
                </p>

            </div>


            <div class="mb-3">

                <strong>Subject:</strong>

                <p class="mt-1">
                    <?php echo htmlspecialchars($message['subject']); ?>
                </p>

            </div>


            <div class="mb-3">

                <strong>Message:</strong>

                <div class="border rounded p-3 mt-2 bg-light">

                    <?php echo nl2br(htmlspecialchars($message['message'])); ?>

                </div>

            </div>


            <div class="mb-3">

                <strong>Date:</strong>

                <p class="mt-1">
                    <?php echo htmlspecialchars($message['created_at']); ?>
                </p>

            </div>


            <a href="messages.php" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Back to Messages

            </a>

        </div>

    </div>

</div>


<?php

include "../includes/footer.php";

?>