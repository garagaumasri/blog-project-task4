<?php
include "db.php";

$message = "";

if(isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $plainPassword = $_POST['password'];

    if(strlen($username) < 3){

        $message = "❌ Username must be at least 3 characters!";

    }
    elseif(strlen($plainPassword) < 6){

        $message = "❌ Password must be at least 6 characters!";

    }
    else{

        $password = password_hash(
            $plainPassword,
            PASSWORD_DEFAULT
        );

        $role = "editor";

        $stmt = $conn->prepare(
            "INSERT INTO users(username,password,role)
             VALUES(?,?,?)"
        );

        $stmt->bind_param(
            "sss",
            $username,
            $password,
            $role
        );

        if($stmt->execute()) {

            $message = "✅ Registration Successful!";

        } else {

            $message = "❌ Error occurred!";

        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>BlogSphere Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background-image:url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1600');
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

.register-card{
    width:420px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:30px;
    color:white;
    box-shadow:0 8px 32px rgba(0,0,0,0.3);
}

.register-card h2{
    text-align:center;
    margin-bottom:20px;
}

.avatar{
    text-align:center;
    font-size:70px;
    margin-bottom:15px;
}

.btn-register{
    width:100%;
    padding:12px;
    font-size:18px;
    transition:0.3s;
}

.btn-register:hover{
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

<div class="register-card">

<div class="avatar">
<i class="fas fa-user-plus"></i>
</div>

<h2>BlogSphere Registration</h2>

<?php if($message != "") { ?>

<div class="alert alert-success text-center">

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
name="register"
class="btn btn-success btn-register">

<i class="fas fa-user-plus"></i>
 Register

</button>

</form>

<div class="footer-text">

<p class="mt-3">
Already have an account?
</p>

<a href="login.php">
Login Here
</a>

</div>

</div>

</div>

</body>
</html>