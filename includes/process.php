<?php
require('functions.php');
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

// user module server codes

if (isset($_POST['actionString']) && $_POST['actionString'] == "insertUsers") {
   $fullname = $_POST['fullname'];
   if (isset($_POST['purchase']))
      $purchase = 'true';
   else
      $purchase = 'false';
   if (isset($_POST['stock']))
      $stock = 'true';
   else
      $stock = 'false';
   if (isset($_POST['sale']))
      $sale = 'true';
   else
      $sale = 'false';
   if (isset($_POST['mazar']))
      $mazar = 'true';
   else
      $mazar = 'false';
   if (isset($_POST['thridfloor']))
      $thridfloor = 'true';
   else
      $thirdfloor = 'false';
   if (isset($_POST['firstfloor']))
      $firstfloor = 'true';
   else
      $firstfloor = 'false';
   if (isset($_POST['sarai']))
      $sarai = 'true';
   else
      $sarai = 'false';
   if (isset($_POST['transport']))
      $transport = 'true';
   else
      $transport = 'false';
   if (isset($_POST['report']))
      $report = 'true';
   else
      $report = 'false';
   if (isset($_POST['sarafi']))
      $sarafi = 'true';
   else
      $sarafi = 'false';
   $phone = $_POST['phone'];
   $password = $_POST['password'];
   $email = $_POST['email'];
   $description = $_POST['description'];
   $query = "insert into users (name,email,password,phone,description,purchase,stock,sarafi,transport,sarai,thirdfloor,firstfloor,report,mazar,sale) values('$name','$email','$phone','$description','$purchase','$stock','$sarafi','$transport','$sarai','$thirdfloor','$firstfloor','$report','$mazar','$sale')";
   if (execute($query))
      echo "true";
   else
      echo "false";
}




// customer authentiatcation 


if (isset($_POST['actionString']) && $_POST['actionString'] == 'loginCustomer') {
   $username = $_POST['username'];
   $password = $_POST['password'];
   $query = "select * from users inner join customer on customer.userid=users.userid where (username='$username' or email='$username') and password='$password' and privilage='customer' and status='enable' ";
   $result = mysqli_query($connection, $query);
   if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION['name'] = $row['name'];
      $_SESSION['surname'] = $row['surname'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['password'] = $row['password'];
      $_SESSION['customerid'] = $row['customerid'];
      $_SESSION['userid'] = $row['userid'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['address'] = $row['address'];
      $_SESSION['dob'] = $row['dob'];
      $_SESSION['privilage'] = $row['privilage'];
      $_SESSION['status'] = $row['status'];
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

// purchase server codes



if (isset($_POST['actionString']) && $_POST['actionString'] == 'viewPurchaseStatus') {

   $query = "select sum(totaldollerprice) as totaldollerpurchase from fabricpurchase";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totaldollerpurchase = $row['totaldollerpurchase'];
   freeResult($result);

   $query = "select sum(doller) as totaldollersubmit from draw";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totaldollersubmit = $row['totaldollersubmit'];
   freeResult($result);
   $balance = $totaldollerpurchase - $totaldollersubmit;

   $query = "select sum(totaldollerprice) as kldhmd from fabricpurchase inner join company on company.companyid=fabricpurchase.companyid
      where company.marka='KLD' or company.marka='HMD'";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $kldhmd = $row['kldhmd'];
   freeResult($result);
   $info = ['totaldollerprice' => $totaldollerpurchase, 'totaldollersubmit' => $totaldollersubmit, 'balance' => $balance, 'kldhmd' => $kldhmd];
   echo json_encode($info);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == 'insertPurchase') {
   $war = $_POST['war'];
   $meter = $_POST['meter'];
   $date = $_POST['date'];
   if (!isset($_POST['yenprice']))
      $yenprice = 0;
   else
      $yenprice = $_POST['yenprice'];


   if (!isset($_POST['yenexchange']))
      $yenexchange = 0;
   else
      $yenexchange = $_POST['yenexchange'];

   $bundle = $_POST['bundle'];
   $companyid = $_POST['companyid'];
   $fabricid = $_POST['fabricid'];
   $vendorcompany = $_POST['vendorcompany'];
   if (!isset($_POST['ttcomission']))
      $ttcomission = 0;
   else
      $ttcomission = $_POST['ttcomission'];

   $fabricpurchasecode = $_POST['fabricpurchasecode'];

   if (!isset($_POST['totalyenprice']))
      $totalyenprice = 0;
   else
      $totalyenprice = $_POST['totalyenprice'];

   $totaldollerprice = $_POST['totaldollerprice'];

   if (!isset($_POST['dollerprice']))
      $dollerprice = 0;
   else
      $dollerprice = $_POST['dollerprice'];
   $transportid = $_POST['transportcompany'];

   $finalDatabaseName1 = null;
   $finalDatabaseName2 = null;

   if (isset($_FILES['bankreceiptphoto']) && $_FILES['bankreceiptphoto']['error'] == UPLOAD_ERR_OK) {
      $realPersonName1 = $_FILES['bankreceiptphoto']['name'];
      $tempName1 = $_FILES['bankreceiptphoto']['tmp_name'];
      $finalDatabaseName1 = time() . ".jpg";
      $destination = "../images/" . $finalDatabaseName1;
      move_uploaded_file($tempName1, $destination);
   }
   if (isset($_FILES['packagephoto']) && $_FILES['packagephoto']['error'] == UPLOAD_ERR_OK) {
      $realPersonName2 = $_FILES['packagephoto']['name'];
      $tempName2 = $_FILES['packagephoto']['tmp_name'];
      $finalDatabaseName2 = time() . "1.jpg";
      $destination = "../images/" . $finalDatabaseName2;
      move_uploaded_file($tempName2, $destination);
   }

   $query = "insert into fabricpurchase (bundle,war,meter,yenprice,yenexchange,ttcommission,packagephoto,bankreceiptphoto,date,fabricid,companyid,vendorcompany,fabricpurchasecode,dollerprice,totaldollerprice,totalyenprice)  values ('$bundle','$war','$meter','$yenprice','$yenexchange','$ttcomission','$finalDatabaseName2','$finalDatabaseName1','$date','$fabricid','$companyid','$vendorcompany','$fabricpurchasecode','$dollerprice','$totaldollerprice','$totalyenprice');";
   $query .= "insert into transportdeal (fabricpurchaseid,transportid) values(last_insert_id(),$transportid);";
   if (mysqli_multi_query($connection, $query))
      echo "true";
   else
      echo "false";
   // } 
   // else 
   // {
//    $query = "insert into fabricpurchase (bundle,meter,war,yenprice,yenexchange,ttcommission,packagephoto,bankreceiptphoto,date,fabricid,companyid,vendorcompany,fabricpurchasecode)  values ('$bundle','$war','$meter','$yenprice','$yenexchange','$ttcomission','$finalDatabaseName2','null','$date','$fabricid','$companyid','$vendorcompany','$fabricpurchasecode')";
//   // echo $query;
//    if(mysqli_query($connection,$query))
//    echo "true";
//    else 
   // echo "false";
// }
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadFabricPurchase") {

   $query = "SELECT *,vendorcompany.name as vendor,fabric.name as fabricname from fabricpurchase inner join company on fabricpurchase.companyid=company.companyid
   inner join fabric on fabricpurchase.fabricid=fabric.fabricid inner join vendorcompany on vendorcompany.vendorcompanyid=fabricpurchase.vendorcompany";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = "<a href='fabricdesign.php?fabricpurchaseid=" . $rows['fabricpurchaseid'] . "' target='_blank'>" . $rows['fabricpurchasecode'] . "</a>";
      $row[] = $rows['vendor'];
      $row[] = $rows['bundle'];
      $row[] = $rows['fabricname'];
      $row[] = $rows['marka'];
      $row[] = $rows['meter'];
      $row[] = $rows['war'];
      $row[] = $rows['yenprice'];
      // $row[]=round(($rows['yenprice']*$rows['meter']),2);// total yen price
      $row[] = $rows['totalyenprice'];
      $row[] = $rows['yenexchange'];
      //   $dollerPrice=round(($rows ['yenprice']/$rows['yenexchange']),2);// doller price
      // $row[]=$dollerPrice;
      $row[] = $rows['dollerprice'];
      //  $row[]=round(($dollerPrice*$rows['meter']),2);// total doller price
      $row[] = $rows['totaldollerprice'];
      $row[] = $rows['ttcommission'];
      if ($rows['ttcommission'] != 0)
         $row[] = round(($rows['dollerprice'] + ($rows['ttcommission'] / $rows['meter'])), 2);
      else
         $row[] = $rows['dollerprice'];
      if ($rows['packagephoto'] == NULL)
         $row[] = "<img src='images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank'href='images/" . $rows['packagephoto'] . "'><img src='images/" . $rows['packagephoto'] . "' width='60px' height='60px'></a>";

      if ($rows['bankreceiptphoto'] == NULL)
         $row[] = "<img src='images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank' href='images/" . $rows['bankreceiptphoto'] . "'><img src='images/" . $rows['bankreceiptphoto'] . "' width='60px' height='60px'></a>";
      $button = "<button class='btn btn-sm  btn-warning mb-1  editButton fa fa-edit' value='" . $rows['fabricpurchaseid'] . "'></button>
         <button class='btn btn-sm btn-danger  deleteButton fa fa-trash' value='" . $rows['fabricpurchaseid'] . "'></button>";

      $row[] = $button;


      if ($rows['status'] == 'complete') {
         $row[] = "<span class='fa fa-check text-success'></span>";
      } else if ($rows['status'] == 'incomplete') {
         // checking the design status for this purchase
         $query = "SELECT count(fabricdesign.fabricdesignid) as count from fabricpurchase 
         inner join fabricdesign on fabricdesign.fabricpurchaseid=fabricpurchase.fabricpurchaseid where fabricdesign.status='incomplete' and fabricpurchase.fabricpurchaseid=" . $rows['fabricpurchaseid'];
         $result2 = execute($query);
         $rows2 = mysqli_fetch_assoc($result2);
         if ($rows2['count'] == 0) { // it means all the bundles are completed hence the fabricdesign status should be updated to complete
            $query = "UPDATE fabricpurchase set status='complete' where fabricpurchase.fabricpurchaseid=" . $rows['fabricpurchaseid'];
            if (execute($query))
               $row[] = "<span class='fa fa-check text-success'></span>";
         } else {
            $row[] = "<span class='fa fa-times text-danger'></span>";
         }
         freeResult($result2);
      }
      $html[] = $row;
   }
   echo json_encode($html);

}

// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'deletePurchase') {
   $purchaseid = $_POST['purchaseid'];
   $query = "delete from fabricpurchase where fabricpurchaseid=$purchaseid";
   if (execute($query))
      echo "true";
   else
      echo "false";
}


// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'viewPurchase') {

   $purchaseid = $_POST['purchaseid'];
   $query = "select * from fabricpurchase where fabricpurchaseid=$purchaseid";
   $result = mysqli_query($connection, $query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}


// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'updatePurchase') {
   $war = $_POST['war'];
   $meter = $_POST['meter'];
   $date = $_POST['date'];
   if (!isset($_POST['yenprice']))
      $yenprice = 0;
   else
      $yenprice = $_POST['yenprice'];


   if (!isset($_POST['yenexchange']))
      $yenexchange = 0;
   else
      $yenexchange = $_POST['yenexchange'];

   $bundle = $_POST['bundle'];
   $companyid = $_POST['companyid'];
   $fabricid = $_POST['fabricid'];
   $vendorcompany = $_POST['vendorcompany'];
   if (!isset($_POST['ttcomission']))
      $ttcomission = 0;
   else
      $ttcomission = $_POST['ttcomission'];

   $fabricpurchasecode = $_POST['fabricpurchasecode'];

   if (!isset($_POST['totalyenprice']))
      $totalyenprice = 0;
   else
      $totalyenprice = $_POST['totalyenprice'];

   $totaldollerprice = $_POST['totaldollerprice'];

   if (!isset($_POST['dollerprice']))
      $dollerprice = 0;
   else
      $dollerprice = $_POST['dollerprice'];
   $transportid = $_POST['transportcompany'];

   $finalDatabaseName1 = null;
   $finalDatabaseName2 = null;

   $fabricpurchaseid = $_POST['fabricpurchaseid'];

   // $realPersonName2 = $_FILES['packagephoto']['name'];
   // $tempName2 = $_FILES['packagephoto']['tmp_name'];
   // $finalDatabaseName2 = time()."1.jpg";
   // $destination = "../images/".$finalDatabaseName2;
   // move_uploaded_file($tempName2,$destination);
   // if(isset($_FILES['bankreceiptphoto']) && $_FILES['bankreceiptphoto']['error']==UPLOAD_ERR_OK)
   // {


   //    $realPersonName1 = $_FILES['bankreceiptphoto']['name'];
   //    $tempName1 = $_FILES['bankreceiptphoto']['tmp_name'];
   //    $finalDatabaseName1 = time().".jpg";
   //    $destination = "../images/".$finalDatabaseName1;
   //    move_uploaded_file($tempName1,$destination);


   // }
   $query = "update  fabricpurchase 
         set bundle=$bundle,
         meter=$meter,war=$war,
         yenprice=$yenprice,
         yenexchange=$yenexchange,
         ttcommission=$ttcomission,
         date='$date',
         fabricid='$fabricid',
         companyid='$companyid',
         vendorcompany='$vendorcompany',
         dollerprice='$dollerprice',
         totaldollerprice='$totaldollerprice',
         totalyenprice='$totalyenprice',
         fabricpurchasecode='$fabricpurchasecode' where fabricpurchaseid='$fabricpurchaseid'";
   $query2 = "update transportdeal set transportid='$transportid' where fabricpurchaseid='$fabricpurchaseid'";
   // echo $query;
   if (execute($query) && execute($query2))
      echo "true";
   else
      echo "false";

}





// design server codes
// design insert
if (isset($_POST['actionString']) && $_POST['actionString'] == 'insertFabricDesign') {
   $war = $_POST['war'];
   $toop = $_POST['toop'];
   $name = $_POST['name'];
   $fabricpurchaseid = $_POST['fabricpurchaseid'];
   $bundle = $_POST['bundle'];

   // if(isset($_FILES['designphoto']) && $_FILES['designphoto']['error']==UPLOAD_ERR_OK)
   // {
   //    $realPersonName1 = $_FILES['designphoto']['name'];
   //    $tempName1 = $_FILES['designphoto']['tmp_name'];
   //    $finalDatabaseName1 = time().".jpg";
   //    $destination = "../images/".$finalDatabaseName1;
   //    move_uploaded_file($tempName1,$destination);

   //    $query = "insert into fabricdesign (bundle,name,war,toop,fabricpurchaseid,designimage)  values ('$bundle','$name','$war','$toop','$fabricpurchaseid','$finalDatabaseName1')";
   //    if(execute($query))
   //    echo "true";
   //    else 
   //    echo "false";    
   // }
   // else 
   // {
   $query = "insert into fabricdesign (bundle,name,war,toop,fabricpurchaseid,designimage)  values ('$bundle','$name','$war','$toop','$fabricpurchaseid',NULL)";

   if (execute($query)) {
      $result = array('result' => 'true', 'name' => $name);
      echo json_encode($result);
   } else {
      $result = array('result' => 'false');

      echo json_encode($result);
   }
   // }
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "viewFabricDesign") {
   $fabricdesignid = $_POST['fabricdesignid'];
   $query = "select * from fabricdesign where fabricdesignid=$fabricdesignid";
   $result = mysqli_query($connection, $query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadExtraBundles") {
   $fabricpurchaseid = $_POST['fabricpurchaseid'];
   $query = "SELECT fabricpurchase.bundle-sum(fabricdesign.bundle) as bundle,fabricpurchase.war-sum(fabricdesign.war) as war from fabricpurchase inner join fabricdesign on fabricpurchase.fabricpurchaseid=fabricdesign.fabricpurchaseid where fabricpurchase.fabricpurchaseid=$fabricpurchaseid";
   $result = mysqli_query($connection, $query);
   $row = mysqli_fetch_assoc($result);
   freeResult($result);
   if ($row['bundle'] == '' || $row['war'] == '') {
      $query = "SELECT fabricpurchase.bundle,fabricpurchase.war from fabricpurchase where fabricpurchaseid=$fabricpurchaseid";
      $result = execute($query);
      $row = mysqli_fetch_assoc($result);
      freeResult($result);
      echo json_encode($row);
   } else
      echo json_encode($row);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == 'deleteFabricDesign') {
   $fabricdesignid = $_POST['fabricdesignid'];

   $query = "delete from fabricdesign where fabricdesignid='$fabricdesignid'";
   // echo $query;
   if (mysqli_query($connection, $query))
      echo "true";
   else
      echo "false";
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadFabricDesign") {
   $fabricpurchaseid = $_POST['fabricpurchaseid'];
   $query = "select *,fabricdesign.war as designwar,fabricdesign.toop as designtoop, fabricdesign.bundle as designbundle from fabricdesign inner join fabricpurchase on fabricpurchase.fabricpurchaseid=fabricdesign.fabricpurchaseid where fabricpurchase.fabricpurchaseid=$fabricpurchaseid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = "<a target='_blank' href='designbundle.php?fabricdesign=" . $rows['fabricdesignid'] . "'>" . $rows['name'] . "</a>";
      $row[] = $rows['designbundle'];
      $row[] = $rows['designwar'];
      $row[] = $rows['designtoop'];
      // collecting the colornames that are already added to this design
      $query = "select color.colorname from fabricdesigncolor inner join color on color.colorid=fabricdesigncolor.colorid where fabricdesigncolor.fabricdesignid=" . $rows['fabricdesignid'];
      $result2 = execute($query);
      $colors = "";
      while ($rows2 = mysqli_fetch_assoc($result2)):
         $colors .= $rows2['colorname'] . " ";
      endwhile;
      $row[] = $colors;
      freeResult($result2);
      // checking if image exist or not for the design
      if ($rows['designimage'] == NULL)
         $row[] = "<img src='images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank'href='images/" . $rows['designimage'] . "'><img src='images/" . $rows['designimage'] . "' width='60px' height='60px'></a>";

      $button = ""; // clearing the button variables
      // checking if the colors are added to the bundle or not
      if ($colors != "")
         $button = "<a class='btn btn-sm btn-secondary mr-1 text-white' href='designbundle.php?fabricdesignid=" . $rows['fabricdesignid'] . "'>بندل</a>";

      // checking if the toops are added to the bundles of the design or not
      $query = "select count(patidesigncolorid) as count from patidesigncolor inner join designbundle on designbundle.designbundleid=patidesigncolor.designbundleid where designbundle.fabricdesignid=" . $rows['fabricdesignid'];
      $result2 = execute($query);
      $rows2 = mysqli_fetch_assoc($result2);
      if ($rows2['count'] == 0) {
         $button .= "<a class='btn btn-sm btn-success mr-1 text-white'  href='designcolor.php?fabricdesignid=" . $rows['fabricdesignid'] . "'> رنگ</a>";
      } else {
         $button .= "<a class='btn btn-sm btn-success mr-1 text-white disabledColorButton' href='#'> رنگ</a>";
      }
      freeResult($result2);
      $button .= "
          <button class='btn btn-sm btn-warning mr-1 editButton' value='" . $rows['fabricdesignid'] . "'>تصحیح</button>
         <button class='btn btn-sm btn-danger mr-1 deleteButton' value='" . $rows['fabricdesignid'] . "'>حذف</button>";
      $row[] = $button; // adding the buttons



      if ($rows['status'] == 'complete') {
         $row[] = "<span class='fa fa-check text-success'></span>";
      } else if ($rows['status'] == 'incomplete') {
         // checking if the bundles for this design is completed
         $query = "SELECT count(designbundle.designbundleid) as count from fabricdesign 
         inner join designbundle on designbundle.fabricdesignid=fabricdesign.fabricdesignid where designbundle.status='incomplete' and fabricdesign.fabricdesignid=" . $rows['fabricdesignid'];
         $result2 = execute($query);
         $rows2 = mysqli_fetch_assoc($result2);
         if ($rows2['count'] == 0) { // it means all the bundles are completed hence the fabricdesign status should be updated to complete
            $query = "UPDATE fabricdesign set status='complete' where fabricdesign.fabricdesignid=" . $rows['fabricdesignid'];
            if (execute($query))
               $row[] = "<span class='fa fa-check text-success'></span>";
         } else {
            $row[] = "<span class='fa fa-times text-danger'></span>";
         }
         freeResult($result2);
      }

      $html[] = $row;
   }
   echo json_encode($html);

}


// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'updateFabricDesign') {

   $war = $_POST['war'];
   $bundle = $_POST['bundle'];
   $toop = $_POST['toop'];
   $name = $_POST['name'];
   $fabricdesignid = $_POST['fabricdesignid'];
   //  $fabricpurchaseid=$_POST['updatefabricpurchaseid'];

   if (isset($_FILES['designphoto']) && $_FILES['designphoto']['error'] == UPLOAD_ERR_OK) {
      // retrieving older company logo name to delete it from folder in case of image update
      $q = "select * from fabricdesign where fabricdesignid=" . $fabricdesignid;
      $result = mysqli_query($connection, $q);
      $row = mysqli_fetch_assoc($result);

      $realPersonName2 = $_FILES['designphoto']['name'];
      $tempName2 = $_FILES['designphoto']['tmp_name'];
      $finalDatabaseName2 = time() . "1.jpg";
      $destination = "../images/" . $finalDatabaseName2;
      move_uploaded_file($tempName2, $destination);

      $query = "update fabricdesign set photo='$finalDatabaseName2' where fabricdesignid=$fabricdesignid";
      if (mysqli_query($connection, $query)) {
         if (!empty($row['photo']) && file_exists('../images/' . $row['photo']))
            unlink('../images/' . $row['photo']);
      }
   }
   $query = "update  fabricdesign 
         set bundle=$bundle,
         war=$war,";
   //         fabricpurchaseid='$fabricpurchaseid',
   $query .= "toop='$toop',
         name='$name' where fabricdesignid='$fabricdesignid'";
   // echo $query;
   if (execute($query))
      echo "true";
   else
      echo "false";

}


// color server codes
// color insert
if (isset($_POST['actionString']) && $_POST['actionString'] == 'insertColor') {
   $name = $_POST['name'];
   $description = $_POST['description'];
   $query = "insert into fabriccolor (colorname,description)  values ('$name','$description')";
   //  echo $query;
   if (mysqli_query($connection, $query))
      echo "true";
   else
      echo "false";
}

if (isset($_POST['actionString']) && $_POST['actionString'] == 'deleteColor') {
   $fabriccolorid = $_POST['fabriccolorid'];
   $query = "delete from fabricdesigncolor where fabricdesigncolorid=$fabriccolorid";
   //  echo $query;
   if (mysqli_query($connection, $query))
      echo "true";
   else
      echo "false";
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadColor") {
   $query = "select * from fabriccolor";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['fabriccolorid'];
      $row[] = $rows['colorname'];
      $row[] = $rows['description'];
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['fabriccolorid'] . "'>تصحیح</button>
         <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['fabriccolorid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);

}




// designcolor server codes
if (isset($_POST["actionString"]) && $_POST["actionString"] == "loadFabricDesignColorColors") {

   $query = "select * from color";
   $result = execute($query);
   $html = "";
   while ($row = mysqli_fetch_assoc($result)) {
      $html .= "<div class='col-2'>
   <input class='form-check-input' type='checkbox' value='" . $row['colorid'] . "' name='checkbox" . $row['colorid'] . "'
      id='checkbox" . $row['colorid'] . "'>
   <label class='form-check-label' for='checkbox" . $row['colorid'] . "'>" . $row['colorname'] . "
   </label>
</div>";
   }
   echo $html;

}
// designcolor insert
if (isset($_POST['actionString']) && $_POST['actionString'] == 'insertNewColor') {
   $colorname = $_POST['colorname'];
   $query = "insert into color (colorname) values('$colorname')";
   execute($query);
   echo "true";
}
// designcolor insert
if (isset($_POST['actionString']) && $_POST['actionString'] == 'insertFabricDesignColor') {

   $data = json_decode($_POST['data'], true);
   // print_r($data);
   $fabricdesignid = $data[0]['value'];
   $userid = $_SESSION['userid'];
   $count = count($data);
   for ($i = 1; $i < $count; $i++) {
      $query = "insert into fabricdesigncolor (colorid,fabricdesignid,userid)  values ('" . $data[$i]['value'] . "','$fabricdesignid','$userid')";
      execute($query);
   }
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadFabricDesignColor") {
   $fabricdesignid = $_POST['fabricdesignid'];
   $query = "SELECt color.colorid,color.colorname,fabricdesigncolor.fabricdesigncolorid,fabricdesigncolor.photo from color 
   inner join fabricdesigncolor on color.colorid=fabricdesigncolor.colorid where fabricdesignid=$fabricdesignid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['colorname'];
      if ($rows['photo'] == null)
         $row[] = "<a target=_blank href='images/blank-image.png'><img src='images/blank-image.png' width=60px height=80px></a>";
      else
         $row[] = "<a target='_blank'href='images/" . $rows['photo'] . "'><img src='images/" . $rows['photo'] . "' width='60px' height='60px'></a>";
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['fabricdesigncolorid'] . "'>تصحیح</button>
         <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['fabricdesigncolorid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "viewFabricColor") {
   $fabricdesigncolorid = $_POST['fabricdesigncolorid'];
   $query = "select * from fabricdesigncolor where fabricdesigncolorid=$fabricdesigncolorid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}



// purchase server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == 'updateFabricDesignColor') {


   $colorid = $_POST['colorid'];
   $fabricdesigncolorid = $_POST['fabricdesigncolorid'];

   // if (isset($_FILES['colorphoto']) && $_FILES['colorphoto']['error'] == UPLOAD_ERR_OK) {
   //    // retrieving older company logo name to delete it from folder in case of image update
   //    $q = "select * from fabricdesigncolor where fabricdesigncolorid=" . $fabricdesigncolorid;
   //    $result = mysqli_query($connection, $q);
   //    $row = mysqli_fetch_assoc($result);

   //    $realPersonName2 = $_FILES['colorphoto']['name'];
   //    $tempName2 = $_FILES['colorphoto']['tmp_name'];
   //    $finalDatabaseName2 = time() . "1.jpg";
   //    $destination = "../images/" . $finalDatabaseName2;
   //    move_uploaded_file($tempName2, $destination);

   //    $query = "update fabricdesigncolor set photo='$finalDatabaseName2' where fabricdesigncolorid=$fabricdesigncolorid";
   //    if (mysqli_query($connection, $query)) {
   //       if (!empty($row['photo']) && file_exists('../images/' . $row['photo']))
   //          unlink('../images/' . $row['photo']);
   //    }
   // }
   $query = "update  fabricdesigncolor 
         set 
         colorid='$colorid' where fabricdesigncolorid='$fabricdesigncolorid'";
   if (execute($query))
      echo "true";
   else
      echo "false";

}



// item details





// stock server codes

if (isset($_POST['actionString']) && $_POST['actionString'] == "designList") {

   $fabricpurchaseid = $_POST['purchaseid'];
   $query = "select * from fabricpurchase 
      inner join fabricdesign on fabricpurchase.fabricpurchaseid=fabricdesign.fabricpurchaseid
      where fabricdesign.fabricpurchaseid='$fabricpurchaseid'";
   $result = execute($query);
   $html = "";
   while ($rows = mysqli_fetch_assoc($result)) {
      $html .= "<tr>";
      $html .= "<td>
                     <a target='_blank' href='createpati.php?fabricdesign=" . $rows['fabricdesignid'] . "'>" . $rows['name'] . "</a>
                     </td>";
      $html .= "<td>" . $rows['bundle'] . "</td>";
      $html .= "<td>" . $rows['war'] . "</td>";
      $html .= "<td>" . $rows['toop'] . "</td>";
      $query = "select count(distinct pati.patiid) as totalpaticount from pati inner join patidesigncolor on pati.patiid = patidesigncolor.patiid inner join fabricdesigncolor on fabricdesigncolor.fabricdesigncolorid=patidesigncolor.fabricdesigncolorid where fabricdesigncolor.fabricdesignid=" . $rows['fabricdesignid'];
      $result2 = execute($query);
      $row2 = mysqli_fetch_assoc($result2);
      $html .= "<td>" . $row2['totalpaticount'] . "</td>";
      freeResult($result2);

      $query = "select sum(patidesigncolor.war) as totalwarcount from pati inner join patidesigncolor on pati.patiid = patidesigncolor.patiid inner join fabricdesigncolor on fabricdesigncolor.fabricdesigncolorid=patidesigncolor.fabricdesigncolorid where fabricdesigncolor.fabricdesignid=" . $rows['fabricdesignid'];
      $result2 = execute($query);
      $row2 = mysqli_fetch_assoc($result2);
      $html .= "<td>" . $row2['totalwarcount'] . "</td>";

      freeResult($result2);
   }
   freeResult($result);
   if ($html == "")
      echo "<tr><td colspan=5><h3>هیچ نوع دیزانی موجود نیست</h3></td></tr>";
   else
      echo $html;
   freeResult($result);
}

// old one    
if (isset($_POST['actionString']) && $_POST['actionString'] == "createPati" && false) {

   // recieveing values
   $designid = $_POST['designid'];
   $fabricpurchaseid = $_POST['purchaseid'];
   // finding the last patiname
   $q = "SELECT patiname from pati order by patiid desc limit 1 ";
   //$r=mysqli_query($connection,$q);
   $r = execute($q);
   $rw = mysqli_fetch_assoc($r);
   $patiname = generatePatiId($rw['patiname']);
   freeResult($r);
   // checking if there exist any already existing pati for this design
   $q2 = "SELECT  count(patidesigncolorid) as  count from patidesigncolor 
   inner join fabricdesigncolor on fabricdesigncolor.fabricdesigncolorid=patidesigncolor.fabricdesigncolorid  
   inner join fabricdesign on fabricdesign.fabricdesignid=fabricdesigncolor.fabricdesignid where fabricdesign.fabricpurchaseid=$fabricpurchaseid and fabricdesign.fabricdesignid=$designid";
   $r2 = execute($q2);
   $rw2 = mysqli_fetch_assoc($r2);
   if ($rw2['count'] >= 0) {
      freeResult($r2);
      //echo $query;
      // inserting the new created pati and retrieving the patiid
      $patiInsertQuery = "insert into pati (patiname) values('$patiname');";
      if (execute($patiInsertQuery)) {
         // retrieving the pattid id of the inserted row
         $patiQuery = "SELECT * from pati order by patiid desc limit 1";
         $patiResult = execute($patiQuery);
         $patiRow = mysqli_fetch_assoc($patiResult);
         $patiid = $patiRow['patiid'];
         freeResult($patiResult);
         $retrieveQuery = "SELECT * from fabricdesigncolor 
   inner join fabriccolor on fabriccolor.fabriccolorid=fabricdesigncolor.fabriccolorid
   inner join fabricdesign on fabricdesign.fabricdesignid=fabricdesigncolor.fabricdesignid 
   where fabricdesign.fabricdesignid=$designid and fabricpurchaseid=$fabricpurchaseid";
         $result = execute($retrieveQuery);
         $insertQuery = "INSERT INTO patidesigncolor (fabricdesigncolorid,patiid) values";
         while ($r = mysqli_fetch_assoc($result)) {
            $insertQuery .= "('" . $r['fabricdesigncolorid'] . "','" . $patiid . "'),";
         }
         // replacing the last comma with semi colon in query;
         $insertQuery[strlen($insertQuery) - 1] = ";";
         //  echo $insertQuery;
         if (execute($insertQuery)) {
            // retrieving column names         
            $columnQuery = "SELECT colorname from fabricdesigncolor 
   inner join fabriccolor on fabriccolor.fabriccolorid=fabricdesigncolor.fabriccolorid
   inner join fabricdesign on fabricdesign.fabricdesignid=fabricdesigncolor.fabricdesignid 
   where fabricdesign.fabricdesignid=$designid and fabricpurchaseid=$fabricpurchaseid";
            $columnResult = execute($columnQuery);
            $html = "<tr>";
            $count = 0;
            //echo $columnQuery;
            while ($columnRows = mysqli_fetch_assoc($columnResult)) {

               $html .= "<td>" . $columnRows['colorname'] . "</td>";
               $count++;
            }
            freeResult($columnResult);
            $html .= "<td>توپ</td><td>کود</td><td></td></tr>
   <tr>";

            $displayQuery = "SELECT * from patidesigncolor inner join fabricdesigncolor on fabricdesigncolor.fabricdesigncolorid=patidesigncolor.fabricdesigncolorid inner join fabricdesign on fabricdesign.fabricdesignid=fabricdesigncolor.fabricdesignid inner join fabricpurchase on fabricpurchase.fabricpurchaseid=fabricdesign.fabricpurchaseid where fabricpurchase.fabricpurchaseid=$fabricpurchaseid and fabricdesign.fabricdesignid=$designid order by patidesigncolor.patidesigncolorid desc limit $count";
            $displayResult = execute($displayQuery);
            $patiid = "";
            //echo $displayQuery;
            while ($displayRow = mysqli_fetch_assoc($displayResult)) {
               $html .= "<td><form><input type='hidden' value='" . $displayRow['patidesigncolorid'] . "' class='patidesigncolorid'><input type='text' class='form-control warValue'></form></td>";
               $patiid = $displayRow['patiid'];
            }
            $html .= "<td>$count</td><td>$patiname</td><td><button value='$patiid' class='btn  deletePati'><i class='fa fa-times text-danger'></i></button></td></tr>";
            freeResult($displayResult);
            echo $html;
         }
      } else
         echo "نتوانتست که پتی ایجاد کند! ";
   } else {

      $query = "SELECT * from fabricdesigncolor 
      inner join fabriccolor on fabriccolor.fabriccolorid=fabricdesigncolor.fabriccolorid
      inner join fabricdesign on fabricdesign.fabricdesignid=fabricdesigncolor.fabricdesignid 
      where fabricdesign.fabricdesignid=$designid and fabricpurchaseid=$fabricpurchaseid";
      //echo $query;
      $result = execute($query);
      $html = "<tr>";
      $count = 0;
      while ($rows = mysqli_fetch_assoc($result)) {
         //   $html.="<td>".$rows['colorname']."</td>";
         $count++;
      }
      // $html.="<td>توپ</td><td>کود</td><td></td></tr><tr>";
      for ($i = 1; $i <= $count; $i++)
         $html .= "<td><input type='text'></td>";
      $html .= "<td>$count</td><td>$patiname</td><td><i class='fa fa-times text-danger'></i></td></tr>";
      freeResult($result);
      echo $html;
   }
}



// createpati page server codes


// update the toop in pati 
if (isset($_POST['actionString']) && $_POST['actionString'] == "updateToop") {
   $patiid = $_POST['patiid'];
   $toop = $_POST['toop'];
   $query = "update pati set toop=$toop where patiid=$patiid";
   if (execute($query))
      echo 'true';
   else
      echo 'false';
}


// update the war  of specific color in a specific pati 
if (isset($_POST['actionString']) && $_POST['actionString'] == "updateWar") {
   $patidesigncolorid = $_POST['patidesigncolorid'];
   $war = $_POST['war'];
   $query = "update patidesigncolor set war=$war where patidesigncolorid=$patidesigncolorid";
   if (execute($query))
      echo 'true';
   else
      echo 'false';
}

// inserting a new pati record into the table
if (isset($_POST['actionString']) && $_POST['actionString'] == "insertNewPati") {
   $value = explode(' ', $_POST['fabricdesignid']);
   $fabricdesignid = $value[0];
   $designbundleid = $value[1];
   // creating pati [ selecting the last pati created]

   $query = "SELECT patiname from pati order by patiid desc limit 1 ";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $patiname = generatePatiId($row['patiname']);
   freeResult($result);

   // retrieving the fabricdesigncolorid of the specific designid for inserting into the patidesigncolor table
   $query = "select * from fabricdesigncolor where fabricdesignid=$fabricdesignid";
   $result = execute($query);

   // inserting the newly created patiid
   $patiid = insertPati($patiname);
   $data = $result;
   foreach ($data as $value):
      // inserts the patiname into the pati table 
      $insertQuery = "INSERT into patidesigncolor (fabricdesigncolorid,patiid,designbundleid) values (" . $value['fabricdesigncolorid'] . ",$patiid,$designbundleid);";
      execute($insertQuery);
   endforeach;
   freeResult($result);
   // retrieving the information based on patiid
   $query = "select  *,pati.toop as patitoop,patidesigncolor.war as patiwar from pati 
  inner join patidesigncolor on patidesigncolor.patiid=pati.patiid
  inner join  fabricdesigncolor on fabricdesigncolor.fabricdesigncolorid=patidesigncolor.fabricdesigncolorid 
  inner join fabricdesign on fabricdesign.fabricdesignid=fabricdesigncolor.fabricdesignid
  inner join designbundle on designbundle.designbundleid=patidesigncolor.designbundleid
  where pati.patiid=$patiid and designbundle.designbundleid=$designbundleid order by fabricdesigncolor.colorname asc";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $html = "";
   $html .= "<tr class='patirow'><td>" . $row['patiname'] . "</td><td>" . $row['name'] . "</td><td>" . $row['bundlename'] . "</td><td><input type='hidden' class='patiid' value='" . $row['patiid'] . "'><input type='text' class='form-control toop'value='" . $row['patitoop'] . "'></td>";
   $patiid = $row['patiid'];

   $result = execute($query);
   while ($row = mysqli_fetch_assoc($result)) {
      $html .= "<td><input type='hidden' class='patidesigncolorid' value='" . $row['patidesigncolorid'] . "'> <input type='text' class='form-control patiwar' value='" . $row['patiwar'] . "'></td>";
   }
   $html .= "<td class='total'>0 </td><td class='btn btn-danger text-white deletePati' value='" . $patiid . "'>&times;</td></tr>";
   //echo $count;
   echo $html;
   freeResult($result);
}


// deleting pati record into the table
if (isset($_POST['actionString']) && $_POST['actionString'] == "deletePati") {
   $patiid = $_POST['patiid'];
   $query = "delete from pati where patiid=$patiid";
   if (execute($query))
      echo 'true';
   else
      echo 'false';
}




// sarai server codes

if (isset($_POST['actionString']) && $_POST['actionString'] == "insertSarai") {
   $name = $_POST['name'];
   $location = $_POST['location'];
   $description = $_POST['description'];
   $type = $_POST['type'];
   $phone = $_POST['phone'];
   $query = "insert into sarai  (name,location,description,type,phone) values('$name','$location','$description','$type','$phone')";
   if (execute($query))
      echo "true";
   else
      echo "false";
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadSarai") {
   $query = "select * from Sarai";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['saraiid'];
      $row[] = $rows['name'];
      $row[] = $rows['location'];
      $row[] = $rows['phone'];
      $row[] = $rows['description'];
      $row[] = $rows['type'];
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['saraiid'] . "'>تصحیح</button>
         <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['saraiid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);
   freeResult($result);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "deleteSarai") {
   $saraiid = $_POST['saraiid'];
   $query = "delete from sarai where saraiid=$saraiid";
   if (mysqli_query($connection, $query))
      echo "true";
   else
      echo "false";
}


// sarai out server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadSaraiOut") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   $query = "SELECT fabricpurchase.fabricpurchaseid,fabric.name,saraiindeal.indate,count(saraidesignbundle.designbundleid) as total from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
   where saraiindeal.saraiid=$saraiid and fabric.fabricid=$fabricid";
   $result = execute($query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['colorname'];
      $row[] = "<a target=_blank href='images/blank-image.png'><img src='images/blank-image.png' width=60px height=80px></a>";
      $row[] = "<a target='_blank'href='images/" . $rows['photo'] . "'><img src='images/" . $rows['photo'] . "' width='60px' height='60px'></a>";
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['fabricdesigncolorid'] . "'>تصحیح</button>
           <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['fabricdesigncolorid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);
   freeResult($result);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "saraiPageLoadOutBundle") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   if ($fabricid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT saraioutdeal.outdate,designbundle.*,sarai.name saraitoname,concat(customer.firstname,' ',customer.lastname) customername,brunch.name brunchname, fabricpurchase.fabricpurchasecode,saraiindeal.indate from fabric inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid 
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid 
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid 
   inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
   left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
   left join sarai on sarai.saraiid=saraioutdeal.saraito
   left join customerdeal on customerdeal.customerdealid=saraioutdeal.customerdealid
   left join customer on customer.customerid=customerdeal.customerid
   left join branchtransportdeal on branchtransportdeal.branchtransportdealid=saraioutdeal.branchtransportdealid
   left join brunch on brunch.brunchid=branchtransportdeal.branchid
   where saraiindeal.saraiid=$saraiid and (saraidesignbundle.status is not null or saraidesignbundle.saraioutdealid is not null) and fabric.fabricid=$fabricid";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['indate'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundlename'];
      $row[] = $rows['bundlewar'];
      $row[] = $rows['outdate'];
      $customername = $rows['customername'];
      $brunchname = $rows['brunchname'];
      $saraitoname = $rows['saraitoname'];
      if ($customername != '')
         $place = $customername;
      else if ($brunchname != '')
         $place = $brunchname;
      else if ($saraitoname != '')
         $place = $saraitoname;
      $row[] = $place;
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "saraiPageLoadInBundle") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   if ($fabricid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT fabricpurchase.fabricpurchasecode,designbundle.*,saraiindeal.indate from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
   where saraiindeal.saraiid=$saraiid  and saraidesignbundle.saraioutdealid is null and saraidesignbundle.status is null and fabric.fabricid=$fabricid";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['indate'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundlename'];
      $row[] = $rows['bundlewar'];
      $row[] = "";
      $row[] = "";
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "saraiPageLoadOutBundleDokan") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   if ($fabricid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT designbundle.*, fabricpurchase.fabricpurchasecode,saraiindeal.indate from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid 
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid 
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid 
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid 
   inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
   inner join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
   where saraiindeal.saraiid=$saraiid and (saraidesignbundle.status is not null or saraidesignbundle.saraioutdealid is not null) and fabric.fabricid=$fabricid";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['indate'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundlename'];
      $q = "SELECT count(pati.patiid) as paticount from pati 
      inner join patidesigncolor on pati.patiid=patidesigncolor.patiid 
      inner join designbundle on patidesigncolor.designbundleid=designbundle.designbundleid where designbundle.designbundleid=" . $rows['designbundleid'] . " group by pati.patiid";
      $patiResult = execute($q);
      $patiRow = mysqli_fetch_assoc($patiResult);
      freeResult($patiResult);
      $row[] = $patiRow["paticount"];
      $row[] = $rows['bundlewar'];
      $row[] = "";
      $row[] = "";
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "saraiPageLoadInBundleDokan") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   if ($fabricid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT fabricpurchase.fabricpurchasecode,designbundle.*,saraiindeal.indate,saraidesignbundle.saraidesignbundleid from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
   where saraiindeal.saraiid=$saraiid  and saraidesignbundle.saraioutdealid is null and saraidesignbundle.status is null and fabric.fabricid=$fabricid";
   $result = execute($query);
   $html = array();
   $i = 1;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['indate'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundlename'];
      $q = "SELECT ifnull(count(pati.patiid),0) as paticount from pati 
      inner join patidesigncolor on pati.patiid=patidesigncolor.patiid 
      inner join designbundle on patidesigncolor.designbundleid=designbundle.designbundleid where designbundle.designbundleid=" . $rows['designbundleid'] . " group by pati.patiid";
      $patiResult = execute($q);
      if (rowsReturn($patiResult) == 0) {
         $row[] = 0;
      } else {
         $patiRow = mysqli_fetch_assoc($patiResult);
         $row[] = $patiRow["paticount"];
      }
      freeResult($patiResult);
      $row[] = $rows['bundlewar'];
      $row[] = "<a class='btn btn-info createPati' value='" . $rows['saraidesignbundleid'] . "'>CreatePati</a>";
      if (isset($patiRow['paticount']))
         $row[] = "<span class='fa fa-check text-success'></span>";
      else
         $row[] = "<span class='fa fa-times text-danger'></span>";
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "saraiPageLoadOutPati") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   if ($fabricid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT saraioutdeal.outdate,designbundle.bundlename,pati.*,sarai.name saraitoname,concat(customer.firstname,' ',customer.lastname) customername,brunch.name brunchname, fabricpurchase.fabricpurchasecode,saraiindeal.indate from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid 
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid 
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid 
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid 
      inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
      inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
      inner join pati on pati.patiid=saraipati.patiid
      inner join saraioutdeal on saraioutdeal.saraioutdealid=saraipati.saraioutdealid
      left join sarai on sarai.saraiid=saraioutdeal.saraito
      left join customerdeal on customerdeal.customerdealid=saraioutdeal.customerdealid
      left join customer on customer.customerid=customerdeal.customerid
      left join branchtransportdeal on branchtransportdeal.branchtransportdealid=saraioutdeal.branchtransportdealid
      left join brunch on brunch.brunchid=branchtransportdeal.branchid
   where saraiindeal.saraiid=$saraiid  and fabric.fabricid=$fabricid";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['indate'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundlename'];
      $row[] = $rows['patiname'];
      $row[] = $rows['patiwar'];
      $row[] = $rows['outdate'];
      $customername = $rows['customername'];
      $brunchname = $rows['brunchname'];
      $saraitoname = $rows['saraitoname'];
      if ($customername != '')
         $place = $customername;
      else if ($brunchname != '')
         $place = $brunchname;
      else if ($saraitoname != '')
         $place = $saraitoname;
      $row[] = $place;
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "saraiPageLoadInPati") {
   $saraiid = $_POST['saraiid'];
   $fabricid = $_POST['fabricid'];
   if ($fabricid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT designbundle.bundlename,pati.*, fabricpurchase.fabricpurchasecode,saraiindeal.indate from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid 
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid 
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid 
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid 
      inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
      inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
      inner join pati on pati.patiid=saraipati.patiid
   where saraiindeal.saraiid=$saraiid  and fabric.fabricid=$fabricid and saraipati.saraioutdealid is null";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['indate'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundlename'];
      $row[] = $rows['patiname'];
      $row[] = $rows['patiwar'];
      $row[] = "";
      $row[] = "";
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

// loading bundles for selections
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadBundlesForSelection") {

   $saraiid = $_POST['saraiid'];
   $fabricpurchaseid = $_POST['fabricpurchaseid'];
   if ($fabricpurchaseid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "SELECT fabricdesign.*,designbundle.*,saraidesignbundle.* from fabricpurchase
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
   inner join fabricdesign on fabricdesign.fabricdesignid=designbundle.fabricdesignid
   where saraiindeal.saraiid=$saraiid  and saraidesignbundle.saraioutdealid is null and saraidesignbundle.status is null and fabricpurchase.fabricpurchaseid=$fabricpurchaseid";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['name'];
      $row[] = $rows['bundlename'];
      $row[] = $rows['bundlewar'];
      $row[] = "<input type='checkbox' class='form-control' value='" . $rows['name'] . " " . $rows['bundlename'] . " " . $rows['saraidesignbundleid'] . "' name='saraidesignbundleid'>";
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

// load fabricpurchase for in the sarai for the transfer form
if (isset($_POST['actionString']) && $_POST['actionString'] == "transferFormLoadFabricPurchase") {
   $saraiid = $_POST['saraiid'];
   $companyid = $_POST['companyid'];
   $query = "SELECT  fabricpurchase.* from company 
   inner join fabricpurchase on fabricpurchase.companyid=company.companyid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   where saraiindeal.saraiid=$saraiid and saraifabricpurchase.saraioutdealid is null and saraifabricpurchase.status is null and company.companyid=$companyid";
   $result = execute($query);
   $html = "";
   while ($row = mysqli_fetch_assoc($result)) {
      $html .= "<option value='" . $row['fabricpurchaseid'] . "'>" . $row['fabricpurchasecode'] . " بندل " . $row['bundle'] . "</option>";
   }
   freeResult($result);
   echo $html;
}

// transfer bundle server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == "transferBundles") {

   $processResults = array();
   /*
   the algorithm for transfering bundles from one to another
   1. each saraidesignbundleid should be check seperately
   2. it should check the designbundle belongs to which fabric in the specific sarai
   3. when moving the designbundle to the next sarai better to check if it is the last bundle in the sarai then the fabricpurchase status in saraifabricpurchase should be out
   4. checking if the bundle has any pati existed in the sarai, if yes then move those pati as well
   4. when moving the bundle to the next sarai, check if the fabricpurchase related to the bundle existed in the sarai or not, if not then insert it in saraifabricpurchase if yes and has not been outed then only add bundle to the destination sarai and if it had any pati then insert them as well into the new sarai
   */
   $userid = $_SESSION['userid'];

   $data = json_decode($_POST['data'], true);
   // print_r($data);
   $jowaliname = $data[0]['value'];
   $saraiid = $data[1]['value'];
   $saraitoid = $data[2]['value'];
   $marka = $data[3]['value'];
   $purchaseid = $data[4]['value'];
   $count = count($data);
   $date = date('y-m-d');
   $saraiDesignBundleIds = array();
   for ($i = 5; $i < $count; $i++)
      $saraiDesignBundleIds[] = $data[$i]['value']; // getting each saraidesignbundleid from the post request
   // print_r($saraiDesignBundleIds);
   // echo "<br>".$jowaliname."<br>".$saraitoid."</br>".$marka."<br>".$purchaseid;

   // inserting into saraioutdeal
   $outDealQuery = "insert into saraioutdeal (outdate,saraito,saraiid,person) values ('$date',$saraitoid,$saraiid,'$jowaliname');";
   execute($outDealQuery);
   // retrieving the lastest id 
   $getIdQuery = "select max(saraioutdealid) as id from saraioutdeal";
   $getIdResult = execute($getIdQuery);
   $getIdRow = mysqli_fetch_assoc($getIdResult);
   $saraiOutDealId = $getIdRow['id'];
   freeResult($getIdResult);


   //inserting into saraiinDeal and retrieving the id
   $inDealQuery = "insert into saraiindeal (indate,saraifrom,saraiid,person) values ('$date',$saraiid,$saraitoid,'$jowaliname');";
   execute($inDealQuery);
   // retrieving the lastest id
   $getIdQuery = "select max(saraiindealid) as id from saraiindeal";
   $getIdResult = execute($getIdQuery);
   $getIdRow = mysqli_fetch_assoc($getIdResult);
   $saraiInDealId = $getIdRow['id'];
   freeResult($getIdResult);

   foreach ($saraiDesignBundleIds as $saraiDesignBundleId) {

      outSaraiBundle($saraiOutDealId, $saraiDesignBundleId, $saraiid);
      inSaraiBundle($saraiDesignBundleId, $saraitoid, $saraiInDealId);
   }

}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadPrintViewSlip") {

   $html = "<h5 class='text-center'>دوکان رخت فروشی حاجی سید محمد<br><br>چک رسید
   مال<br><br>موبایل: 0795953838 - 0799242585- 0202101508</h5>";
   $userid = $_SESSION['userid'];
   $data = json_decode($_POST['data'], true);
   // print_r($data);
   $jowaliname = $data[0]['value'];
   $saraiid = $data[1]['value'];
   $saraitoid = $data[2]['value'];
   $marka = $data[3]['value'];
   $purchaseid = $data[4]['value'];
   $count = count($data);
   $date = date('y-m-d');
   $saraiDesignBundleIds = array();
   // sarai information
   $query = "select * from sarai where saraiid=" . $saraiid;
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $sarainame = $row['name'];
   freeResult($result);
   // marka information
   $query = "select * from company where companyid=" . $marka;
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $markaname = $row['marka'];
   freeResult($result);


   for ($i = 5; $i < $count; $i++)
      $saraiDesignBundleIds[] = $data[$i]['value'];

   // retrieving the bolak names
   $bolaknames = "";
   $count = 0;
   foreach ($saraiDesignBundleIds as $saraiDesignBundleId) {
      $query = "select designbundle.bundlename from designbundle inner join saraidesignbundle on saraidesignbundle.designbundleid=designbundle.designbundleid where saraidesignbundleid=" . $saraiDesignBundleId;
      $result = execute($query);
      $row = mysqli_fetch_assoc($result);
      $bolaknames .= " " . $row['bundlename'] . " ";
      freeResult($result);
      $count++;
   }
   $html .= "<p><span class='ml-5'>نمبر بل : </span><span class='mr-5'> تاریخ : " . $date . "</span></p>";
   $html .= "<p>اسم جوالی: " . $jowaliname . "</p>";
   $html .= "<p>اسم سرای : " . $sarainame . "</p>";
   $html .= "<p>مارکه : " . $markaname . "</p>";
   $html .= "<p>تعداد بولک : <input type='hidden' class='totalBundle' value='" . $count . "'><span class='totalBundleText'></span></p>";
   $html .= "<p>بولکها : " . $bolaknames . "</p>";
   $html .= "<h6 class='text-center'>مهر و امضأ:<br>نوت: رسید هذا بدون مهر و امضا مدار اعتبار نیست</h6>";
   echo $html;
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadSaraiMainTable") {
   $saraiid = $_POST['saraiid'];
   $html = "";
   $i = 1;
   $fabricQuery = "SELECT * from fabric";
   $fabricResult = execute($fabricQuery);
   while ($fabricRow = mysqli_fetch_assoc($fabricResult)):
      $totalQuery = "SELECT fabricpurchase.fabricpurchaseid,fabric.name,saraiindeal.indate,count(saraidesignbundle.designbundleid) as total from fabric 
      inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
      inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
      left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
      where saraiindeal.saraiid=$saraiid and fabric.fabricid=" . $fabricRow['fabricid'];
      $totalResult = execute($totalQuery);
      $totalRow = mysqli_fetch_assoc($totalResult);
      $html .= "<tr><td>$i</td><td>" . $fabricRow['name'] . "</td><td>" . $totalRow['indate'] . "</td><td>" . $totalRow['total'] . "</td>";

      $outQuery = "SELECT saraiindeal.indate,count(saraidesignbundle.designbundleid) as outbundle from fabric inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid where saraiindeal.saraiid=$saraiid and (saraidesignbundle.status is not null or saraidesignbundle.saraioutdealid is not null) and fabric.fabricid=" . $fabricRow['fabricid'];
      $outResult = execute($outQuery);
      $outRow = mysqli_fetch_assoc($outResult);
      $html .= "<td><button type='button' class='btn btn-danger outBundleButton' value='" . $fabricRow['fabricid'] . "' >" . $outRow['outbundle'] . "</button></td>";

      $inQuery = "SELECT fabric.name,saraiindeal.indate,count(saraidesignbundle.designbundleid) as inbundle from fabric 
      inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
      inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
      left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
      where saraiindeal.saraiid=$saraiid  and saraidesignbundle.saraioutdealid is null and saraidesignbundle.status is null and fabric.fabricid=" . $fabricRow['fabricid'];
      $inResult = execute($inQuery);
      $inRow = mysqli_fetch_assoc($inResult);
      $html .= "<td><button type='button' class='btn btn-success inBundleButton' value='" . $fabricRow['fabricid'] . "' >" . $inRow['inbundle'] . "</button></td>";
      //  $html.="<td><a target=_blank href='saraipageout.php?saraiid=$saraiid&fabricid=".$fabricRow['fabricid']."'><input type='button' class='btn btn-danger' value='خروج'></a></td>"; 
      freeResult($totalResult);
      freeResult($inResult);
      freeResult($outResult);
      $i++;
   endwhile;
   echo $html;

}

// loading pati in saraipage servercodes
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadSaraiMainTablePati") {
   $saraiid = $_POST['saraiid'];
   $html = "";
   $i = 1;
   $fabricQuery = "SELECT * from fabric";
   $fabricResult = execute($fabricQuery);
   while ($fabricRow = mysqli_fetch_assoc($fabricResult)):
      $totalBundleQuery = "SELECT fabric.name,saraiindeal.indate,count(saraidesignbundle.designbundleid) as totalbundle from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
   left join saraioutdeal on saraioutdeal.saraioutdealid=saraipati.saraioutdealid
   where saraiindeal.saraiid=$saraiid and fabric.fabricid=" . $fabricRow['fabricid'];
      $totalBundleResult = execute($totalBundleQuery);
      $totalBundleRow = mysqli_fetch_assoc($totalBundleResult);
      $html .= "<tr><td>$i</td><td>" . $fabricRow['name'] . "</td><td>" . $totalBundleRow['indate'] . "</td><td>" . $totalBundleRow['totalbundle'] . "</td>";
      $totalPatiQuery = "SELECT count(saraipati.patiid) as totalpati from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
   left join saraioutdeal on saraioutdeal.saraioutdealid=saraipati.saraioutdealid
   where saraiindeal.saraiid=$saraiid and fabric.fabricid=" . $fabricRow['fabricid'];
      $totalPatiResult = execute($totalPatiQuery);
      $totalPatiRow = mysqli_fetch_assoc($totalPatiResult);
      $html .= "<td>" . $totalPatiRow['totalpati'] . "</td>";

      $outQuery = "SELECT count(saraipati.patiid) as outpati from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
   inner join saraioutdeal on saraioutdeal.saraioutdealid=saraipati.saraioutdealid where saraiindeal.saraiid=$saraiid and fabric.fabricid=" . $fabricRow['fabricid'];
      $outResult = execute($outQuery);
      $outRow = mysqli_fetch_assoc($outResult);
      $html .= "<td><button type='button' class='btn btn-danger outPatiButton' value='" . $fabricRow['fabricid'] . "' >" . $outRow['outpati'] . "</button></td>";

      $inQuery = "SELECT count(saraipati.patiid) as inpati from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
   inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
   where  saraipati.saraioutdealid is null and saraiindeal.saraiid=$saraiid  and fabric.fabricid=" . $fabricRow['fabricid'];
      $inResult = execute($inQuery);
      $inRow = mysqli_fetch_assoc($inResult);
      $html .= "<td><button type='button' class='btn btn-success inPatiButton' value='" . $fabricRow['fabricid'] . "' >" . $inRow['inpati'] . "</button></td>";
      //  $html.="<td><a target=_blank href='saraipageout.php?saraiid=$saraiid&fabricid=".$fabricRow['fabricid']."'><input type='button' class='btn btn-danger' value='خروج'></a></td>"; 
      freeResult($totalPatiResult);
      freeResult($inResult);
      freeResult($outResult);
      freeResult($totalBundleResult);
      $i++;
   endwhile;
   echo $html;

}
// saraipage dokan server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadTotalBundleTableDokan") {
   $saraiid = $_POST['saraiid'];
   $html = "";
   $i = 1;
   $fabricQuery = "SELECT * from fabric";
   $fabricResult = execute($fabricQuery);
   while ($fabricRow = mysqli_fetch_assoc($fabricResult)):
      $totalQuery = "SELECT fabricpurchase.fabricpurchaseid,fabric.name,saraiindeal.indate,count(saraidesignbundle.designbundleid) as total from fabric 
      inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
      inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
      left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
      where saraiindeal.saraiid=$saraiid and fabric.fabricid=" . $fabricRow['fabricid'];
      $totalResult = execute($totalQuery);
      $totalRow = mysqli_fetch_assoc($totalResult);
      $html .= "<tr><td>$i</td><td>" . $fabricRow['name'] . "</td><td>" . $totalRow['indate'] . "</td><td>" . $totalRow['total'] . "</td>";
      $outQuery = "SELECT saraiindeal.indate,count(saraidesignbundle.designbundleid) as outbundle from fabric inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid where saraiindeal.saraiid=$saraiid and (saraidesignbundle.status is not null or saraidesignbundle.saraioutdealid is not null) and fabric.fabricid=" . $fabricRow['fabricid'];
      $outResult = execute($outQuery);
      $outRow = mysqli_fetch_assoc($outResult);
      $html .= "<td><button type='button' class='btn btn-danger outBundleButton' value='" . $fabricRow['fabricid'] . "' >" . $outRow['outbundle'] . "</button></td>";

      $inQuery = "SELECT fabric.name,saraiindeal.indate,count(saraidesignbundle.designbundleid) as inbundle from fabric 
      inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid
      inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid
      left join saraioutdeal on saraioutdeal.saraioutdealid=saraidesignbundle.saraioutdealid
      where saraiindeal.saraiid=$saraiid  and saraidesignbundle.saraioutdealid is null and saraidesignbundle.status is null and fabric.fabricid=" . $fabricRow['fabricid'];
      $inResult = execute($inQuery);
      $inRow = mysqli_fetch_assoc($inResult);
      $html .= "<td><button type='button' class='btn btn-success inBundleButton' value='" . $fabricRow['fabricid'] . "' >" . $inRow['inbundle'] . "</button></td>";
      //  $html.="<td><a target=_blank href='saraipageout.php?saraiid=$saraiid&fabricid=".$fabricRow['fabricid']."'><input type='button' class='btn btn-danger' value='خروج'></a></td>"; 
      freeResult($totalResult);
      freeResult($inResult);
      freeResult($outResult);
      $i++;
   endwhile;
   echo $html;

}
// loading bundles for selections
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadPatiForSelections") {

   $saraiid = $_POST['saraiid'];
   $fabricpurchaseid = $_POST['fabricpurchaseid'];
   if ($fabricpurchaseid == "") {
      $html = array();
      echo json_encode($html);
      return;
   }
   $query = "
   SELECT designbundle.bundlename,pati.*,saraipati.* from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid 
   inner join saraifabricpurchase on saraifabricpurchase.fabricpurchaseid=fabricpurchase.fabricpurchaseid 
      inner join saraiindeal on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid 
      inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid=saraifabricpurchase.saraifabricpurchaseid 
      inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
      inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
      inner join pati on pati.patiid=saraipati.patiid
   where saraiindeal.saraiid=$saraiid  and fabricpurchase.fabricpurchaseid=$fabricpurchaseid and saraipati.saraioutdealid is null";
   $result = execute($query);
   $html = array();
   $i = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['bundlename'];
      $row[] = $rows['patiname'];
      $row[] = $rows['patiwar'];
      $row[] = "<input type='checkbox' class='form-control' value='" . $rows['bundlename'] . " " . $rows['patiname'] . " " . $rows['saraipatidesigncolorid'] . "' name='saraipatidesigncolorid'>";
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);
   freeResult($result);
}

// transfer pati server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == "transferPati") {

   $processResults = array();

   $userid = $_SESSION['userid'];

   $data = json_decode($_POST['data'], true);
   // print_r($data);
   $jowaliname = $data[0]['value'];
   $saraiid = $data[1]['value'];
   $saraitoid = $data[2]['value'];
   $marka = $data[3]['value'];
   $purchaseid = $data[4]['value'];
   $count = count($data);
   $date = date('y-m-d');
   $saraiPatiDesignColorIds = array();
   for ($i = 5; $i < $count; $i++)
      $saraiPatiDesignColorIds[] = $data[$i]['value']; // getting each saraidesignbundleid from the post request
   // print_r($saraiPatiDesignColorIds);
   // echo "<br>".$jowaliname."<br>".$saraitoid."</br>".$marka."<br>".$purchaseid;
   // inserting into saraioutdeal
   $outDealQuery = "insert into saraioutdeal (outdate,saraito,saraiid,person) values ('$date',$saraitoid,$saraiid,'$jowaliname');";
   execute($outDealQuery);
   // retrieving the lastest id 
   $getIdQuery = "select max(saraioutdealid) as id from saraioutdeal";
   $getIdResult = execute($getIdQuery);
   $getIdRow = mysqli_fetch_assoc($getIdResult);
   $saraiOutDealId = $getIdRow['id'];
   freeResult($getIdResult);

   //inserting into saraiinDeal and retrieving the id
   $inDealQuery = "insert into saraiindeal (indate,saraifrom,saraiid,person) values ('$date',$saraiid,$saraitoid,'$jowaliname');";
   execute($inDealQuery);
   // retrieving the lastest id
   $getIdQuery = "select max(saraiindealid) as id from saraiindeal";
   $getIdResult = execute($getIdQuery);
   $getIdRow = mysqli_fetch_assoc($getIdResult);
   $saraiInDealId = $getIdRow['id'];
   freeResult($getIdResult);

   foreach ($saraiPatiDesignColorIds as $saraiPatiDesignColorId) {

      outSaraiPati($saraiPatiDesignColorId, $saraiid, $saraiOutDealId);
      inSaraiPati($saraiPatiDesignColorId, $saraiInDealId, $saraitoid);
   }

}



// customer page server codes
// loading customerlist dropdown select2 records for the begakpage
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerList") {
   $searchString = $_POST['term'];
   $query = "select * from customer where firstname like '%$searchString%' or lastname like '%$searchString%'";
   $result = execute($query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)):
      $row = array();
      $row['id'] = $rows['customerid'];
      $row['text'] = $rows['firstname'] . " " . $rows['lastname'];
      $html['results'][] = $row;
   endwhile;
   echo json_encode($html);
}
// loading customer list for the customer page
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerListCustomerPage") {
   $searchString = $_POST['searchString'];
   if ($searchString != '')
      $query = "select * from customer where firstname like '%$searchString%' or lastname like '%$searchString%'";
   else if ($searchString == "")
      $query = "select * from customer";
   $result = execute($query);
   $html = "";
   while ($rows = mysqli_fetch_assoc($result)):
      $customerid = $rows['customerid'];
      $q1 = "select sum(totalcost) as totalCostDoller from customerdeal where customerid=$customerid and currency='doller'";
      $r1 = execute($q1);
      $rw1 = mysqli_fetch_assoc($r1);
      $totalCostDoller = $rw1['totalCostDoller'];
      $q1 = "select sum(totalcost) as totalCostAfghani from customerdeal where customerid=$customerid and currency='afghani'";
      $r1 = execute($q1);
      $rw1 = mysqli_fetch_assoc($r1);
      $totalCostAfghani = $rw1['totalCostAfghani'];
      freeResult($r1);
      $q2 = "select sum(amountafghani) as paymentAfghani,sum(amountdoller) as paymentDoller from customerpayment where customerid=$customerid";
      $r2 = execute($q2);
      $rw2 = mysqli_fetch_assoc($r2);
      $paymentAfghani = $rw2['paymentAfghani'];
      $paymentDoller = $rw2['paymentDoller'];
      freeResult($r2);
      $dueDoller = $totalCostDoller - $paymentDoller;
      $dueAfghani = $totalCostAfghani - $paymentAfghani;
      $html .= "<tr>";
      $html .= "<td><button class='btn btn-sm btn-link customerName' value='" . $rows['customerid'] . "'>" . $rows['firstname'] . " " . $rows['lastname'] . "</button></td>";
      $html .= "<td class='text-sm '>$dueDoller</td>";
      $html .= "<td class='text-sm '>$dueAfghani</td>";
      $html .= "</tr>";
   endwhile;
   echo $html;
}


// loading customerDeal stats
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerDeal") {

   $customerid = $_POST['customerid'];
   $query = "select * from customer where customerid=$customerid";
   $html = array();
   $result = execute($query);
   $q1 = "select sum(if(currency='doller',totalcost,0)) as totalCostDoller,sum(if(currency='afghani',totalcost,0))   as totalCostAfghani from customerdeal where customerid=$customerid";
   $r1 = execute($q1);
   $rw1 = mysqli_fetch_assoc($r1);
   $totalCostAfghani = $rw1['totalCostAfghani'];
   $totalCostDoller = $rw1['totalCostDoller'];
   freeResult($r1);
   $q2 = "select sum(amountafghani) as paymentAfghani,sum(amountdoller) as paymentDoller from customerpayment where customerid=$customerid";
   $r2 = execute($q2);
   $rw2 = mysqli_fetch_assoc($r2);
   $paymentAfghani = $rw2['paymentAfghani'];
   $paymentDoller = $rw2['paymentDoller'];
   freeResult($r2);
   $dueDoller = $totalCostDoller - $paymentDoller;
   $dueAfghani = $totalCostAfghani - $paymentAfghani;

   $html['totalCostAfghani'] = $totalCostAfghani;
   $html['totalCostDoller'] = $totalCostDoller;
   $html['paymentDoller'] = $paymentDoller;
   $html['paymentAfghani'] = $paymentAfghani;
   $html['dueDoller'] = $dueDoller;
   $html['dueAfghani'] = $dueAfghani;
   // calculating all the sale module
   $query = "select sum(if(currency='doller',totalcost,0)) as totalDoller,sum(if(currency='afghani',totalcost,0)) as totalAfghani from customerdeal";
   $r3 = execute($query);
   $rw3 = mysqli_fetch_assoc($r3);
   $query = "select sum(amountafghani) as paymentAfghani,sum(amountdoller) as paymentDoller from customerpayment";
   $r4 = execute($query);
   $rw4 = mysqli_fetch_assoc($r4);
   freeResult($r3);
   freeResult($r4);
   $html['allTotalCostAfghani'] = $rw3['totalAfghani'];
   $html['allTotalCostDoller'] = $rw3['totalDoller'];
   $html['allPaymentAfghani'] = $rw4['paymentAfghani'];
   $html['allPaymentDoller'] = $rw4['paymentDoller'];
   $html['allDueAfghani'] = $rw3['totalAfghani'] - $rw4['paymentAfghani'];
   $html['allDueDoller'] = $rw3['totalDoller'] - $rw4['paymentDoller'];
   echo json_encode($html);
   //     if($totalcost==null)
   //       $html.="<td class='align-middle'>0</td>";
   //       else 
   //       $html.="<td class='align-middle'>".round($totalcost,3)."</td>";
   //       if($totalpayment==null)
   //       $html.="<td class='text-success align-middle'>0</td>";
   //       else 
   //       $html.="<td class='text-success align-middle'>".round($totalpayment,3)."</td>";
   //       if($duemoney==null)
   //       $html.="<td class='align-middle'>0</td>";
   //       else 
   //       $html.="<td class='text-danger  align-middle'>".round($duemoney,3)."</td>";
   //     $html.="</tr>";
   // if($html=="")
   // echo "موجود نیست";
   // else
   // echo $html;
}

if (isset($_POST['actionString']) && $_POST['actionString'] == 'loadAllCustomerDeal') {
   $html = array();
   // calculating all the sale module
   $query = "select sum(totalcostdoller) as totalDoller,sum(totalcostafghani) as totalAfghani from customerdeal";
   $r3 = execute($query);
   $rw3 = mysqli_fetch_assoc($r3);
   $query = "select sum(amountafghani) as paymentAfghani,sum(amountdoller) as paymentDoller from customerpayment";
   $r4 = execute($query);
   $rw4 = mysqli_fetch_assoc($r4);
   freeResult($r3);
   freeResult($r4);
   $html['allTotalCostAfghani'] = $rw3['totalAfghani'];
   $html['allTotalCostDoller'] = $rw3['totalDoller'];
   $html['allPaymentAfghani'] = $rw4['paymentAfghani'];
   $html['allPaymentDoller'] = $rw4['paymentDoller'];
   $html['allDueAfghani'] = $rw3['totalAfghani'] - $rw4['paymentAfghani'];
   $html['allDueDoller'] = $rw3['totalDoller'] - $rw4['paymentDoller'];
   echo json_encode($html);
}


// insert customer
if (isset($_POST['actionString']) && $_POST['actionString'] == "insertCustomer") {
   $userid = $_SESSION['userid'];
   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $province = $_POST['province'];
   $address = $_POST['address'];
   $phone = $_POST['phone'];
   $brunch = $_POST['brunch'];
   $query = "insert into customer
   (firstname,lastname,address,userid,brunch,province,phone)
   values('$firstname','$lastname','$address','$userid','$brunch','$province','$phone')";
   if (execute($query))
      echo "true";
   else
      echo "false";

}
// loadCustomerRecords
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerRecords") {

   $html = array();
   $customerid = $_POST['customerid'];
   if ($customerid == '') {
      echo json_encode($html);
      return;
   } else {
      $query = "select customerdealid as id,'فروش' as type,date,begaknumber,sum(if(currency='doller',totalcost,0))  as doller,sum(if(currency='afghani',totalcost,0)) as afghani from customerdeal where customerdeal.customerid=$customerid
   union all 
    select customerpaymentid,'رسید',date,'',amountdoller,amountafghani from customerpayment where customerpayment.customerid=$customerid order by date";
   }
   $result = execute($query);
   $html = array();
   $i = 1;
   $purchaseAfghani = 0;
   $purchaseDoller = 0;
   $paymentAfghani = 0;
   $paymentDoller = 0;
   $balanceDoller = 0;
   $balanceAfghani = 0;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['type'];
      $row[] = $rows['date'];
      $row[] = $rows['begaknumber'];
      $row[] = $rows['doller'];
      $row[] = $rows['afghani'];
      if ($rows['type'] == 'رسید') {
         $paymentAfghani += $rows['afghani'];
         $paymentDoller += $rows['doller'];
      } else if ($rows['type'] == 'فروش') {
         $purchaseDoller += $rows['doller'];
         $purchaseAfghani += $rows['afghani'];
      }
      $balanceDoller = $purchaseDoller - $paymentDoller;
      $balanceAfghani = $purchaseAfghani - $paymentAfghani;
      $row[] = $balanceDoller;
      $row[] = $balanceAfghani;
      $i++;
      $html[] = $row;
   }
   echo json_encode($html);

}

// loadCustomerRecords
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerPayment") {

   $html = array();
   $customerid = $_POST['customerid'];
   if ($customerid == '') {
      echo json_encode($html);
      return;
   } else {
      $query = " select * from customerpayment where customerpayment.customerid=$customerid order by date";
   }
   $result = execute($query);
   $html = array();
   $i = 1;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['date'];
      $row[] = $rows['amountdoller'];
      $row[] = $rows['amountafghani'];
      $row[] = $rows['person'];
      $row[] = $rows['description'];
      $row[] = "<button class='btn btn-warning fa fa-edit btn-sm customerPaymentEditButton' value=" . $rows['customerpaymentid'] . "></button>
              <button class='btn btn-danger fa fa-trash btn-sm customerPaymentDeleteButton' value=" . $rows['customerpaymentid'] . "></button>";
      $i++;
      $html[] = $row;
   }
   echo json_encode($html);

}
// loadCustomerPaymentInfo
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerPaymentInfo") {
   $customerpaymentid = $_POST['customerpaymentid'];
   $html = array();
   $query = " select * from customerpayment where customerpaymentid=$customerpaymentid";
   $result = execute($query);
   $rows = mysqli_fetch_assoc($result);
   echo json_encode($rows);

}
// updating customer payment record
if (isset($_POST['actionString']) && $_POST['actionString'] == "updateCustomerPayment") {
   $customerpaymentid = $_POST['customerpaymentid'];
   $type = $_POST['type'];
   $userid = $_SESSION['userid'];
   $amount = $_POST['amount'];
   $description = $_POST['description'];
   $person = $_POST['person'];
   if ($type == 'afghani')
      $query = "update  customerpayment set amountafghani='$amount',amountdoller='0',description='$description',person='$person' where customerpaymentid=$customerpaymentid";
   else if ($type == 'doller')
      $query = "update  customerpayment set amountdoller='$amount',amountafghani='0',description='$description',person='$person' where customerpaymentid=$customerpaymentid";
   if (execute($query))
      echo "true";
   else
      echo "false";

}

// delete customer payement
if (isset($_POST['actionString']) && $_POST['actionString'] == "deleteCustomerPayment") {
   $customerpaymentid = $_POST['customerpaymentid'];
   $query = "delete from customerpayment where customerpaymentid=$customerpaymentid";
   if (execute($query))
      echo "true";
   else
      echo "false";

}
// loadCustomerRecords
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadCustomerPurchase") {

   $html = array();
   $customerid = $_POST['customerid'];
   if ($customerid == '') {
      echo json_encode($html);
      return;
   } else {
      $query = " select * from customerdeal where customerdeal.customerid=$customerid order by date";
   }
   $result = execute($query);
   $html = array();
   $i = 1;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['date'];
      $row[] = $rows['begaknumber'];
      $row[] = $rows['totalcostdoller'];
      $row[] = $rows['totalcostafghani'];
      $row[] = $rows['totalwar'];
      $row[] = "<button class='btn btn-warning fa fa-edit btn-sm' value=" . $rows['customerdealid'] . "></button>
              <button class='btn btn-danger fa fa-trash btn-sm' value=" . $rows['customerdealid'] . "></button>";
      $i++;
      $html[] = $row;
   }
   echo json_encode($html);

}

// loading single customer informatoin
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadSingleCustomer") {
   $customerid = $_POST['customerid'];
   $query = "select * from customer where customerid=$customerid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   freeResult($result);
   echo json_encode($row);
}


// insert customer payment
if (isset($_POST['actionString']) && $_POST['actionString'] == "insertCustomerPayment") {
   $type = $_POST['type'];
   $userid = $_SESSION['userid'];
   $amount = $_POST['amount'];
   $description = $_POST['description'];
   $person = $_POST['person'];
   $customerid = $_POST['customerid'];
   $date = date('y-m-d');
   if ($type == 'afghani')
      $query = "insert into customerpayment
   (amountafghani,description,customerid,userid,person,date)
   values('$amount','$description','$customerid','$userid','$person','$date')";
   else if ($type == 'doller')
      $query = "insert into customerpayment
   (amountdoller,description,customerid,userid,person,date)
   values('$amount','$description','$customerid','$userid','$person','$date')";
   if (execute($query))
      echo "true";
   else
      echo "false";

}
// begak server codes
// load item name in begak
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadItemNameBegakForm") {
   $id = $_POST['id'];
   $id = explode(" ", $id);
   $saraiid = $id[0];
   $saraidesignbundleid = $id[1];
   $saraipatiid = $id[2];
   $query = "select fabric.name,designbundle.bundlewar as itemwar from fabric 
   inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid 
   inner join fabricdesign on fabricdesign.fabricpurchaseid=fabricpurchase.fabricpurchaseid
   inner join designbundle on designbundle.fabricdesignid=fabricdesign.fabricdesignid
   inner join saraidesignbundle on designbundle.designbundleid=saraidesignbundle.designbundleid where saraidesignbundle.saraidesignbundleid=$saraidesignbundleid";
   if ($saraipatiid != '') {
      $query = "select fabric.name,pati.patiwar as itemwar from fabric 
         inner join fabricpurchase on fabricpurchase.fabricid=fabric.fabricid 
         inner join fabricdesign on fabricdesign.fabricpurchaseid=fabricpurchase.fabricpurchaseid
         inner join designbundle on designbundle.fabricdesignid=fabricdesign.fabricdesignid
         inner join saraidesignbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
         inner join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
         inner join pati on pati.patiid=saraipati.patiid where saraipati.saraipatidesigncolorid=$saraipatiid";
   }
   //  echo $query;
   $result = execute($query);
   $returnValue = mysqli_fetch_assoc($result);
   echo json_encode($returnValue);

}
// add begak items
if (isset($_POST['actionString']) && $_POST['actionString'] == "addBegakItem") {
   $html = "";
   $i = $_POST['count'];
   $html .= "<tr><td class='rowNumber'>$i<input type='hidden' name='rowNumber$i' value='$i'></td><td><select class='form-control itemCode' name='itemCode$i'>";
   $query = "SELECT saraidesignbundle.saraidesignbundleid,saraipati.saraipatidesigncolorid,sarai.name as sarainame,sarai.saraiid,fabric.name as fabricname,fabricpurchase.fabricpurchasecode,designbundle.bundlename,designbundle.bundlewar,pati.patiname,pati.patiwar from sarai 
   inner join saraiindeal on saraiindeal.saraiid = sarai.saraiid
   inner join saraifabricpurchase on saraifabricpurchase.saraiindealid=saraiindeal.saraiindealid
   inner join fabricpurchase on fabricpurchase.fabricpurchaseid=saraifabricpurchase.fabricpurchaseid
   inner join fabric on fabric.fabricid=fabricpurchase.fabricid
   inner join saraidesignbundle on saraidesignbundle.saraifabricpurchaseid = saraifabricpurchase.saraifabricpurchaseid
   inner join designbundle on designbundle.designbundleid=saraidesignbundle.designbundleid
   left join saraipati on saraipati.saraidesignbundleid=saraidesignbundle.saraidesignbundleid
   left join pati on pati.patiid=saraipati.patiid
   where saraifabricpurchase.status is null and saraidesignbundle.saraioutdealid is null and saraipati.saraioutdealid is null and saraidesignbundle.status is null";
   $result = execute($query);
   while ($row = mysqli_fetch_assoc($result)):
      $html .= "<option value='" . $row['saraiid'] . " " . $row['saraidesignbundleid'] . " " . $row['saraipatidesigncolorid'] . "'>" . $row['sarainame'] . " " . $row['fabricname'] . " " . $row['fabricpurchasecode'] . " ";
      $html .= "بندل" . $row['bundlename'];
      $html .= "وار " . $row['bundlewar'];
      if (!is_null($row['patiname'])):
         $html .= " " . $row['patiname'] . "وار";
         $html .= " " . $row['patiwar'] . "پتی";
      endif;
      $html .= "</option>";
   endwhile;
   $html .= "</select>
   </td>
   <td><input type='text' class='form-control fabricname' name='fabricname$i'></td>
   <td><input type='text' class='form-control itemWar' name='itemWar$i'></td>
   <td><input type='text' class='form-control itemPrice' name='itemPrice$i'></td>
   <td><input type='text' class='form-control itemTotalPrice' name='itemTotalPrice$i'></td>
   <td><button class='btn btn-danger btn-sm deleteRowButton fa fa-trash' type='button'></button></td>
   </tr>";
   freeResult($result);
   echo $html;
}



// insert begakform
if (isset($_POST["actionString"]) && $_POST["actionString"] == 'insertBegak') {
   $data = json_decode($_POST['data'], true);
   /* algorithm for saving the begak number
   1.inserting the totalcost,due,payment,date,begaknumber into the customerdeal
   2.inserting the reference of customerdeal to saraioutdeal 
   3.retrieving the each row record of the begak seperately
   4.checking the item is pati or bundle
   5.updating each pati or bundle sarai record with saraioutdeal reference and the sale price 
   6.running the algorithm to change the status of saraibundle to out or saraifabricpurchase to out  
   */
   //print_r($data);
   $date = $shamsiDate->date("Y-m-d", false, false);
   $userid = $_SESSION['userid'];
   $count = count($data);
   $itemCount = ($count - 7) / 6;
   $begakNumber = $data[1]['value'];
   $customerid = $data[0]['value'];
   $currency = $data[2]['value'];
   // getting the values from the last part of the array and escapping items int he begak
   $index = ($itemCount * 6) + 3;
   $totalBegakPrice = $data[$index]['value'];
   $index++;
   $begakPayment = $data[$index]['value'];
   $index++;
   $begakDue = $data[$index]['value'];
   $index++;
   $begakDescription = $data[$index]['value'];
   $index++;
   // inserting customerdeal record
   $customerDealInsertQuery = "insert into customerdeal (customerid,totalcost,begaknumber,date,userid,currency,begakpayment,begakdue,description) values('$customerid','$totalBegakPrice','$begakNumber','$date','$userid','$currency','$begakPayment','$begakDue','$begakDescription')";
   // echo $customerDealInsertQuery;
   execute($customerDealInsertQuery);

   // retrieving the customerdealid
   $customerDealQuery = "select * from customerdeal where begaknumber='$begakNumber'";
   $customerDealResult = execute($customerDealQuery);
   $row = mysqli_fetch_assoc($customerDealResult);
   $customerDealId = $row['customerdealid'];
   freeResult($customerDealResult);

   // getting the row Item Values
   $index = 3;
   for ($i = 1; $i <= $itemCount; $i++) {
      $index++;
      $id = $data[$index]['value'];
      $id = explode(' ', $id);
      if (isset($id[2]) && $id[2] != '') {
         $saraiid = $id[0];
         $saraiPatiDesignColorId = $id[2];
         $index++;
         $fabricname = $data[$index]['value'];
         $index++;
         $war = $data[$index]['value'];
         $index++;
         $price = $data[$index]['value'];
         $index++;
         $totalPrice = $data[$index]['value'];
         $index++;
         // checking if the saraioutdeal record is inserted already for this begak  and for this sarai or not
         $checkSaraioutDealQuery = "select * from saraioutdeal where customerdealid=$customerDealId and saraiid=$saraiid";
         $checkSaraioutDealResult = execute($checkSaraioutDealQuery);
         $countRows = rowsReturn($checkSaraioutDealResult);
         // it means the record doesn't exist for this begak and sarai
         if ($countRows == 0) {
            $saraioutDealQuery = "insert into saraioutdeal (outdate,customerdealid,saraiid) values('$date','$customerDealId','$saraiid')";
            execute($saraioutDealQuery);

         }
         $checkSaraioutDealResult = execute($checkSaraioutDealQuery);
         $checkSaraioutDealRow = mysqli_fetch_assoc($checkSaraioutDealResult);
         $saraioutDealId = $checkSaraioutDealRow["saraioutdealid"];

         // outing the saraipati
         if ($currency == 'doller')
            $saraipatiQuery = "update saraipati set dollerprice=$price where saraipatidesigncolorid=$saraiPatiDesignColorId";
         else
            $saraipatiQuery = "update saraipati set afghaniprice=$price where saraipatidesigncolorid=$saraiPatiDesignColorId";
         freeResult($checkSaraioutDealResult);

         if (execute($saraipatiQuery))
            outSaraiPati($saraiPatiDesignColorId, $saraiid, $saraioutDealId);

      } else {
         $saraiid = $id[0];
         $saraiDesignBundleId = $id[1];
         $index++;
         $fabricname = $data[$index]['value'];
         $index++;
         $war = $data[$index]['value'];
         $index++;
         $price = $data[$index]['value'];
         $index++;
         $totalPrice = $data[$index]['value'];
         $index++;
         // checking if the saraioutdeal record is inserted already for this begak  and for this sarai or not
         $checkSaraioutDealQuery = "select * from saraioutdeal where customerdealid=$customerDealId and saraiid=$saraiid";
         $checkSaraioutDealResult = execute($checkSaraioutDealQuery);
         $countRows = rowsReturn($checkSaraioutDealResult);
         // it means the record doesn't exist for this begak and sarai
         if ($countRows == 0) {
            $saraioutDealQuery = "insert into saraioutdeal (outdate,customerdealid,saraiid) values('$date','$customerDealId','$saraiid')";
            execute($saraioutDealQuery);

         }

         $checkSaraioutDealResult = execute($checkSaraioutDealQuery);
         $checkSaraioutDealRow = mysqli_fetch_assoc($checkSaraioutDealResult);
         $saraioutDealId = $checkSaraioutDealRow["saraioutdealid"];

         // outing the saraidesignbundle
         if ($currency == 'doller')
            $saraiDesignBundleQuery = "update saraidesignbundle set dollerprice=$price where saraidesignbundleid=$saraiDesignBundleId";
         else
            $saraiDesignBundleQuery = "update saraipati set afghaniprice=$price where saraidesignbundleid=$saraiDesignBundleId";
         freeResult($checkSaraioutDealResult);
         if (execute($saraiDesignBundleQuery))
            outSaraiBundle($saraioutDealId, $saraiDesignBundleId, $saraiid);

      }
   }

   // finding the due
}

// tranportdeal server codes



// sarai server codes

if (isset($_POST['actionString']) && $_POST['actionString'] == "insertTranportDeal") {
   $containerno = $_POST['containerno'];
   $sdate = $_POST['sdate'];
   $edate = $_POST['edate'];
   $khat = $_POST['khat'];
   $khastcost = $_POST['khatprice'];
   $transportid = $_POST['transportid'];
   $fabricpurchaseid = $_POST['fabricpurchaseid'];
   $query = "insert into transportdeal
(startdate,arrivaldate,fabricpurchaseid,containerno,khatamount,costperkhat,transportid,status)
values('$sdate','$edate','$fabricpurchaseid','$containerno','$khat','$khastcost','$transportid','pending')";
   if (execute($query))
      echo "true";
   else
      echo "false";

}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadTransportDeal") {
   $query = "select *,transport.name as transportname,fabric.name as fabricname from transport
inner join transportdeal on transport.transportid = transportdeal.transportid
inner join fabricpurchase on fabricpurchase.fabricpurchaseid=transportdeal.fabricpurchaseid
inner join fabric on fabric.fabricid=fabricpurchase.fabricid
inner join company on company.companyid=fabricpurchase.companyid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['transportname'];
      $row[] = $rows['fabricname'];
      $row[] = $rows['marka'];
      $row[] = $rows['khatamount'];
      $row[] = $rows['costperkhat'];
      $row[] = $rows['khatamount'] * $rows['costperkhat'];
      $row[] = $rows['startdate'];
      $row[] = $rows['arrivaldate'];
      $row[] = $rows['containerno'];
      if ($rows['status'] == 'recieved') {
         $row[] = "<span class='fa fa-check text-success'></span>";
      } else {
         $row[] = "<span class='fa fa-times text-danger'></span>";
      }
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows[' transportdealid'] . "'>تصحیح</button>
<button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows[' transportdealid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);

}

// if(isset($_POST['actionString']) && $_POST['actionString']=="deleteTransportDeal")
// {
// $transportdealid=$_POST['transportdealid'];
// $query="delete from transportdeal where transportdealid=$transportdealid";
// if(mysqli_query($connection,$query))
// echo "true";
// else
// echo "false";
// }


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadPurchaseDetails") {
   $purchaseid = $_POST['purchaseid'];
   $query = "select * from fabricpurchase inner join fabric on fabric.fabricid=fabricpurchase.fabricid where
fabricpurchaseid=$purchaseid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadPurchaseDetailsForSarai") {
   $purchaseid = $_POST['purchaseid'];
   $query = "select fabricpurchase.*,fabric.name as fabricname,company.* from fabricpurchase inner join fabric on
fabric.fabricid=fabricpurchase.fabricid
inner join company on company.companyid=fabricpurchase.companyid where fabricpurchaseid=$purchaseid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}
//transferpati servercodes




if (isset($_POST['actionString']) && $_POST['actionString'] == "loadAllPati") {


   $query = "select * ,pati.toop as patitoop from pati inner join patidesigncolor on pati.patiid=patidesigncolor.patiid
inner join sarai on sarai.saraiid=pati.saraiid group by pati.patiname";
   $result = execute($query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['patiid'];
      $row[] = $rows['patiname'];
      $q = "select sum(war) as totalpatiwar from patidesigncolor where patiid=" . $rows['patiid'];
      $result2 = execute($q);
      $row2 = mysqli_fetch_assoc($result2);
      $row[] = $row2['totalpatiwar'];
      freeResult($result2);
      $row[] = $rows['name'];
      $button = "<button class='btn btn-sm btn-primary mb-1 upperShop' value='" . $rows[' patiid'] . "'>دوکان پایان</button>
<button class='btn btn-sm btn-danger mb-1 lowerShop' value='" . $rows[' patiid'] . "'>دوکان بالا</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);


}

if (isset($_POST['actionString']) && $_POST['actionString'] == "upperShop") {

   $patiid = $_POST['patiid'];
   $query = "update pati set saraiid=6 where patiid=$patiid";
   echo $query;
   if (execute($query))
      echo "true";
   else
      echo "false";

}

if (isset($_POST['actionString']) && $_POST['actionString'] == "lowerShop") {

   $patiid = $_POST['patiid'];
   $query = "update pati set saraiid=5 where patiid=$patiid";
   if (execute($query))
      echo "true";
   else
      echo "false";

}




// designbundle server codes

if (isset($_POST['actionString']) && $_POST['actionString'] == "insertDesignBundle") {
   $bundlename = $_POST['bundlename'];
   $bundletoop = $_POST['bundletoop'];
   $bundlewar = $_POST['bundlewar'];
   $fabricdesignid = $_POST['fabricdesignid'];
   $query = "insert into designbundle (bundlename,bundletoop,fabricdesignid,bundlewar)
values('$bundlename','$bundletoop','$fabricdesignid','$bundlewar')";
   if (execute($query))
      echo "true";
   else
      echo "false";

}


if (isset($_POST['actionString']) && $_POST['actionString'] == "loadRemainingBundleToop") {
   $fabricdesignid = $_POST['fabricdesignid'];
   $query = "SELECT fabricdesign.bundle-count(designbundle.designbundleid) as bundle, fabricdesign.toop-sum(designbundle.bundletoop) as toop from fabricdesign 
   inner join designbundle on fabricdesign.fabricdesignid=designbundle.fabricdesignid where fabricdesign.fabricdesignid=$fabricdesignid";
   $result = mysqli_query($connection, $query);
   $row = mysqli_fetch_assoc($result);
   freeResult($result);
   if ($row['bundle'] == '' || $row['toop'] == '') {
      $query = "SELECT fabricdesign.bundle as bundle,fabricdesign.toop as toop from fabricdesign where fabricdesignid=$fabricdesignid";
      $result = execute($query);
      $row = mysqli_fetch_assoc($result);
      freeResult($result);
      echo json_encode($row);
   } else
      echo json_encode($row);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "updateDesignBundle") {
   $designbundleid = $_POST['designbundleid'];
   $bundlename = $_POST['bundlename'];
   $bundletoop = $_POST['bundletoop'];
   $bundlewar = $_POST['bundlewar'];
   $query = " UPDATE  designbundle set bundlename='$bundlename',bundletoop='$bundletoop',bundlewar='$bundlewar' where designbundleid='$designbundleid'";
   if (execute($query))
      echo "true";
   else
      echo "false";

}
if (isset($_POST['actionString']) && $_POST['actionString'] == "completeButtonDesignBundle") {

   $designbundleid = $_POST["designbundleid"];
   $q = "SELECT sum(patidesigncolor.war) as bundlewar from patidesigncolor where designbundleid=$designbundleid";
   $result1 = execute($q);
   $row1 = mysqli_fetch_assoc($result1);
   freeResult($result1);
   $query = "update designbundle set status='complete',bundlewar=" . $row1['bundlewar'] . " where designbundleid=$designbundleid";
   if (execute($query))
      echo "true";
   else
      echo "false";
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "inCompleteButtonDesignBundle") {
   $designbundleid = $_POST["designbundleid"];
   $query = "update designbundle set status='incomplete' where designbundleid=$designbundleid";
   if (execute($query))
      echo "true";
   else
      echo "false";
}
if (isset($_POST['actionString']) && $_POST['actionString'] == "defaultButtonDesignBundle") {
   $designbundleid = $_POST["designbundleid"];
   $userid = $_SESSION['userid'];
   $designBundleQuery = "SELECT designbundle.*,fabricdesigncolor.*,color.colorname from designbundle inner join fabricdesign on designbundle.fabricdesignid=fabricdesign.fabricdesignid
   inner join fabricdesigncolor on fabricdesigncolor.fabricdesignid=fabricdesign.fabricdesignid
   inner join color on color.colorid=fabricdesigncolor.colorid
   where designbundle.designbundleid=" . $designbundleid;
   $result = execute($designBundleQuery);

   // obtaining the bundletoop,bundlewar,toopwar and iterationCount
   $designBundleRow = mysqli_fetch_assoc($result);
   $bundleWar = $designBundleRow["bundlewar"];
   $bundleToop = $designBundleRow["bundletoop"];
   $toopWar = round($bundleWar / $bundleToop, 1);
   $colorCount = rowsReturn($result);
   $iterationCount = $bundleToop / $colorCount;
   freeResult($result);
   // obtain colorids of the design
   $result = execute($designBundleQuery);
   while ($row = mysqli_fetch_assoc($result))
      $fabricdesigncolorids[] = $row['fabricdesigncolorid'];

   // iterating the insertion query for each color separtely   
   for ($i = 1; $i <= $iterationCount; $i++) {
      foreach ($fabricdesigncolorids as $fabricdesigncolorid) {
         $toopQuery = "insert into patidesigncolor (fabricdesigncolorid,war,designbundleid,userid)
            values('$fabricdesigncolorid','$toopWar','$designbundleid','$userid')";
         execute($toopQuery);
      }
   }
   echo "true";
}
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadDesignBundle") {
   $fabricdesignid = $_POST['fabricdesignid'];
   $query = "SELECT * from designbundle where designbundle.fabricdesignid=$fabricdesignid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['bundlename'];
      $row[] = $rows['bundletoop'];
      $row[] = $rows['bundlewar'];
      $button = '';
      $q = "SELECT sum(patidesigncolor.war) as bundlewar from patidesigncolor where designbundleid=" . $rows['designbundleid'];
      $result1 = execute($q);
      $row1 = mysqli_fetch_assoc($result1);
      freeResult($result1);
      $row[] = $row1['bundlewar'];
      $q = "SELECT count(fabricdesigncolorid) as count from fabricdesigncolor where fabricdesignid=$fabricdesignid";
      $result1 = execute($q);
      $row2 = mysqli_fetch_assoc($result1);
      freeResult($result1);
      if ($row2['count'] != 0) {
         $button .= "<a class='btn btn-sm btn-success mr-1 text-white' href='designtoop.php?designbundleid=" . $rows['designbundleid'] . "'> تفصیل توپ</a>";
      }
      //<a class='btn btn-sm btn-info mb-1 text-white' href='designpati.php?designbundleid=" . $rows['designbundleid'] . "&fabricdesignid=" . $fabricdesignid . "'> ایجاد پتی</a>

      if ($row1['bundlewar'] == '' && $rows['bundlewar'] != 0)
         $button .= "<button class='btn btn-sm btn-info mr-1 defaultButton' value='" . $rows['designbundleid'] . "'>توزیع</button>";
      if ($row1['bundlewar'] != '' && $rows['status'] == 'incomplete') {
         $button .= "<button class='btn btn-sm btn-secondary mr-1 completeButton' value='" . $rows['designbundleid'] . "'>تایید تکمیل</button>";
      }
      if ($rows['status'] == 'incomplete') {
         $button .= "<button class=' btn btn-sm btn-warning mr-1 editButton' value='" . $rows['designbundleid'] . "'>تصحیح</button>";
         $button .= "<button class='btn btn-sm btn-danger mr-1 deleteButton' value='" . $rows['designbundleid'] . "'>حذف</button>";
      }
      $row[] = $button;
      if ($rows["status"] == "complete") {
         $row[] = "<span class='fa fa-check text-success incompleteButton' value='" . $rows['designbundleid'] . "'></span>";
      } else if ($rows['status'] == 'incomplete') {
         $row[] = "<span class='fa fa-times text-danger'></span>";
      }
      $html[] = $row;
   }
   echo json_encode($html);

}

if (isset($_POST['actionString']) && $_POST['actionString'] == "deleteDesignBundle") {
   $designbundleid = $_POST['designbundleid'];
   $query = "delete from designbundle where designbundleid=$designbundleid";
   if (execute($query))
      echo "true";
   else
      echo "false";
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "viewDesignBundle") {
   $designbundleid = $_POST['designbundleid'];
   $query = "select * from designbundle  where designbundleid=$designbundleid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   freeResult($result);
   echo json_encode($row);
}


// designtoop server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadBundleToop") {
   $designbundleid = $_POST['designbundleid'];
   $query = "SELECT patidesigncolor.*,color.*,designbundle.status from designbundle 
   inner join patidesigncolor on 
   patidesigncolor.designbundleid=designbundle.designbundleid 
   inner join fabricdesigncolor on fabricdesigncolor.fabricdesigncolorid=patidesigncolor.fabricdesigncolorid 
   inner join color on color.colorid=fabricdesigncolor.colorid 
   where designbundle.designbundleid=$designbundleid";
   $result = mysqli_query($connection, $query);
   $html = array();
   $i = 1;
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $i;
      $row[] = $rows['war'];
      $row[] = $rows['colorname'];
      if ($rows['status'] == 'complete')
         $button = "<span class='fa fa-check text-success'></span>";
      else
         $button = "<button class=' btn btn-sm btn-warning mb-1 editButton' value='" . $rows['patidesigncolorid'] . "'>تصحیح</button><button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['patidesigncolorid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
      $i++;
   }
   echo json_encode($html);

}

// load remainingtoop and totoalwar toop records 
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadRemainingToopWar") {
   $designbundleid = $_POST['designbundleid'];
   $query = "SELECT designbundle.bundletoop-count(patidesigncolor.patidesigncolorid) as toop, sum(war) as war from designbundle inner join patidesigncolor on designbundle.designbundleid=patidesigncolor.designbundleid where designbundle.designbundleid=$designbundleid";
   $result = mysqli_query($connection, $query);
   $rows = mysqli_fetch_assoc($result);
   freeResult($result);
   if ($rows['war'] == '' || $rows['toop'] == '') {
      $query = "select designbundle.bundletoop as toop, 0 as war from designbundle";
      $result = execute($query);
      $row = mysqli_fetch_assoc($result);
      freeResult($result);
      echo json_encode($row);

   } else {
      echo json_encode($rows);
   }
}
// load remainingtoop and totoalwar toop records 
if (isset($_POST['actionString']) && $_POST['actionString'] == "insertBundleToop") {
   $designbundleid = $_POST['designbundleid'];
   $war = $_POST['toopWar'];
   $fabricdesigncolorid = $_POST['fabricdesigncolorid'];
   $query = "INSERT into patidesigncolor (designbundleid,war,fabricdesigncolorid) values ('$designbundleid','$war','$fabricdesigncolorid');";
   if (execute($query))
      echo "true";
   else
      echo "false";
}


// deleting the toop of a bundle
if (isset($_POST['actionString']) && $_POST['actionString'] == "deleteBundleToop") {
   $patidesigncolorid = $_POST['patidesigncolorid'];
   $query = "delete from patidesigncolor where patidesigncolorid=$patidesigncolorid;";
   if (execute($query))
      echo "true";
   else
      echo "false";
}



// updating the bundle toop
if (isset($_POST['actionString']) && $_POST['actionString'] == "updateBundleToop") {
   $patidesigncolorid = $_POST['patidesigncolorid'];
   $war = $_POST['war'];
   $fabricdesigncolorid = $_POST['fabricdesigncolorid'];
   $query = "UPDATE patidesigncolor set war='$war',fabricdesigncolorid='$fabricdesigncolorid' where patidesigncolorid='$patidesigncolorid'";
   if (execute($query))
      echo "true";
   else
      echo "false";
}

// viewing the bundletoop record for edit
if (isset($_POST['actionString']) && $_POST['actionString'] == "viewBundleToop") {
   $patidesigncolorid = $_POST['patidesigncolorid'];
   $query = "select * from patidesigncolor where patidesigncolorid=$patidesigncolorid;";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   freeResult($result);
   echo json_encode($row);
}

// sarafi server codes

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadSarafiDeposit") {
   $sarafiid = $_POST['sarafiid'];
   $query = "select deposit.*,users.name from deposit inner join users on users.userid=deposit.userid where
    deposit.sarafiid=$sarafiid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['depositid'];
      $row[] = $rows['date1'];
      $row[] = $rows['doller'];
      $row[] = $rows['name'];
      $row[] = $rows['description'];
      $button = "
    <button class='btn btn-sm btn-warning mb-1 editButton' value='" . $rows[' depositid'] . "'>تصحیح</button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows[' depositid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);

}


if (isset($_POST['actionString']) && $_POST['actionString'] == "insertSarafiDeposit") {
   $sarafiid = $_POST['sarafiid'];
   $doller = $_POST['doller'];
   $description = $_POST['description'];
   $date1 = $_POST['date1'];
   $userid = $_POST['userid'];
   $query = "insert into deposit (date1,doller,description,sarafiid,userid)
    values('$date1','$doller','$description','$sarafiid','$userid')";
   if (execute($query))
      echo "true";
   else
      echo "false";
}



if (isset($_POST['actionString']) && $_POST['actionString'] == "loadُSarafiDraw") {

   $sarafiid = $_POST['sarafiid'];
   $query = "select draw.*,vendorcompany.name as companyname,users.name from draw inner join sarafi on
    sarafi.sarafiid=draw.sarafiid left join vendorcompany on vendorcompany.vendorcompanyid=draw.companyid left join
    users on draw.userid=users.userid where sarafi.sarafiid=$sarafiid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['drawid'];
      $row[] = $rows['date1'];
      $row[] = $rows['yen'];
      $row[] = $rows['exchangerate'];
      $row[] = $rows['doller'];
      $row[] = $rows['companyname'];
      $row[] = $rows['name'];

      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows[' drawid'] . "'>تصحیح</button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows[' drawid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);

}


if (isset($_POST['actionString']) && $_POST['actionString'] == 'viewSarafiStatus') {

   $sarafiid = $_POST['sarafiid'];
   $query = "select sum(doller) as totaldeposit from deposit where sarafiid=$sarafiid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totaldeposit = $row['totaldeposit'];
   freeResult($result);

   $query = "select sum(doller) as totaldraw from draw where sarafiid=$sarafiid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totaldraw = $row['totaldraw'];
   freeResult($result);
   $balance = $totaldeposit - $totaldraw;


   $info = ['totaldeposit' => $totaldeposit, 'totaldraw' => $totaldraw, 'balance' => $balance];
   echo json_encode($info);
}








// transport pending server codes
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadPendingTransport") {
   $query = "SELECT transportdeal.*,fabricpurchase.fabricpurchasecode,fabricpurchase.war,container.name from saraiindeal
   inner join transportdeal on transportdeal.transportdealid=saraiindeal.transportdealid
    inner join transport on transport.transportid = transportdeal.transportid
    inner join fabricpurchase on fabricpurchase.fabricpurchaseid=transportdeal.fabricpurchaseid
    inner join container on container.transportdealid=transportdeal.transportdealid where saraiindeal.saraiid=14 order by transportdeal.status";
   $result = execute($query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['startdate'];
      $row[] = $rows['arrivaldate'];
      // $row[] = $rows['duration'];
      $currentDate = new DateTime(date('Y-m-d'));
      $givenDate = new DateTime($rows['startdate']);
      $interval = $givenDate->diff($currentDate);
      if ($currentDate < $givenDate)
         $row[] = "-" . $interval->d;
      else if ($currentDate > $givenDate)
         $row[] = "+" . $interval->d;
      else if ($currentDate == $givenDate)
         $row[] = $interval->d;
      $row[] = $rows['name'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundle'];
      //$value=$rows['totalcost']/$rows['war'];
      // $row[]=round($value,2);//costperwar
      $row[] = $rows['warcost'];
      $row[] = $rows['khatamount'];
      $value = $rows['khatamount'] / $rows['bundle'];
      $row[] = round($value, 2); // amount of khat per bundle
      $row[] = $rows['costperkhat'];
      $row[] = $rows['totalcost']; // total cost
      $button = "";
      if ($rows['status'] == 'pending')
         $button = "<button class='btn btn-sm btn-primary mb-1 rasidButton' value='" . $rows['transportdealid'] . "'>رسید</button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton fa fa-trash' value='" . $rows['transportdealid'] . "'></button>";
      $row[] = $button;
      if ($rows['status'] == 'Recieved')
         $row[] = "<span class='fa fa-check text-success'></span>";
      else
         $row[] = "<span class='fa fa-times text-danger'></span>";
      $html[] = $row;
   }
   // print_r($html);
   echo json_encode($html);
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "changeTransportDealStatus") {
   $id = $_POST['transportdealid'];
   $date = date('Y-m-d');
   $query = "update transportdeal set status='Recieved', arrivaldate='$date' where transportdealid=$id";
   //echo $query;
   if (execute($query))
      echo "true";
   else
      echo "false";
   syncPurchaseDetailsInSarai($id);
}

// transportdeal servercodes



if (isset($_POST['actionString']) && $_POST['actionString'] == "insertTransportDeal") {

   $bundle = $_POST['bundle'];
   $khatprice = $_POST['khatprice'];
   $khatamount = $_POST['khatamount'];
   $date1 = $_POST['date1'];
   $purchaseid = $_POST['purchaseid'];
   $containerno = $_POST['containerno'];
   $transportid = $_POST['transportid'];
   $saraiid = $_POST['saraiid'];
   $totalcost = $_POST['totalprice'];
   $warprice = $_POST['warprice'];
   $containerno = $_POST['containerno'];

   // $totalcost=$khatamount*$khatprice;
   $query = "insert into transportdeal
    (startdate,fabricpurchaseid,khatamount,costperkhat,transportid,bundle,totalcost,warcost)
    values('$date1','$purchaseid','$khatamount','$khatprice','$transportid','$bundle','$totalcost','$warprice')";
   if (execute($query)):
      $query = "select transportdealid from transportdeal where transportid=$transportid order by transportdealid desc limit
    1";
      $result = execute($query);
      $row = mysqli_fetch_assoc($result);
      freeResult($result);
      $query = "insert into container (name,transportdealid) values('$containerno','" . $row['transportdealid'] . "');";
      execute($query);
      $query = "insert into saraiindeal (saraiid,transportdealid) values('$saraiid','" . $row['transportdealid'] . "');";
      execute($query);
      echo 'true';
   else:
      echo "false";
   endif;
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "updateTransportDeal") {

   $transportdealid = $_POST['transportdealid'];
   $bundle = $_POST['bundle'];
   $khatprice = $_POST['khatprice'];
   $khatamount = $_POST['khatamount'];
   $date1 = $_POST['date1'];
   $purchaseid = $_POST['purchaseid'];
   $containerno = $_POST['containerno'];
   $transportid = $_POST['transportid'];
   $saraiid = $_POST['saraiid'];
   $totalcost = $_POST['totalprice'];
   $warprice = $_POST['warprice'];
   $containerno = $_POST['containerno'];

   // $totalcost=$khatamount*$khatprice;
   $query = "update transportdeal set
    startdate='$date1',fabricpurchaseid='$purchaseid',khatamount='$khatamount',costperkhat='$khatprice',bundle='$bundle',totalcost='$totalcost',warcost='$warprice'
    where transportdealid='$transportdealid'";

   if (execute($query)):
      // checking if container number exist
      $query = "select containerid from container inner join transportdeal on
    transportdeal.transportdealid=container.transportdealid where transportdeal.transportdealid=$transportdealid";

      $result = execute($query);
      $count = rowsReturn($result);
      freeResult($result);
      if ($count != 0)
         $query = "update container set name='$containerno' where transportdealid='$transportdealid'";
      else
         $query = "insert into container (name,transportdealid) values('$containerno','$transportdealid')";
      execute($query);
      // checking if sarai is choosen

      $query = "select saraiid from saraiindeal inner join transportdeal on
    transportdeal.transportdealid=saraiindeal.transportdealid where saraiindeal.transportdealid=$transportdealid";

      $result = execute($query);
      $count = rowsReturn($result);
      freeResult($result);
      if ($count != 0)
         $query = "update saraiindeal set saraiid='$saraiid' where transportdealid='$transportdealid'";
      else
         $query = "insert into saraiindeal (saraiid,transportdealid) values('$saraiid','$transportdealid');";
      execute($query);
      echo 'true';
   else:
      echo "false";
   endif;
}
if (isset($_POST['actionString']) && $_POST['actionString'] == "loadTransportDeal2") {
   $transportid = $_POST['transportid'];
   $query = "select transportdeal.*,fabricpurchase.fabricpurchasecode,fabricpurchase.war,container.name from
    transportdeal inner join transport on transport.transportid = transportdeal.transportid
    inner join fabricpurchase on fabricpurchase.fabricpurchaseid=transportdeal.fabricpurchaseid
    left join container on container.transportdealid=transportdeal.transportdealid where
    transport.transportid=$transportid";
   $result = execute($query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['startdate'];
      $row[] = $rows['arrivaldate'];
      // $row[] = $rows['duration'];
      // $row[] = $rows['duration'];
      $currentDate = new DateTime($rows['arrivaldate']);
      $givenDate = new DateTime($rows['startdate']);
      $interval = $givenDate->diff($currentDate);
      if ($currentDate < $givenDate)
         $row[] = "-" . $interval->d;
      else if ($currentDate > $givenDate)
         $row[] = "+" . $interval->d;
      else if ($currentDate == $givenDate)
         $row[] = $interval->d;
      $row[] = $rows['name'];
      $row[] = $rows['fabricpurchasecode'];
      $row[] = $rows['bundle'];
      //$value=$rows['totalcost']/$rows['war'];
      // $row[]=round($value,2);//costperwar
      $row[] = $rows['warcost'];
      $row[] = $rows['khatamount'];
      if ($rows['bundle'] != 0)
         $value = $rows['khatamount'] / $rows['bundle'];
      else
         $value = 0;
      $row[] = round($value, 2); // amount of khat per bundle
      $row[] = $rows['costperkhat'];
      $row[] = $rows['totalcost']; // total cost
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton fa fa-edit' value='" . $rows['transportdealid'] . "'></button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton fa fa-trash' value='" . $rows['transportdealid'] . "'></button>";
      $row[] = $button;
      if ($rows['status'] == 'Recieved') {
         $row[] = "<span class='fa fa-check text-success'></span>";
      } else {
         $row[] = "<span class='fa fa-times text-danger'></span>";
      }
      $html[] = $row;
   }
   // print_r($html);
   echo json_encode($html);
}

// delete transportdeal
if (isset($_POST['actionString']) && $_POST['actionString'] == 'deletetransportdeal') {
   $transportdealid = $_POST['transportdealid'];
   $query = "delete from transportdeal where transportdealid=$transportdealid";
   if (execute($query))
      echo "true";
   else
      echo "false";
}
// view transportdeal for editing

if (isset($_POST['actionString']) && $_POST['actionString'] == 'viewTransportDeal') {
   $transportdealid = $_POST['transportdealid'];
   $query = "select transportdeal.*,saraiindeal.saraiid,container.name from transportdeal
    left join saraiindeal on transportdeal.transportdealid=saraiindeal.transportdealid
    left join container on container.transportdealid=transportdeal.transportdealid where
    transportdeal.transportdealid=$transportdealid";

   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   echo json_encode($row);
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "insertRasidatTransport") {
   $transportid = $_POST['transportid'];
   $date1 = $_POST['date1'];
   $person = $_POST['person'];
   $amount = $_POST['amount'];
   $query = "insert into transportpayment (date1,person,amount,transportid)
    values('$date1','$person','$amount','$transportid')";
   if (execute($query))
      echo "true";
   else
      echo "false";
}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadRasidatTransport") {
   $transportid = $_POST['transportid'];
   $query = "select * from transport inner join transportpayment on transport.transportid=transportpayment.transportid
    where transport.transportid=$transportid";
   $result = execute($query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['transportpaymentid'];
      $row[] = $rows['date1'];
      $row[] = $rows['person'];
      $row[] = $rows['amount'];
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['transportpaymentid'] . "'>تصحیح</button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows['transportpaymentid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   // print_r($html);
   echo json_encode($html);
}



if (isset($_POST['actionString']) && $_POST['actionString'] == "deleteRasidatTransport") {
   $transportpaymentid = $_POST['transportpaymentid'];
   $query = "delete from transportpayment where transportpaymentid='$transportpaymentid'";
   if (execute($query))
      echo "true";
   else
      echo "false";
}


if (isset($_POST['actionString']) && $_POST['actionString'] == "viewTransportStatus") {

   $transportid = $_POST['transportid'];
   $query = "select sum(totalcost) as totalcost from transportdeal where transportid=$transportid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totalcost = $row['totalcost'];
   freeResult($result);

   $query = "select sum(amount) as totalpayment from transportpayment where transportid='$transportid'";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totalpayment = $row['totalpayment'];
   freeResult($result);
   $duemoney = $totalcost - $totalpayment;

   $query = "select sum(bundle) as duebundle from transportdeal where transportid='$transportid' and status!='pending'";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $duebundle = $row['duebundle'];
   freeResult($result);

   $query = "select sum(bundle) as bundlecount from transportdeal where transportid='$transportid'";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $bundlecount = $row['bundlecount'];
   freeResult($result);

   $info = ['totalmoney' => $totalcost, 'bundlecount' => $bundlecount, 'duebundle' => $duebundle, 'paidmoney' => $totalpayment, 'duemoney' => $duemoney];
   echo json_encode($info);
}




// vendorcompany servercodes

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadVendorCompanyPurchase") {
   $vendorcompanyid = $_POST['vendorcompanyid'];
   $query = "SELECT *,vendorcompany.name as vendor,fabric.name as fabricname from fabricpurchase inner join company on
    fabricpurchase.companyid=company.companyid
    inner join fabric on fabricpurchase.fabricid=fabric.fabricid inner join vendorcompany on
    vendorcompany.vendorcompanyid=fabricpurchase.vendorcompany
    where vendorcompany.vendorcompanyid=$vendorcompanyid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = "<a href='fabricdesign.php?fabricpurchaseid=" . $rows[' fabricpurchaseid'] . "' target='_blank'>" . $rows
      ['fabricpurchasecode'] . "</a>";
      $row[] = $rows['vendor'];
      $row[] = $rows['bundle'];
      $row[] = $rows['fabricname'];
      $row[] = $rows['marka'];
      $row[] = $rows['meter'];
      $row[] = $rows['war'];
      $row[] = $rows['yenprice'];
      // $row[]=round(($rows['yenprice']*$rows['meter']),2);// total yen price
      $row[] = $rows['totalyenprice'];
      $row[] = $rows['yenexchange'];
      // $dollerPrice=round(($rows ['yenprice']/$rows['yenexchange']),2);// doller price
      // $row[]=$dollerPrice;
      $row[] = $rows['dollerprice'];
      // $row[]=round(($dollerPrice*$rows['meter']),2);// total doller price
      $row[] = $rows['totaldollerprice'];
      $row[] = $rows['ttcommission'];
      if ($rows['ttcommission'] != 0)
         $row[] = round(($rows['dollerprice'] + ($rows['ttcommission'] / $rows['meter'])), 2);
      else
         $row[] = $rows['dollerprice'];
      if ($rows['packagephoto'] == NULL)
         $row[] = "<img src='images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank' href='images/" . $rows[' packagephoto'] . "'><img src='images/" . $rows[' packagephoto'] . "'
            width='60px' height='60px'></a>";

      if ($rows['bankreceiptphoto'] == NULL)
         $row[] = "<img src='images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank' href='images/" . $rows[' bankreceiptphoto'] . "'><img src='images/" . $rows['
            bankreceiptphoto'] . "' width='60px' height='60px'></a>";
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows['
        fabricpurchaseid'] . "'>تصحیح</button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows[' fabricpurchaseid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);

}

if (isset($_POST['actionString']) && $_POST['actionString'] == "loadVendorCompanyRasidat") {
   $vendorcompanyid = $_POST['vendorcompanyid'];
   $query = "select draw.*,vendorcompany.name as companyname,sarafi.fullname as sarafname from draw inner join sarafi on
    sarafi.sarafiid=draw.sarafiid inner join vendorcompany on vendorcompany.vendorcompanyid=draw.companyid where
    vendorcompany.vendorcompanyid=$vendorcompanyid";
   $result = mysqli_query($connection, $query);
   $html = array();
   while ($rows = mysqli_fetch_assoc($result)) {
      $row = array();
      $row[] = $rows['drawid'];
      $row[] = $rows['date1'];
      // $dateValue = strtotime($rows['date1']);
      // $yr = date("Y", $dateValue) ." ";
      // $mon = date("m", $dateValue)." ";
      // $date = date("d", $dateValue);
      // $dateValue=gregoriantojd($mon,$date,$yr);
      // $row[]=$dateValue;
      $row[] = $rows['yen'];
      $row[] = $rows['exchangerate'];
      $row[] = $rows['doller'];
      $row[] = $rows['companyname'];
      $row[] = $rows['sarafname'];
      if ($rows['photo'] == NULL)
         $row[] = "<img src='images/blank-image.png' width='60px' height='60px'>";
      else
         $row[] = "<a target='_blank' href='images/" . $rows[' photo'] . "'><img src='images/" . $rows[' photo'] . "' width='60px'
            height='60px'></a>";
      $button = "<button class='btn btn-sm btn-primary mb-1 editButton' value='" . $rows[' drawid'] . "'>تصحیح</button>
    <button class='btn btn-sm btn-danger mb-1 deleteButton' value='" . $rows[' drawid'] . "'>حذف</button>";
      $row[] = $button;
      $html[] = $row;
   }
   echo json_encode($html);

}

if (isset($_POST['actionString']) && $_POST['actionString'] == 'viewVendorCompanyStatus') {

   $vendorcompanyid = $_POST['vendorcompanyid'];
   $query = "select sum(totaldollerprice) as totaldollerpurchase from fabricpurchase where
    vendorcompany=$vendorcompanyid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totaldollerpurchase = $row['totaldollerpurchase'];
   freeResult($result);

   $query = "select sum(doller) as totaldollersubmit from draw where companyid=$vendorcompanyid";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $totaldollersubmit = $row['totaldollersubmit'];
   freeResult($result);
   $balance = $totaldollerpurchase - $totaldollersubmit;

   $query = "select sum(totaldollerprice) as kldhmd from fabricpurchase inner join company on
    company.companyid=fabricpurchase.companyid
    where fabricpurchase.vendorcompany=$vendorcompanyid and (company.marka='KLD' or company.marka='HMD')";
   $result = execute($query);
   $row = mysqli_fetch_assoc($result);
   $kldhmd = $row['kldhmd'];
   freeResult($result);
   $info = ['totaldollerprice' => $totaldollerpurchase, 'totaldollersubmit' => $totaldollersubmit, 'balance' => $balance, 'kldhmd' => $kldhmd];
   echo json_encode($info);
}