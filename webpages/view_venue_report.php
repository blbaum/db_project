<html>
<head>
    <title>📊 Venue Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Venue Report 📊 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="view_venue_report.php" class = "form" method="post">
            Venue: 
            <select name="venue_id">
                    <?php
                    $project_root = dirname(__DIR__);
                    $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
                    $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                    echo '<option value="">All Venues</option>';
                    $result = $mysqli->query('SELECT DISTINCT VenueId, VenueName FROM Venue ORDER BY VenueId');
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . ($row['VenueId']) . '">' . htmlspecialchars($row['VenueName']) . '</option>';
                    }
                    $mysqli->close();
                    ?>
                </select><br>
                <input name="submit" type="submit" value="View Report">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $venue_id = escapeshellarg($_POST['venue_id']);

        $script = dirname(__DIR__) . '/functions/view_venue_report.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $venue_id;

        if ($venue_id == "''") {
            echo "<p class='container'>Report for all venues:</p>";
        } else {
            echo "<p class='container'>Report for venue id: $venue_id:</p>";
        }
        $output = shell_exec($command . ' 2>&1');
        echo $output;          
    }
    ?>

</body>
</html>
