<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link rel="stylesheet" href="<?=URL_ROOT?>/assets/css/style.css">

    
</head>
<body>
    <div class="form-container">
        <form action="<?=URL_ROOT?>/login" method="post">
        <h2>LOGIN</h2>
            <input type="text" name="email" placeholder=" Enter your email" required>
            <input type="password" name="password" placeholder=" Enter your password" required>
            <input type="hidden" name="login_type" value="email">
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="<?=URL_ROOT?>/signup">Register</a></p>
        </form>
        
    </div>
</body>
</html>

