<?php
require 'includes/connection.php';
require 'includes/loginAuthentication.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/header-links.php'; ?>
    <link rel="stylesheet" type="text/css" href="dist/css/datatable-css.css">
    <style>
    .inputError {
        border: solid 1px red;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <zdiv class="wrapper">
        <!-- Navbar -->
        <?php include 'includes/top-nav.php'; ?>

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <?php include 'includes/sidebar.php'; ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row my-3">
                        <div class="col text-center">
                            <h3>مدیریت کتگوری</h3>
                        </div>
                    </div>
                    <form id="inputForm">
                        <div class="row my-2">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control name" placeholder="اسم کتگوری" name="brand">
                            </div>

                        </div>
                        <div class="row my-2">

                            <div class="col-lg-2"></div>
                            <div class="col-lg-6 ">
                                <input type="text" class="form-control description" placeholder=" توضیحات" name="model">
                            </div>

                        </div>

                        <div class="row my-2">

                            <div class="col-lg-2"></div>
                            <div class="col-lg-6 my-1">
                                <input type="button" class="btn btn-primary saveButton" value="ثبت">
                            </div>
                        </div>
                    </form>
                    <div class="row my-4">
                        <div class="col">

                            <table class="table table-tabular table-striped display" id="tableRecords">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>اسم کتگوری</td>
                                        <td>توضیحات</td>
                                        <td>اقدامات</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- data table plugin example -->





        </div>
        </div>
        <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->

        <!-- /.control-sidebar -->
        <!-- modals -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">


                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <div aria-hidden="true">&times;</div>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">پیفام</h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm">
                            <div class="row my-2">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6">
                                    <input type='hidden' class='categoryid'>
                                    <input type="text" class="form-control name" placeholder="اسم کتگوری" name="name">
                                </div>

                            </div>
                            <div class="row my-2">

                                <div class="col-lg-2"></div>
                                <div class="col-lg-6 ">
                                    <input type="text" class="form-control description" placeholder=" توضیحات"
                                        name="description">
                                </div>

                            </div>

                            <div class="row my-2">

                                <div class="col-lg-2"></div>
                                <div class="col-lg-6 my-1">
                                    <input type="button" class="btn btn-primary updateButton" value="تغییر">
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- Main Footer -->
        <?php include 'includes/footer.php'; ?>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <?php include 'includes/footer-links.php'; ?>
        <script src="dist/js/datatable-js.js"></script>
        <script src="dist/js/bs.custom-file.js"></script>
</body>

</html>

<script>
$(document).ready(function() {
    $("a[href='category.php']").addClass('active');
    var Records = $('#tableRecords').DataTable({
        columnDefs: [{
            className: 'dt-right',
            targets: '_all'
        }],
        ajax: {
            url: 'includes/process.php',
            dataSrc: '',
            type: 'post',
            data: {
                actionString: 'loadCategory'
            },
        },
    });
    $('#inputForm .saveButton').on('click', function(e) {
        var name, description;
        name = $('#inputForm .name');

        description = $('#inputForm .description');
        name.removeClass('inputError');

        description.removeClass('inputError');
        if (name.val() == "")
            name.addClass('inputError');
        else {
            $.ajax({
                url: 'includes/process.php',
                type: 'post',
                data: {
                    actionString: 'insertCategory',
                    name: name.val(),
                    description: description.val(),
                },
                success: function(response) {
                    if (response.trim() == 'true') {
                        $('#inputForm')[0].reset();
                        $('#messageModal').modal('show');
                        $('#messageModal .modal-body').text(
                            "معلومات ثبت گردید");
                        Records.ajax.reload();
                    }
                }

            });
        }
    });
    // delete request
    $('#tableRecords').on('click', '.deleteButton', function() {
        var value = $(this).val();
        $.ajax({
            url: 'includes/process.php',
            type: 'post',
            data: {
                actionString: 'deleteCategory',
                categoryid: value
            },
            success: function(response) {
                if (response.trim() == 'true') {
                    $('#messageModal').modal('show');
                    $('#messageModal .modal-body').text(
                        "مورد موفقانه حذف گردید  ");
                    Records.ajax.reload();
                } else {
                    $('#messageModal').modal('show');
                    $('#messageModal .modal-body').html(
                        "مورد قابل حذف نمیباشد.<br> علت: وابیستگی با دیگر معلومات! "
                    );
                }
            }

        });
    });
    // edit view request
    $('#tableRecords').on('click', '.editButton', function() {
        var value = $(this).val();
        $.ajax({
            url: 'includes/process.php',
            type: 'post',
            dataType: 'json',
            data: {
                actionString: 'viewCategory',
                categoryid: value
            },
            success: function(response) {
                $('#editModal').modal('show');
                $('#updateForm .categoryid').val(response.categoryid);
                $('#updateForm .name').val(response.name);
                $('#updateForm .description').val(response.description);
            }

        });
    });

    // edit record request
    $('#updateForm .updateButton').on('click', function(e) {
        var name, description, categoryid;
        categoryid = $('#updateForm .categoryid');
        name = $('#updateForm .name');

        description = $('#updateForm .description');
        name.removeClass('inputError');
        description.removeClass('inputError');
        if (name.val() == "")
            name.addClass('inputError');
        else {
            $.ajax({
                url: 'includes/process.php',
                type: 'post',
                data: {
                    actionString: 'updateCategory',
                    name: name.val(),
                    description: description.val(),
                    categoryid: categoryid.val()
                },
                success: function(response) {
                    if (response.trim() == 'true') {
                        $('#updateForm')[0].reset();
                        $('#editModal').modal('hide');
                        $('#messageModal').modal('show');
                        $('#messageModal .modal-body').text(
                            "معلومات تغییر کرد  ");
                        Records.ajax.reload();
                    }
                }

            });
        }
    });
});
</script>