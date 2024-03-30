<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>
    <h1>Add Employee (Dekan)</h1>
    <form method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="login">Login:</label><br>
        <input type="text" id="login" name="login"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="hidden" name="role" value="dekan">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
