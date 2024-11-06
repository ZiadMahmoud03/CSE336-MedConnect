<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link rel="stylesheet" href="style.css">

    
</head>
<body>
    <div class="form-container">
        <form action="index.php?action=login" method="post">
        <h2>LOGIN</h2>
            <input type="text" name="email" placeholder=" Enter your email" required>
            <input type="password" name="password" placeholder=" Enter your password" required>
            <button type="submit">Login</button>
            <p>Don't have an account?</p>
            <p><a href="RegisterDonor.php"> Register as Donor</a> or <a href="RegisterHospitalAdmin.php"> Register as Hospital Admin</a></p>
        </form>
        
    </div>
</body>
</html>

