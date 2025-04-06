<?php
session_start();
include 'db.php';

// Fetch books
$books_stmt = $conn->prepare("SELECT * FROM books");
$books_stmt->execute();
$books_result = $books_stmt->get_result();
$books = $books_result->fetch_all(MYSQLI_ASSOC); // Fetch all rows into an array
$books_result->free(); // Free the result set
$books_stmt->close(); // Close the statement

// Fetch journals
$journals_stmt = $conn->prepare("SELECT * FROM journals");
$journals_stmt->execute();
$journals_result = $journals_stmt->get_result();
$journals = $journals_result->fetch_all(MYSQLI_ASSOC);
$journals_result->free();
$journals_stmt->close();

// Fetch e-books
$ebooks_stmt = $conn->prepare("SELECT * FROM e_books");
$ebooks_stmt->execute();
$ebooks_result = $ebooks_stmt->get_result();
$ebooks = $ebooks_result->fetch_all(MYSQLI_ASSOC);
$ebooks_result->free();
$ebooks_stmt->close();

// Fetch newspapers
$newspapers_stmt = $conn->prepare("SELECT * FROM newspapers");
$newspapers_stmt->execute();
$newspapers_result = $newspapers_stmt->get_result();
$newspapers = $newspapers_result->fetch_all(MYSQLI_ASSOC);
$newspapers_result->free();
$newspapers_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - University of Bidii Library</title>
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
            height: 60px;
            vertical-align: left;
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
            background: url("Image/Bidii_banner.png") no-repeat center center/cover;
            margin-bottom: 20px;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .section {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .item {
            text-align: center;
            padding: 10px;
        }

        .item img {
            width: 100px;
            height: auto;
            border-radius: 4px;
        }

        .item p {
            margin: 10px 0;
            font-size: 14px;
        }

        button {
            background: #003087;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            color: #003087;
            text-decoration: none;
        }

        a:hover {
            color: #0056b3;
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
            <img src="Image/Bidii logo.png" alt="University of Bidii Logo">
            <h1>University of Bidii Library</h1>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contact Info</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="index.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <form class="search-form" action="#services">
            <input type="text" placeholder="Search Library Catalog..." name="search">
            <button type="submit">Search</button>
        </form>
    </header>
    <div class="banner"></div>
    <div class="container">
        <h1>Library Services</h1>
        <p>The University of Bidii Library provides access to a comprehensive range of academic resources designed to support research, teaching, and learning.</p>
        <div class="section">
            <h2>Books</h2>
            <p>Our physical book collection is organized by faculty to cater to specific academic needs. Select your faculty below to view recommended titles:</p>
            <div class="grid">
                <?php foreach ($books as $book): ?>
                <div class="item">
                    <!-- Changed placeholder link to local file path -->
                    <img src="Image/<?php echo htmlspecialchars($book['title']); ?>.png" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <p><?php echo htmlspecialchars($book['title']); ?> by <?php echo htmlspecialchars($book['author']); ?></p>
                    <?php if (isset($_SESSION['user_id']) && $book['available_copies'] > 0): ?>
                        <form method="POST" action="borrow_book.php">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit">Borrow</button>
                        </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="section">
            <h2>Journals</h2>
            <p>Access leading academic journals to support your research endeavors. Below are some prominent titles available in our collection:</p>
            <div class="grid">
                <?php foreach ($journals as $journal): ?>
                <div class="item">
                    <!-- Changed placeholder link to local file path -->
                    <img src="Image/<?php echo htmlspecialchars($journal['title']); ?>.jpg" alt="<?php echo htmlspecialchars($journal['title']); ?>">
                    <p><?php echo htmlspecialchars($journal['title']); ?></p>
                    <a href="<?php echo $journal['pdf_link']; ?>" target="_blank">Read PDF</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="section">
            <h2>E-books</h2>
            <p>Our digital library offers an extensive collection of e-books available for instant access. Below are some featured titles:</p>
            <div class="grid">
                <?php foreach ($ebooks as $ebook): ?>
                <div class="item">
                    <!-- Changed placeholder link to local file path -->
                    <img src="Image/<?php echo htmlspecialchars($ebook['title']); ?>.png" alt="<?php echo htmlspecialchars($ebook['title']); ?>">
                    <p><?php echo htmlspecialchars($ebook['title']); ?> by <?php echo htmlspecialchars($ebook['author']); ?></p>
                    <a href="<?php echo $ebook['pdf_link']; ?>" target="_blank">Read PDF</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="section">
            <h2>Newspapers</h2>
            <p>Stay informed with our selection of newspapers, available for purchase at the library circulation desk for 20 KES each.</p>
            <div class="grid">
                <?php foreach ($newspapers as $newspaper): ?>
                <div class="item">
                    <!-- Changed placeholder link to local file path -->
                    <img src="Image/<?php echo htmlspecialchars($newspaper['title']); ?>.jpg" alt="<?php echo htmlspecialchars($newspaper['title']); ?>">
                    <p><?php echo htmlspecialchars($newspaper['title']); ?></p>
                    <a href="<?php echo $newspaper['pdf_link']; ?>" target="_blank">Read PDF</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <footer>
        <p><strong>Opening Hours:</strong> Mon-Fri 8:00 AM - 10:00 PM | Sat 10:00 AM - 6:00 PM | Sun 12:00 PM - 5:00 PM</p>
        <p><strong>Contact:</strong> <a href="mailto:library@bidii.ac.ke">library@bidii.ac.ke</a> | (254) 746883710</p>
        <p>© 2025 University of Bidii Library. All rights reserved.</p>
    </footer>
</body>
</html>