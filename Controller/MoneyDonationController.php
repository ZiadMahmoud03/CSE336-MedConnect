<?php

class MoneyDonationController {
    private $paymentStrategy;
    private $paymentId;
    private $amount;
    private $date;
    private $paymentMethod;

    
    public function setPaymentStrategy(IMoneyDonationStrategy $strategy) {
        $this->paymentStrategy = $strategy;
    }

    public function makePayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->amount = $_POST['amount']; 
            $this->paymentMethod = $_POST['payment_method']; 

           
            switch ($this->paymentMethod) {
                case 'cash':
                    $this->setPaymentStrategy(new CashPayment());
                    break;
                case 'online':
                    $this->setPaymentStrategy(new OnlinePayment());
                    break;
                default:
                    return "Invalid payment method.";
            }

            
            try {
                $result = $this->paymentStrategy->pay($this->amount);
                return $result; 
            } catch (Exception $e) {
                return "Payment failed: " . $e->getMessage();
            }
        }
        return "No payment data received.";
    }

   
    public function showPaymentForm() {
        require "View/payment_form.php";
    }
}
