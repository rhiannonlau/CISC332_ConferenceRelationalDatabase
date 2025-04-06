<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Attendees</title>
    <link rel="stylesheet" href="media/conference.css">
</head>

<body>
    <?php
        ob_start();
        include 'connectdb.php';
    ?>
    <h2>Attendees</h2>
    <h3>Students</h3>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Room Number</th>
        </tr>
    <?php
        $query = 'SELECT * FROM Student';
        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                $room = $row["rNumber"];

                if (!$room)
                {
                    $room = "N/A";
                }

                echo "<tr>
                    <td>".$row["firstName"]."</td>
                    <td>".$row["lastName"]."</td>
                    <td>".$row["emailAddress"]."</td>
                    <td>".$room."</td>
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
    <h3>Professionals</h3>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
        </tr>
    <?php
        $query = 'SELECT * FROM Professional';
        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                echo "<tr>
                    <td>".$row["firstName"]."</td>
                    <td>".$row["lastName"]."</td>
                    <td>".$row["emailAddress"]."</td>
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='3'>No professionals found</td></tr>";
        }
    ?>
    </table>
    </br>
    <h3>Sponsors</h3>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Company</th>
        </tr>
    <?php
        $query = 'SELECT * FROM Sponsor';
        $result = $connection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch())
            {
                echo "<tr>
                    <td>".$row["firstName"]."</td>
                    <td>".$row["lastName"]."</td>
                    <td>".$row["emailAddress"]."</td>
                    <td>".$row["cName"]."</td>
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

    <!-- the initial add button -->
    <form action="" method="post" onsubmit="return showFields()" class="center">
        <input type="submit" name="showAddAttendee" value="Add Attendee" id="addButton"></input>
    </form>

    <!-- the form that shows up when you press the button  -->
     <!-- setTimeout(function(){window.location.reload();},10); -->
    <form action="" method="post" onsubmit="" style="display: none;" id="addAttendee" class="center">
        <h2> Add a new attendee</h2>
        <p>First Name: <input type="text" name="attendeefname" required><br></br>
        Last Name: <input type="text" name="attendeelname" required><br></br>
        Email: <input type="text" name="attendeeemail" required><br></br>
        Role: <br>
        <div style="display: flex; justify-content: center;">
            <div style="text-align: left;">
                <input type="radio" name="attendeerole" value="Student" required>Student<br>
                <input type="radio" name="attendeerole" value="Professional">Professional<br>
                <input type="radio" name="attendeerole" value="Sponsor" onchange="showCompanyField()">Sponsor<br></br>
            </div>
        </div>

        <!-- company drop down shows up when the user selects sponsor -->
        <label for="companySelect" id="companyLabel" style="display: none;">Select a company:</label>
        <select name="company" id="companySelect" style="display: none;">
        <option value="" disabled selected>Select a company</option>
        <?php
            $query = 'SELECT * FROM Company';
            $result = $connection->query($query);

            while ($row = $result->fetch()) {
                echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
            }
        ?>
        </select>
        </p>
        </br>

        <input type="submit" value="Add Attendee">
    </form>

    <!-- store new attendee info -->
    <?php
        $numRows = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST"
            && isset($_POST["attendeefname"])
            && isset($_POST["attendeelname"])
            && isset($_POST["attendeeemail"])
            && isset($_POST["attendeerole"]))
        {
            $fName = $_POST["attendeefname"];
            $lName = $_POST["attendeelname"];
            $email = $_POST["attendeeemail"];
            $role = $_POST["attendeerole"];

            if ($role == "Student")
            {
                // pick a room that has space and put them in it
                $query = 'SELECT r.roomNumber FROM Room r
                    LEFT JOIN Student s ON r.roomNumber = s.rNumber
                    GROUP BY r.roomNumber, r.numberOfBeds
                    HAVING COUNT(s.rNumber) < r.numberOfBeds;';
                $result = $connection->query($query);
                $room = $result->fetch()["roomNumber"]; // get the first room

                $query = 'INSERT INTO Student values("' . $fName . '","' . $lName . '",50.00,"' . $email . '","' . $room . '")';
                $numRows = $connection->exec($query);
            }

            elseif ($role == "Professional")
            {
                $query = 'INSERT INTO Professional values("' . $fName . '","' . $lName . '",100.00,"' . $email . '")';
                $numRows = $connection->exec($query);
            }

            elseif ($role == "Sponsor")
            {
                $company = $_POST["company"];
                $query = 'INSERT INTO Sponsor values("' . $fName . '","' . $lName . '",0.00,"' . $email . '","' . $company . '")';
                $numRows = $connection->exec($query);
            }

            // force refresh to reflect changes
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    ?>

    </br>
    <form action="conference.php" class="center">
        <input type="submit" name="return" value="Return"></input>
    </form>

    <?php
        $connection = NULL;
        ob_end_flush();
    ?>

<script>
function showFields()
{
    document.getElementById("addAttendee").style.display = "block";
    document.getElementById("addButton").style.display = "none";
    return false;
}

function showCompanyField() {
    const selectedRole = document.querySelector('input[name="attendeerole"]:checked')?.value;
    const companySelect = document.getElementById('companySelect');
    const companyLabel = document.getElementById('companyLabel');

    // check if sponsor was selected, show the company dropdown
    if (selectedRole == "Sponsor") {
        companySelect.style.display = "inline";
        companyLabel.style.display = "inline";
        companySelect.setAttribute("required", "required");
    }
    
    else {
        companySelect.style.display = "none";
        companyLabel.style.display = "none";
        companySelect.removeAttribute("required");
        companySelect.value = ""; // reset selection
    }
}
</script>
</body>
</html>