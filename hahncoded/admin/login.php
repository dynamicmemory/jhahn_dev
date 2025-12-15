<?php 
session_start();
require_once "../../website_data/database.php";

if (isset($_POST["username"], $_POST["password"])) {
    $statement = $database->prepare("SELECT * FROM users WHERE username = :u");
    $statement->execute([":u" => $_POST["username"]]);
    $user = $statement->fetch();

    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        header("Location: index.php");
        exit;
    }
    $error = "Invalid Login details";
}
?>

<h2>Admin Login</h2>

<form method="POST">
    <input name="username" placeholder="username">
    <input name="password" type="password" placeholder="password">
    <button>Login</button>
</form>

<?php if(!empty($error)) echo "<p>$error</p>"; ?>
