<?php

//require_once __DIR__ . '/../vendor/autoload.php';

$dsn = "mysql:host=db;dbname=todoapp;charset=utf8mb4";
$user = "user";
$pass = "password";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// CREATE
if (!empty($_POST['title'])) {
    $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:t)");
    $stmt->execute([':t' => $_POST['title']]);
    header("Location: /");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['delete']]);
    header("Location: /");
    exit;
}

// READ
$todos = $pdo->query("SELECT * FROM todos ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8" />
<title>Todo App</title>
<style>
    body { font-family: Arial; width: 400px; margin: 30px auto; }
    .todo { margin: 8px 0; padding: 8px; border-bottom: 1px solid #ddd; }
    form { margin-bottom: 20px; }
    input[type=text] { width: 75%; padding: 8px; }
    button { padding: 8px 12px; }
</style>
</head>
<body>

<h1>Todo List</h1>

<form method="post">
    <input type="text" name="title" placeholder="Neue Aufgabe..." required />
    <button type="submit">Hinzufügen</button>
</form>

<?php foreach ($todos as $t): ?>
<div class="todo">
    <?= htmlspecialchars($t['title']) ?>
    <a href="?delete=<?= $t['id'] ?>" style="float:right;color:red" onclick="return confirm('Löschen?')">X</a>
</div>
<?php endforeach; ?>

</body>
</html>
