<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Menu</title>
</head>
<body>
<h1>Manage Weekly Menu</h1>
<a href="index.php?controller=auth&action=logout">Logout</a>

<h2>Add New Menu Item</h2>
<form method="post">
    <input type="hidden" name="action" value="add">
    <p>
        <label>Day of Week:
            <select name="day_of_week">
                <option>Monday</option>
                <option>Tuesday</option>
                <option>Wednesday</option>
                <option>Thursday</option>
                <option>Friday</option>
                <option>Saturday</option>
                <option>Sunday</option>
            </select>
        </label>
    </p>
    <p>
        <label>Meal Type:
            <select name="meal_type">
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>
        </label>
    </p>
    <p>
        <label>Item Name: <input type="text" name="item_name" required></label>
    </p>
    <p>
        <label>Price: <input type="number" step="0.01" name="price" required></label>
    </p>
    <button type="submit">Add</button>
</form>

<h2>Existing Menu Items</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Day</th>
        <th>Meal</th>
        <th>Item</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($allMenuItems as $menuItem): ?>
    <tr>
        <td><?= $menuItem['id'] ?></td>
        <td><?= $menuItem['day_of_week'] ?></td>
        <td><?= $menuItem['meal_type'] ?></td>
        <td><?= htmlspecialchars($menuItem['item_name']) ?></td>
        <td><?= $menuItem['price'] ?></td>
        <td>
            <!-- Edit form -->
            <form method="post" style="display:inline">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?= $menuItem['id'] ?>">
                <input type="text" name="day_of_week" value="<?= $menuItem['day_of_week'] ?>">
                <input type="text" name="meal_type" value="<?= $menuItem['meal_type'] ?>">
                <input type="text" name="item_name" value="<?= $menuItem['item_name'] ?>">
                <input type="number" step="0.01" name="price" value="<?= $menuItem['price'] ?>">
                <button type="submit">Update</button>
            </form>

            <!-- Delete form -->
            <form method="post" style="display:inline" onsubmit="return confirm('Delete this item?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $menuItem['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
