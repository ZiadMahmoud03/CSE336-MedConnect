<?php

Interface IMoneyDonationStrategy
{
    public function pay(array $paymentDetails);
}