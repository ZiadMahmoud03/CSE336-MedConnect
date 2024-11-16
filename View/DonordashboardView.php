<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Profile</title>
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

    <div class="profile-container">
        <div class="profile-content">
            <div class="profile-picture">
                <img src="profile-pic.jpg" alt="Profile Picture">
            </div>
            <div class="user-details">
                <h2>John Doe</h2>
                <p>Email: john.doe@example.com</p>
                <p>Member since: January 2020</p>
            </div>
        </div>
        <div class="history-status">
            <div class="donation-status">
                <h3>Donation Status</h3>
                <p>Most recent donation of $50 to Hospital 2 is: <strong>Processing</strong></p>
            </div>

           
            <div class="donation-history">
    <h3>Donation History</h3>
    <div class="filters">
        <div class="hospital-filter">
            <label for="hospital-select">Filter by Hospital:</label>
            <select id="hospital-select">
                <option value="">All Hospitals</option>
                <option value="hospital1">Hospital 1</option>
                <option value="hospital2">Hospital 2</option>
                <option value="hospital3">Hospital 3</option>
            </select>
        </div>
        <div class="date-filter">
            <label for="filter-date">Filter by Date:</label>
            <input type="date" id="filter-date">
        </div>
        <button id="filter-button">Apply Filters</button>
    </div>
    <table id="donation-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Donation</th>
                <th>Hospital</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>March 19, 2021</td>
                <td>$25.00</td>
                <td>Hospital 2</td>
                <td><span class="complete">Complete</span></td>
                <td><a href="#" class="view-receipt">View Receipt</a></td>
            </tr>
            <tr>
                <td>March 19, 2021</td>
                <td>$25.00</td>
                <td>Hospital 2</td>
                <td><span class="complete">Complete</span></td>
                <td><a href="#" class="view-receipt">View Receipt</a></td>
            </tr>
            <tr>
                <td>March 19, 2021</td>
                <td>$25.00</td>
                <td>Hospital 2</td>
                <td><span class="complete">Complete</span></td>
                <td><a href="#" class="view-receipt">View Receipt</a></td>
            </tr>
            <tr>
                <td>March 19, 2021</td>
                <td>$25.00</td>
                <td>Hospital 2</td>
                <td><span class="complete">Complete</span></td>
                <td><a href="#" class="view-receipt">View Receipt</a></td>
            </tr>
   
        </tbody>
    </table>
    <p class="showing-info">Showing 1 - 4 of 4 Donations</p>

</div>

        </div>
    </div>
</body>
</html>