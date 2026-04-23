<html>
<head>
    <title>🎨 View Concerts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Concerts For An Artist 🎨 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="view_concerts_artist_webpage.php" class = "form" method="post">
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
            <input name="submit" type="submit" value="View Concerts Artist">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $artist_id = escapeshellarg($_POST['artist_id']);

        $script = dirname(__DIR__) . '/functions/view_concerts_artist.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $artist_id;

        # Looks pretty ugly if query returns nothing
        echo "<p class='container'>Concerts for Artist ID $artist_id:</p>";
        $output = shell_exec($command . ' 2>&1');
        echo $output;
    }
    ?>

</body>
</html>
