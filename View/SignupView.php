<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registeration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="form-container">
        <form action="/register" method="post" id="registrationForm">
        <h2>REGISTER</h2>
        <div class="social-container">
                    <a href="#" class="social facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social google"><i class="fab fa-google"></i></a>
            </div>
                <span>Or use your email for registration</span>
            <input type="text" name="name" placeholder=" Enter your name" required>
            <input type="text" name="email" placeholder=" Enter your email" required>
            <input type="text" name="phone" placeholder=" Enter your phone number" required>
            <input type="text" name="adress" placeholder=" Enter your address" required>
            <input type="text" name="nationalid" placeholder=" Enter your national ID" required>
            <input type="password" name="password" placeholder=" Enter your password" required>
            <input type="password" name="conpassword" placeholder=" Confirm your password" required>
            <button type="submit">Register</button>
            <p>Already have an account?<a href="LoginView.php"> Login</a></p>
        </form>
      
        
    </div>
</body>
</html>

