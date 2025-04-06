<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Conference</title>
    <link rel="stylesheet" href="media/conference.css">
</head>

<body>
<?php
include 'connectdb.php' ;
?>
<div class="sidebar">
    <h2>Records</h2>
    <a href="subcommittees.php">Sub-Committees</a>
    <a href="attendees.php">Attendees</a>
    <a href="schedule.php">Schedules</a>
    <a href="intake.php">Intake</a>
    <a href="jobs.php">Jobs</a>
    <a href="rooms.php">Rooms</a>
    <a href="sponsors.php">Sponsors</a>
    <p style="position: fixed; bottom: 0; padding: 10px;">
        Rhiannon Lau</br>
    </p>
</div>
<div class="main">
    <h1>Conference Relational Database</h1>
    
    <p style="font-size: 18px">Welcome to the Conference Relational Database, where you can access and change information ahead of your conference.</br>To get started, try navigating to one of the sub-pages using the sidebar on the left.</p>
    </br>
    </br>
    <img src="media/meeting line art.jpg" alt="Meeting line art">
    </br>
    </br>
    <hr>
    </br>
    <h3>Special thank you to our sponsors:</h3>
    <?php
        $query = 'SELECT name FROM Company ORDER BY financialSupport DESC';
        $result = $connection->query($query);

        $names = [];
        while ($row = $result->fetch())
        {
            $names[] = $row['name'];
        }
        
        echo "<p style='font-size: 18px;'>";
        for ($i = 0; $i < count($names); $i++)
        {
            if ($i == count($names) - 1) {
                echo "and " . $names[$i] . ".";
            }
            
            else {
                echo $names[$i] . ", ";
            }
        }
        echo "</p>";
    ?>
</div>

<?php
        $connection = NULL;
    ?>
</body>
</html>