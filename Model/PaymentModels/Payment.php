<?php
class Payment {
    private int $paymentID;
    private string $type; // e.g., credit_card, debit_card, etc.
    private float $amount;
    private int $userID;
    private int $donationID;

    public function __construct(
        ?int $paymentID = null,
        string $type = "credit_card", // Default to credit_card
        float $amount,
        int $userID,
        int $donationID
    ) {
        $this->paymentID = $paymentID;
        $this->type = $type;
        $this->amount = $amount;
        $this->userID = $userID;
        $this->donationID = $donationID;

        // Ensure payment type is valid
        if (!in_array($type, ['credit_card', 'debit_card', 'paypal', 'other_online'])) {
            throw new InvalidArgumentException("Invalid payment type. Only online payment methods are allowed.");
        }
    }

    public function recordPayment(): bool {
        global $configs;
        try {
            $query = "INSERT INTO Payment (type, amount, userID, donationID) VALUES (?, ?, ?, ?)";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("sdii", $this->type, $this->amount, $this->userID, $this->donationID);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Error recording payment: " . $e->getMessage());
            return false;
        }
    }

    public function getPaymentInfo(int $paymentID): ?array {
        global $configs;
        try {
            $query = "SELECT * FROM Payment WHERE paymentID = ?";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $paymentID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            error_log("Error fetching payment info: " . $e->getMessage());
            return null;
        }
    }
}
