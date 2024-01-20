<?php
if(!isset($_SESSION['name']))
    {
        header('location:login.php');
        exit();
    }