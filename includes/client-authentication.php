<?php

require ('includes/connection.php');

if(!isset($_SESSION['customerid']))
{
    header('location:user_login.php');
    exit();
}