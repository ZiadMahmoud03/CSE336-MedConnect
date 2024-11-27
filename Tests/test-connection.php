<?php
require "config/db-conn-setup.php";

// Test Singleton by creating multiple instances
function testSingletonUniqueness()
{
    $conn1 = Database::getInstance();
    $conn2 = Database::getInstance();
    
    if ($conn1 === $conn2) {
        echo "Singleton pattern works! Both variables hold the same instance.<br/>";
    } else {
        echo "Singleton pattern failed! Different instances detected.<br/>";
    }
}

// Run the uniqueness test
testSingletonUniqueness();
?>
