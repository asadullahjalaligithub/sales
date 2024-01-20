<?php

require ('includes/connection.php');

if(!isset($_SESSION['privilage']) && $_SESSION['privilage']!='admin')
{
    header('location:admin_login.php');
    exit();
}