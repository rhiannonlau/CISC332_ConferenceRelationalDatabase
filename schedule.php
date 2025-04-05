<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Schedule</title>
    <link rel="stylesheet" href="conference.css">
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
        Filter by
        <select name="filter" onchange="showCalendar();">
        <?php
            $query = 'SELECT * FROM Company';
            $result = $connection->query($query);

            // first option = all dates
            echo "<option value='All Dates'" . ($selectedFilter == "All Dates" ? " selected" : "") . ">All Dates</option>";
            echo "<option value='Specific Date'" . ($selectedFilter == "Specific Date" ? " selected" : "") . ">Specific Date</option>";
        ?>
        </select>
        
        <label for="dateSelect" id="dateLabel" style="display: none;">Select a date:</label>
        <input type="date" name="date" id="dateSelect" style="display: none;">
        <?php
            $selectedDate = isset($_POST["date"]) ? $_POST["date"] : "";
        ?>
    </form>
        </br>
    <table>
        <tr>
            <th>Session Name</th>
            <th>Speaker</th>
            <th>Date</th>
            <th>Time</th>
            <th>Room</th>
        </tr>
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

                echo "<tr>
                    <td>".$row["snName"]."</td>
                    <td>".$row["spFirstName"]." ".$row["spLastName"]."</td>
                    <td>".$row["snDate"]."</td>
                    <td>".$startTime." - ".$endTime."</td>
                    <td>".$row["roomLocation"]."</td>
                    </tr>";
            }
        }
        else
        {
            echo "<tr><td colspan='5'>No sessions found</td></tr>";
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

<script>
function showCalendar() {
    const selectedFilter = document.querySelector('input[name="filter"]:selected')?.value;
    const dateSelect = document.getElementById('dateSelect');
    const dateLabel = document.getElementById('dateLabel');

    // check if sponsor was selected, show the company dropdown
    if (selectedFilter === "Specific Date") {
        dateSelect.style.display = "inline";
        dateLabel.style.display = "inline";
        dateSelect.setAttribute("required", "required");
    }
    
    else {
        dateSelect.style.display = "none";
        dateLabel.style.display = "none";
        dateSelect.removeAttribute("required");
        dateSelect.value = ""; // reset selection
    }

    this.form.submit();
}
window.onload = showCalendar;
</script>
</body>
</html>