<?php
require('../includes/connection.php');
// admin authentiatcation 


if (isset($_POST['actionString']) && $_POST['actionString'] == 'loginAuthentication') {
   $username = $_POST['username'];
   $password = $_POST['password'];
   $query = "select * from user where username='$username' and password='$password' and privilage='admin'";
   $result = mysqli_query($connection, $query);
   if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION['firstname'] = $row['firstname'];
      $_SESSION['lastname'] = $row['lastname'];
      $_SESSION['password'] = $row['password'];
      $_SESSION['userid'] = $row['userid'];
      $_SESSION['privilage'] = $row['privilage'];
      $_SESSION['status'] = $row['status'];
      $_SESSION['login'] = 'true';
      echo "true";
   } else
      echo "false";
}






if (isset($_POST['actionString']) && $_POST['actionString'] == "insertCategory") {
   $name = $_POST['name'];
   $description = $_POST['description'];
   $query = "insert into category  (name,description) values ('$name','$description')";
   if (execute($query))
      echo "true";
   else
      echo "false";

}


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCategory") {
   $query = "SELECT * from category";
   $result = mysqli_query($connection, $query);
   $html = array();
   $i = 1;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['name'];
      $row[] = $rows['description'];
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['categoryid'] . "'>تصحیح</button>
         <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['categoryid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);

}



if (isset($_POST['actionString']) && $_POST['actionString'] == "deleteCategory") {
   $categoryid = $_POST['categoryid'];
   $query = "delete from category where categoryid=$categoryid";
   if (execute($query))
      echo "true";
   else
      echo "false";

}


if (isset($_POST['actionString']) && $_POST['actionString'] == "viewCategory") {
   $categoryid = $_POST['categoryid'];
   $query = "select * from category where categoryid=$categoryid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}
if (isset($_POST['actionString']) && $_POST['actionString'] == "updateCategory") {
   $categoryid = $_POST['categoryid'];
   $name = $_POST['name'];
   $description = $_POST['description'];

   $query = "update  category set name='$name',description='$description' where categoryid='$categoryid'";
   if (execute($query))
      echo "true";
   else
      echo "false";

}



if (isset($_POST['actionString']) && $_POST['actionString'] == 'insertItem') {
   $name = $_POST['name'];
   $description = $_POST['description'];
   $unit = $_POST['unit'];

   $price = $_POST['price'];
   $total = $_POST['total'];
   $categoryid = $_POST['categoryid'];


   $finalDatabaseName = null;

   if (isset($_FILES['itemphoto']) && $_FILES['itemphoto']['error'] == UPLOAD_ERR_OK) {
      $realPersonName1 = $_FILES['itemphoto']['name'];
      $tempName1 = $_FILES['itemphoto']['tmp_name'];
      $finalDatabaseName = time() . ".jpg";
      $destination = "../images/" . $finalDatabaseName;
      move_uploaded_file($tempName1, $destination);
   }

   $query = "insert into product(name,description,unit,price,total,image,categoryid)  values ('$name','$description','$unit','$price','$total','$finalDatabaseName','$categoryid');";
   if (execute($query))
      echo "true";
   else
      echo "false";

}


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadItems") {

   $query = "SELECT product.*,category.name as cname from product inner join category on product.categoryid=category.categoryid";
   $result = mysqli_query($connection, $query);
   $html = array();
   $i = 1;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['name'];
      $row[] = $rows['description'];
      $row[] = $rows['price'];
      $row[] = $rows['unit'];
      $row[] = $rows['total'];
      $row[] = $rows['cname'];

      if ($rows['image'] == NULL)
         $row[] = "<img src='../images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank' href='../images/" . $rows['image'] . "'><img src='../images/" . $rows['image'] . "' width='60px' height='60px'></a>";
      $button = "<button class='btn btn-sm  btn-warning mb-1  editButton fa fa-edit' value='" . $rows['productid'] . "'></button>
         <button class='btn btn-sm btn-danger  deleteButton fa fa-trash' value='" . $rows['productid'] . "'></button>";

      $row[] = $button;
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);

}

// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'deleteItem') {
   $productid = $_POST['productid'];
   $query = "delete from product where productid=$productid";
   if (execute($query))
      echo "true";
   else
      echo "false";
}


// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'viewItem') {

   $productid = $_POST['productid'];
   $query = "select * from product where productid=$productid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}


// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'updateItem') {
   $name = $_POST['name'];
   $description = $_POST['description'];
   $unit = $_POST['unit'];

   $price = $_POST['price'];
   $total = $_POST['total'];
   $categoryid = $_POST['categoryid'];
   $productid = $_POST['productid'];


   $finalDatabaseName = null;

   if (isset($_FILES['itemphoto']) && $_FILES['itemphoto']['error'] == UPLOAD_ERR_OK) {

      // retrieving older company logo name to delete it from folder in case of image update
      $q = "select * from product where productid=" . $productid;
      $result = execute($q);
      $row = mysqli_fetch_assoc($result);

      $realName = $_FILES['itemphoto']['name'];
      $tempName1 = $_FILES['itemphoto']['tmp_name'];
      $finalDatabaseName = time() . ".jpg";
      $destination = "../images/" . $finalDatabaseName;
      move_uploaded_file($tempName1, $destination);


      $query = "update product set image='$finalDatabaseName' where productid=$productid";
      if (execute($query)) {
         if (!empty($row['image']) && file_exists('../images/' . $row['image']))
            unlink('../images/' . $row['image']);
      }
   }

   $query = "update  product 
         set name='$name',
         total=$total,
         price=$price,
         description='$description',
         unit='$unit',
         categoryid='$categoryid' where productid='$productid'";
   // echo $query;
   if (execute($query))
      echo "true";
   else
      echo "false";

}