<?php
session_start();
include 'db.php';

// Initialize variables for form submission
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_query'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact = filter_var($_POST['contact'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } elseif (empty($contact) || empty($message)) {
        $error_message = "All fields are required.";
    } else {
        // Insert the query into the database
        $stmt = $conn->prepare("INSERT INTO queries (email, contact, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $contact, $message);
        
        if ($stmt->execute()) {
            $success_message = "Your query has been submitted successfully! We will get back to you soon.";
        } else {
            $error_message = "There was an error submitting your query. Please try again later.";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Info - University of Bidii Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
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

        .map {
            margin-top: 20px;
            text-align: center;
        }

        .map iframe {
            width: 100%;
            max-width: 600px;
            height: 400px;
            border: 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .query-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
            text-align: left;
        }

        .query-form h2 {
            color: #003087;
            margin-bottom: 15px;
            text-align: center;
        }

        .query-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .query-form input,
        .query-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .query-form textarea {
            height: 100px;
            resize: vertical;
        }

        .query-form button {
            background: #003087;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 0 auto;
        }

        .query-form button:hover {
            background: #0056b3;
        }

        .success-message {
            color: green;
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        .staff-section {
            margin: 20px 0;
        }

        .staff-section h2 {
            color: #003087;
            margin-bottom: 20px;
        }

        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .staff-member {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .staff-member h3 {
            color: #003087;
            margin-bottom: 5px;
        }

        .staff-member p {
            margin: 5px 0;
            font-size: 14px;
        }

        .staff-member a {
            color: #003087;
            text-decoration: none;
        }

        .staff-member a:hover {
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
            <img src="Image\Bidii logo.png" alt="University of Bidii Logo">
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
    </header>
    <div class="banner"></div>
    <div class="container">
        <h1>Contact Info</h1>
        <p>Email: library@bidii.ac.ke</p>
        <p>Phone: +254-746883710</p>
        <p>Address: 123 Bidii Road, Nairobi, Kenya</p>

        <!-- Query Form -->
        <div class="query-form">
            <h2>Submit a Query</h2>
            <?php if ($success_message): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="contact">Contact Number:</label>
                <input type="text" id="contact" name="contact" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit" name="submit_query">Submit Query</button>
            </form>
        </div>

        <!-- Library Department Members -->
        <div class="staff-section">
            <h2>Meet Our Library Team</h2>
            <div class="staff-grid">
                <!-- Member 1 -->
                <div class="staff-member">
                    <h3>Dr. Amina Kiptoo</h3>
                    <p><strong>Title:</strong> Head Librarian</p>
                    <p><strong>Email:</strong> <a href="mailto:amina.kiptoo@bidii.ac.ke">amina.kiptoo@bidii.ac.ke</a></p>
                    <p><strong>Phone:</strong> +254-700-123-456</p>
                </div>
                <!-- Member 2 -->
                <div class="staff-member">
                    <h3>Mr. James Mwangi</h3>
                    <p><strong>Title:</strong> Reference Librarian</p>
                    <p><strong>Email:</strong> <a href="mailto:james.mwangi@bidii.ac.ke">james.mwangi@bidii.ac.ke</a></p>
                    <p><strong>Phone:</strong> +254-700-123-457</p>
                </div>
                <!-- Member 3 -->
                <div class="staff-member">
                    <h3>Ms. Esther Wanjiku</h3>
                    <p><strong>Title:</strong> Circulation Manager</p>
                    <p><strong>Email:</strong> <a href="mailto:esther.wanjiku@bidii.ac.ke">esther.wanjiku@bidii.ac.ke</a></p>
                    <p><strong>Phone:</strong> +254-700-123-458</p>
                </div>
                <!-- Member 4 -->
                <div class="staff-member">
                    <h3>Mr. David Otieno</h3>
                    <p><strong>Title:</strong> Digital Resources Librarian</p>
                    <p><strong>Email:</strong> <a href="mailto:david.otieno@bidii.ac.ke">david.otieno@bidii.ac.ke</a></p>
                    <p><strong>Phone:</strong> +254-700-123-459</p>
                </div>
                <!-- Member 5 -->
                <div class="staff-member">
                    <h3>Ms. Fatuma Ali</h3>
                    <p><strong>Title:</strong> Archivist</p>
                    <p><strong>Email:</strong> <a href="mailto:fatuma.ali@bidii.ac.ke">fatuma.ali@bidii.ac.ke</a></p>
                    <p><strong>Phone:</strong> +254-700-123-460</p>
                </div>
            </div>
        </div>

        <div class="map">
            <h2>Find Us on the Map</h2>
            <p>The University of Bidii Library is located in the central part of the campus, near the Main Auditorium and the Engineering Faculty.</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.815496674701!2d36.82014661475372!3d-1.2832539990513035!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMTYnNTkuNyJTIDM2wrA0OScxMi41IkU!5e0!3m2!1sen!2sus!4v1696118400000!5m2!1sen!2sus" allowfullscreen="" loading="lazy"></iframe>
        </div>
        </section>

<!-- About Section -->
<section id="about">
    <h1>About Us</h1>
    <p>The University of Bidii Library is dedicated to fostering academic excellence through a vast collection of resources and expert support, inspired by leading academic institutions like the University of Nairobi Library.</p>
</section>
    </div>
    <footer>
        <p><strong>Opening Hours:</strong> Mon-Fri 8:00 AM - 10:00 PM | Sat 10:00 AM - 6:00 PM | Sun 12:00 PM - 5:00 PM</p>
        <p><strong>Contact:</strong> <a href="mailto:library@bidii.ac.ke">library@bidii.ac.ke</a> | (254) 746883710</p>
        <p>© 2025 University of Bidii Library. All rights reserved.</p>
    </footer>
</body>
</html>