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
<body class="home">
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
    
    <h2>Most Recent</h2>
    <div class="slider-container">
        <div class="wrapper">
            <!-- Left button -->
            <i class="prev-btn fas fa-angle-left" onclick="slideLeft()"></i>

            <!-- Carousel container -->
            <ul class="carousel">
                <li class="card">
                    <div class="img">
                        <img src="Images\kisspng-57357-hospital-dar-al-fouad-cancer-child-5b3e67bbbbbc02.222815191530816443769.jpg" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
            </ul>

            <!-- Right button -->
            <i class="next-btn fas fa-angle-right" onclick="slideRight()"></i>
        </div>
    </div>
    
    <h2>Most Donated</h2>
    <div class="slider-container">
        <div class="wrapper">
            <!-- Left button -->
            <i class="prev-btn fas fa-angle-left" onclick="slideLeft()"></i>

            <!-- Carousel container -->
            <ul class="carousel">
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
            </ul>

            <!-- Right button -->
            <i class="next-btn fas fa-angle-right" onclick="slideRight()"></i>
        </div>
    </div> 

    <h2>Hospitals</h2>
    <div class="slider-container">
        <div class="wrapper">
            <!-- Left button -->
            <i class="prev-btn fas fa-angle-left" onclick="slideLeft()"></i>

            <!-- Carousel container -->
            <ul class="carousel">
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
                <li class="card">
                    <div class="img">
                        <img src="" alt="img" draggable="false">
                    </div>
                    <h4>hi</h4>
                </li>
            </ul>

            <!-- Right button -->
            <i class="next-btn fas fa-angle-right" onclick="slideRight()"></i>
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