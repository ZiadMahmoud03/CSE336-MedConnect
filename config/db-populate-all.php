<?php
require "db-conn-setup.php";

run_queries(
    queries: [
        // Drop the database if it already exists
        "DROP DATABASE IF EXISTS $configs->DB_NAME",

        // Create the database from scratch
        "CREATE DATABASE $configs->DB_NAME",

        // Create Address table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_ADDRESS_TABLE (
            address_id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(222) NOT NULL,
            parent_id INT,
            FOREIGN KEY (parent_id) REFERENCES Address(address_id) ON DELETE SET NULL
        );",

        // Create Person table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_PERSON_TABLE (
            person_id INT PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(15),
            address_id INT,
            FOREIGN KEY (address_id) REFERENCES Address(address_id)
        );",

        // Create User table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_USER_TABLE (
            user_id INT PRIMARY KEY AUTO_INCREMENT,
            person_id INT,
            national_id VARCHAR(11) NOT NULL UNIQUE,  -- Changed to VARCHAR for 11 characters
            is_volunteer BOOLEAN DEFAULT FALSE,
            skills TEXT,
            FOREIGN KEY (person_id) REFERENCES Person(person_id)
        );",

        // Create HospitalAdmin table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_HOSPITALADMIN_TABLE (
            admin_id INT PRIMARY KEY AUTO_INCREMENT,
            hospital_id INT,
            person_id INT,
            FOREIGN KEY (person_id) REFERENCES Person(person_id)
        );",

        // Create Item table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_ITEM_TABLE (
            item_id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            quantity_available INT DEFAULT 0,
            description VARCHAR(255)
        );",

        // Create Medicine table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_MEDICINE_TABLE (
            medicine_id INT PRIMARY KEY AUTO_INCREMENT,
            expiry_date DATE NOT NULL,
            item_id INT,
            FOREIGN KEY (item_id) REFERENCES Item(item_id)
        );",

        // Create Equipment table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_EQUIPMENT_TABLE (
            equipment_id INT PRIMARY KEY AUTO_INCREMENT,
            item_id INT,
            FOREIGN KEY (item_id) REFERENCES Item(item_id)
        );",

        // Create Donation table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_DONATION_TABLE (
            donation_id INT PRIMARY KEY AUTO_INCREMENT,
            medicine_id INT,
            quantity INT,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES User(user_id),
            FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id)
        );",

        // Create Donation Details table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_DONATION_DETAILS_TABLE (
            donation_details_id INT PRIMARY KEY AUTO_INCREMENT,
            donation_id INT,
            medicine_id INT,
            equipment_id INT,
            quantity INT NOT NULL,
            FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id),
            FOREIGN KEY (equipment_id) REFERENCES Equipment(equipment_id)
        );",

        // Create Event table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_EVENT_TABLE (
            event_id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            location VARCHAR(255),
            description TEXT
        );",

        // Create Volunteer Details table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_VOLUNTEER_DETAILS_TABLE (
            volunteer_id INT PRIMARY KEY AUTO_INCREMENT,
            event_id INT,
            user_id INT,
            hours INT DEFAULT 0,
            FOREIGN KEY (event_id) REFERENCES Event(event_id),
            FOREIGN KEY (user_id) REFERENCES User(user_id)
        );",

        // Create Event Details table
        "CREATE TABLE $configs->DB_NAME.$configs->DB_EVENT_DETAILS_TABLE (
            event_details_id INT PRIMARY KEY AUTO_INCREMENT,
            event_id INT,
            volunteer_id INT,
            attendance VARCHAR(255),
            FOREIGN KEY (event_id) REFERENCES Event(event_id),
            FOREIGN KEY (volunteer_id) REFERENCES VolunteerDetails(volunteer_id)
        );",

        // Populate Address table
        "INSERT INTO $configs->DB_NAME.$configs->DB_ADDRESS_TABLE (address_id, name, parent_id) VALUES 
            (1, 'Cairo', NULL),
            (2, 'Giza', 1),
            (3, 'Alexandria', NULL),
            (4, 'Sharm El-Sheikh', NULL),
            (5, 'Aswan', NULL);",

        // Populate Person table
        "INSERT INTO $configs->DB_NAME.$configs->DB_PERSON_TABLE (first_name, last_name, email, phone, address_id) VALUES 
            ('Ali', 'Mohamed', 'ali.mohamed@example.com', '01123456789', 1),
            ('Sara', 'Hassan', 'sara.hassan@example.com', '01098765432', 2),
            ('Omar', 'El-Sayed', 'omar.elsayed@example.com', '01234567890', 3),
            ('Nadia', 'Khalil', 'nadia.khalil@example.com', '01555555555', 4),
            ('Mohamed', 'Salah', 'mohamed.salah@example.com', '01333333333', 5);",

        // Populate User table
        "INSERT INTO $configs->DB_NAME.$configs->DB_USER_TABLE (user_id, person_id, national_id, is_volunteer, skills) VALUES 
            (1, 1, '12345678901', TRUE, 'Medical, First Aid'),
            (2, 2, '23456789012', FALSE, 'Logistics, Communication'),
            (3, 3, '34567890123', TRUE, 'Event Management'),
            (4, 4, '45678901234', TRUE, 'Public Speaking'),
            (5, 5, '56789012345', FALSE, 'Administrative Tasks');",

        // Populate HospitalAdmin table
        "INSERT INTO $configs->DB_NAME.$configs->DB_HOSPITALADMIN_TABLE (admin_id, hospital_id, person_id) VALUES 
            (1, 1, 1),
            (2, 2, 2);",

        // Populate Item table
        "INSERT INTO $configs->DB_NAME.$configs->DB_ITEM_TABLE (name, quantity_available, description) VALUES 
            ('Aspirin', 100, 'Pain reliever.'),
            ('Bandages', 200, 'Medical bandages.'),
            ('Syringe', 150, 'Disposable syringes.'),
            ('Gloves', 300, 'Sterile surgical gloves.'),
            ('Face Masks', 500, 'Protective face masks.');",

        // Populate Medicine table
        "INSERT INTO $configs->DB_NAME.$configs->DB_MEDICINE_TABLE (medicine_id, expiry_date, item_id) VALUES 
            (1, '2025-12-31', 1),
            (2, '2024-06-30', 2),
            (3, '2023-03-15', 3),
            (4, '2026-01-10', 4),
            (5, '2024-11-25', 5);",

        // Populate Equipment table
        "INSERT INTO $configs->DB_NAME.$configs->DB_EQUIPMENT_TABLE (equipment_id, item_id) VALUES 
            (1, 1),
            (2, 2),
            (3, 3),
            (4, 4),
            (5, 5);",

        // Populate Donation table
        "INSERT INTO $configs->DB_NAME.$configs->DB_DONATION_TABLE (donation_id, medicine_id, quantity, user_id) VALUES 
            (1, 1, 10, 1),
            (2, 2, 5, 2),
            (3, 3, 15, 3);",

        // Populate Donation Details table
        "INSERT INTO $configs->DB_NAME.$configs->DB_DONATION_DETAILS_TABLE (donation_id, medicine_id, equipment_id, quantity) VALUES 
            (1, 1, 1, 10),
            (2, 2, NULL, 5),
            (3, 3, 3, 15);",

        // Populate Event table
        "INSERT INTO $configs->DB_NAME.$configs->DB_EVENT_TABLE (name, date, location, description) VALUES 
            ('Blood Donation Drive', '2024-11-30', 'Cairo', 'A blood donation event in Cairo.'),
            ('Health Awareness Campaign', '2024-12-15', 'Giza', 'A campaign to raise health awareness.'),
            ('Free Medical Check-up', '2024-12-20', 'Alexandria', 'Offering free check-ups and consultations.');",

        // Populate Volunteer Details table
        "INSERT INTO $configs->DB_NAME.$configs->DB_VOLUNTEER_DETAILS_TABLE (event_id, user_id, hours) VALUES 
            (1, 1, 5),
            (2, 2, 3),
            (3, 3, 8);",

        // Populate Event Details table
        "INSERT INTO $configs->DB_NAME.$configs->DB_EVENT_DETAILS_TABLE (event_id, volunteer_id, attendance) VALUES 
            (1, 1, 'Attended'),
            (2, 2, 'Pending'),
            (3, 3, 'Registered');"
    ]
);
?>
