<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, borrow_date, status) VALUES (?, ?, ?, 'borrowed')");
    $stmt->bind_param("iis", $user_id, $book_id, $borrow_date);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();

    header("Location: services.php");
    exit();
}
?>