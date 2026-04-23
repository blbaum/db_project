<html>
<head>
    <title>🖌️ Add Artist</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>Add a New Artist 🖌️ </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
            <form action="add_artist_webpage.php" method="post" class = "form">
                Artist Name: <input type="text" name="artist_name" placeholder="Michael Jackson" required><br>
                Genre: <input type="text" name="genre" placeholder="Pop" required><br>
                <input name="submit" type="submit" value="Add Artist">
            </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $artist_name = escapeshellarg($_POST['artist_name']);
        $genre = escapeshellarg($_POST['genre']);

        $script = dirname(__DIR__) . '/functions/add_artist.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $artist_name . ' ' . $genre;
        
        echo "<p class='container'>New artist added - Name: $artist_name, Genre: $genre</p>";
        $output = shell_exec($command . ' 2>&1');
        echo $output;                 
    }
    ?>

</body>
</html>
