<?php
<<<<<<< HEAD
=======
    return (object) array(

        // Application configuration
        'SITENAME'     => "MedConnect",
        'APPROOT'      => dirname(dirname(__FILE)),
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

<?php
>>>>>>> cc488f8cd445985c0f1d853b4bd69a9c3db0b4b4
$configs = require "config.php";
$conn = new mysqli($configs->DB_HOST, $configs->DB_USER);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully<br/><hr/>";

function run_queries($queries, $echo = false): array
{
    global $conn;
    $ret = [];
    foreach ($queries as $query) {
        $ret += [$conn->query($query)];
        if ($echo) {
            echo '<pre>' . $query . '</pre>';
            echo $ret[array_key_last($ret)] === TRUE ? "Query ran successfully<br/>" : "Error: " . $conn->error;
            echo "<hr/>";
        }
    }
    return $ret;
}

function run_query($query, $echo = false): bool
{
    return run_queries([$query], $echo)[0];
}

function run_select_query($query, $echo = false): mysqli_result|bool
{
    global $conn;
    $result = $conn->query($query);
    if ($echo) {
        echo '<pre>' . $query . '</pre>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
                echo $row;
        } else {
            echo "0 results";
        }
        echo "<hr/>";
    }
    return $result;
}

<<<<<<< HEAD
// $conn->close();
=======
// $conn->close();
>>>>>>> cc488f8cd445985c0f1d853b4bd69a9c3db0b4b4
