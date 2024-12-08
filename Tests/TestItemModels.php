<?php

// Include required files
require_once "../config/db-conn-setup.php";
require_once "../Model/ItemModels/Item.php"; 
require_once "../Model/ItemModels/Equipment.php"; 

// if (!isset($configs->conn) || !$configs->conn instanceof mysqli) {
//     die("Database connection not properly initialized.");
// }


// TODO - Fix Update and Delete operations for Equipment class

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

// Test CRUD operations for Equipment class
runTest("Test Insert Equipment", function() {
    $equipment = new Equipment(null, null, "Test Equipment", 10, "New", "Test equipment description");
    return $equipment->insertEquipment(); // Test insertion
});

runTest("Test Retrieve Equipment", function() {
    $equipment = new Equipment(1); // Assuming ID 1 exists in the database
    $availability = $equipment->checkAvailability(); // Check availability
    $condition = $equipment->checkCondition(); // Check condition
    return [
        "availability" => $availability,
        "condition" => $condition
    ];
});

runTest("Test Update Equipment", function() {
    $equipment = new Equipment(1); // Assuming ID 1 exists
    $equipment->setCondition("Updated Condition"); // Update condition
    $equipment->insertEquipment(); // Update DB entry
    return $equipment->checkCondition() === "Updated Condition"; // Verify update
});

runTest("Test Delete Equipment", function() {
    $conn = Database::getInstance(); // Use Database singleton for connection

    $equipmentID = 1; // Specify the ID of the equipment to delete (replace with an appropriate test value)

    $query = "DELETE FROM Equipment WHERE equipment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $equipmentID);
    $stmt->execute();

    return $stmt->affected_rows > 0; // Return true if a row was successfully deleted
});



// Clean up any open database connections
if (isset($configs) && isset($configs->conn)) {
    $configs->conn->close();
}
