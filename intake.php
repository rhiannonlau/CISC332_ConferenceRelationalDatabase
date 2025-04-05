<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Conference - Intake</title>
    <link rel="stylesheet" href="conference.css">
</head>

<body>
    <?php
        include 'connectdb.php';
    ?>
    <h2>Intake</h2>
    <?php
        // total registration amount
        $query = 'SELECT SUM(attendanceRate) FROM Student';
        $result = $connection->query($query);
        $students = $result->fetch();

        $query = 'SELECT SUM(attendanceRate) FROM Professional';
        $result = $connection->query($query);
        $professionals = $result->fetch();

        $registration = floatval($students[0]) + floatval($professionals[0]);

        // format the financial support values to have spaces for clarity
        $unformatted = $registration;
        $digits = (int) strpos($unformatted, "."); // get the number of digits by finding the index of the .

        if ($digits > 3)
        {
            for ($i = $digits - 3; $i > 0; $i -= 3)
            {
                $registration = substr_replace($unformatted, ' ', $i, 0);
            }
        }

        else
        {
            $registration = $unformatted;
        }

        // total sponsorship amount
        $query = 'SELECT SUM(financialSupport) FROM Company';
        $result = $connection->query($query);
        $sponsorship = $result->fetch();

        // format the financial support values to have spaces for clarity
        $unformatted = $sponsorship[0];
        $digits = (int) strpos($unformatted, "."); // get the number of digits by finding the index of the .

        if ($digits > 3)
        {
            for ($i = $digits - 3; $i > 0; $i -= 3)
            {
                $sponsorship = substr_replace($unformatted, ' ', $i, 0);
            }
        }

        else
        {
            $sponsorship = $unformatted;
        }

        // display amounts
        echo "<p>Total registration amount: $" . $registration . "</p>";
        echo "<p>Total sponsorship amount: $" . $sponsorship . "</p>";
    ?>

    <form action="conference.php">
        <input type="submit" name="return" value="Return"></input>
    </form>
    
    <?php
        $connection =- NULL;
    ?>
</body>
</html>