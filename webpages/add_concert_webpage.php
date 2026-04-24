<html>
<head>
    <title>🎤 Add Concert</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>Add a New Concert 🎤 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
            <form action="add_concert_webpage.php" method="post" class="form">
                Venue:
                <select name="venue_id" required>
                    <option value="">-- Select a Venue --</option>
                    <?php
                    $project_root = dirname(__DIR__);
                    $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
                    $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                    $result = $mysqli->query('SELECT VenueId, VenueName, City FROM Venue ORDER BY VenueName');
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . ($row['VenueId']) . '">' . htmlspecialchars($row['VenueName']) . ' (' . htmlspecialchars($row['City']) . ')</option>';
                    }
                    $mysqli->close();
                    ?>
                </select><br>
                Concert Date (YYYY-MM-DD): <input type="date" name="concert_date" required><br>
                Artist:
                <select name="artist_id" required>
                    <option value="">-- Select an Artist --</option>
                    <?php
                    $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                    $result = $mysqli->query('SELECT ArtistId, ArtistName FROM Artist ORDER BY ArtistName');
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . ($row['ArtistId']) . '">' . htmlspecialchars($row['ArtistName']) . '</option>';
                    }
                    $mysqli->close();
                    ?>
                </select><br>
            <input name="submit" type="submit" value="Add Concert" class="submit">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $venue_id = escapeshellarg($_POST['venue_id']);
        $concert_date = escapeshellarg($_POST['concert_date']);
        $artist_id = escapeshellarg($_POST['artist_id']);

        $script = dirname(__DIR__) . '/functions/add_concert.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $venue_id . ' ' . $concert_date . ' ' . $artist_id;

        echo "<p class='container'>New concert added - Venue ID: $venue_id, Date: $concert_date, Artist ID: $artist_id</p>";
        $output = shell_exec($command . ' 2>&1');
        echo $output;           
    }
    ?>

</body>
</html>
