<?php
require "db.php";


if(isset($_POST["insert"])) {
    $mail = mysqli_real_escape_string($conn, $_POST["mail"]);
    $password = $_POST["password"];

    // Use prepared statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE mail = ?");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        if($data['pass'] === $password) { 
            // Set session variables
            session_start();
            
            $_SESSION["admin"] = $data["id"];
            $_SESSION["role"] = $data["role"];
            $_SESSION["date"] = time();
            
            if($data["role"] == 'admin') {
                header("location: admin.php");
            } else {
                header("location: index.php");
            }
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
    
    mysqli_stmt_close($stmt);
}

if(isset($error)) {
    echo "<div style='color: red; text-align: center; padding: 10px;'>$error</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }
        .demo-accounts {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">mail:</label>
                <input type="text" id="username" name="mail" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="insert">Login</button>
        </form>
        
        </div>
    </div>
</body>
</html>