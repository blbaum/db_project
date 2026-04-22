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
                Venue Name: <input type="text" name="venue_name" required><br>
                City: <input type="text" name="city" required><br>
                Concert Date (YYYY-MM-DD): <input type="text" name="concert_date" required><br>
                Artist: 
                <select name="artist_id" required>
                    <option value="">-- Select an Artist --</option>
                    <?php
                    $project_root = dirname(__DIR__);
                    $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
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
        $venue_name = escapeshellarg($_POST['venue_name']);
        $city = escapeshellarg($_POST['city']);
        $concert_date = escapeshellarg($_POST['concert_date']);
        $artist_id = escapeshellarg($_POST['artist_id']);

        $script = dirname(__DIR__) . '/functions/add_concert.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $venue_name . ' ' . $city . ' ' . $concert_date . ' ' . $artist_id;

        // Remove dangerous characters from command to protect web server
        $escaped_command = escapeshellcmd($command);
        echo "<p class=container>New concert added - Venue: $venue_name, City: $city, Date: $concert_date, Artist ID: $artist_id</p>"; 
        
        $output = shell_exec($escaped_command . ' 2>&1');
        echo $output;           
    }
    ?>

</body>
</html>
