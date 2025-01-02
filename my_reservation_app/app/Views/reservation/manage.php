<!DOCTYPE html>
<html>
<head>
    <title>My Reservations</title>
</head>
<body>
<h1>My Reservations</h1>
<a href="index.php?controller=reservation&action=index">Back to Dashboard</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Meal Type</th>
        <th>Contents</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($reservations as $res): ?>
    <tr>
        <td><?= $res['id'] ?></td>
        <td><?= $res['reservation_date'] ?></td>
        <td><?= $res['meal_type'] ?></td>
        <td><?= htmlspecialchars($res['contents']) ?></td>
        <td><?= $res['quantity'] ?></td>
        <td><?= $res['total_price'] ?></td>
        <td>
            <a href="index.php?controller=reservation&action=edit&id=<?= $res['id'] ?>">Edit</a>
            <a href="index.php?controller=reservation&action=delete&id=<?= $res['id'] ?>"
               onclick="return confirm('Are you sure?')">
               Delete
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
