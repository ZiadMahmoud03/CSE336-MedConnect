<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
            <input type="text" placeholder="Search">
        </div>
        <div class="user-actions">
        <a href="<?=URL_ROOT?>/login"><button>Login</button></a>
        <a href="<?=URL_ROOT?>/signup"><button>Register</button></a>
        <a href="<?=URL_ROOT?>/donordashboard"><i class="fa-solid fa-user" style="color: #000000;"></i></a>
        </div>
    </div>
    
    
    <h2>Most Donated</h2>
    <div class="slider-container">
        <div class="wrapper">
            <!-- Left button -->
            <i class="prev-btn fas fa-angle-left" onclick="slideLeft(event)"></i>

            <!-- Carousel container -->
            <ul class="carousel">
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/91kIVwRYUpL._AC_SL1500_.jpg" alt="img" draggable="false">
                    </div>
                    <h4>Wheelchair</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/drive-medical-independent-living-rtl10402-64_600.avif" alt="img" draggable="false">
                    </div>
                    <h4>Crutches</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/https___cloudfront-us-east-2.images.arcpublishing.com_reuters_SQ4LJZ4KYVM7VOH6YA6YDKMVOI.avif" alt="img" draggable="false">
                    </div>
                    <h4>Lumakras</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/LGMSH5CKNNO3TENSD3QSN6FNOQ.jpg" alt="img" draggable="false">
                    </div>
                    <h4>Enhertu</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/H409080bd3b154374beeff2edb0fdd83c8.jpg_300x300.avif" alt="img" draggable="false">
                    </div>
                    <h4>Hospital Bed</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/nebulizer.jpg" alt="img" draggable="false">
                    </div>
                    <h4>Nebulizer</h4>
                </li>
            </ul>

            <!-- Right button -->
            <i class="next-btn fas fa-angle-right" onclick="slideRight(event)"></i>
        </div>
    </div> 

    <h2>Hospitals</h2>
    <div class="slider-container">
        <div class="wrapper">
            <!-- Left button -->
            <i class="prev-btn fas fa-angle-left" onclick="slideLeft(event)"></i>

            <!-- Carousel container -->
            <ul class="carousel">
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/kisspng-57357-hospital-dar-al-fouad-cancer-child-5b3e67bbf03836.324450831530816443984.png" alt="img" draggable="false">
                    </div>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/24c01355787951.Y3JvcCwxMTk1LDkzNSwxMDMsMA.png" alt="img" draggable="false">
                    </div>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/a088b693705887.Y3JvcCwzMzY2LDI2MzMsMCww.png" alt="img" draggable="false">
                    </div>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/images.png" alt="img" draggable="false">
                    </div>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets/images/ormanb-logo.png" alt="img" draggable="false">
                    </div>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="<?=URL_ROOT?>/assets\images\logo (1).png" alt="img" draggable="false">
                    </div>
                </li>
            </ul>

            <!-- Right button -->
            <i class="next-btn fas fa-angle-right"onclick="slideRight(event)"></i>
        </div>
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