<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Schedule</title>
    <link rel="stylesheet" href="media/conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h2>Schedule</h2>
    <?php
        // get the filter value if one has been chosen, otherwise set to all
        $selectedFilter = isset($_POST["filter"]) ? $_POST["filter"] : "All Dates";
    ?>
    <form method="post" action="">
        <p>Filter by 
        <select name="filter" onchange="showCalendar(this);">
        <?php
            // first option = all dates
            echo "<option value='All Dates'" . ($selectedFilter == "All Dates" ? " selected" : "") . ">All Dates</option>";
            echo "<option value='Specific Date'" . ($selectedFilter == "Specific Date" ? " selected" : "") . ">Specific Date</option>";
        ?>
        </select>
        
        <label for="dateSelect" id="dateLabel" style="display: none;">Select a date:</label>
        <input type="date" name="date" id="dateSelect" style="display: none;" onchange="this.form.submit()">
        <?php
            $selectedDate = isset($_POST["date"]) ? $_POST["date"] : "";
        ?>
        </p>
    </form>
        </br>
    <table>
        <thead>
        <tr>
            <th>Session Name</th>
            <th>Speaker</th>
            <th>Date</th>
            <th>Time</th>
            <th>Room</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ($selectedFilter == "All Dates")
            {
                $query = 'SELECT * FROM Session AS Sn, Speaker AS Sp, SpeakerSpeaksAtSession AS SS WHERE
                    Sn.name=SS.snName AND
                    Sn.startTime=SS.snStart AND
                    Sn.date=SS.snDate AND
                    Sp.firstName=SS.spFirstName AND
                    Sp.lastName=SS.spLastName';
            }
            else
            {
                $query = 'SELECT * FROM Session AS Sn, Speaker AS Sp, SpeakerSpeaksAtSession AS SS WHERE
                    Sn.name=SS.snName AND
                    Sn.startTime=SS.snStart AND
                    Sn.date=SS.snDate AND
                    Sp.firstName=SS.spFirstName AND
                    Sp.lastName=SS.spLastName AND
                    Sn.date="' . $selectedDate . '"';
            }

            $result = $connection->query($query);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch())
                {
                    $phpStartTime = strtotime($row["startTime"]);
                    $startTime = date( 'g:i A', $phpStartTime );

                    $phpEndTime = strtotime($row["endTime"]);
                    $endTime = date( 'g:i A', $phpEndTime );

                    echo "<tr data-href='conference.php'>
                        <td>".$row["snName"]."</td>
                        <td>".$row["spFirstName"]." ".$row["spLastName"]."</td>
                        <td>".$row["snDate"]."</td>
                        <td>".$startTime." - ".$endTime."</td>
                        <td>".$row["roomLocation"]."</td>
                        <td style='text-align: center;'>
                            <input type='submit' value='Edit' onclick=\"showEditForm('".$row["name"]."', '".$row["date"]."', '".$row["startTime"]."', '".$row["endTime"]."', '".$row["roomLocation"]."')\"></button>
                        </td>
                        </tr>";
                }
            }
            else
            {
                echo "<tr><td colspan='5'>No sessions found</td></tr>";
            }
        ?>
        </tbody>
    </table>

    </br>
    <!-- edit form -->
    <form action="" method="post" id="editSession" style="display: none;" class="center" onsubmit="setTimeout(function(){window.location.reload();},10);">
        <h2>Edit Session: <span id="sessionNameDisplay"></span></h2>
        <p><input type="hidden" id="sessionName" name="sessionName">
            Edit date: <input type="date" id="sessionDate" name="sessionDate"></br>
            Edit start time: <input type="time" id="sessionStartTime" name="sessionStartTime"></br>
            Edit end time: <input type="time" id="sessionEndTime" name="sessionEndTime"></br>
            Room: <input type="text" id="sessionRoom" name="sessionRoom"></br></br>
        </p>
        </br>
        <input type="submit" name="saveChanges" value="Save Changes">
    </form>

    <?php
        // save the edits
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveChanges"])) {
            $name = $_POST["sessionName"];
            $date = $_POST["sessionDate"];
            $startTime = $_POST["sessionStartTime"];
            $endTime = $_POST["sessionEndTime"];
            $room = $_POST["sessionRoom"];
            
            $query = "UPDATE Session SET 
                      date = '" . $date . "',
                      startTime = '" . $startTime . "',
                      endTime = '" . $endTime . "',
                      roomLocation = '" . $room . "'
                      WHERE name = '" . $name . "'";
            
            $result = $connection->exec($query);
        }
        
        $connection = NULL;
    ?>

    <form action="conference.php" class="center">
        <input type="submit" name="return" value="Return"></input>
    </form>

<script>
// show the calendar so the user can filter by a specific date
function showCalendar(select) {
    dateSelect = document.getElementById('dateSelect');
    if (select.options[select.selectedIndex].value == "Specific Date") {
        dateSelect.style.display = 'block';
    } else {
        dateSelect.style.display = 'none';
    }
}

// show the editing fields so the user can edit session information
function showEditForm(name, date, startTime, endTime, room) {
    document.getElementById("sessionNameDisplay").textContent = name;
    document.getElementById("sessionName").value = name;
    document.getElementById("sessionDate").value = date;
    document.getElementById("sessionStartTime").value = startTime;
    document.getElementById("sessionEndTime").value = endTime;
    document.getElementById("sessionRoom").value = room;
    document.getElementById("editSession").style.display = "block";
}

window.onload = showCalendar;
</script>

</body>
</html>