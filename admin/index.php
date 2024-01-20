<?php
require '../includes/connection.php';
require '../includes/loginAuthentication.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/header-links.php'; ?>
    <link rel="stylesheet" type="text/css" href="../dist/css/datatable-css.css">
    <style>
        .inputError {
            border: solid 1px red;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <zdiv class="wrapper">
        <!-- Navbar -->
        <?php include '../includes/top-nav.php'; ?>

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row-my-3">
                        <div class="col-lg-12">
                            <h3>مدیریت اجناس</h3>
                        </div>
                    </div>
                    <form id="inputForm">
                        <div class="row my-1">
                            <div class="col-lg-2">اسم جنس</div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control name" placeholder="اسم جنس" name="name">
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-2">توضیح</div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control description" placeholder=" توضیح"
                                    name="description">
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-2"> مقدار</div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control total" placeholder="مقدار" name="total">
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-2"> واحد فروش</div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control unit" placeholder=" واحد فروش" name="unit">
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-2"> قیمت</div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control price" placeholder="قیمت " name="price">
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-2"> کتگوری</div>

                            <div class="col-lg-6">
                                <select class='form-control' name='categoryid'>
                                    <?php
                                    $query = "select * from category";
                                    $result = execute($query);
                                    $html = "";
                                    while ($row = mysqli_fetch_array($result)) {
                                        $html .= "<option value='" . $row['categoryid'] . "'>" . $row['name'] . "</option>";
                                    }
                                    echo $html;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-2"> </div>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> تصویر جنس</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input itemphoto" name="itemphoto"
                                            id="inputGroupFile02" accept="image/x-png,image/gif,image/jpeg">
                                        <label class="custom-file-label c1" id="label" for="inputGroupFile02">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-1">
                            <div class="col-lg-2">
                                <input type="submit" class="btn btn-primary saveButton" value="ثبت">
                            </div>
                        </div>
                    </form>
                    <div class="row my-4">
                        <div class="col-lg-12 col-sm-6">

                            <table class="table table-tabular table-striped display" id="tableRecords">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>اسم </td>
                                        <td>توضیحات</td>
                                        <td>قیمت</td>
                                        <td>واحد فروش</td>
                                        <td>مفدار</td>
                                        <td>کتگوری</td>
                                        <td>تصویر</td>
                                        <td>اقدامات</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->



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
                        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm">
                            <div class="row my-1">
                                <div class="col-lg-2">اسم جنس</div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control name" placeholder="اسم جنس" name="name">
                                    <input type='hidden' name='productid' class='productid'>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-2">توضیح</div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control description" placeholder=" توضیح"
                                        name="description">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-2"> مقدار</div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control total" placeholder="مقدار" name="total">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-2"> واحد فروش</div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control unit" placeholder=" واحد فروش" name="unit">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-2"> قیمت</div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control price" placeholder="قیمت " name="price">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-2"> کتگوری</div>

                                <div class="col-lg-6">
                                    <select class='form-control' name='categoryid'>
                                        <?php
                                        $query = "select * from category";
                                        $result = execute($query);
                                        $html = "";
                                        while ($row = mysqli_fetch_array($result)) {
                                            $html .= "<option value='" . $row['categoryid'] . "'>" . $row['name'] . "</option>";
                                        }
                                        echo $html;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-2"> </div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> تصویر جنس</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input itemphoto" name="itemphoto"
                                                id="inputGroupFile02" accept="image/x-png,image/gif,image/jpeg">
                                            <label class="custom-file-label c1" id="label" for="inputGroupFile02">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row my-2">

                                <div class="col-lg-2"></div>
                                <div class="col-lg-6 my-1">
                                    <input type="submit" class="btn btn-primary updateButton" value="تغییر">
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- Main Footer -->
        <?php include '../includes/footer.php'; ?>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <?php include '../includes/footer-links.php'; ?>
        <script src="../dist/js/datatable-js.js"></script>
        <script src="../dist/js/bs.custom-file.js"></script>
</body>

</html>

<script>
    $(document).ready(function () {
        $("a[href='index.php']").addClass('active');
        // validation function  
        function validateText(value) {
            if ($.isNumeric(value) || value.trim() == "")
                return false;
            else
                return true;
        }

        function validateNumber(value) {
            if (!$.isNumeric(value) || value.trim() == "")
                return false;
            else
                return true;
        }
        // validating file type name
        function validateFileType(fileName) {
            var dot = fileName.lastIndexOf(".") + 1;
            var extentionFile = fileName.substr(dot, fileName.length).toLowerCase();
            if (extentionFile == "jpg" || extentionFile == "jpeg" || extentionFile == "png")
                return true;
            else
                return false;
        }
        bsCustomFileInput.init();
        var Records = $('#tableRecords').DataTable({
            responsive: true,
            ajax: {
                url: '../includes/process.php',
                dataSrc: '',
                type: 'post',
                data: {
                    actionString: 'loadItems'
                },
            },
        });
        $('#inputForm').on('submit', function (e) {
            e.preventDefault();
            var name, description, price, unit, total, itemphotolabel, itemphoto;
            // accessing the form fields
            name = $('#inputForm .name');
            price = $('#inputForm .price');
            unit = $('#inputForm .unit');
            itemphotolabel = $('#inputForm .c1');
            itemphoto = $('#inputForm .itemphoto');

            // removing the error
            name.removeClass('inputError');
            price.removeClass('inputError');
            unit.removeClass('inputError');

            itemphotolabel.removeClass('inputError');

            // checking for validation
            if (validateText(name.val()) == false) {
                name.addClass('inputError');
            } else if (validateNumber(price.val()) == false) {
                price.addClass('inputError');
            } else if (validateText(unit.val()) == false) {
                unit.addClass('inputError');
            } else if (itemphoto.val().trim() == "" || validateFileType(itemphoto.val()) == false) {
                itemphotolabel.addClass('inputError');
            } else {
                var data = new FormData(this);
                data.append('actionString', 'insertItem');
                $.ajax({
                    url: '../includes/process.php',
                    type: 'post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (response) {
                        if (response == "true") {

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
        $('#tableRecords').on('click', '.deleteButton', function () {
            var value = $(this).val();
            $.ajax({
                url: '../includes/process.php',
                type: 'post',
                data: {
                    actionString: 'deleteItem',
                    productid: value
                },
                success: function (response) {
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
        $('#tableRecords').on('click', '.editButton', function () {
            var value = $(this).val();
            $.ajax({
                url: '../includes/process.php',
                type: 'post',
                dataType: 'json',
                data: {
                    actionString: 'viewItem',
                    productid: value
                },
                success: function (response) {
                    $('#editModal').modal('show');
                    $('#updateForm .name').val(response.name);
                    $('#updateForm .unit').val(response.unit);
                    $('#updateForm .price').val(response.price);
                    $('#updateForm .total').val(response.total);
                    $('#updateForm .productid').val(response.productid);
                    $('#updateForm select option[value="' + response.categoryid + '"]').attr(
                        'selected', 'true');
                }

            });
        });

        // edit record request
        $('#updateForm').on('submit', function (e) {
            e.preventDefault();
            var name, description, price, unit, total;
            // accessing the form fields
            name = $('#updateForm .name');
            price = $('#updateForm .price');
            unit = $('#updateForm .unit');

            // removing the error
            name.removeClass('inputError');
            price.removeClass('inputError');
            unit.removeClass('inputError');


            // checking for validation
            if (validateText(name.val()) == false) {
                name.addClass('inputError');
            } else if (validateNumber(price.val()) == false) {
                price.addClass('inputError');
            } else if (validateText(unit.val()) == false) {
                unit.addClass('inputError');
            } else {
                var data = new FormData(this);
                data.append('actionString', 'updateItem');
                $.ajax({
                    url: '../includes/process.php',
                    type: 'post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (response) {
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