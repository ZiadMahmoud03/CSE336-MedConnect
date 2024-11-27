<?php
$configs = require 'config/config.php';

echo "Site Name: " . $configs->SITE_NAME . "<br>";
echo "Database Host: " . $configs->DB_HOST . "<br>";
echo "Database Name: " . $configs->DB_NAME . "<br>";

?>