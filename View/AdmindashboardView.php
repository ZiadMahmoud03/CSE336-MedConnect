<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/193fff84d2.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="navbar">
        <div class="logo">
            <img src="Images\Logo.png" alt="Logo">
        </div>
        <div class="buttons">
            <a href="MoneyDonationView.php"><button>Donate Money</button></a>
            <a href="ItemDonationView.php"><button>Donate Items</button></a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>
        <div class="user-actions">
            <a href="LoginView.php"><button>Login</button></a>
            <a href="SignupView.php"><button>Register</button></a>
            <a href="DonordashboardView.php"><i class="fa-solid fa-user" style="color: #000000;"></i></a>
        </div>
    </div>
    <div class="dashboard-container">

        <main class="main-content">
        <header class="admin-header">
            <img src="Images/admin-avatar.png" alt="" class="profile-img">
            <div class="admin-info">
                <h2 class="hospital-name">City Hospital</h2>
                <p class="admin-name">Admin:</p>
            </div>
        </header>
            <section id="overview">
                <h2>Activity Overview</h2>
                <div class="stats">
                    <div class="stat">
                        <h3>Total Items Uploaded</h3>
                        <p>120</p>
                    </div>
                    <div class="stat">
                        <h3>Pending Requests</h3>
                        <p>5</p>
                    </div>
                </div>
            </section>

            <section id="upload">
                <h2>Upload Needed Items</h2>
                <form action="NeedsController.php?action=uploadNeeds" method="POST" class="upload-form">
                    <label for="item_name">Item Name:</label>
                    <input type="text" id="item_name" name="item_name" required>
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                    
                    <label for="quantity_needed">Quantity Needed:</label>
                    <input type="number" id="quantity_needed" name="quantity_needed" required>
                    
                    <button type="submit">Upload</button>
                </form>
            </section>

        </main>
    </div>
    <footer class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h4>About Us</h4>
            <p></p>
        </div>

        <div class="footer-section links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Donate Now</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Volunteer</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>

        <div class="footer-section contact">
            <h4>Contact Us</h4>
            <ul>
                <li><strong>Email:</strong></li>
                <li><strong>Phone:</strong></li>
                <li><strong>Address:</strong> </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; 2024 MedConnect. All rights reserved.</p>
    </div>
</footer>
</body>
</html>

