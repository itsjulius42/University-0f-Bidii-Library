<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$is_admin = $_SESSION['user_role'] == 'admin';

// Fetch borrowed books
if ($is_admin) {
    // Admins see all borrowed books
    $borrowed_stmt = $conn->prepare("SELECT u.name, b.title, bb.borrow_date, bb.return_date, bb.status 
                                    FROM borrowed_books bb 
                                    JOIN users u ON bb.user_id = u.id 
                                    JOIN books b ON bb.book_id = b.id 
                                    WHERE bb.status = 'borrowed'");
} else {
    // Regular users see only their borrowed books
    $borrowed_stmt = $conn->prepare("SELECT u.name, b.title, bb.borrow_date, bb.return_date, bb.status 
                                    FROM borrowed_books bb 
                                    JOIN users u ON bb.user_id = u.id 
                                    JOIN books b ON bb.book_id = b.id 
                                    WHERE bb.status = 'borrowed' AND bb.user_id = ?");
    $borrowed_stmt->bind_param("i", $user_id);
}
$borrowed_stmt->execute();
$borrowed_result = $borrowed_stmt->get_result();
$borrowed_books = $borrowed_result->fetch_all(MYSQLI_ASSOC);
$borrowed_result->free();
$borrowed_stmt->close();

// Fetch returned books
if ($is_admin) {
    $returned_stmt = $conn->prepare("SELECT u.name, b.title, bb.borrow_date, bb.return_date, bb.status 
                                    FROM borrowed_books bb 
                                    JOIN users u ON bb.user_id = u.id 
                                    JOIN books b ON bb.book_id = b.id 
                                    WHERE bb.status = 'returned'");
} else {
    $returned_stmt = $conn->prepare("SELECT u.name, b.title, bb.borrow_date, bb.return_date, bb.status 
                                    FROM borrowed_books bb 
                                    JOIN users u ON bb.user_id = u.id 
                                    JOIN books b ON bb.book_id = b.id 
                                    WHERE bb.status = 'returned' AND bb.user_id = ?");
    $returned_stmt->bind_param("i", $user_id);
}
$returned_stmt->execute();
$returned_result = $returned_stmt->get_result();
$returned_books = $returned_result->fetch_all(MYSQLI_ASSOC);
$returned_result->free();
$returned_stmt->close();

// Fetch lost books
if ($is_admin) {
    $lost_stmt = $conn->prepare("SELECT u.name, b.title, bb.borrow_date, bb.return_date, bb.status 
                                FROM borrowed_books bb 
                                JOIN users u ON bb.user_id = u.id 
                                JOIN books b ON bb.book_id = b.id 
                                WHERE bb.status = 'lost'");
} else {
    $lost_stmt = $conn->prepare("SELECT u.name, b.title, bb.borrow_date, bb.return_date, bb.status 
                                FROM borrowed_books bb 
                                JOIN users u ON bb.user_id = u.id 
                                JOIN books b ON bb.book_id = b.id 
                                WHERE bb.status = 'lost' AND bb.user_id = ?");
    $lost_stmt->bind_param("i", $user_id);
}
$lost_stmt->execute();
$lost_result = $lost_stmt->get_result();
$lost_books = $lost_result->fetch_all(MYSQLI_ASSOC);
$lost_result->free();
$lost_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - University of Bidii Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Include the shared CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: #003087;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        header .logo img {
            height: 50px;
            vertical-align: middle;
        }

        header h1 {
            display: inline;
            margin-left: 10px;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            padding: 10px 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: #0056b3;
        }

        .banner {
            width: 100%;
            height: 200px;
            background: url("Image\Bidii_banner.png") no-repeat center center/cover;
            margin-bottom: 20px;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            text-align: center;
        }

        h1 {
            color: #003087;
        }

        a {
            color: #003087;
        }

        a:hover {
            color: #0056b3;
        }

        .section {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #003087;
            color: #fff;
        }
        /* Footer */
        footer {
            background: linear-gradient(90deg, #5f818d, #8ba4bb);
            color: rgb(166, 34, 135);
            padding: 25px;
            text-align: center;
            margin-top: 40px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.2);
        }
        footer p {
            margin: 8px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="Image\Bidii logo.png" alt="University of Bidii Logo">
            <h1>University of Bidii Library</h1>
            <p>Welcome back! Manage your library activities below.</p>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contact Info</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="banner"></div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <?php if ($is_admin): ?>
            <p><a href="admin_users.php">View All Users</a> | <a href="admin_books.php">Manage Books</a> | <a href="admin_borrowed.php">View All Borrowed Books</a></p>
        <?php endif; ?>
        <p>This is your dashboard. Below is your borrowing history.</p>

        <!-- Borrowed Books Section -->
        <div class="section">
            <h2>Borrowed Books</h2>
            <?php if (count($borrowed_books) > 0): ?>
                <table>
                    <tr>
                        <th>User Name</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($borrowed_books as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['return_date'] ?: 'Not Returned'; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No books currently borrowed.</p>
            <?php endif; ?>
        </div>

        <!-- Returned Books Section -->
        <div class="section">
            <h2>Returned Books</h2>
            <?php if (count($returned_books) > 0): ?>
                <table>
                    <tr>
                        <th>User Name</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($returned_books as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['return_date'] ?: 'Not Returned'; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No books have been returned.</p>
            <?php endif; ?>
        </div>

        <!-- Lost Books Section -->
        <div class="section">
            <h2>Lost Books</h2>
            <?php if (count($lost_books) > 0): ?>
                <table>
                    <tr>
                        <th>User Name</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($lost_books as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['return_date'] ?: 'Not Returned'; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No books have been marked as lost.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <p><strong>Opening Hours:</strong> Mon-Fri 8:00 AM - 10:00 PM | Sat 10:00 AM - 6:00 PM | Sun 12:00 PM - 5:00 PM</p>
        <p><strong>Contact:</strong> <a href="mailto:library@bidii.ac.ke">library@bidii.ac.ke</a> | (254) 746883710</p>
        <p>© 2025 University of Bidii Library. All rights reserved.</p>
    </footer>
</body>
</html>