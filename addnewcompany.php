<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - ?</title>
</head>
<body>
<?php
   include 'connectdb.php';
?>
<ol>
    <?php
    $name = $_POST["companyname"];
    $strSupport =$_POST["companysupport"];
    // $query1= 'select max(petid) as maxid from pet';
    // $result= $connection->query($query1);
    // $row=$result->fetch();
    // $newkey = intval($row["maxid"]) + 1;
    // $petid = (string)$newkey;
    $floatSupport = floatval($strSupport);
    $level;

    if ($floatSupport >= 10000)
    {
        $level = "Platinum";
    }
    elseif ($floatSupport >= 5000)
    {
        $level = "Gold";
    }
    elseif ($floatSupport >= 3000)
    {
        $level = "Silver";
    }
    elseif ($floatSupport >= 1000)
    {
        $level = "Bronze";
    }

    $query = 'INSERT INTO Company values("' . $name . '","' . $level . '","' . $floatSupport . '")';
    $numRows = $connection->exec($query);
    echo "Company " . $name . " was added!";
    $connection = NULL;
    ?>
</ol>
</body>
</html>