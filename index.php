<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];

$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$start = ($page - 1) * $limit;

$search = "";

if(isset($_GET['search']) && !empty($_GET['search'])){

    $search = trim($_GET['search']);
    $searchTerm = "%".$search."%";

    $stmt = $conn->prepare(
        "SELECT * FROM posts
         WHERE user_id=?
         AND (title LIKE ? OR content LIKE ?)
         ORDER BY id DESC
         LIMIT $start,$limit"
    );

    $stmt->bind_param(
        "iss",
        $user_id,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();
    $result = $stmt->get_result();

    $count_stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM posts
         WHERE user_id=?
         AND (title LIKE ? OR content LIKE ?)"
    );

    $count_stmt->bind_param(
        "iss",
        $user_id,
        $searchTerm,
        $searchTerm
    );

    $count_stmt->execute();

    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();

} else {

    $stmt = $conn->prepare(
        "SELECT * FROM posts
         WHERE user_id=?
         ORDER BY id DESC
         LIMIT $start,$limit"
    );

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $count_stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM posts
         WHERE user_id=?"
    );

    $count_stmt->bind_param("i", $user_id);
    $count_stmt->execute();

    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();
}

$total_posts = $count_row['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html>
<head>

<title>BlogSphere - My Posts</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background:linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
}

.hero{
    background:white;
    border-radius:20px;
    overflow:hidden;
    margin-top:20px;
}

.hero img{
    height:300px;
    object-fit:cover;
}

.card{
    border:none;
    border-radius:15px;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    margin-right:10px;
}

.footer{
    color:white;
    text-align:center;
    padding:20px;
}

</style>

</head>

<body>

<nav class="navbar navbar-dark bg-dark shadow">

<div class="container">

<span class="navbar-brand fw-bold">
📝 BlogSphere
</span>

<span class="text-white">

<img
src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
class="avatar">

<?php echo $_SESSION['username']; ?>

</span>

</div>

</nav>

<div class="container">

<div class="hero shadow-lg">

<img
src="https://images.pexels.com/photos/261949/pexels-photo-261949.jpeg"
class="img-fluid w-100"
alt="Blog Banner">

<div class="p-4">

<h1 class="text-center">
📖 My Blog Posts
</h1>

<p class="text-center text-muted">
Manage, Search and Organize Your Content
</p>

</div>

</div>

<div class="text-center my-4">

<a href="dashboard.php" class="btn btn-secondary m-1">
🏠 Dashboard
</a>

<a href="create.php" class="btn btn-success m-1">
➕ Create Post
</a>

<a href="logout.php" class="btn btn-danger m-1">
🚪 Logout
</a>

</div>

<form method="GET" class="mb-4">

<div class="input-group">

<span class="input-group-text">
🔍
</span>

<input
type="text"
name="search"
class="form-control"
placeholder="Search Posts..."
value="<?php echo htmlspecialchars($search); ?>">

<button class="btn btn-primary">
Search
</button>

</div>

</form>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<div class="card shadow-lg mb-4">

<div class="card-body">

<h3 class="card-title">
<?php echo htmlspecialchars($row['title']); ?>
</h3>

<p class="card-text">
<?php echo nl2br(htmlspecialchars($row['content'])); ?>
</p>

<p class="text-muted">
📅 Posted on:
<?php echo $row['created_at']; ?>
</p>

<a
href="edit.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary">

✏ Edit

</a>

<?php if($_SESSION['role'] == 'admin'){ ?>

<a
href="delete.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger"
onclick="return confirm('Delete this post?')">

🗑 Delete

</a>

<?php } ?>

</div>

</div>

<?php

}

}else{

?>

<div class="alert alert-warning text-center">

No Posts Found

</div>

<?php

}

?>

<div class="text-center mb-4">

<?php if($page > 1){ ?>

<a
href="index.php?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>"
class="btn btn-warning m-1">

⬅ Previous

</a>

<?php } ?>

<?php

for($i=1;$i<=$total_pages;$i++){

?>

<a
href="index.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
class="btn btn-secondary m-1">

<?php echo $i; ?>

</a>

<?php

}

?>

<?php if($page < $total_pages){ ?>

<a
href="index.php?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>"
class="btn btn-success m-1">

Next ➡

</a>

<?php } ?>

</div>

<div class="footer">

<h5>© 2026 BlogSphere</h5>

<p>Smart Blog Management Platform</p>

</div>

</div>

</body>
</html>