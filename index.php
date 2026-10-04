<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>David Worship Center</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="DWC.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar_container">
        <a href="javascript:void(0);" id="navbar_logo" onclick="showHome()">
            <i class="fa-solid fa-church"></i> DWC
        </a>
        <ul class="navbar_menu">
            <li class="navbar_item"><a href="javascript:void(0);" class="navbar_links" onclick="showSection('aboutSection')"><i class="fa-solid fa-info-circle"></i> About</a></li>
            <li class="navbar_item"><a href="javascript:void(0);" class="navbar_links" onclick="showSection('locationSection')"><i class="fa-solid fa-location-dot"></i> Location</a></li>
            <li class="navbar_item"><a href="javascript:void(0);" class="navbar_links" onclick="showSection('bibleSection')"><i class="fa-solid fa-book-bible"></i> Bible</a></li>
            <li class="navbar_item"><a href="javascript:void(0);" class="navbar_links" onclick="showSection('eventsSection')"><i class="fa-solid fa-calendar-days"></i> Events</a></li>
            <li class="navbar_item"><a href="javascript:void(0);" class="navbar_links" onclick="showSection('contactSection')"><i class="fa-solid fa-envelope"></i> Contact</a></li>
        </ul>
    </div>
</nav>

<!-- HOME SECTION -->
<div id="homeSection">
    <header class="hero">
        <h1>Welcome to David Worship Center (DWC)</h1>
        <p>Experience the presence of God and grow in faith.</p>
    </header>
    <main class="content">
        <p><em>Hey, want to know more about God? You are in the right place.</em><br><br>
        Learning is made easy here.<br>
        Experience is the best teacher.<br>
        So try it and experience it.</p>
        <a href="#" class="main_btn">Get Started</a>
    </main>
</div>

<!-- ABOUT SECTION -->
<section class="about" id="aboutSection" style="display:none;">
    <h2>About David Worship Center</h2>
    <p>Founded in 2019</p>
    <p><strong>Pastor:</strong> Edward Mukuha</p>
    <p><strong>Mission:</strong> To spread the Gospel to the whole world.</p>
    <button onclick="showHome()">Back Home</button>
</section>

<!-- LOCATION SECTION -->
<section class="about" id="locationSection" style="display:none;">
    <h2>Our Location</h2>
    <p>We are located at [PO Box: 1234568].</p>
    <button onclick="showHome()">Back Home</button>
</section>

<!-- BIBLE SECTION -->
<section class="about" id="bibleSection" style="display:none;">
    <h2>The Bible</h2>
    <div style="margin-bottom:10px;">
        <label for="bookSelect">Book:</label>
        <select id="bookSelect"></select>
        <label for="chapterSelect">Chapter:</label>
        <select id="chapterSelect"></select>
    </div>
    <div style="margin-bottom:10px;">
        <label for="searchVerse">Search Verse:</label>
        <input type="text" id="searchVerse" placeholder="e.g. John 3:16">
        <button id="searchBtn">Search</button>
    </div>
    <div id="bibleDisplay" style="text-align:left; max-width:600px; margin:20px auto; white-space: pre-wrap; background:#fff8dc; padding:10px; border-radius:6px; border:1px solid #4B0082;"></div>
    <button onclick="showHome()">Back Home</button>
</section>

<!-- EVENTS SECTION (view only) -->
<section class="about" id="eventsSection" style="display:none;">
    <h2>Upcoming Events</h2>
    <div id="eventsList" style="max-width:600px; margin:20px auto; text-align:left;">
        <?php
        $res = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
        if($res->num_rows==0) echo "<p>No upcoming events yet.</p>";
        else {
            while($row = $res->fetch_assoc()){
                echo "<div style='margin-bottom:15px;'>";
                echo "<p><strong>Date:</strong> ".$row['event_date']."</p>";
                echo "<p><strong>Event:</strong> ".$row['name']."</p>";
                echo "<p><strong>Location:</strong> ".$row['location']."</p>";
                if($row['description']) echo "<p><strong>Description:</strong> ".$row['description']."</p>";
                echo "<hr></div>";
            }
        }
        ?>
    </div>
    <button onclick="showHome()">Back Home</button>
</section>

<!-- CONTACT SECTION -->
<section class="about" id="contactSection" style="display:none;">
    <h2>Contact Us</h2>
    <form action="save_message.php" method="POST" style="max-width:600px; margin:20px auto; text-align:left;">
        <label for="contactName">Name:</label><br>
        <input type="text" id="contactName" name="contactName" required><br><br>
        <label for="contactEmail">Email:</label><br>
        <input type="email" id="contactEmail" name="contactEmail" required><br><br>
        <label for="contactMessage">Message:</label><br>
        <textarea id="contactMessage" name="contactMessage" rows="4" required></textarea><br><br>
        <button type="submit">Send Message</button>
    </form>
    <!-- Messages are NOT displayed publicly anymore -->
    <button onclick="showHome()">Back Home</button>
</section>

<script src="DWC.js"></script>
</body>
</html>