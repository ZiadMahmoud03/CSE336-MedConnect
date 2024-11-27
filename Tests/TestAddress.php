<?php

// Include the required files
require_once "config/db-conn-setup.php";
require_once "Model/Address.php";  // Your Address class file

// Function to run test and display results
function runTest($testName, $callback) {
    echo "<div class='test-case'>";
    echo "<h3>Test: $testName</h3>";
    echo "<div class='test-details'>";
    try {
        $result = $callback();
        echo "<div class='result " . ($result === true ? "pass" : "fail") . "'>";
        echo "Result: " . ($result === true ? "PASS" : "FAIL") . "</div>";
        echo "<div class='output'><strong>Output:</strong> <pre>";
        var_dump($result);
        echo "</pre></div>";
    } catch (Exception $e) {
        echo "<div class='error'>Test failed with exception: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    echo "</div></div>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Address Class Tests</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-case { 
            margin: 20px 0; 
            padding: 15px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
        }
        .test-details { margin-left: 20px; }
        .result { 
            padding: 5px 10px; 
            margin: 10px 0; 
            border-radius: 3px; 
        }
        .pass { background-color: #dff0d8; color: #3c763d; }
        .fail { background-color: #f2dede; color: #a94442; }
        .error { 
            background-color: #fcf8e3; 
            color: #8a6d3b; 
            padding: 10px; 
            margin: 10px 0; 
        }
        pre { 
            background: #f8f8f8; 
            padding: 10px; 
            overflow-x: auto; 
        }
        h1 { color: #333; }
        .output { margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Address Class Tests</h1>

<?php

// Test cases
// 1. Test object creation
runTest("Address Object Creation", function() {
    $address = new Address(1, "Test Address", 0);
    return $address instanceof Address;
});

// 2. Test saving new address
runTest("Save New Address", function() {
    $address = new Address(null, "New Test Address", 1);
    $result = $address->save();
    return $result;
});

// 3. Test finding address by ID
runTest("Find Address by ID", function() {
    // First create an address to find
    $address = new Address(null, "Address to Find", 1);
    $address->save();
    
    // Try to find the last inserted address
    $query = "SELECT address_id FROM Address ORDER BY address_id DESC LIMIT 1";
    $result = run_select_query($query);
    $row = $result->fetch_assoc();
    $foundAddress = Address::findByID($row['address_id']);
    
    return $foundAddress !== null && $foundAddress instanceof Address;
});

// 4. Test updating existing address
runTest("Update Existing Address", function() {
    // First create an address
    $address = new Address(null, "Original Name", 1);
    $address->save();
    
    // Get the ID of the saved address
    $query = "SELECT address_id FROM Address ORDER BY address_id DESC LIMIT 1";
    $result = run_select_query($query);
    $row = $result->fetch_assoc();
    $addressId = $row['address_id'];
    
    // Update the address
    $address->setAddressID($addressId);
    $address->setName("Updated Name");
    return $address->save();
});

// 5. Test finding all addresses
runTest("Find All Addresses", function() {
    $addresses = Address::findAll();
    return is_array($addresses) && count($addresses) > 0;
});

// 6. Test with non-existent address ID
runTest("Find Non-existent Address", function() {
    $address = Address::findByID(99999); // Using a likely non-existent ID
    return $address === null; // Should return true as the address shouldn't exist
});

// Clean up any open database connections
if (isset($configs) && isset($configs->conn)) {
    $configs->conn->close();
}

?>

</body>
</html>