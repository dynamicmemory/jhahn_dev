<?php 
session_start();
require_once "../../storage/database.php";

// Get the ip of the user trying to log in
$ip = $_SERVER["REMOTE_ADDR"];
$now = time();
$max_time = 600;
$max_attempts = 10;

// Check if they are trying to brute force
$stmt = $database->prepare("SELECT * FROM login_attempts WHERE ip = :ip");
$stmt->execute([":ip" => $ip]);
$row = $stmt->fetch();

if ($row && ($now - $row["last_attempt"] < $max_time) && $row["attempts"] >= $max_attempts) {
    $error = "Too many login attempts. Try again later.";
}

else if (isset($_POST["username"], $_POST["password"])) {
    // Check login details
    $statement = $database->prepare("SELECT * FROM users WHERE username = :u");
    $statement->execute([":u" => $_POST["username"]]);
    $user = $statement->fetch();

    // Authenticate correct login 
    if ($user && password_verify($_POST["password"], $user["password"])) {
        $remove = $database->prepare("DELETE FROM login_attempts WHERE ip = :ip");
        $remove->execute([":ip" => $ip]);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        header("Location: index.php");
        exit;
    }
    else {
        // If failed, record the attempt 
    if ($row)
        $database->prepare("UPDATE login_attempts 
            SET attempts = attempts + 1, last_attempt = :t WHERE ip = :ip")
            ->execute([":t"=>$now, ":ip"=>$ip]);
    else 
        $database->prepare("INSERT INTO login_attempts(ip, attempts, last_attempt)
            VALUES(:ip, 1, :t)")->execute([":t"=>$now, ":ip"=>$ip]);

    $error = "Invalid Login details";
    }
}
?>

<h2>Admin Login</h2>

<form method="POST">
    <input name="username" placeholder="username">
    <input name="password" type="password" placeholder="password">
    <button>Login</button>
</form>

<?php if(!empty($error)) echo "<p>$error</p>"; ?>
