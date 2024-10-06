<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f4f8;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Employee Details</h2>

    <?php
    include 'db.php';
    
    $sql = "SELECT * FROM empdetails";
    $rs = mysqli_query($conn, $sql);
    echo("<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Department</th>
                <th>DOJ</th>
                <th>Salary</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>"
    );
    if ($rs) {
        while ($emp = mysqli_fetch_assoc($rs)) {
            echo("<tr>
                <td>{$emp['EMPID']}</td>
                <td>{$emp['ENAME']}</td>
                <td>{$emp['DESIG']}</td>
                <td>{$emp['DEPT']}</td>
                <td>{$emp['DOJ']}</td>
                <td>{$emp['SALARY']}</td>
                <td>
                    <form action='editEmp.php' method='GET'>
                        <input type='hidden' name='empid' value='{$emp['EMPID']}'>
                        <input type='submit' value='Edit'>
                    </form>
                </td>
            </tr>");
        }
    }

    echo("</tbody></table>");
    mysqli_close($conn);
    ?>
</body>
</html>
