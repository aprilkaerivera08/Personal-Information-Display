<?php

// If a form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $action = $_POST['action'];

    $file = 'submission.csv';

    // Create new entry
    if ($action === 'register') {
        $fp = fopen($file, 'a');
        // Added the escape parameter to fputcsv
        fputcsv($fp, [$fname, $lname, $email, $password], ',', '"', '\\');
        fclose($fp);
        $message = 'Registration successful!';
    }
    
    // Update existing entry
    if ($action === 'update') {
        $rows = [];
        $updated = false;

        // Read existing data from the CSV
        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[2] === $email) { // Find record by email
                    $data = [$fname, $lname, $email, $password]; // Update this record
                    $updated = true;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }

        // Read existing data from the CSV
        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[2] === $email) { // Find record by email
                    $data = [$fname, $lname, $email, $password]; // Update this record
                    $updated = true;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }

        // Re-write the updated data back to CSV
        if ($updated) {
            $fp = fopen($file, 'w');
            // Added the escape parameter to fputcsv
            foreach ($rows as $row) {
                fputcsv($fp, $row, ',', '"', '\\');
            }
            fclose($fp);
            $message = 'Profile updated successfully!';
        } else {
            $message = 'Error: Could not find user to update.';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0C2B4E;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: #1D546C;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #1A3D64;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
        }
        button:hover {
            background-color: green;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Personal Information Display</h2>

        <!-- Display message after form submission -->
        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <!-- Registration Form -->
        <form method="POST" action="">
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="hidden" name="action" value="register">
            <button type="submit">Submit</button>
            <button type="reset">Reset</button>
        </form>

        <!-- Show the data that was entered by the user -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="display-data">
                <h3>Your Submitted Information</h3>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($fname); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lname); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Password:</strong> <?php echo htmlspecialchars($password); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
