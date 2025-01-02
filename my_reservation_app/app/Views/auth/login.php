<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form method="post" action="index.php?controller=auth&action=login">
    <p>
        <label>Email: <input type="email" name="email" required></label>
    </p>
    <p>
        <label>Password: <input type="password" name="password" required></label>
    </p>
    <p><button type="submit">Login</button></p>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <p> New USER? <a href="http://localhost/RestaurantReservationWebApp/my_reservation_app/public/index.php?controller=auth&action=register">Click here</a></p>
</form>
</body>
</html>
