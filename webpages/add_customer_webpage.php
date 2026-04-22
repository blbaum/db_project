<html>
<head>
    <title>👤 Add Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>Add a New Customer 👤 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="add_customer_webpage.php" method="post">
            <input name="submit" type="submit" value="Add Customer">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        // $venue_name = escapeshellarg($_POST['venue_name']);
        // $city = escapeshellarg($_POST['city']);
        // $concert_date = escapeshellarg($_POST['concert_date']);
        // $artist_id = escapeshellarg($_POST['artist_id']);

        $command = 'python3 add_customr.py ';

        // Remove dangerous characters from command to protect web server
        $escaped_command = escapeshellcmd($command);
        echo "<p>New customer added</p>"; 
        
        $output = shell_exec($escaped_command . ' 2>&1');
        // echo $output;           
    }
    ?>

</body>
</html>
