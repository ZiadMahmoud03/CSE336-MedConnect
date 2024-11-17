<?php
class PaymentDetails {
    private int $paymentDetailID;
    private int $paymentID;
    private int $donationID;
    private string $timestamp;
    private string $status;
    private ?string $remarks;

    public function __construct(
        ?int $paymentDetailID = null,
        int $paymentID,
        int $donationID,
        string $status = "pending", // Default status
        ?string $remarks = null
    ) {
        $this->paymentDetailID = $paymentDetailID;
        $this->paymentID = $paymentID;
        $this->donationID = $donationID;
        $this->status = $status;
        $this->remarks = $remarks;
    }

    public function logPaymentDetails(): bool {
        global $configs;
        try {
            $query = "INSERT INTO PaymentDetails (paymentID, donationID, status, remarks) VALUES (?, ?, ?, ?)";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("iiss", $this->paymentID, $this->donationID, $this->status, $this->remarks);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Error logging payment details: " . $e->getMessage());
            return false;
        }
    }

    public function retrievePaymentHistory(int $paymentID): ?array {
        global $configs;
        try {
            $query = "SELECT * FROM PaymentDetails WHERE paymentID = ?";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $paymentID);
            $stmt->execute();
            $result = $stmt->get_result();
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $details[] = $row;
            }
            return $details;
        } catch (mysqli_sql_exception $e) {
            error_log("Error retrieving payment history: " . $e->getMessage());
            return null;
        }
    }
}
