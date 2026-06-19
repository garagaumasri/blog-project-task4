<?php
session_start();
include "db.php";

$message = "";

if(isset($_POST['login'])) {

   $username = trim($_POST['username']);
$password = trim($_POST['password']);

if(strlen($username) < 3){

    $message = "❌ Username must be at least 3 characters!";

}
elseif(strlen($password) < 6){

    $message = "❌ Password must be at least 6 characters!";

}
else{

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username=?"
    );

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])) {

            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "❌ Wrong Password!";

        }

    } else {

        $message = "❌ User Not Found!";

    }
}
}
?>

<!DOCTYPE html>
<html>
<head>

<title>BlogSphere Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background-image:url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1600');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    min-height:100vh;
}

.overlay{
    background:rgba(0,0,0,0.5);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-card{
    width:420px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:30px;
    color:white;
    box-shadow:0 8px 32px rgba(0,0,0,0.3);
}

.login-card h2{
    text-align:center;
    margin-bottom:20px;
}

.avatar{
    text-align:center;
    font-size:70px;
    margin-bottom:15px;
}

.btn-login{
    width:100%;
    padding:12px;
    font-size:18px;
    transition:0.3s;
}

.btn-login:hover{
    transform:scale(1.03);
}

.form-control{
    border-radius:10px;
}

.footer-text{
    text-align:center;
    margin-top:20px;
}

.footer-text a{
    color:white;
    text-decoration:none;
    font-weight:bold;
}

.footer-text a:hover{
    text-decoration:underline;
}

</style>

</head>

<body>

<div class="overlay">

<div class="login-card">

<div class="avatar">
<i class="fas fa-user-circle"></i>
</div>

<h2>BlogSphere Login</h2>

<?php if($message != "") { ?>

<div class="alert alert-danger text-center">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
placeholder="Enter Username"
required
minlength="3">

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter Password"
required
minlength="6">

</div>

<button
type="submit"
name="login"
class="btn btn-primary btn-login">

<i class="fas fa-sign-in-alt"></i>
 Login

</button>

</form>

<div class="footer-text">

<p class="mt-3">
Don't have an account?
</p>

<a href="register.php">
Create New Account
</a>

</div>

</div>

</div>

</body>
</html>