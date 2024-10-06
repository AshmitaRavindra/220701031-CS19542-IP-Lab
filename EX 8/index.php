<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Sanukavu@1424";
$dbname = "banking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate random account number
function generateRandomAccountID($cid) {
    // Generating a random number for account ID
    return rand(1000000000, 9999999999);  // Random number prefixed with 'ACC_' and Customer ID
}

// Insert Customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $cname = $_POST['cname'];
    
    // Input validation for customer name
    if (!empty($cname) && preg_match("/^[a-zA-Z ]*$/", $cname)) {
        // Generate unique customer ID
        $cid = "CUST_" . uniqid();
        
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO CUSTOMER (CID, CNAME) VALUES (?, ?)");
        $stmt->bind_param("ss", $cid, $cname);
        
        if ($stmt->execute()) {
            echo "<div class='success-message'>Customer added successfully with Customer ID: " . $cid . "</div>";
        } else {
            echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='error-message'>Invalid customer name.</div>";
    }
}

// Insert Account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_account'])) {
    $atype = $_POST['atype'];
    $balance = $_POST['balance'];
    $cid = $_POST['cid'];
    
    // Input validation for account information
    if (is_numeric($balance) && $balance >= 0 && !empty($cid)) {
        // Generate unique account number
        $ano = generateRandomAccountID($cid);
        
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO ACCOUNT (ANO, ATYPE, BALANCE, CID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $ano, $atype, $balance, $cid);
        
        if ($stmt->execute()) {
            echo "<div class='success-message'>Account added successfully with Account No: " . $ano . "</div>";
        } else {
            echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='error-message'>Invalid input. Ensure balance is a positive number and Customer ID exists.</div>";
    }
}

// Display Customers
$customer_sql = "SELECT * FROM CUSTOMER";
$customer_result = $conn->query($customer_sql);

// Display Accounts
$account_sql = "SELECT ACCOUNT.ANO, ACCOUNT.ATYPE, ACCOUNT.BALANCE, CUSTOMER.CNAME 
                FROM ACCOUNT 
                INNER JOIN CUSTOMER ON ACCOUNT.CID = CUSTOMER.CID";
$account_result = $conn->query($account_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Banking Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 40px;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        label {
            font-size: 1.2em;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            padding: 12px 15px;
        }

        td {
            padding: 12px 15px;
        }

        .success-message, .error-message {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            table, th, td {
                font-size: 0.9em;
            }
        }

        .button-container {
            text-align: center;
            margin: 20px 0;
        }

        .toggle-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1em;
        }

        .toggle-button:hover {
            background-color: #0056b3;
        }

        .hidden {
            display: none;
        }
    </style>
    <script>
        function toggleForm(formId) {
            document.getElementById('customerForm').classList.add('hidden');
            document.getElementById('accountForm').classList.add('hidden');
            document.getElementById(formId).classList.remove('hidden');
        }
    </script>
</head>
<body>

<div class="container">

    <div class="button-container">
        <button class="toggle-button" onclick="toggleForm('customerForm')">Add New Customer</button>
        <button class="toggle-button" onclick="toggleForm('accountForm')">Add New Account</button>
    </div>

    <div id="customerForm" class="form-container hidden">
        <h2>Add New Customer</h2>
        <form method="POST" action="">
            <label for="cname">Customer Name:</label>
            <input type="text" name="cname" required>
            <br>
            <input type="submit" name="add_customer" value="Add Customer">
        </form>
    </div>

    <div id="accountForm" class="form-container hidden">
        <h2>Add New Account</h2>
        <form method="POST" action="">
            <label for="atype">Account Type:</label>
            <select name="atype" required>
                <option value="S">Savings</option>
                <option value="C">Current</option>
            </select>
            <br>
            <label for="balance">Balance:</label>
            <input type="text" name="balance" required>
            <br>
            <label for="cid">Customer ID:</label>
            <input type="text" name="cid" required>
            <br>
            <input type="submit" name="add_account" value="Add Account">
        </form>
    </div>

    <!-- Display Customer Information -->
    <?php if ($customer_result->num_rows > 0): ?>
        <h2>Customer List</h2>
        <table>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
            </tr>
            <?php while($row = $customer_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["CID"]; ?></td>
                <td><?php echo $row["CNAME"]; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>

    <!-- Display Account Information -->
    <?php if ($account_result->num_rows > 0): ?>
        <h2>Account List</h2>
        <table>
            <tr>
                <th>Account No</th>
                <th>Account Type</th>
                <th>Balance</th>
                <th>Customer Name</th>
            </tr>
            <?php while($row = $account_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["ANO"]; ?></td>
                <td><?php echo $row["ATYPE"]; ?></td>
                <td><?php echo $row["BALANCE"]; ?></td>
                <td><?php echo $row["CNAME"]; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No accounts found.</p>
    <?php endif; ?>

</div>

</body>
</html>
