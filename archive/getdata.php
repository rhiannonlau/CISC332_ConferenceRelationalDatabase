<?php
    // $result = $connection->query("select * from Member");
    // echo "<ol>";
    // while ($row = $result->fetch()) {
    //     echo "<li>";
    //     echo $row["firstName"]." ".$row["lastName"];
    //     echo "</li>";
    // }
    // echo "</ol>";

    $query = "SELECT * FROM Company";
    $result = $connection->query($query);
    echo "Pick a company to view the jobs they have available </br>";
    while ($row = $result->fetch()) {
            echo '<input type="radio" name="companies" value="';
            echo $row["name"];
            echo '">' . $row["name"] . " - " . $row["level"] . "<br>";
    }
?>