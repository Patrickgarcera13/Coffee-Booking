<?php
require_once '../config.php';

$stmt = $pdo->query("
    SELECT * FROM bookings 
    ORDER BY created_at DESC 
    LIMIT 50
");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Coffee Shop</title>
    <style>
        body {
             font-family: Arial; margin: 20px; background: #f5f5f5; 
            }
        .header {
             background: #333; color: white; padding: 20px; text-align: center; 
            }
        table {
             width: 100%; border-collapse: collapse; margin-top: 20px; background: white; 
            }
        th, td {
             padding: 12px; text-align: left; border-bottom: 1px solid #ddd; 
            }
        th {
             background: #4ecdc4; color: white; 
            }
        .status {
             padding: 5px 10px; border-radius: 20px; color: white;
             }
        .new {
             background: #ff6b6b;
             }
        .confirmed {
             background: #4ecdc4;
             }
        tr:hover {
             background: #f0f0f0;
             }
    </style>
</head>
<body>
    <div class="header">
        <h1>☕ Coffee Shop Admin Dashboard</h1>
        <p>Total Bookings: <?php echo count($bookings); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>People</th>
                <th>Status</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td>#<?php echo $booking['id']; ?></td>
                <td><?php echo htmlspecialchars($booking['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($booking['customer_email']); ?></td>
                <td><?php echo htmlspecialchars($booking['customer_phone']); ?></td>
                <td><?php echo date('M d, Y', strtotime($booking['booking_date'])); ?></td>
                <td><?php echo date('g:i A', strtotime($booking['booking_time'])); ?></td>
                <td><?php echo $booking['number_of_people']; ?></td>
                <td>
                    <span class="status new">New</span>
                </td>
                <td><?php echo date('M d, Y h:i A', strtotime($booking['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="text-align: center; margin-top: 20px;">
        <a href="../index.html" style="color: #4ecdc4; text-decoration: none;">← Back to Customer Site</a>
    </p>
</body>
</html>