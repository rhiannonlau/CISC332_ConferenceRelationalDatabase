<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Rooms</title>
    <link rel="stylesheet" href="conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h2>Students in Rooms</h2>
    <?php
        // get the filter value if one has been chosen, otherwise set to all
        $selectedFilter = isset($_POST["filter"]) ? $_POST["filter"] : "All Rooms";
    ?>
    <form method="post" action="">
        Filter by
        <select name="filter" onchange="this.form.submit()">
        <?php
            $query = 'SELECT * FROM Room';
            $result = $connection->query($query);

            // first option = all sub committees
            echo "<option value='All Rooms'" . ($selectedFilter == "All Rooms" ? " selected" : "") . ">All Rooms</option>";

            while ($row = $result->fetch())
            {
                $number = $row["roomNumber"];

                // keep the selected sub-committee as the current dropdown value
                if ($selectedFilter == $number)
                {
                    $isSelected = " selected";
                }

                else
                {
                    $isSelected = "";
                }

                // show all the companies
                echo "<option value='" . $number . "'$isSelected>Room " . $number . "</option>";
            }
        ?>
        </select>
    </form>
        </br>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Room</th>
        </tr>
    <?php

        if ($selectedFilter == "All Rooms")
        {
            $query = 'SELECT * FROM Student WHERE rNumber IS NOT NULL';
        }

        else
        {
            $query = 'SELECT * FROM Student WHERE rNumber="' . $selectedFilter . '"';
        }

        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                echo "<tr>
                    <td>".$row["firstName"]."</td>
                    <td>".$row["lastName"]."</td>
                    <td>".$row["emailAddress"]."</td>
                    <td>".$row["rNumber"]."</td>
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='4'>No students found</td></tr>";
        }
    ?>
    </table>
    </br>
    <form action="conference.php">
        <input type="submit" name="return" value="Return"></input>
    </form>
    <?php
        $connection =- NULL;
    ?>
</body>
</html>