<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Donation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="donation-form-container">
    <h2>Make a Donation</h2>
    <form action="process_donation.php" method="post">
    <label for="hospital">Select Hospital</label> 
    <select id="hospital"> 
    <option value="hospital1">Hospital 1</option>
    <option value="hospital2">Hospital 2</option> 
    <option value="hospital3">Hospital 3</option> 
    <option value="hospital4">Hospital 4</option> 
    </select>
        <label for="amount">Donation Amount:</label>
        <input type="number" id="amount" name="amount" min="1" required>
        
        <label for="frequency">Frequency</label> 
        <select id="frequency"> 
        <option value="one-time">One Time</option> 
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option> 
        </select> 
        <label for="payment-method">Payment Option</label>
         <select id="payment-method">
         <option value="pickup">Pick Up</option> 
         <option value="dropoff">Drop Off</option> 
        </select>

        <button type="submit">Donate</button>
    </form>
</div>


</body>
</html>

