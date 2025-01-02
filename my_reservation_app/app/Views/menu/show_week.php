<!DOCTYPE html>
<html>
<head>
    <title>Weekly Menu</title>
</head>
<body>
<h1>Weekly Menu</h1>
<a href="index.php?controller=reservation&action=index">Back to Dashboard</a>
<table border="1">
    <tr>
        <th>Day</th>
        <th>Meal</th>
        <th>Item</th>
        <th>Price</th>
    </tr>
    <?php foreach ($allMenuItems as $menuItem): ?>
    <tr>
        <td><?= $menuItem['day_of_week'] ?></td>
        <td><?= $menuItem['meal_type'] ?></td>
        <td><?= htmlspecialchars($menuItem['item_name']) ?></td>
        <td><?= $menuItem['price'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
