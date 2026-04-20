<html>
<head>
    <title>Add New Concert</title>
</head>
<body>
    <h2>Add a New Concert</h2>
    <a href="home_webpage.php">Back to Home</a>
    <br><br>

    <form action="add_concert_webpage.php" method="post">
        Venue Name: <input type="text" name="venue_name" required><br>
        City: <input type="text" name="city" required><br>
        Concert Date (YYYY-MM-DD): <input type="text" name="concert_date" required><br>
        Artist: 
        <select name="artist_id" required>
            <option value="">-- Select an Artist --</option>
            <?php
            $mysqli = new mysqli('localhost', 'lsilva', 'iubaoXu1', 'lsilva');
            
            if ($mysqli->connect_error) {
                die('Connection failed: ' . $mysqli->connect_error);
            }
            
            $result = $mysqli->query('SELECT ArtistId, ArtistName FROM Artist ORDER BY ArtistName');
            
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['ArtistId'] . '">' . htmlspecialchars($row['ArtistName']) . '</option>';
            }
            
            $mysqli->close();
            ?>
        </select><br>
        <input name="submit" type="submit" value="Add Concert">
    </form>

    <?php
    if (isset($_POST['submit'])) 
    {
        // Escape shell arguments for security
        $venue_name = escapeshellarg($_POST['venue_name']);
        $city = escapeshellarg($_POST['city']);
        $concert_date = escapeshellarg($_POST['concert_date']);
        $artist_id = escapeshellarg($_POST['artist_id']);

        $command = 'python3 add_new_concert.py ' . $venue_name . ' ' . $city . ' ' . $concert_date . ' ' . $artist_id;

        // Remove dangerous characters from command to protect web server
        $escaped_command = escapeshellcmd($command);
        echo "<p>New concert added - Venue: $venue_name, City: $city, Date: $concert_date, Artist ID: $artist_id</p>"; 
        
        $output = shell_exec($escaped_command . ' 2>&1');
        // echo $output;           
    }
    ?>

</body>
</html>
