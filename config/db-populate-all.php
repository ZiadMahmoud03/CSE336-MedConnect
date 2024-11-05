<?php
    require "db-conn-setup.php";

    run_queries(
        queries: [
            // Drop the database if it already exists, do nothing otherwise
            "DROP DATABASE IF EXISTS $configs->DB_NAME",

            // Create the database from scratch
            "CREATE DATABASE $configs->DB_NAME",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_ADDRESS_TABLE (
                address_id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(222) NOT NULL,
                parent_id INT,
                FOREIGN KEY (parent_id) REFERENCES Address(address_id) ON DELETE SET NULL
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_PERSON_TABLE (
                person_id INT PRIMARY KEY AUTO_INCREMENT,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                phone INT,
                address_id INT,
                FOREIGN KEY (address_id) REFERENCES Address(address_id)
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_USER_TABLE (
                user_id INT PRIMARY KEY,
                person_id INT,
                national_id INT NOT NULL UNIQUE,
                is_volunteer BOOLEAN DEFAULT FALSE,
                skills TEXT,  -- serialized list of skills
                FOREIGN KEY (person_id) REFERENCES Person(person_id)
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_HOSPITALADMIN_TABLE (
                admin_id INT PRIMARY KEY,
                hospital_id INT,
                person_id INT,
                FOREIGN KEY (person_id) REFERENCES Person(person_id),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_ITEM_TABLE (
                item_id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                quantity_available INT DEFAULT 0,
                description VARCHAR(255),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_MEDICINE_TABLE (
                medicine_id INT PRIMARY KEY,
                expiry_date DATE NOT NULL,
                item_id INT,
                FOREIGN KEY (item_id) REFERENCES Item(item_id),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_EQUIPMENT_TABLE (
                equipment_id INT PRIMARY KEY,
                item_id INT,
                FOREIGN KEY (item_id) REFERENCES Item(item_id),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_DONATION_TABLE (
                donation_id INT PRIMARY KEY,
                medicine_id INT,
                quantity INT,
                user_id INT,
                FOREIGN KEY (user_id) REFERENCES User(user_id),
                FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_DONATION_DETAILS_TABLE (
                donation_details_id INT PRIMARY KEY AUTO_INCREMENT,
                donation_id INT,
                medicine_id INT,
                equipment_id INT,
                quantity INT NOT NULL,
                FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id),
                FOREIGN KEY (equipment_id) REFERENCES Equipment(equipment_id),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_EVENT_TABLE (
                event_id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                location VARCHAR(255),
                description TEXT
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_EVENT_DETAILS_TABLE (
                event_details_id INT PRIMARY KEY AUTO_INCREMENT,
                event_id INT,
                volunteer_id INT,
                attendance VARCHAR(255),
                FOREIGN KEY (event_id) REFERENCES Event(event_id),
                FOREIGN KEY (volunteer_id) REFERENCES VolunteerDetails(volunteer_id),
            );",

            "CREATE TABLE $configs->DB_NAME.$configs->DB_VOLUNTEER_DETAILS_TABLE (
                volunteer_id INT PRIMARY KEY AUTO_INCREMENT,
                event_id INT,
                user_id INT,
                hours INT DEFAULT 0,
                FOREIGN KEY (event_id) REFERENCES Event(event_id),
                FOREIGN KEY (user_id) REFERENCES User(user_id),
            );",

        ]
    )
?>