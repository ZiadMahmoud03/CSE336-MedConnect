<?php
$configs = require "config.php"; // No need for global here

class Database
{
    private static $instance = null;
    private $connection;

    // Private constructor to prevent multiple instances
    private function __construct()
    {
        global $configs; // Use global to access configs if needed

        $this->connection = new mysqli(
            $configs->DB_HOST,
            $configs->DB_USER,
            $configs->DB_PASS,
            $configs->DB_NAME
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        } else {
            error_log("Database connection successful");
        }
    }

    // Public method to get the single instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}

// Updated run_queries function
function run_queries($queries, $echo = false): array
{
    $conn = Database::getInstance();
    $ret = [];
    foreach ($queries as $query) {
        $result = $conn->query($query);
        $ret[] = $result; // Store the result
        if ($echo) {
            echo '<pre>' . $query . '</pre>';
            echo $result === TRUE ? "Query ran successfully<br/>" : "Error: " . $conn->error;
            echo "<hr/>";
        }
    }
    return $ret;
}

// Updated run_query function
function run_query($query, $echo = false): bool
{
    return run_queries([$query], $echo)[0];
}

// Updated run_select_query function
function run_select_query($query, $echo = false): mysqli_result|bool
{
    $conn = Database::getInstance();
    $result = $conn->query($query);
    if ($echo) {
        echo '<pre>' . $query . '</pre>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<pre>' . print_r($row, true) . '</pre>'; // Use print_r for better formatting
            }
        } else {
            echo "0 results";
        }
        echo "<hr/>";
    }
    return $result;
}
?>
