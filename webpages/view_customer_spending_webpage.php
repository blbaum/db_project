<html>
<head>
    <title>💰 View Customer Spending</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>View Customer Spending 💰 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
        <form action="view_customer_spending_webpage.php" class = "form" method="post">
            Customer: 
            <select name="customer_id">
                    <?php
                    $project_root = dirname(__DIR__);
                    $creds = json_decode(file_get_contents($project_root . '/credentials.json'), true);
                    $mysqli = new mysqli($creds['hostname'], $creds['user'], $creds['password'], $creds['database']);
                    echo '<option value="">All Customers</option>';
                    $result = $mysqli->query('SELECT DISTINCT CustomerName, CustomerId FROM Customer ORDER BY CustomerId');
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . ($row['CustomerId']) . '">' . htmlspecialchars($row['CustomerName']) . '</option>';
                    }
                    $mysqli->close();
                    ?>
                </select><br>
                <input name="submit" type="submit" value="View Spending">
        </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $customer_id = escapeshellarg($_POST['customer_id']);

        $script = dirname(__DIR__) . '/functions/view_customer_spending.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $customer_id;

        if ($customer_id == "''") {
            echo "<p class='container'>Customer Spending for All Customers:</p>";
        } else {
            echo "<p class='container'>Customer Spending for $customer_id:</p>";
        }
        $output = shell_exec($command . ' 2>&1');
        echo $output;          
    }
    ?>

</body>
</html>
