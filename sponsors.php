<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Sponsors</title>
    <link rel="stylesheet" href="media/conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';

        // delete code
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
            $companyName = $_POST["companyName"];
            
            $query = 'DELETE FROM Company WHERE name ="' . $companyName . '"';
            $result = $connection->exec($query);
            
            // force refresh to reflect changes
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    ?>
    <h2>Companies</h2>
    <table>
        <tr>
            <th>Company Name</th>
            <th>Level</th>
            <th>Financial Support</th>
            <th>Options</th>
        </tr>
    <tbody>
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
                    <td class='center'>
                        <form method='post' onsubmit='return confirm(\"Are you sure you want to delete this company?\");'>
                            <input type='hidden' name='companyName' value='".$row["name"]."'>
                            <input type='submit' name='delete' value='Delete'>
                        </form>
                    </td>
                    
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='4'>No companies found</td></tr>";
        }
    ?>
    </tbody>
    </table>
    </br>

    <!-- the initial add button -->
    <form action="" method="post" onsubmit="return showFields()" class="center">
        <input type="submit" name="showAddCompany" value="Add Company" id="addButton"></input>
    </form>
    
    <!-- the form that shows up when you press the button  -->
    <form action="" method="post" onsubmit="setTimeout(function(){window.location.reload();},10);" style="display: none;" id="addCompany" class="center">
        <h2>Add a new company</h2>
        <p>Company Name: <input type="text" name="companyname" required></br></br>
        Support ($): <input type="text" name="companysupport" required></br>
        </p>
        <input type="submit" value="Add Company">
    </form>

    <!-- store new company info -->
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST"
            && isset($_POST["companyname"])
            && isset($_POST["companysupport"]))
        {
            $name = $_POST["companyname"];
            $strSupport =$_POST["companysupport"];
            $floatSupport = floatval($strSupport);
            $level = "N/A";

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
        }
    ?>

    </br>

    <form action="conference.php" class="center">
        <input type="submit" name="return" value="Return"></input>
    </form>
    <?php
        $connection = NULL;
    ?>

<script>
function showFields()
{
    document.getElementById("addCompany").style.display = "block";
    document.getElementById("addButton").style.display = "none";
    return false;
}
</script>
</body>
</html>