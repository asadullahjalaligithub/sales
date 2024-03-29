<?php
require 'includes/connection.php';

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
            <div class="col-lg-10 col-sm-10">
                <h1>به فروشگاه امینی خوش آمدید!</h1>
            </div>
            <div class="col-2">
                <img src="images/logo.jpeg" style="border-radius:20px; box-shadow:10px 10px 10px lightgray;" alt=""
                    width="150" height="100px">
            </div>
        </div>
        <div class="row text-center">
            <div class="col-3"></div>
            <div class="col-lg-4 col-sm-4">
                <label for="search">جستجو</label>
                <input type='search' class='form-control' id='search'>
            </div>
            <div class="col-5">

            </div>
        </div>
        <div class="row my-5" id='contents'>

        </div>

    </div><!-- /.container-fluid -->
    </div>
    <?php include 'includepages/footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="plugins/jquery/jquery.min.js"></script>
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
    function loadItems(value) {
        $.ajax({
            url: 'includes/process.php',
            type: 'post',
            data: {
                actionString: 'loadContents',
                value: value
            },
            success: function(response) {
                $('#contents').html(response);
            }

        });
    }
    $('#search').on('keyup', function(e) {
        if (e.keycode == 'enter')
            e.preventDefault();
        // var value = $(this).val();
        console.log(value);
        if (value == "")
            loadItems("");
        else
            loadItems(value);
    });
    loadItems("");
});
</script>