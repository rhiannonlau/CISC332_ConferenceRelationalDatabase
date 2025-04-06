<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Conference - Job Listings</title>
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h3>Here are the available jobs:</h3>
    <table>
    <?php
        try {
            $whichCompany= $_POST["companies"];
            $query = 'SELECT * FROM Company AS c, JobAd AS j WHERE j.cName=c.name AND j.cName="' . $whichCompany . '"';
            $result=$connection->query($query);
            
            while ($row=$result->fetch()) {
            echo "<tr><td>".$row["title"]."</td><td>".$row["city"].", ".$row["province"]."</td><td>".$row["payRate"]."</td></tr>";
            }
        } catch (PDOException $e) {
            print "Error!: ". $e->getMessage(). "<br/>";
            die();
            // echo "This company has no jobs listed.";
            // how to print error?
        }
    ?>
    </table>
    <?php
        $connection = NULL;
    ?>
</body>
</html>