<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Sponsors</title>
    <link rel="stylesheet" href="conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h2>Companies</h2>
    <table>
        <tr>
            <th>Company Name</th>
            <th>Level</th>
            <th>Financial Support</th>
            <th>Options</th>
        </tr>
    <?php
        $query = 'SELECT * FROM Company';
        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                // format the financial support values to have spaces for clarity
                $unformattedSupport = $row["financialSupport"];
                $digits = (int) strpos($unformattedSupport, "."); // get the number of digits by finding the index of the .

                if ($digits > 3)
                {
                    for ($i = $digits - 3; $i > 0; $i -= 3)
                    {
                        $strSupport = substr_replace($unformattedSupport, ' ', $i, 0);
                    }
                }

                else
                {
                    $strSupport = $unformattedSupport;
                }

                echo "<tr>
                    <td>".$row["name"]."</td>
                    <td>".$row["level"]."</td>
                    <td style='text-align: right'>$".$strSupport."</td>
                    <td style='text-align: center'><input type='submit' name='delete' value='Delete'></input></td>
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='4'>No companies found</td></tr>";
        }
    ?>
    </table>
    </br>
    
    <h2>Add a new company</h2>
    <form action="addnewcompany.php" method="post">
        Company Name: <input type="text" name="companyname" required></br></br>
        Support: <input type="text" name="companysupport" required></br></br>
        <input type="submit" value="Add Company">
    </form>

    </br>

    <form action="conference.php">
        <input type="submit" name="return" value="Return"></input>
    </form>
    <?php
        $connection =- NULL;
    ?>
</body>
</html>