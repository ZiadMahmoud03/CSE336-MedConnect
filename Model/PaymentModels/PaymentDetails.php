<?php

ob_start();
require_once "config/db-conn-setup.php";
ob_end_clean();

class PaymentDetails {
    private ?int $paymentDetailID;
    private ?string $timestamp;
    private ?string $status;
    private ?string $remarks;

    // Valid payment statuses
    private const VALID_STATUSES = [
        'pending',
        'processing',
        'completed',
        'failed',
        'refunded',
        'cancelled'
    ];

    public function __construct(
        ?int $paymentDetailID = null,
        ?string $timestamp = null,
        ?string $status = "pending",
        ?string $remarks = null
    ) {
        $this->paymentDetailID = $paymentDetailID;
        $this->timestamp = $timestamp ?? date('Y-m-d H:i:s');
        $this->setStatus($status);
        $this->remarks = $remarks;
    }

    // Getters and setters
    public function getPaymentDetailID(): ?int {
        return $this->paymentDetailID;
    }

    public function getTimestamp(): ?string {
        return $this->timestamp;
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function getRemarks(): ?string {
        return $this->remarks;
    }

    public function setStatus(string $status): void {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new InvalidArgumentException("Invalid payment status. Valid statuses are: " . implode(', ', self::VALID_STATUSES));
        }
        $this->status = $status;
    }

    public function setRemarks(?string $remarks): void {
        $this->remarks = $remarks;
    }

    public function logPaymentDetails(int $paymentID): bool {
        if (!$this->validateDetails($paymentID)) {
            return false;
        }

        global $configs;
        try {
            $query = "INSERT INTO PaymentDetails (paymentID, timestamp, status, remarks) 
                     VALUES (?, ?, ?, ?)";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("isss", 
                $paymentID,
                $this->timestamp,
                $this->status, 
                $this->remarks
            );

            if ($stmt->execute()) {
                $this->paymentDetailID = $stmt->insert_id;
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Error logging payment details: " . $e->getMessage());
            return false;
        }
    }

    public static function retrievePaymentHistory(int $paymentID): ?array {
        global $configs;
        try {
            $query = "SELECT pd.*, p.type as payment_type, p.amount
                     FROM PaymentDetails pd
                     LEFT JOIN Payment p ON pd.paymentID = p.paymentID
                     WHERE pd.paymentID = ?
                     ORDER BY pd.timestamp DESC";

            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $paymentID);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $details[] = $row;
            }
            
            return !empty($details) ? $details : null;
        } catch (mysqli_sql_exception $e) {
            error_log("Error retrieving payment history: " . $e->getMessage());
            return null;
        }
    }

    public function updateStatus(int $paymentID, string $newStatus, ?string $remarks = null): bool {
        try {
            $this->setStatus($newStatus);
            if ($remarks !== null) {
                $this->setRemarks($remarks);
            }

            global $configs;
            $query = "UPDATE PaymentDetails 
                     SET status = ?, remarks = ?, timestamp = NOW() 
                     WHERE paymentDetailID = ? AND paymentID = ?";
            
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("ssii", $this->status, $this->remarks, $this->paymentDetailID, $paymentID);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating payment status: " . $e->getMessage());
            return false;
        }
    }

    private function validateDetails(int $paymentID): bool {
        if ($paymentID <= 0) {
            error_log("Invalid payment ID");
            return false;
        }

        if (!in_array($this->status, self::VALID_STATUSES)) {
            error_log("Invalid payment status");
            return false;
        }

        return true;
    }

    public static function getValidStatuses(): array {
        return self::VALID_STATUSES;
    }

    public static function getDetailsByDateRange(string $startDate, string $endDate): ?array {
        global $configs;
        try {
            $query = "SELECT pd.*, p.type as payment_type, p.amount
                     FROM PaymentDetails pd
                     LEFT JOIN Payment p ON pd.paymentID = p.paymentID
                     WHERE pd.timestamp BETWEEN ? AND ?
                     ORDER BY pd.timestamp DESC";

            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("ss", $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $details[] = $row;
            }
            
            return !empty($details) ? $details : null;
        } catch (mysqli_sql_exception $e) {
            error_log("Error retrieving payment details by date range: " . $e->getMessage());
            return null;
        }
    }
}