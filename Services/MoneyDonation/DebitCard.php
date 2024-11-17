<?php

Class DebitCard implements IMoneyDonationStrategy {
    
    private $paymentModel;

    public function __construct() {
       // $this->paymentModel = new Payment();
    }

    // public function pay(array $userCredentials) {
    //    $this->paymentModel->initialize($userCredentials);
    //     $this->paymentModel->process();
    
    // } 

    public function pay(){
        echo "Debit Card Payment\n";
    }

}   