<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Job Listings</title>
    <link rel="stylesheet" href="media/conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h2>Jobs</h2>
    <?php
        // get the filter value if one has been chosen, otherwise set to all
        $selectedFilter = isset($_POST["filter"]) ? $_POST["filter"] : "All Companies";
    ?>
    <form method="post" action="">
        <p>Filter by 
        <select name="filter" onchange="this.form.submit()">
        <?php
            $query = 'SELECT * FROM Company';
            $result = $connection->query($query);

            // first option = all companies
            echo "<option value='All Companies'" . ($selectedFilter == "All Companies" ? " selected" : "") . ">All Companies</option>";

            while ($row = $result->fetch())
            {
                $name = $row["name"];

                // keep the selected company as the current dropdown value
                if ($selectedFilter == $name)
                {
                    $isSelected = " selected";
                }

                else
                {
                    $isSelected = "";
                }

                // show all the companies
                echo "<option value='" . $name . "'$isSelected>Company - " . $name . "</option>";
            }
        ?>
        </select>
        </p>
    </form>
        </br>
    <table>
        <tr>
            <th>Job Title</th>
            <th>Location</th>
            <th>Pay Rate</th>
        </tr>
    <?php

        if ($selectedFilter == "All Companies")
        {
            $query = 'SELECT * FROM JobAd';
        }

        else
        {
            $query = 'SELECT * FROM JobAd WHERE cname="' . $selectedFilter . '"';
        }

        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                // format the pay rate to have spaces for clarity
                $unformattedPayRate = $row["payRate"];
                $digits = (int) strpos($unformattedPayRate, "."); // get the number of digits by finding the index of the .

                if ($digits > 3)
                {
                    for ($i = $digits - 3; $i > 0; $i -= 3)
                    {
                        $strPayRate = substr_replace($unformattedPayRate, ' ', $i, 0);
                    }
                }

                else
                {
                    $strPayRate = $unformattedPayRate;
                }

                echo "<tr>
                    <td>".$row["title"]."</td>
                    <td>".$row["city"].", ".$row["province"]."</td>
                    <td style='text-align: right'>$".$strPayRate."</td>
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='3'>No jobs found</td></tr>";
        }
    ?>
    </table>
    </br>
    <form action="conference.php" class="center">
        <input type="submit" name="return" value="Return"></input>
    </form>
    <?php
        $connection =- NULL;
    ?>
</body>
</html>