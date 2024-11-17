<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Donation</title>
    <link rel="stylesheet" href="<?=URL_ROOT?>/assets/css/style.css">
    <script src="https://kit.fontawesome.com/193fff84d2.js" crossorigin="anonymous"></script>
    <script src="<?=URL_ROOT?>/assets/js/script.js"></script>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="<?=URL_ROOT?>/assets/images/Logo.png" alt="Logo">
        </div>
        <div class="buttons">
        <a href="<?=URL_ROOT?>/moneydonation"><button>Donate Money</button></a>
        <a href="<?=URL_ROOT?>/itemdonation"><button>Donate Items</button></a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>
        <div class="user-actions">
        <a href="<?=URL_ROOT?>/login"><button>Login</button></a>
        <a href="<?=URL_ROOT?>/signup"><button>Register</button></a>
        <a href="<?=URL_ROOT?>/donordashboard"><i class="fa-solid fa-user" style="color: #000000;"></i></a>
        </div>
    </div>

    <div class="donation-form-container">
    <h2>Make a Donation</h2>
    <form action="/donation" method="post">
    <label for="hospital">Select Hospital</label> 
    <select id="hospital"> 
    <option value="hospital1">57357</option>
    <option value="hospital2">Al-Nas Burn Hospital</option> 
    <option value="hospital3">Magdi Yacoub</option> 
    </select>
        <label for="amount">Donation Amount:</label>
        <input type="number" id="amount" name="amount" min="1" required>
        
        <label for="frequency">Payment Method</label>
        <select id="frequency" onchange="togglePaymentOption()">
            <option value="credit-card">Credit Card</option>
            <option value="debit-card">Debit Card</option>
            <option value="cash">Cash</option>
            <option value="paypal">Paypal</option>
        </select>

        <label for="payment-method" id="payment-method-label" style="display:none;">Payment Option</label>
        <select id="payment-method" style="display:none;">
            <option value="pickup">Pick Up</option>
            <option value="dropoff">Drop Off</option>
        </select>


        <button type="submit">Donate</button>
    </form>
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

