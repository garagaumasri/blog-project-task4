<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background:linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
}

.hero-card{
    border:none;
    overflow:hidden;
    border-radius:20px;
}

.hero-card img{
    height:300px;
    object-fit:cover;
}

.dashboard-card{
    transition:0.3s;
    border:none;
    border-radius:15px;
}

.dashboard-card:hover{
    transform:translateY(-8px);
}

footer{
    color:white;
    text-align:center;
    margin-top:40px;
    padding-bottom:20px;
}

</style>

</head>

<body>

<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">

<div class="container">

<a class="navbar-brand fw-bold">
📝 Blog Management System
</a>

<span class="text-white">
👤 <?php echo $_SESSION['username']; ?>
|
🔑 <?php echo ucfirst($_SESSION['role']); ?>
</span>

</div>

</nav>

<div class="container mt-4">

<!-- Hero Banner -->

<div class="card hero-card shadow-lg">

<img
src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200"
class="card-img">

<div class="card-img-overlay d-flex flex-column justify-content-center text-white">

<h1 class="fw-bold">
Welcome, <?php echo $_SESSION['username']; ?> 🎉
</h1>

<h4>
Manage your blog posts professionally
</h4>

<p>
Create, edit, search and organize your content easily.
</p>

</div>

</div>

<!-- Statistics Section -->

<div class="row mt-4">

<div class="col-md-4 mb-3">

<div class="card dashboard-card shadow text-center">

<div class="card-body">

<h1 class="text-primary">
<i class="fas fa-file-alt"></i>
</h1>

<h4>Blog Posts</h4>

<p>Create and manage posts.</p>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card dashboard-card shadow text-center">

<div class="card-body">

<h1 class="text-success">
<i class="fas fa-user"></i>
</h1>

<h4>User</h4>

<p>
<?php echo $_SESSION['username']; ?>
</p>

<p class="text-primary fw-bold">
Role:
<?php echo ucfirst($_SESSION['role']); ?>
</p>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card dashboard-card shadow text-center">

<div class="card-body">

<h1 class="text-danger">
<i class="fas fa-search"></i>
</h1>

<h4>Task 3</h4>

<p>Search & Pagination</p>

</div>

</div>

</div>

</div>

<!-- Action Buttons -->

<div class="card shadow-lg mt-4">

<div class="card-body text-center">

<h3 class="mb-4">
Quick Actions
</h3>

<a
href="create.php"
class="btn btn-success btn-lg m-2">

<i class="fas fa-plus"></i>
Create Post

</a>

<a
href="index.php"
class="btn btn-primary btn-lg m-2">

<i class="fas fa-book"></i>
View Posts

</a>

<a
href="logout.php"
class="btn btn-danger btn-lg m-2">

<i class="fas fa-sign-out-alt"></i>
Logout

</a>

</div>

</div>

</div>

<footer>

<h5>
© 2026 Blog Management System
</h5>


</footer>

</body>
</html>