<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

// Fetch post using Prepared Statement
$stmt = $conn->prepare(
    "SELECT * FROM posts WHERE id=?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['update'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side Validation
    if(empty($title)) {

        $message = "❌ Title is required!";

    }
    elseif(strlen($title) < 5) {

        $message = "❌ Title must be at least 5 characters!";

    }
    elseif(strlen($content) < 20) {

        $message = "❌ Content must be at least 20 characters!";

    }
    else {

        // Update using Prepared Statement
        $stmt = $conn->prepare(
            "UPDATE posts
             SET title=?, content=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "ssi",
            $title,
            $content,
            $id
        );

        if($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "❌ Error Updating Post!";

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Post - BlogSphere</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background-image:url('https://images.unsplash.com/photo-1455390582262-044cdead277a?w=1600');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    min-height:100vh;
}

.overlay{
    background:rgba(0,0,0,0.55);
    min-height:100vh;
    padding:40px 0;
}

.edit-card{
    width:700px;
    max-width:95%;
    margin:auto;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:30px;
    color:white;
    box-shadow:0 8px 32px rgba(0,0,0,0.3);
}

.form-control{
    border-radius:12px;
}

.btn{
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.03);
}

.avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    margin-right:10px;
}

.navbar{
    box-shadow:0 4px 10px rgba(0,0,0,0.3);
}

</style>

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

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

<div class="overlay">

<div class="edit-card">

<h2 class="text-center mb-4">

<i class="fas fa-edit"></i>
 Edit Blog Post

</h2>

<?php if($message != "") { ?>

<div class="alert alert-danger text-center">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Post Title
</label>

<input
type="text"
name="title"
class="form-control"
value="<?php echo $row['title']; ?>"
required
minlength="5">

</div>

<div class="mb-3">

<label class="form-label">
Post Content
</label>

<textarea
name="content"
class="form-control"
rows="8"
required
minlength="20"><?php echo $row['content']; ?></textarea>

</div>

<button
type="submit"
name="update"
class="btn btn-primary w-100">

<i class="fas fa-save"></i>
 Update Post

</button>

</form>

<div class="text-center mt-4">

<a href="dashboard.php"
class="btn btn-secondary m-1">

🏠 Dashboard

</a>

<a href="index.php"
class="btn btn-success m-1">

📖 View Posts

</a>

</div>

</div>

</div>

</body>
</html>