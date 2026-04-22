<html>
<head>
    <title>💵 Top Artists Revenue</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Top Three Artists Revenue 💵  </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="top_artists_revenue_webpage.php" method="post">
            <input name="submit" type="submit" value="View Top Artists">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        // $venue_name = escapeshellarg($_POST['venue_name']);
        // $city = escapeshellarg($_POST['city']);
        // $concert_date = escapeshellarg($_POST['concert_date']);
        // $artist_id = escapeshellarg($_POST['artist_id']);

        $command = 'python3 top_artists_revenue.py ';

        // Remove dangerous characters from command to protect web server
        $escaped_command = escapeshellcmd($command);
        echo "<p>Top Artists Viewed</p>"; 
        
        $output = shell_exec($escaped_command . ' 2>&1');
        // echo $output;           
    }
    ?>

</body>
</html>
