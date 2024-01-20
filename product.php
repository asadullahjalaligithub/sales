<?php
require 'includes/connection.php';
if (!isset($_GET['productid'])) {
    header('location:index.php');
    exit();
}
$productid = $_GET['productid'];
$query = "SELECT * from product where productid=$productid";
$result = execute($query);
$row = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>فروشگاه امینی</title>
    <style>
    .container-fluid {
        min-height: 900px;
    }
    </style>
</head>

<body>
    <div class="container-fluid" dir='rtl'>
        <div class="row text-center">
            <div class="col-lg-12 col-sm-12">
                <h3>به فروشگاه امینی خوش آمدید!</h3>
            </div>
        </div>
        <div class="row-my-5">
            <div class='col-lg-3 col-sm-6'>
                <p align='center'>

                    <img src='images/<?php echo $row['image']; ?>' border='1px' height='500px' width='500px'>

                </p>
                <h4 align='center'>
                    <?php echo $row['name']; ?>
                </h4>
                <h6 align='center'>
                    <?php echo $row['price']; ?> اففانی
                </h6>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    </div>
    <?php include 'includepages/footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src=" plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script> -->
</body>

</html>

<script>
$(document).ready(function() {

});
</script>