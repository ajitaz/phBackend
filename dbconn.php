<?php
// $hostname = 'localhost';
// $username = 'root';
// $password = '';
// $dbname = 'plant_hugger';

$hostname = 'remotemysql.com';
$username = 'NpFnsxlDq4';
$password = '8yp3YyIS9O';
$dbname = 'NpFnsxlDq4';

$conn = new mysqli($hostname,$username,$password,$dbname);
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}