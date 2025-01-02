<!DOCTYPE html>
<html>
<head>
    <title>Add Reservation</title>
</head>
<body>
<h1>Add Reservation</h1>
<a href="index.php?controller=reservation&action=index">Back to Dashboard</a>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <p>
        <label>Date: <input type="date" name="reservation_date" required></label>
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
        <label>Contents (for lunch/dinner): 
            <input type="text" name="contents">
            <!-- or a dropdown if you want to pick from weekly_menu directly -->
        </label>
    </p>
    <p>
        <label>Quantity: <input type="number" name="quantity" value="1"></label>
    </p>
    <p><button type="submit">Save</button></p>
</form>
</body>
</html>
