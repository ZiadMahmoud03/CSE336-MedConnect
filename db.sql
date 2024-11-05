CREATE TABLE Address (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(222) NOT NULL,
    parent_id INT,
    FOREIGN KEY (parent_id) REFERENCES Address(address_id) ON DELETE SET NULL
);

-- Abstract Person table
CREATE TABLE Person (
    person_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone INT,
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES Address(address_id)
);

-- User table (inherits from Person)
CREATE TABLE User (
    user_id INT PRIMARY KEY,
    person_id INT,
    national_id INT NOT NULL UNIQUE,
    is_volunteer BOOLEAN DEFAULT FALSE,
    skills TEXT,  -- serialized list of skills
    FOREIGN KEY (person_id) REFERENCES Person(person_id)
);

-- HospitalAdmin table (inherits from Person)
CREATE TABLE HospitalAdmin (
    admin_id INT PRIMARY KEY,
    hospital_id INT,
    person_id INT,
    FOREIGN KEY (person_id) REFERENCES Person(person_id)
);

-- Abstract Item table
CREATE TABLE Item (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    quantity_available INT DEFAULT 0,
    description VARCHAR(255)
);

-- Medicine table (inherits from Item)
CREATE TABLE Medicine (
    medicine_id INT PRIMARY KEY,
    expiry_date DATE NOT NULL,
    item_id INT,
    FOREIGN KEY (item_id) REFERENCES Item(item_id)
);

-- Equipment table (inherits from Item)
CREATE TABLE Equipment (
    equipment_id INT PRIMARY KEY,
    `condition` VARCHAR(255) NOT NULL,
    item_id INT,
    FOREIGN KEY (item_id) REFERENCES Item(item_id)
);

-- DonationDetails table (associates medicines and equipment with donations)
CREATE TABLE DonationDetails (
    donation_details_id INT PRIMARY KEY AUTO_INCREMENT,
    donation_id INT,
    medicine_id INT,
    equipment_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id),
    FOREIGN KEY (equipment_id) REFERENCES Equipment(equipment_id)
);

-- BasicDonation table (implements Donation)
CREATE TABLE Donation (
    donation_id INT PRIMARY KEY,
    medicine_id INT,
    quantity INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (medicine_id) REFERENCES Medicine(medicine_id)
);

-- Event table
CREATE TABLE Event (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(255),
    description TEXT
);

-- VolunteerDetails table
CREATE TABLE VolunteerDetails (
    volunteer_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    hours INT DEFAULT 0,
    FOREIGN KEY (event_id) REFERENCES Event(event_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- EventDetails table (connects volunteers to specific events with attendance)
CREATE TABLE EventDetails (
    event_details_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    volunteer_id INT,
    attendance VARCHAR(255),
    FOREIGN KEY (event_id) REFERENCES Event(event_id),
    FOREIGN KEY (volunteer_id) REFERENCES VolunteerDetails(volunteer_id)
);