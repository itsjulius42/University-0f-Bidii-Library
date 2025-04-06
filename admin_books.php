<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $faculty = $_POST['faculty'];
    $image_link = $_POST['image_link'];
    $available_copies = $_POST['available_copies'];
    $stmt = $conn->prepare("INSERT INTO books (title, author, faculty, image_link, available_copies) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $author, $faculty, $image_link, $available_copies);
    $stmt->execute();
}

$stmt = $conn->prepare("SELECT * FROM books");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Books - University of Bidii Library</title>
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
        }

        .form-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        input {
            display: block;
            width: 90%;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background: #003087;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #0056b3;
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

        img {
            width: 50px;
            height: auto;
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
        <h1>Manage Books</h1>
        <div class="form-box">
            <form method="POST">
                <input type="text" name="title" placeholder="Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="faculty" placeholder="Faculty" required>
                <input type="text" name="image_link" placeholder="Image Link" required>
                <input type="number" name="available_copies" placeholder="Available Copies" required>
                <button type="submit">Add Book</button>
            </form>
        </div>
        <h2>Existing Books</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Faculty</th>
                <th>Image</th>
                <th>Available Copies</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
                <td><?php echo htmlspecialchars($row['faculty']); ?></td>
                <td><img src="<?php echo $row['image_link']; ?>" alt="Book"></td>
                <td><?php echo $row['available_copies']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <footer>
        <p><strong>Opening Hours:</strong> Mon-Fri 8:00 AM - 10:00 PM | Sat 10:00 AM - 6:00 PM | Sun 12:00 PM - 5:00 PM</p>
        <p><strong>Contact:</strong> <a href="mailto:library@bidii.ac.ke">library@bidii.ac.ke</a> | (254) 746883710</p>
        <p>© 2025 University of Bidii Library. All rights reserved.</p>
    </footer>
</body>
</html>