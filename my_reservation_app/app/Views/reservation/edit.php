<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservation</title>
</head>
<body>
<h1>Edit Reservation #<?= $reservation['id'] ?></h1>
<a href="index.php?controller=reservation&action=manage">Back to Manage</a>

<form method="post">
    <p>
        <label>Contents:
            <input type="text" name="contents" value="<?= htmlspecialchars($reservation['contents']) ?>">
        </label>
    </p>
    <p>
        <label>Quantity:
            <input type="number" name="quantity" value="<?= $reservation['quantity'] ?>">
        </label>
    </p>
    <p><button type="submit">Update</button></p>
</form>
</body>
</html>