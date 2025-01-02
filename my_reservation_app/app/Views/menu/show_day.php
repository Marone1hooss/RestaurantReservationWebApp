<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($day) ?> Menu</title>
</head>
<body>
<h1><?= htmlspecialchars($day) ?> Menu</h1>
<a href="index.php?controller=reservation&action=index">Back to Dashboard</a>
<table border="1">
    <tr>
        <th>Meal</th>
        <th>Item</th>
        <th>Price</th>
    </tr>
    <?php foreach ($menuItems as $menuItem): ?>
    <tr>
        <td><?= $menuItem['meal_type'] ?></td>
        <td><?= htmlspecialchars($menuItem['item_name']) ?></td>
        <td><?= $menuItem['price'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
