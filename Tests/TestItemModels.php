<?php

// Include the required files
require_once "config/db-conn-setup.php";
require_once "Model/ItemModels/Item.php";  // Assuming this contains the parent Item class
require_once "Model/ItemModels/Equipment.php";  // The file containing your Equipment class

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

// Test cases
// 1. Test object creation
runTest("Equipment Object Creation", function() {
    $equipment = new Equipment(1, 1, "Test Equipment", 5, "Good");
    return $equipment instanceof Equipment;
});

// 2. Test availability check for available equipment
runTest("Check Availability - Should be available", function() {
    $equipment = new Equipment(1, 1, "Test Equipment", 5, "Good");
    return $equipment->checkAvailability();
});

// 3. Test condition check
runTest("Check Condition", function() {
    $equipment = new Equipment(1, 1, "Test Equipment", 5, "Good");
    $condition = $equipment->checkCondition();
    echo "Condition returned: $condition\n";
    return $condition !== "Error retrieving condition";
});

// 4. Test with non-existent equipment ID
runTest("Check Non-existent Equipment", function() {
    $equipment = new Equipment(999, 999, "Non-existent Equipment", 0, "Unknown");
    $available = $equipment->checkAvailability();
    $condition = $equipment->checkCondition();
    echo "Availability: " . ($available ? "Yes" : "No") . "\n";
    echo "Condition: $condition\n";
    return !$available; // Should return false for non-existent equipment
});

// Clean up any open database connections
if (isset($configs) && isset($configs->conn)) {
    $configs->conn->close();
}