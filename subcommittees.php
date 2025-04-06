<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Sub-Committees</title>
    <link rel="stylesheet" href="media/conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h2>Sub-Committees</h2>
    <?php
        // get the filter value if one has been chosen, otherwise set to all
        $selectedFilter = isset($_POST["filter"]) ? $_POST["filter"] : "All Sub-Committees";
    ?>
    <form method="post" action="">
        <p>Filter by 
        <select name="filter" onchange="this.form.submit()">
        <?php
            $query = 'SELECT * FROM SubCommittee';
            $result = $connection->query($query);

            // first option = all sub committees
            echo "<option value='All Sub-Committees'" . ($selectedFilter == "All Sub-Committees" ? " selected" : "") . ">All Sub-Committees</option>";

            while ($row = $result->fetch())
            {
                $name = $row["name"];

                // keep the selected sub-committee as the current dropdown value
                if ($selectedFilter == $name)
                {
                    $isSelected = " selected";
                }

                else
                {
                    $isSelected = "";
                }

                // show all the companies
                echo "<option value='" . $name . "'$isSelected>Sub-Committee - " . $name . "</option>";
            }
        ?>
        </select>
        </p>
    </form>
        </br>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Sub-Committee</th>
            <th>Role</th>
        </tr>
    <?php

        if ($selectedFilter == "All Sub-Committees")
        {
            $query = 'SELECT * FROM MemberInSubCommittee AS MS, Member AS M WHERE MS.mFirstName=M.firstName AND MS.mLastName=M.lastName';
        }

        else
        {
            $query = 'SELECT * FROM MemberInSubCommittee AS MS, Member AS M WHERE MS.sName="' . $selectedFilter . '" AND MS.mFirstName=M.firstName AND MS.mLastName=M.lastName';
        }

        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                echo "<tr>
                    <td>".$row["firstName"]."</td>
                    <td>".$row["lastName"]."</td>
                    <td>".$row["emailAddress"]."</td>
                    <td>".$row["sName"]."</td>
                    <td>".$row["role"]."</td>
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='5'>No members found</td></tr>";
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