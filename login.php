<?php
if(isset($_GET['logout']))
    {
        session_start();
        session_destroy();
    }
session_start();
if(isset($_SESSION['login'])=='true')
    {
        header('location:index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Fabric Management System</title>
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <style>
    .inputError {
        border: solid 1px red;
    }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Fabric Whole Sale Management System</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="username"
                                                aria-describedby="emailHelp" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                placeholder="Password">
                                        </div>

                                        <input type='button' class="btn btn-primary btn-user btn-block" id='loginButton'
                                            value='login'>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small">Forgot Password?</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- message Modal-->
    <div class=" modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Wrong Username or Password!
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#loginButton').click(function() {
            var username = $('#username');
            var password = $('#password');
            username.removeClass('inputError');
            password.removeClass('inputError');
            if (username.val() == "")
                username.addClass('inputError');
            else if (password.val() == "")
                password.addClass('inputError');
            else {
                $.ajax({
                    url: 'includes/process.php',
                    type: 'post',
                    data: {
                        actionString: 'loginAuthentication',
                        username: username.val(),
                        password: password.val()
                    },
                    success: function(response) {
                        if (response.trim() == 'false') {
                            $('#messageModal').modal(
                                'show');
                        } else if (response.trim() == 'true') {
                            $(location).attr('href', 'index.php');
                        }
                    }
                });
            }
        });
    });
    </script>


</body>

</html>