<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Management System - Home</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        .navbar {
            width: 100%;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }
        .navbar button {
            padding: 10px 20px;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-actions .icon {
            font-size: 1.5em;
            cursor: pointer;
            color: #333;
        }
        .content {
            width: 80%;
            margin-top: 20px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            margin-bottom: 10px;
            color: #333;
        }
        .grid {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .item {
            width: 23%;
            height: 100px;
            border: 1px solid #007bff;
            border-radius: 10px;
            background-color: #f0f8ff;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <button>Donate</button>
        <input type="text" class="search-bar" placeholder="Search...">
        <div class="user-actions">
            <!-- Menu icon -->
            <span class="icon">&#9776;</span> <!-- Menu icon (three horizontal lines) -->
            <!-- User profile icon -->
            <span class="icon">&#128100;</span> <!-- Profile icon (person symbol) -->
        </div>
    </div>

    <!-- Content Sections -->
    <div class="content">
        <!-- Most Donated Section -->
        <div class="section">
            <h2>Most Donated</h2>
            <div class="grid">
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div class="item"></div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Most Requested Section -->
        <div class="section">
            <h2>Most Requested</h2>
            <div class="grid">
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div class="item"></div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Hospital Section -->
        <div class="section">
            <h2>Hospitals</h2>
            <div class="grid">
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div class="item"></div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>
</html>
