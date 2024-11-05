<?php
    return (object) array(

        // Application configuration
        'SITE_NAME'     => "MedConnect",
        'APP_ROOT'      => dirname(dirname(__FILE__)),
        'URL_ROOT'      => 'http://localhost/HOSPITALDONATIONS', // Adjust if hosted on a server or subfolder
        'URL_SUBFOLDER' => '', // Leave empty if accessing directly as a folder

        // Database configuration
        'DB_HOST' => 'localhost',
        'DB_USER' => 'root',
        'DB_PASS' => '',
        'DB_NAME' => 'medconnect',

        // Database tables
        'DB_ADDRESS_TABLE'=> 'Address',
        'DB_PERSON_TABLE'=> 'Person',
        'DB_USER_TABLE'=> 'User',
        'DB_HOSPITALADMIN_TABLE'=> 'HospitalAdmin',
        'DB_ITEM_TABLE'=> 'Item',
        'DB_MEDICINE_TABLE'=> 'Medicine',
        'DB_EQUIPMENT_TABLE'=> 'Equipment',
        'DB_DONATION_TABLE'=> 'Donation',
        'DB_DONATION_DETAILS_TABLE'=> 'DonationDetails',
        'DB_EVENT_TABLE'=> 'Event',
        'DB_EVENT_DETAILS_TABLE'=> 'EventDetails',
        'DB_VOLUNTEER_DETAILS_TABLE'=> 'VolunteerDetails',

        // Routes can be defined here if needed
    );
?>