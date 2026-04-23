<html>
<head>
    <title>💵 Top Artists Revenue</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Top Three Artists Revenue 💵  </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="top_artists_revenue_webpage.php" class = "form" method="post">
            <input name="submit" type="submit" value="View Top Artists">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $script = dirname(__DIR__) . '/functions/top_artists_revenue.py';
        $command = 'python3 ' . escapeshellarg($script);

        $output = shell_exec($command . ' 2>&1');
        echo $output;           
    }
    ?>

</body>
</html>
