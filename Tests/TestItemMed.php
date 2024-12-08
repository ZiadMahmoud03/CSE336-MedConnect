<?php

// Include required files
require_once "../config/db-conn-setup.php";
require_once "../Model/ItemModels/Item.php";
require_once "../Model/ItemModels/Medicine.php";

// Ensure a valid database connection is available
// if (!isset($configs->conn) || !$configs->conn instanceof mysqli) {
//     die("Database connection not properly initialized.");
// }

// Function to run test and display results
function runTest($testName, $callback) {
    echo "\nRunning test: $testName\n";
    echo "----------------------------------------\n";
    try {
        $result = $callback();
        echo "Result: " . ($result === true ? "PASS" : "FAIL") . "\n";
        echo "Output: ";
        var_dump($result);
    } catch (Exception $e) {
        echo "Test failed with exception: " . $e->getMessage() . "\n";
    }
    echo "----------------------------------------\n";
}

// Test CRUD operations for Medicine class
runTest("Test Insert Medicine", function() {
    $medicine = new Medicine(null, null, "Test Medicine", 50, "2025-12-31", "Test medicine description");
    return $medicine->insertMedicine(); // Assuming insertItem inserts medicine properly
});

runTest("Test Retrieve Medicine", function() {
    $medicine = new Medicine(1); // Assuming ID 1 exists in the database
    $availability = $medicine->checkAvailability(); // Check availability
    $expiryStatus = $medicine->checkExpiry(); // Check expiry status
    return [
        "availability" => $availability,
        "expiry_status" => $expiryStatus
    ];
});

runTest("Test Update Medicine", function() {
    $medicine = new Medicine(1); // Assuming ID 1 exists
    $success = $medicine->updateField("name", "Panadol");
    return $success;
    // && $medicine->getDescription() === "Updated Medicine Description";
});



runTest("Test Delete Medicine", function() {
    $conn = Database::getInstance();

    $medicineID = 1; // Specify the ID of the medicine to delete (replace with an appropriate test value)

    $query = "DELETE FROM Medicine WHERE equipment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $medicineID);
    $stmt->execute();

    return $stmt->affected_rows > 0; // Return true if a row was successfully deleted
});

runTest("Test Medicine Near Expiry", function() {
    $medicine = new Medicine(1); // Assuming ID 1 exists and is near expiry
    return $medicine->isNearExpiry(30); // Check if the medicine is near expiry within 30 days
});

// Clean up any open database connections
if (isset($configs) && isset($configs->conn)) {
    $configs->conn->close();
}
