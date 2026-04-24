<html>
<head>
    <title>🏙️ View Concerts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Concerts in a City 🏙️ </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="view_concerts_city_webpage.php" class = "form" method="post">
            City: 
            <select name="city">
                    <?php
                    $project_root = dirname(__DIR__);
                    $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
                    $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                    echo '<option value="">All Cities</option>';
                    $result = $mysqli->query('SELECT DISTINCT City FROM Venue ORDER BY City');
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . ($row['City']) . '">' . htmlspecialchars($row['City']) . '</option>';
                    }
                    $mysqli->close();
                    ?>
                </select><br>
            <input name="submit" type="submit" value="View Concerts">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $city = escapeshellarg($_POST['city']);

        $script = dirname(__DIR__) . '/functions/view_concerts_city.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $city;

        if ($city == "''") {
            echo "<p class='container'>Concerts in All Cities:</p>";
        } else {
            echo "<p class='container'>Concerts in $city:</p>";
        }
        $output = shell_exec($command . ' 2>&1');
        echo $output;
    }
    ?>

</body>
</html>
