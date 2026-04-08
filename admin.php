<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tingog Mo, Aksyon Ko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    session_start();
    require_once 'config.php';
    
    if (!isset($_SESSION['admin_logged_in'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] === ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3>Admin Login</h3>
                                <form method="POST">
                                    <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>
                                <a href="index.php" class="btn btn-link mt-3">Public Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            exit;
        }
    }
    ?>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Admin Dashboard</span>
            <a href="?logout=1" class="btn btn-outline-light">Logout</a>
        </div>
    </nav>
    <div class="container mt-4 mb-5">
        <h2>Manage Suggestions</h2>
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name/Contact</th>
                    <th>Category</th>
                    <th>Suggestion</th>
                    <th>Status</th>
                    <th>Response</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM suggestions ORDER BY created_at DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $name_display = $row['anonymous'] ? 'Anonymous' : ($row['full_name'] . ' (' . $row['contact'] . ')');
                    echo '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . htmlspecialchars($name_display) . '</td>
                            <td>' . htmlspecialchars($row['category']) . '</td>
                            <td>' . htmlspecialchars(substr($row['suggestion'], 0, 100)) . '...</td>
                            <td>' . $row['status'] . '</td>
                            <td>' . htmlspecialchars(substr($row['response'] ?? '', 0, 50)) . '...</td>
                            <td>
                                <a href="process_update.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                          </tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Public Home</a>
    </div>
    <?php
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: admin.php');
        exit;
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

