<html>
<head>
    <title>🏙️ View Concerts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Concerts in a City 🏙️ </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="view_concerts_city_webpage.php" method="post">
            <input name="submit" type="submit" value="View Concerts City">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        // $venue_name = escapeshellarg($_POST['venue_name']);
        // $city = escapeshellarg($_POST['city']);
        // $concert_date = escapeshellarg($_POST['concert_date']);
        // $artist_id = escapeshellarg($_POST['artist_id']);

        $command = 'python3 view_concerts_city.py ';

        // Remove dangerous characters from command to protect web server
        $escaped_command = escapeshellcmd($command);
        echo "<p>Concert in city viewed:</p>"; 
        
        $output = shell_exec($escaped_command . ' 2>&1');
        // echo $output;           
    }
    ?>

</body>
</html>
