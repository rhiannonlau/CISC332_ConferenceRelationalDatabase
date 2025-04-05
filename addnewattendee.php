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
    $fName = $_POST["attendeefname"];
    $lName = $_POST["attendeelname"];
    $email = $_POST["attendeeemail"];
    $role = $_POST["attendeerole"];

    if ($role == "Student")
    {
        // assign them to a room
        $query = 'INSERT INTO Student values("' . $fName . '","' . $lName . '","' . $email . '")';
    }

    elseif ($role == "Professional")
    {
        $query = 'INSERT INTO Professional values("' . $fName . '","' . $lName . '","' . $email . '")';
    }

    else
    {
        $query = 'INSERT INTO Sponsor values("' . $fName . '","' . $lName . '","' . $email . '")';
    }

    $numRows = $connection->exec($query);
    echo "Attendee " . $fName . " " . $lName . " was added!";
    
    $connection = NULL;
    ?>
</ol>
</body>
</html>