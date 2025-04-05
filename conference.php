<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Conference</title>
    <link rel="stylesheet" href="conference.css">
</head>

<body>
<?php
include 'connectdb.php' ;
?>
    <h1>Conference</h1>
    <!-- <h2>Members</h2> -->
    <?php
    // include 'getdata.php';
    ?>
    <h2>Companies</h2>
    <form action="getjobsbycompany.php" method="post">
        <?php
            include 'getdata.php';
        ?>
    <input type="submit" value="View jobs">
    </form>
    <!-- <p>
    <hr>
    <p>
    <h2> Add a new attendee</h2>
    <form action="addnewattendee.php" method="post">
        First Name: <input type="text" name="attendeefname"><br>
        Last Name: <input type="text" name="attendeelname"><br>
        Role: <br>
        <input type="radio" name="role" value="student">Student<br>
        <input type="radio" name="role" value="professional">Professional<br>
        <input type="radio" name="role" value="sponsor">Sponsor<br>
        <input type="submit" value="Add Attendee">
    </form> -->
    
    <p>
    <hr>
    <p>

    <h2>Jobs</h2>
    <form action="jobs.php" method="post">
        <input type="submit" value="View jobs">
    </form>

    <p>
    <hr>
    <p>

    <h2>Sponsors</h2>
    <form action="sponsors.php" method="post">
        <input type="submit" value="View sponsors">
    </form>
    <p>
    <hr>
    <p>

    <h2>Attendees</h2>
    <form action="attendees.php" method="post">
        <input type="submit" value="View attendees">
    </form>
    <p>
    <hr>
    <p>

    <h2>Sub-Committees</h2>
    <form action="subcommittees.php" method="post">
        <input type="submit" value="View Sub-Committees">
    </form>
    <p>
    <hr>
    <p>

    <h2>Rooms</h2>
    <form action="rooms.php" method="post">
        <input type="submit" value="View Rooms">
    </form>
    <p>
    <hr>
    <p>

    <h2>Schedules</h2>
    <form action="schedule.php" method="post">
        <input type="submit" value="View Schedule">
    </form>
    <p>
    <hr>
    <p>

    <h2>Intake</h2>
    <form action="intake.php" method="post">
        <input type="submit" value="View Intake">
    </form>
    <p>
    <hr>
    <p>

    
    <h3>Thank you to our sponsors:</h3>
    <?php
        $query = 'SELECT name FROM Company ORDER BY financialSupport DESC';
        $result = $connection->query($query);
        
        while ($row = $result->fetch())
        {
            if ($row != end($row))
            {
                echo $row["name"] . ", ";
            }
            
            else
            {
                echo "and " . $row["name"];
            }
        }
    ?>

<?php
        $connection =- NULL;
    ?>
</body>
</html>