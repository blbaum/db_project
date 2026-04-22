<html>
<head>
    <title>🎨 View Concerts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Concerts For An Artist 🎨 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="view_concerts_artist_webpage.php" method="post">
            <input name="submit" type="submit" value="View Concerts Artist">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        // $venue_name = escapeshellarg($_POST['venue_name']);
        // $city = escapeshellarg($_POST['city']);
        // $concert_date = escapeshellarg($_POST['concert_date']);
        // $artist_id = escapeshellarg($_POST['artist_id']);

        $command = 'python3 view_concerts_artist.py ';

        // Remove dangerous characters from command to protect web server
        $escaped_command = escapeshellcmd($command);
        echo "<p>Artist Concerts Viewed</p>"; 
        
        $output = shell_exec($escaped_command . ' 2>&1');
        // echo $output;           
    }
    ?>

</body>
</html>
