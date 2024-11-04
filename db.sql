-- Address table (used by both Donor and HospitalAdmin)
CREATE TABLE Address (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(222) NOT NULL,
    parent_id INT,
    FOREIGN KEY (parent_id) REFERENCES Address(address_id) ON DELETE SET NULL
);


-- Person table (abstract)
CREATE TABLE Person (
    person_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255),
    phone INT,
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES Address(address_id)
);

-- Donor table (inherits from Person)
CREATE TABLE Donor (
    donor_id INT PRIMARY KEY,
    national_id INT,
    person_id INT,
    FOREIGN KEY (person_id) REFERENCES Person(person_id)
);

-- HospitalAdmin table (inherits from Person)
CREATE TABLE HospitalAdmin (
    admin_id INT PRIMARY KEY,
    hospital_id INT,
    person_id INT,
    FOREIGN KEY (person_id) REFERENCES Person(person_id)
);

-- Item table (abstract)
CREATE TABLE Item (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    quantity_available INT
);

-- Medicine table (inherits from Item)
CREATE TABLE Medicine (
    medicine_id INT PRIMARY KEY,
    expiry_date DATE,
    item_id INT,
    FOREIGN KEY (item_id) REFERENCES Item(item_id)
);

-- Equipment table (inherits from Item)
CREATE TABLE Equipment (
    equipment_id INT PRIMARY KEY,
    `condition` VARCHAR(255),
    item_id INT,
    FOREIGN KEY (item_id) REFERENCES Item(item_id)
);

-- DonationDetails table (associates medicines and equipment with donations)
CREATE TABLE DonationDetails (
    donation_details_id INT PRIMARY KEY AUTO_INCREMENT,
    donation_id INT,
    medicine_id INT,
    equipment_id INT,
    quantity INT,
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id),
    FOREIGN KEY (equipment_id) REFERENCES Equipment(equipment_id)
);

-- Donation table (abstract interface)
CREATE TABLE Donation (
    donation_id INT PRIMARY KEY AUTO_INCREMENT,
    donor_id INT,
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id)
);

-- BasicDonation table (implements Donation)
CREATE TABLE BasicDonation (
    basic_donation_id INT PRIMARY KEY,
    donation_id INT,
    medicine_id INT,
    quantity INT,
    FOREIGN KEY (donation_id) REFERENCES Donation(donation_id),
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id)
);

-- DonationDecorator table (abstract, uses Donation)
CREATE TABLE DonationDecorator (
    decorator_id INT PRIMARY KEY AUTO_INCREMENT,
    donation_id INT,
    FOREIGN KEY (donation_id) REFERENCES Donation(donation_id)
);

-- RecurringDonation table (inherits DonationDecorator)
CREATE TABLE RecurringDonation (
    recurring_donation_id INT PRIMARY KEY,
    decorator_id INT,
    frequency INT,
    FOREIGN KEY (decorator_id) REFERENCES DonationDecorator(decorator_id)
);

-- MedicalEquipmentDonation table (inherits DonationDecorator)
CREATE TABLE MedicalEquipmentDonation (
    equipment_donation_id INT PRIMARY KEY,
    decorator_id INT,
    equipment_list TEXT,  -- serialized list of equipment or references to IDs
    FOREIGN KEY (decorator_id) REFERENCES DonationDecorator(decorator_id)
);

-- FundsDonation table (inherits DonationDecorator)
CREATE TABLE FundsDonation (
    funds_donation_id INT PRIMARY KEY,
    decorator_id INT,
    amount DECIMAL(10, 2),
    FOREIGN KEY (decorator_id) REFERENCES DonationDecorator(decorator_id)
);
