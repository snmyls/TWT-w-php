<?php
$conn = new mysqli("localhost", "root", "", "techwise_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitBtn'])) {
    $un = $_POST['username'];
    $pw = $_POST['password'];

    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $un, $pw);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $un;
        header("location:User-Home.php");
        exit; 
    } else {
        $error_message = "Invalid username or password"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> USER Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div class="container">
        <div class="company-name">
             <a href="admin-login.html">
                <img src="img/logo.png" alt="Company Logo" class="company-logo">
            </a>
            <h1>TechWiseThesis</h1>
        </div>

        <!--//////////LOG IN////////////////-->
    <div class="login-wrap">
        <div class="login-html">
            <a href="main.html">
                <button class="exit-button"><i class="fa fa-xmark"></i></button>
            </a>
            <input id="tab-1" type="radio" name="tab" class="log-in" checked><label for="tab-1" class="tab">Log In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-in"><label for="tab-2" class="tab">Sign Up</label>
            <div class="login-form">
                <div class="log-in-htm">
                    <form action="user-login.php" method="POST" id="login-form">
                        <div class="group">
                            <label for="login-username" class="label">Username</label>
                            <input id="login-username" name="username" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="login-password" class="label">Password</label>
                            <input id="login-password" name="password" type="password" class="input" data-type="password" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Log In" name="submitBtn">
                        </div>
                        <div id="error-message" class="error-message"><?php echo $error_message; ?></div> <!-- Display error message -->

                    </form>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="forgot_pass.html">Forgot Password?</a>
                    </div>
                </div>
				
                <!--//////////SIGN UP////////////////-->
               <div class="sign-in-htm">
                    <form action="singup.php" method="post"> 
                        <div class="group">
                            <label for="register-username" class="label">Username</label>
                            <input id="register-username" name="username" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="register-password" class="label">Password</label>
                            <input id="register-password" name="password" type="password" class="input" data-type="password" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Sign Up">
                        </div>
                    </form>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Already have an Account?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
