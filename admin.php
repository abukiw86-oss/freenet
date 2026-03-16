<?php
require "db.php";
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Get all users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY date DESC");
$total_users = mysqli_num_rows($users);

// Get today's registrations
$today = date('Y-m-d');
$today_users = mysqli_query($conn, "SELECT * FROM users WHERE DATE(date) = '$today'");
$total_today = mysqli_num_rows($today_users);
 if (isset($_POST['make_admin'])){
            mysqli_query($conn, "UPDATE users SET role = 'admin' WHERE unique_id = '$user_id'");
            echo  "User promoted to admin";}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin_css.css?v<?php echo time()?>">
</head>
<body>
    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header">
            <h1>
                <i class="fas fa-crown"></i>
                Admin Dashboard
            </h1>
            <p>Welcome back, <?php echo $_SESSION['mail'] ?? 'Admin'; ?>!</p>
            
            <div class="admin-nav">
                <a href="#" class="nav-btn active">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-user-plus"></i>
                <div class="stat-number"><?php echo $total_today; ?></div>
                <div class="stat-label">New Today</div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-shield-alt"></i>
                <div class="stat-number">
                    <?php 
                    $admin_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
                    $admin_data = mysqli_fetch_assoc($admin_count);
                    echo $admin_data['count'];
                    ?>
                </div>
                <div class="stat-label">Administrators</div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-chart-line"></i>
                <div class="stat-number">
                    <?php echo round(($total_today / max($total_users, 1)) * 100, 1); ?>%
                </div>
                <div class="stat-label">Growth Rate</div>
            </div>
        </div>
        <div class="admin-table-container">
            <div class="table-header">
                <h2><i class="fas fa-table"></i> All Users (<?php echo $total_users; ?>)</h2>
            </div>
            
            <?php if($total_users > 0): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($users, 0);
                    while($user = mysqli_fetch_assoc($users)): 
                    ?>
                    <tr>
                        <td>
                            <span class="user-id">#<?php echo $user['id'] ?? 'N/A'; ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($user['mail']); ?></td>
                        <td>
                            <code style="background: #f1f3f4; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                <?php echo htmlspecialchars($user['pass']); ?>
                            </code>
                        </td>
                        <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                        <td>
                            <span class="status-badge role-<?php echo $user['role']; ?>">
                                <i class="fas fa-<?php echo $user['role'] === 'admin' ? 'crown' : 'user'; ?>"></i>
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            $date = new DateTime($user['date']);
                            echo $date->format('M j, Y \a\t g:i A');
                            ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-view">
                                    <form action="" method="post">
                                    <i class="fas fa-eye" name="make_admin"></i> make ademin
                                </button>
                            </form>
                                <button class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-users-slash"></i>
                <h3>No Users Found</h3>
                <p>There are no users registered in the system yet.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>