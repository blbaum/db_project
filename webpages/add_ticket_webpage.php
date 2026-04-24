<html>
<head>
    <title>🎫 Add Ticket</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>Add a New Ticket 🎫 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
            <form action="add_ticket_webpage.php" method="post" class = "form">
                    Concert:
                    <select name="concert_id" required>
                        <option value="">-- Select a Concert --</option>
                        <?php
                        $project_root = dirname(__DIR__);
                        $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
                        $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                        $result = $mysqli->query('SELECT ArtistName, ConcertId, VenueName, ConcertDate FROM Concert JOIN Artist ON Concert.ArtistId = Artist.ArtistId JOIN Venue ON Concert.VenueId = Venue.VenueId ORDER BY VenueName');
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . ($row['ConcertId']) . '">' . htmlspecialchars($row['ArtistName']) . ' (' . htmlspecialchars($row['VenueName']) . ' - ' . htmlspecialchars($row['ConcertDate']) . ')</option>';
                        }
                        $mysqli->close();
                        ?>
                    </select><br>
                    Customer:
                    <select name="customer_id" required>
                        <option value="">-- Select a Customer --</option>
                        <?php
                        $project_root = dirname(__DIR__);
                        $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
                        $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                        $result = $mysqli->query('SELECT CustomerId, CustomerName FROM Customer ORDER BY CustomerName');
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . ($row['CustomerId']) . '">' . htmlspecialchars($row['CustomerName']) . '</option>';
                        }
                        $mysqli->close();
                        ?>
                    </select><br>
                    Seat Number(s), Comma Separate to Add Multiple: <input type="text" name="seat_number" placeholder = "A1, B2, etc." required><br>
                    Price: <input type="number" name="price" step="0.01" placeholder="0.00" required><br>
                    <input name="submit" type="submit" value="Add Ticket">
            </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $concert_id = escapeshellarg($_POST['concert_id']);
        $customer_id = escapeshellarg($_POST['customer_id']);
        $seat_number = escapeshellarg($_POST['seat_number']);
        $price = escapeshellarg($_POST['price']);

        $script = dirname(__DIR__) . '/functions/add_ticket.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $concert_id . ' ' . $customer_id . ' ' . $seat_number . ' ' . $price;

        echo "<p class='container'>New ticket added - Concert ID: $concert_id, Customer ID: $customer_id, Seat Number: $seat_number, Price: $price</p>";
        $output = shell_exec($command . ' 2>&1');
        echo $output;           
    }
    ?>

</body>
</html>