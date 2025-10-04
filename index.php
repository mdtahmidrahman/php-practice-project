<!DOCTYPE html>
<html>
<head>
    <title>Insert User Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef1f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #217bab;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #10c947;
        }

        .message {
            margin-top: 15px;
            padding: 8px;
            border-radius: 4px;
        }

        .success {
            background-color: #d9f7d9;
            color: #0a690a;
        }

        .error {
            background-color: #fcdede;
            color: #a22;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Form</h1>

        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "test");

        if ($conn->connect_error) {
            die("<div class='message error'>Connection failed: " . $conn->connect_error . "</div>");
        }

        // Check if form is submitted
        if (isset($_GET['name']) && isset($_GET['email'])) {
            $name = $_GET['name'];
            $email = $_GET['email'];

            if (!empty($name) && !empty($email)) {
                $sql = "INSERT INTO User (name, email) VALUES ('$name', '$email')";
                if ($conn->query($sql) === TRUE) {
                    $last_id = $conn->insert_id;
                    $result = $conn->query("SELECT * FROM User WHERE id = $last_id");
                    $row = $result->fetch_assoc();

                    echo "<div class='message success'>
                            <strong>Data Inserted!</strong><br>
                            ID: " . $row['id'] . "<br>
                            Name: " . htmlspecialchars($row['name']) . "<br>
                            Email: " . htmlspecialchars($row['email']) . "
                          </div>";
                } else {
                    echo "<div class='message error'>Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='message error'>Please fill out both fields.</div>";
            }
        }

        $conn->close();
        ?>

        <form action="index.php" method="GET">
            <label>Name:</label>
            <input type="text" name="name" placeholder="Enter name">

            <label>Email:</label>
            <input type="text" name="email" placeholder="Enter email">

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
