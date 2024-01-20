<?php
// display all php errors and warning
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'jdatetime.class.php';
$shamsiDate = new jDateTime(true, true, 'Asia/Kabul');

$user = "root";
$password = "root";
$database = "fabric";
$server = "localhost";

$connection = mysqli_connect($server, $user, $password, $database);

if (mysqli_connect_errno())
    die("Failed to connect :" . mysqli_connect_error());


// to make free the database variable that containts database results
function freeResult($result)
{
    mysqli_free_result($result);
}
// insert, or delete or select
function execute($query)
{
    global $connection;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    return $result;
}

// select statement counting the number of rows
function rowsReturn($result)
{
    global $connection;
    $count = mysqli_num_rows($result);

    return $count;
}

// executing multiple delete, insert or update statement
function executeMulti($query)
{
    global $connection;
    $result = mysqli_multi_query($connection, $query) or die(mysqli_error($connection));
    return $result;
}

// formatting a number

function format($value)
{
    return number_format($value, 2);
}



function outSaraiBundle($saraiOutDealId, $saraiDesignBundleId, $saraiid)
{
    $getBundleQuery = "SELECT * from saraidesignbundle inner join saraifabricpurchase on saraifabricpurchase.saraifabricpurchaseid=saraidesignbundle.saraifabricpurchaseid where 
    saraidesignbundle.saraidesignbundleid=$saraiDesignBundleId";
    $getBundleResult = execute($getBundleQuery);
    $getBundleRow = mysqli_fetch_assoc($getBundleResult);
    $saraiFabricPurchaseId = $getBundleRow['saraifabricpurchaseid'];
    freeResult($getBundleResult);

    // checking if the saraidesignbundle is the last bundle in the sarai
    $checkLastBundleQuery = "select count(saraidesignbundleid) as id from saraidesignbundle inner join  saraiindeal on saraiindeal.saraiindealid=saraidesignbundle.saraiindealid where saraiindeal.saraiid=$saraiid and saraifabricpurchaseid=$saraiFabricPurchaseId and saraidesignbundleid!=$saraiDesignBundleId and saraidesignbundle.status is null and saraidesignbundle.saraioutdealid is null";
    //  echo $checkLastBundleQuery;
    $checkLastBundleResult = execute($checkLastBundleQuery);
    $checkLastBundleRow = mysqli_fetch_assoc($checkLastBundleResult);
    freeResult($checkLastBundleResult);
    if ($checkLastBundleRow['id'] == 0) // it means this is the last bundle
    {

        // outing the bundle
        $outingQuery = "update saraidesignbundle set saraioutdealid=$saraiOutDealId where saraidesignbundleid=$saraiDesignBundleId;";

        if (execute($outingQuery))
            $processResult[] = "outingQuery";
        // changing the status of the saraifabricpurchase
        $outStatusQuery = "update saraifabricpurchase set status='out' where saraifabricpurchaseid=$saraiFabricPurchaseId";
        if (execute($outStatusQuery))
            $processResult[] = "outingStatusQuery";


    } else {
        // outing the bundle
        $outingQuery = "update saraidesignbundle set saraioutdealid=$saraiOutDealId where saraidesignbundleid=$saraiDesignBundleId;";

        if (execute($outingQuery))
            $processResult[] = "elseoutingQuery";
    }

}

function inSaraiBundle($saraiDesignBundleId, $saraitoid, $saraiInDealId)
{
    $userid = $_SESSION['userid'];
    $getBundleQuery = "SELECT * from saraidesignbundle inner join saraifabricpurchase on saraifabricpurchase.saraifabricpurchaseid=saraidesignbundle.saraifabricpurchaseid where 
    saraidesignbundle.saraidesignbundleid=$saraiDesignBundleId";
    $getBundleResult = execute($getBundleQuery);
    $getBundleRow = mysqli_fetch_assoc($getBundleResult);
    $saraiFabricPurchaseId = $getBundleRow['saraifabricpurchaseid'];
    freeResult($getBundleResult);
    // inning bundle into another sarai
    // checking if the fabric exist in the new sarai
    $checkSaraiFabricPurchaseQuery = "select * from saraiindeal inner join saraifabricpurchase on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid where saraifabricpurchase.fabricpurchaseid=" . $getBundleRow['fabricpurchaseid'] . " and status is null and saraiindeal.saraiid=$saraitoid";
    // echo $checkSaraiFabricPurchaseQuery;
    $checkSaraiFabricPurchaseResult = execute($checkSaraiFabricPurchaseQuery);
    $rowCount = rowsReturn($checkSaraiFabricPurchaseResult);
    freeResult($checkSaraiFabricPurchaseResult);
    //  echo $checkSaraiFabricPurchaseQuery;
    // echo $rowCount;
    if ($rowCount == 1) {
        $checkSaraiFabricPurchaseResult = execute($checkSaraiFabricPurchaseQuery);
        $checkSaraiFabricPurchaseRow = mysqli_fetch_assoc($checkSaraiFabricPurchaseResult);

        $insertBundle = "insert into saraidesignbundle (designbundleid,userid,saraiindealid,saraifabricpurchaseid) values(" . $getBundleRow['designbundleid'] . ",$userid,$saraiInDealId," . $checkSaraiFabricPurchaseRow['saraifabricpurchaseid'] . ");";

        execute($insertBundle);

        freeResult($checkSaraiFabricPurchaseResult);
    } else if ($rowCount == 0) {
        // inserting the record into saraifabricpurchase
        $insertSaraiFabricPurchaseQuery = "insert into saraifabricpurchase (fabricpurchaseid,userid,saraiindealid) values (" . $getBundleRow['fabricpurchaseid'] . ",$userid,$saraiInDealId);";
        execute($insertSaraiFabricPurchaseQuery);
        $getIdQuery = "select max(saraifabricpurchaseid) as id from saraifabricpurchase";
        $getIdResult = execute($getIdQuery);
        $getIdRow = mysqli_fetch_assoc($getIdResult);

        // inserting the bundle into the saraidesignbundle
        $insertBundle = "insert into saraidesignbundle (designbundleid,userid,saraiindealid,saraifabricpurchaseid) values(" . $getBundleRow['designbundleid'] . ",$userid,$saraiInDealId," . $getIdRow['id'] . ");";

        execute($insertBundle);

        freeResult($getIdResult);

    }
}

function outSaraiPati($saraiPatiDesignColorId, $saraiid, $saraiOutDealId)
{
    $processResult = array();

    $getPatiQuery = "SELECT * from saraipati inner join saraidesignbundle on saraidesignbundle.saraidesignbundleid=saraipati.saraidesignbundleid inner join saraifabricpurchase on saraifabricpurchase.saraifabricpurchaseid=saraidesignbundle.saraifabricpurchaseid where 
       saraipati.saraipatidesigncolorid=$saraiPatiDesignColorId";
    $getPatiResult = execute($getPatiQuery);
    $getPatiRow = mysqli_fetch_assoc($getPatiResult);
    $saraiDesignBundleId = $getPatiRow['saraidesignbundleid'];
    $saraiFabricPurchaseId = $getPatiRow['saraifabricpurchaseid'];
    freeResult($getPatiResult);

    // checking if the saraipatidesigncolorid is the last pati in the sarai
    $checkLastPatiQuery = "select count(saraipatidesigncolorid) as id from saraipati inner join saraiindeal on saraiindeal.saraiindealid=saraipati.saraiindealid where saraidesignbundleid=$saraiDesignBundleId and saraiindeal.saraiid=$saraiid and saraipatidesigncolorid!=$saraiPatiDesignColorId and  saraipati.saraioutdealid is null";
    //  echo $checkLastpatiQuery
    $checkLastPatiResult = execute($checkLastPatiQuery);
    $checkLastPatiRow = mysqli_fetch_assoc($checkLastPatiResult);
    freeResult($checkLastPatiResult);
    if ($checkLastPatiRow['id'] == 0) // it means this is the last pati
    {

        // outing the pati
        $outingQuery = "update saraipati set saraioutdealid=$saraiOutDealId where saraipatidesigncolorid=$saraiPatiDesignColorId;";

        if (execute($outingQuery))
            $processResult[] = "outingpatiqueryif";
        // changing the status of the saraidesingbundle
        $outStatusQuery = "update saraidesignbundle set status='out' where saraidesignbundleid=$saraiDesignBundleId";
        if (execute($outStatusQuery))
            $processResult[] = "outingsaraidesignstatus";

        // checking if the saraidesignbundle is the last bundle in the sarai
        $checkLastBundleQuery = "select count(saraidesignbundleid) as id from saraidesignbundle inner join saraiindeal on saraiindeal.saraiindealid=saraidesignbundle.saraiindealid where saraiindeal.saraiid=$saraiid and saraifabricpurchaseid=$saraiFabricPurchaseId and saraidesignbundle.status is null and saraidesignbundle.saraioutdealid is null";
        //  echo $checkLastBundleQuery;
        $checkLastBundleResult = execute($checkLastBundleQuery);
        $checkLastBundleRow = mysqli_fetch_assoc($checkLastBundleResult);
        freeResult($checkLastBundleResult);
        if ($checkLastBundleRow['id'] == 0) // it means this is the last bundle of the fabric purchase
        {
            // changing the status of the saraifabricpurchase
            $outStatusQuery = "update saraifabricpurchase set status='out' where saraifabricpurchaseid=$saraiFabricPurchaseId";
            if (execute($outStatusQuery))
                $processResult[] = "outingsaraifabricstatus";
        }
    } else  // it means it is not the last pati then
    {
        // outing the pati
        $outingQuery = "update saraipati set saraioutdealid=$saraiOutDealId where saraipatidesigncolorid=$saraiPatiDesignColorId;";

        if (execute($outingQuery))
            $processResult[] = "saripatioutelse";
    }
}

function inSaraiPati($saraiPatiDesignColorId, $saraiInDealId, $saraitoid)
{
    $userid = $_SESSION['userid'];
    $getPatiQuery = "SELECT * from saraipati inner join saraidesignbundle on saraidesignbundle.saraidesignbundleid=saraipati.saraidesignbundleid inner join saraifabricpurchase on saraifabricpurchase.saraifabricpurchaseid=saraidesignbundle.saraifabricpurchaseid where 
       saraipati.saraipatidesigncolorid=$saraiPatiDesignColorId";
    $getPatiResult = execute($getPatiQuery);
    $getPatiRow = mysqli_fetch_assoc($getPatiResult);
    $saraiDesignBundleId = $getPatiRow['saraidesignbundleid'];
    $saraiFabricPurchaseId = $getPatiRow['saraifabricpurchaseid'];
    freeResult($getPatiResult);
    // inning pati into destination sarai
    // check if the bundle of the pati exist in the destination sarai
    $checkSaraiDesignBundleQuery = "select * from saraiindeal inner join saraidesignbundle on saraidesignbundle.saraiindealid=saraiindeal.saraiindealid where  saraidesignbundle.status is null and saraiindeal.saraiid=$saraitoid and saraidesignbundle.designbundleid=" . $getPatiRow['designbundleid'];
    $checkSaraiDesignBundleResult = execute($checkSaraiDesignBundleQuery);
    $saraiBundleCount = rowsReturn($checkSaraiDesignBundleResult);
    freeResult($checkSaraiDesignBundleResult);
    if ($saraiBundleCount == 0) // if the bundle doesn't exist in the sarai 
    {
        // checking if the fabric exist in the destination sarai
        $checkSaraiFabricPurchaseQuery = "select * from saraiindeal inner join saraifabricpurchase on saraiindeal.saraiindealid=saraifabricpurchase.saraiindealid where saraifabricpurchase.fabricpurchaseid=" . $getPatiRow['fabricpurchaseid'] . " and status is null and saraiindeal.saraiid=$saraitoid";
        // echo $checkSaraiFabricPurchaseQuery;
        $checkSaraiFabricPurchaseResult = execute($checkSaraiFabricPurchaseQuery);
        $saraiFabricCount = rowsReturn($checkSaraiFabricPurchaseResult);
        freeResult($checkSaraiFabricPurchaseResult);
        if ($saraiFabricCount == 0) // it means the fabric doesn't exist
        {
            // inserting the record into saraifabricpurchase
            $insertSaraiFabricPurchaseQuery = "insert into saraifabricpurchase (fabricpurchaseid,userid,saraiindealid) values (" . $getPatiRow['fabricpurchaseid'] . ",$userid,$saraiInDealId);";
            execute($insertSaraiFabricPurchaseQuery);


            $getSaraiFabricIdQuery = "select max(saraifabricpurchaseid) as id from saraifabricpurchase";
            $getSaraiFabricResult = execute($getSaraiFabricIdQuery);
            $getSaraiFabricRow = mysqli_fetch_assoc($getSaraiFabricResult);

            // inserting the bundle into the saraidesignbundle
            $insertBundle = "insert into saraidesignbundle (designbundleid,userid,saraiindealid,saraifabricpurchaseid) values(" . $getPatiRow['designbundleid'] . ",$userid,$saraiInDealId," . $getSaraiFabricRow['id'] . ");";

            execute($insertBundle);

            freeResult($getSaraiFabricResult);

        } else if ($saraiFabricCount == 1) { // it means the fabric exist in the destination sarai
            $checkSaraiFabricPurchaseResult = execute($checkSaraiFabricPurchaseQuery);
            $checkSaraiFabricPurchaseRow = mysqli_fetch_assoc($checkSaraiFabricPurchaseResult);

            $insertBundle = "insert into saraidesignbundle (designbundleid,userid,saraiindealid,saraifabricpurchaseid) values(" . $getPatiRow['designbundleid'] . ",$userid,$saraiInDealId," . $checkSaraiFabricPurchaseRow['saraifabricpurchaseid'] . ");";

            execute($insertBundle);

            freeResult($checkSaraiFabricPurchaseResult);
        }
    }

    $checkSaraiDesignBundleResult = execute($checkSaraiDesignBundleQuery);
    $checkSaraiDesignBundleRow = mysqli_fetch_assoc($checkSaraiDesignBundleResult);

    $insertPati = "insert into saraipati (patiid,userid,saraiindealid,saraidesignbundleid) values(" . $getPatiRow['patiid'] . ",$userid,$saraiInDealId," . $checkSaraiDesignBundleRow['saraidesignbundleid'] . ");";

    execute($insertPati);

    freeResult($checkSaraiDesignBundleResult);

}



function syncPurchaseDetailsInSarai($transportdealid)
{
    $currentDate = date("Y-m-d");
    $userid = $_SESSION['userid'];
    $query = "UPDATE saraiindeal set indate='$currentDate' where transportdealid=$transportdealid";
    // echo $query;
    if (execute($query))
        echo "first";

    // obtaining saraiindeal record and transportdeal record
    $infoQuery = "select * from transportdeal inner join saraiindeal on transportdeal.transportdealid=saraiindeal.transportdealid where transportdeal.transportdealid=$transportdealid";
    if (execute($infoQuery))
        echo "second";
    $infoResult = execute($infoQuery);
    $infoResultRow = mysqli_fetch_assoc($infoResult);
    $saraiindealid = $infoResultRow['saraiindealid']; //2
    $fabricpurchaseid = $infoResultRow['fabricpurchaseid']; //54
    freeResult($infoResult);

    //  echo $infoQuery;
    // inserting record into saraifabricpurchase 

    $query = "INSERT into saraifabricpurchase (fabricpurchaseid,userid,saraiindealid) values ($fabricpurchaseid,$userid,$saraiindealid)";
    if (execute($query))
        echo "three";


    // echo $query;
    // obtaining the saraifabricpurchase info
    $query = "SELECT saraifabricpurchaseid from saraifabricpurchase where fabricpurchaseid=$fabricpurchaseid and saraiindealid=$saraiindealid and status is null";
    if (execute($query))
        echo "four";
    $result = execute($query);
    $saraifabricpurchaseRow = mysqli_fetch_assoc($result);
    $saraifabricpurchaseid = $saraifabricpurchaseRow['saraifabricpurchaseid'];
    freeResult($result);

    // echo $query;
    // obtaining designbundles of the fabricpurchase and inserting them into the saraidesignbundle

    $designBundleQuery = "SELECT designbundle.* from designbundle 
    inner join fabricdesign on fabricdesign.fabricdesignid=designbundle.fabricdesignid
    inner join fabricpurchase on fabricdesign.fabricpurchaseid=fabricpurchase.fabricpurchaseid
    where fabricpurchase.fabricpurchaseid=$fabricpurchaseid";
    if (execute($designBundleQuery))
        echo "five";
    $designBundleResult = execute($designBundleQuery);
    // echo $designBundleQuery;
    while ($designBundleRow = mysqli_fetch_assoc($designBundleResult)) {
        $saraidesignBundleQuery = "insert into saraidesignbundle (designbundleid,userid,saraiindealid,saraifabricpurchaseid)
        values(" . $designBundleRow['designbundleid'] . ",$userid,$saraiindealid,$saraifabricpurchaseid)";
        if (execute($saraidesignBundleQuery))
            echo "loop";

    }
}