<?php
include "db.php";
$empid = $_GET['empid'];
$sql = "SELECT * FROM empdetails WHERE EMPID = $empid";
$rs = mysqli_query($conn, $sql);
$emp = mysqli_fetch_assoc($rs);

if (!$emp) {
    echo("Employee not found");
    exit();
}

if (isset($_POST['update_emp'])) {
    $ename = $_POST['ename'];
    $desig = $_POST['desig'];
    $dept = $_POST['dept'];
    $doj = $_POST['doj'];
    $salary = $_POST['salary'];

    $update_sql = "UPDATE empdetails SET ENAME='$ename', DESIG='$desig', DEPT='$dept', DOJ='$doj', SALARY='$salary' WHERE EMPID=$empid";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "Employee details updated successfully.";
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error updating employee details: ".mysqli_error($conn);
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Edit Employee Details</h2>
    <form action="" method="POST">
        <label for="ename">Name:</label>
        <input type="text" id="ename" name="ename" value="<?php echo $emp['ENAME']; ?>" required><br>

        <label for="desig">Designation:</label>
        <input type="text" id="desig" name="desig" value="<?php echo $emp['DESIG']; ?>" required><br>

        <label for="dept">Department:</label>
        <input type="text" id="dept" name="dept" value="<?php echo $emp['DEPT']; ?>" required><br>

        <label for="doj">Date of Joining:</label>
        <input type="date" id="doj" name="doj" value="<?php echo $emp['DOJ']; ?>" required><br>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" value="<?php echo $emp['SALARY']; ?>" required><br>

        <input type="submit" name="update_emp" value="Update">
    </form>
</body>
</html>
