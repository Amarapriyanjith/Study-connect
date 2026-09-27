<?php

session_start();

require_once 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login page.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if note ID was provided
if (!isset($_GET['id'])) {
    header("Location: account.php");
    exit();
}

$note_id = intval($_GET['id']);

// Get the note information
$stmt = $conn->prepare("
    SELECT file_name
    FROM notes
    WHERE id = ? AND uploaded_by = ?
");

$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();

$result = $stmt->get_result();

// Make sure the note belongs to this user
if ($result->num_rows !== 1) {
    $stmt->close();

    header("Location: account.php");
    exit();
}

$note = $result->fetch_assoc();

$stmt->close();

// Delete the note from database
$delete = $conn->prepare("
    DELETE FROM notes
    WHERE id = ? AND uploaded_by = ?
");

$delete->bind_param("ii", $note_id, $user_id);
$delete->execute();

$delete->close();

// Delete the uploaded PDF file from the server
$file_path = "upload/uploads/" . $note['file_name'];

if (file_exists($file_path)) {
    unlink($file_path);
}

// Go back to account page
header("Location: account.php");
exit();

?>