<?php
require "config/db-conn-setup.php";
require "Model/PaymentModels/Payment.php";

// Establish a database connection
$conn = new mysqli($configs->DB_HOST, $configs->DB_USER, $configs->DB_PASS, $configs->DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear the Payment table to avoid duplicates during testing
// $conn->query("DELETE FROM $configs->DB_PAYMENT_TABLE");

// Insert valid test data
$testData = [
    ["type" => "credit_card", "amount" => 100.00, "user_id" => 1, "donation_id" => 1],
    ["type" => "paypal", "amount" => 50.00, "user_id" => 2, "donation_id" => 2],
    ["type" => "debit_card", "amount" => 75.00, "user_id" => 3, "donation_id" => 3],
    ["type" => "other_online", "amount" => 120.00, "user_id" => 4, "donation_id" => 3],
];

echo "Inserting valid data into the Payment table...\n";
foreach ($testData as $data) {
    $stmt = $conn->prepare("INSERT INTO $configs->DB_PAYMENT_TABLE (type, amount, user_id, donation_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdii", $data["type"], $data["amount"], $data["user_id"], $data["donation_id"]);
    if ($stmt->execute()) {
        echo "Inserted: " . json_encode($data) . "\n";
    } else {
        echo "Error inserting: " . $stmt->error . "\n";
    }
    $stmt->close();
}

// Attempt invalid insertions to test constraints
$invalidData = [
    ["type" => "bitcoin", "amount" => 100.00, "user_id" => 1, "donation_id" => 1], // Invalid type
    ["type" => "credit_card", "amount" => -50.00, "user_id" => 2, "donation_id" => 2], // Negative amount
    ["type" => "paypal", "amount" => 75.00, "user_id" => null, "donation_id" => 3], // Null user_id
    ["type" => "debit_card", "amount" => 120.00, "user_id" => 4, "donation_id" => 999], // Non-existent donation_id
];

echo "\nTesting invalid data insertions...\n";
foreach ($invalidData as $data) {
    $stmt = $conn->prepare("INSERT INTO $configs->DB_PAYMENT_TABLE (type, amount, user_id, donation_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdii", $data["type"], $data["amount"], $data["user_id"], $data["donation_id"]);
    if ($stmt->execute()) {
        echo "Unexpected success: " . json_encode($data) . "\n";
    } else {
        echo "Expected failure: " . $stmt->error . "\n";
    }
    $stmt->close();
}

// Retrieve and display data to verify the results
$result = $conn->query("SELECT * FROM $configs->DB_PAYMENT_TABLE");
echo "\nCurrent rows in the Payment table:\n";
while ($row = $result->fetch_assoc()) {
    print_r($row);
}

// Close connection
$conn->close();
?>
