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


// Fetch messages
$sql = "SELECT * FROM messages ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Messages</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>

                            <td>
                                <?php echo $row['id']; ?>
                            </td>

                            <td>
                                <?php echo $row['name']; ?>
                            </td>

                            <td>
                                <?php echo $row['email']; ?>
                            </td>

                            <td>
                                <?php echo $row['subject']; ?>
                            </td>

                            <td>
                                <?php echo $row['created_at']; ?>
                            </td>

                            <td>

                                <a href="view-messages.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-primary btn-sm">

                                    <i class="bi bi-eye"></i>
                                    View

                                </a>
                                <a href="delete-message.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this message?');">

                                            <i class="bi bi-trash"></i>
                                            Delete

                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php

include "../includes/footer.php";

?>