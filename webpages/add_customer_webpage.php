<html>
<head>
    <title>👤 Add Customer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container"> 
        <h2>Add a New Customer 👤 </h2>
        <a href="home_webpage.php" class="item"> Back to Home 🏠</a>        
            <form action="add_customer_webpage.php" method="post" class = "form">
                Name: <input type="text" name="customer_name" placeholder="John Smith" required><br>
                <input name="submit" type="submit" value="Add Customer">
            </form>
    </div>
    
    <?php
    if (isset($_POST['submit'])) 
    {
        $customer_name = escapeshellarg($_POST['customer_name']);

        $script = dirname(__DIR__) . '/functions/add_customer.py';
        $command = 'python3 ' . escapeshellarg($script) . ' ' . $customer_name;
    
        echo "<p class='container'>New customer added - Name: $customer_name</p>";
        $output = shell_exec($command . ' 2>&1');
        echo $output;         
    }
    ?>

</body>
</html>
