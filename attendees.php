<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Attendees</title>
    <link rel="stylesheet" href="conference.css">
</head>

<body>
    <?php
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

    <h2> Add a new attendee</h2>
    <form action="addnewattendee.php" method="post">
        First Name: <input type="text" name="attendeefname" required><br></br>
        Last Name: <input type="text" name="attendeelname" required><br></br>
        Email: <input type="text" name="attendeeemail" required><br></br>
        Role: <br>
        <input type="radio" name="attendeerole" value="Student" required>Student<br>
        <input type="radio" name="attendeerole" value="Professional">Professional<br>
        <input type="radio" name="attendeerole" value="Sponsor" onchange="showCompanyField()">Sponsor<br></br>

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
        </br>
        </br>
        <input type="submit" value="Add Attendee">
    </form>

    </br>

    <form action="conference.php">
        <input type="submit" name="return" value="Return"></input>
    </form>
    <?php
        $connection =- NULL;
    ?>

<script>
function showCompanyField() {
    const selectedRole = document.querySelector('input[name="attendeerole"]:checked')?.value;
    const companySelect = document.getElementById('companySelect');
    const companyLabel = document.getElementById('companyLabel');

    // check if sponsor was selected, show the company dropdown
    if (selectedRole === "Sponsor") {
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