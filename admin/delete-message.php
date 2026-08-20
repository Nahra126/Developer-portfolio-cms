<?php

session_start();

require_once "../includes/auth.php";
require_once "../includes/db.php";

if (!isset($_GET['id'])) {

    header("Location: messages.php");
    exit();

}

$id = $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM messages WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header("Location: messages.php");
exit();

?>