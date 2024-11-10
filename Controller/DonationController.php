<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
class DonationController {
    
    use Controller;

    // Create a new donation
    public function createDonation($donationType, $description, &$donationDetails) {
        // Generate a unique donation ID (e.g., using timestamp or a simple random approach)
        $donationID = uniqid('donation_', true);

        // Add the donation ID, type, and description to the donationDetails array
        $donationDetails[$donationID] = [
            'donationType' => $donationType,
            'description' => $description
        ];

        echo "Donation created: " . print_r($donationDetails[$donationID], true);
    }

    // Update an existing donation
    public function updateDonation($donationID, $donationType, $description, &$donationDetails) {
        // Check if the donationID exists
        if (isset($donationDetails[$donationID])) {
            // Update the donation type and description
            $donationDetails[$donationID]['donationType'] = $donationType;
            $donationDetails[$donationID]['description'] = $description;
            echo "Donation updated: " . print_r($donationDetails[$donationID], true);
        } else {
            echo "Donation ID not found for update!";
        }
    }

    // Delete a donation
    public function deleteDonation($donationID, &$donationDetails) {
        // Remove the donation by its ID
        if (isset($donationDetails[$donationID])) {
            unset($donationDetails[$donationID]);
            echo "Donation deleted: Donation ID $donationID has been removed.";
        } else {
            echo "Donation ID not found for deletion!";
        }
    }

    // View donation details
    public function viewDonation($donationID, $donationDetails) {
        // Check if the donationID exists
        if (isset($donationDetails[$donationID])) {
            echo "Viewing donation: " . print_r($donationDetails[$donationID], true);
        } else {
            echo "Donation ID not found!";
        }
    }
}

$donationDetails = array();
$donationController = new DonationController();

// Create a donation for equipment
$donationController->createDonation("Equipment", "Donating medical equipment for surgeries", $donationDetails);

// Update the donation to add a description change
$donationID = array_key_first($donationDetails);  // Get the first donation ID for update
$donationController->updateDonation($donationID, "Medicine", "Donating essential medical supplies", $donationDetails);

// View the updated donation
$donationController->viewDonation($donationID, $donationDetails);

// Delete the donation
$donationController->deleteDonation($donationID, $donationDetails);