<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - University of Bidii Library</title>
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

        .event {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .event h3 {
            color: #003087;
            margin-bottom: 10px;
        }

        .event p {
            margin-bottom: 10px;
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
        <h1>Upcoming Events</h1>

        <!-- Event 1: Engineering Summit -->
        <div class="event">
            <h3>Bidii Engineering Summit 2025</h3>
            <p><strong>Date:</strong> May 15-16, 2025</p>
            <p><strong>Venue:</strong> University of Bidii Main Auditorium, Nairobi, Kenya</p>
            <p><strong>Theme:</strong> "Innovating for a Sustainable Future: Engineering Solutions for Africa"</p>
            <p><strong>Guests:</strong> Prof. Dr. A. B. M. Badruzzaman (Vice-Chancellor, Bangladesh University of Engineering and Technology), Dr. Mehiret Walga (Lecturer, Addis Ababa University Institute of Technology), and Eng. Hari Nath (Organizer, Analytics India Magazine)</p>
            <p><strong>Exhibiting Companies:</strong> Volvo India Pvt. Ltd., SAP Labs India Pvt. Ltd., and Messe Muenchen India Pvt. Ltd.</p>
            <p>Join us for a two-day summit focused on engineering innovation, featuring keynote speeches, workshops, and panel discussions on sustainable engineering practices. Network with industry leaders and explore the latest technologies in engineering.</p>
        </div>

        <!-- Event 2: AI and Technology Conference -->
        <div class="event">
            <h3>Global AI and Technology Conference 2025</h3>
            <p><strong>Date:</strong> November 19-21, 2025</p>
            <p><strong>Venue:</strong> University of Bidii Conference Center, Nairobi, Kenya</p>
            <p><strong>Theme:</strong> "International Conference on Artificial Intelligence and Emerging Technology 2.0"</p>
            <p><strong>Guests:</strong> Sr. AI Software Dev Engineer (Intel, USA), Professor and Founding Dean (Eastern International University, Vietnam), and a representative from the University of Bristol Business School, UK</p>
            <p><strong>Exhibiting Companies:</strong> Intel, IEEE Women in Engineering, and Bennett University</p>
            <p>This conference will bring together researchers and professionals to discuss advancements in AI, machine learning, cybersecurity, and more. Accepted papers will be submitted for inclusion into IEEE Xplore.</p>
        </div>

        <!-- Event 3: Library Resource Access Trial -->
        <div class="event">
            <h3>ICE Virtual Library Trial Access</h3>
            <p><strong>Date:</strong> Now until March 3, 2025</p>
            <p><strong>Venue:</strong> University of Bidii Library (Online Access)</p>
            <p><strong>Theme:</strong> "Exploring Civil Engineering Resources"</p>
            <p><strong>Guests:</strong> Open to all University of Bidii students and faculty</p>
            <p><strong>Exhibiting Companies:</strong> ICE Publishing</p>
            <p>The University of Bidii Library has secured free trial access to the ICE Virtual Library, a leading provider of information in civil and environmental engineering. Access 35 peer-reviewed journals and explore real-world engineering resources.</p>
        </div>
    </div>
    <footer>
        <p><strong>Opening Hours:</strong> Mon-Fri 8:00 AM - 10:00 PM | Sat 10:00 AM - 6:00 PM | Sun 12:00 PM - 5:00 PM</p>
        <p><strong>Contact:</strong> <a href="mailto:library@bidii.ac.ke">library@bidii.ac.ke</a> | (254) 746883710</p>
        <p>© 2025 University of Bidii Library. All rights reserved.</p>
    </footer>
</body>
</html>