<?php
// display all php errors and warning
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'jdatetime.class.php';
$shamsiDate = new jDateTime(true, true, 'Asia/Kabul');

$user = "root";
$password = "root";
$database = "sales";
$server = "localhost";

$connection = mysqli_connect($server, $user, $password, $database);

if (mysqli_connect_errno())
    die("Failed to connect :" . mysqli_connect_error());


// to make free the database variable that containts database results
function freeResult($result)
{
    mysqli_free_result($result);
}
// insert, or delete or select
function execute($query)
{
    global $connection;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    return $result;
}

// select statement counting the number of rows
function rowsReturn($result)
{
    global $connection;
    $count = mysqli_num_rows($result);

    return $count;
}

// executing multiple delete, insert or update statement
function executeMulti($query)
{
    global $connection;
    $result = mysqli_multi_query($connection, $query) or die(mysqli_error($connection));
    return $result;
}

// formatting a number

function format($value)
{
    return number_format($value, 2);
}