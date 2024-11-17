<?php

Class CreditCard implements IMoneyDonationStrategy {
    
    private $paymentModel;

    public function __construct() {
       // $this->paymentModel = new Payment();
    }

    // public function pay(array $userCredentials) {
    //    $this->paymentModel->initialize($userCredentials);
    //     $this->paymentModel->process();
    
    // } 

    public function pay(){
        echo "Credit Card Payment\n";
    }

}   