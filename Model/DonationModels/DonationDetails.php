<?php
ob_start();  

require_once "config/db-conn-setup.php";  

ob_end_clean();  

class DonationDetails {
    private ?int $donationDetailsID;
    private ?int $donationID;
    private ?string $type; // 'medicine' or 'equipment'
    private int $itemID;  // medicineID or equipmentID
    private ?int $quantity;
    private ?float $unitPrice;
    private ?string $timestamp;
    private string $status;

    private const ITEM_TYPES = ['medicine', 'equipment', 'money'];
    private const STATUS_TYPES = ['Pending', 'Received', 'Cancelled'];

    public function __construct(
        ?int $donationDetailsID = null,
        ?int $donationID  = null,
        string $type = 'money',
        ?int $itemID  = null,
        ?int $quantity  = null,
        ?float $unitPrice = null,
        ?string $timestamp = null,
        string $status = 'Pending'
    ) {
        if (!in_array($type, self::ITEM_TYPES)) {
            throw new InvalidArgumentException("Invalid item type. Allowed values: " . implode(', ', self::ITEM_TYPES));
        }

        if (!in_array($status, self::STATUS_TYPES)) {
            throw new InvalidArgumentException("Invalid status. Allowed values: " . implode(', ', self::STATUS_TYPES));
        }

        $this->donationDetailsID = $donationDetailsID;
        $this->donationID = $donationID;
        $this->type = $type;
        $this->itemID = $itemID;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->timestamp = $timestamp ?? date('Y-m-d H:i:s');
        $this->status = $status;
    }

    public function addDetails(): bool {
        global $configs;
        try {
            $query = "INSERT INTO DonationDetails 
                     (donationID, type, itemID, quantity, unitPrice, timestamp, status)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("isiidsss",
                $this->donationID,
                $this->type,
                $this->itemID,
                $this->quantity,
                $this->unitPrice,
                $this->timestamp,
                $this->status
            );

            if ($stmt->execute()) {
                $this->donationDetailsID = $stmt->insert_id;
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Error adding donation details: " . $e->getMessage());
            return false;
        }
    }

    public function updateStatus(string $newStatus): bool {
        if (!in_array($newStatus, self::STATUS_TYPES)) {
            throw new InvalidArgumentException("Invalid status");
        }

        global $configs;
        try {
            $query = "UPDATE DonationDetails 
                     SET status = ?, timestamp = NOW() 
                     WHERE donationDetailsID = ?";
            
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("si", $newStatus, $this->donationDetailsID);
            
            if ($stmt->execute()) {
                $this->status = $newStatus;
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Error updating donation details status: " . $e->getMessage());
            return false;
        }
    }

    public static function getDetailsByDonation(int $donationID): ?array {
        global $configs;
        try {
            $query = "SELECT dd.*,
                            CASE 
                                WHEN dd.type = 'medicine' THEN m.name
                                WHEN dd.type = 'equipment' THEN e.name
                            END as item_name
                     FROM DonationDetails dd
                     LEFT JOIN Medicine m ON dd.type = 'medicine' AND dd.itemID = m.medicineID
                     LEFT JOIN Equipment e ON dd.type = 'equipment' AND dd.itemID = e.equipmentID
                     WHERE dd.donationID = ?
                     ORDER BY dd.timestamp DESC";

            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $donationID);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $details[] = $row;
            }
            
            return !empty($details) ? $details : null;
        } catch (mysqli_sql_exception $e) {
            error_log("Error retrieving donation details: " . $e->getMessage());
            return null;
        }
    }

    public function calculateTotalValue(): float {
        return $this->quantity * ($this->unitPrice ?? 0);
    }

    // Getters
    public function getDonationDetailsID(): ?int {
        return $this->donationDetailsID;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

}
?>
