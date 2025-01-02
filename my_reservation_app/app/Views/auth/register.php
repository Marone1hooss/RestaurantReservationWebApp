<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h1>Register</h1>
<form method="post" action="index.php?controller=auth&action=register">
    <p>
        <label>Username: <input type="text" name="username" required></label>
    </p>
    <p>
        <label>Email: <input type="email" name="email" required></label>
    </p>
    <p>
        <label>Password: <input type="password" name="password" required></label>
    </p>
    <p><button type="submit">Register</button></p>
</form>
</body>
</html>
