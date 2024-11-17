<?php
require "CashDonation.php";
require "CreditCard.php";
require "DebitCard.php";
require "Paypal.php";
function testPaymentStrategy(IMoneyDonationStrategy $paymentMethod) {
    $paymentMethod->pay();
}

// Testing the different strategies
echo "Testing CreditCard Strategy:\n";
testPaymentStrategy(new CreditCard());

echo "\nTesting Paypal Strategy:\n";
testPaymentStrategy(new Paypal());

echo "\nTesting DebitCard Strategy:\n";
testPaymentStrategy(new DebitCard());

echo "\nTesting Cash Strategy:\n";
testPaymentStrategy(new CashDonation());