<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
include 'config.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Admin</title>
</head>

<body>
<link rel="stylesheet" href="style1.css">

<div align="center" style=" margin-top:200px">
<form action="proses_login.php" method="post">
<table width="30%" border="0" cellspacing="0" cellpadding="10" id="wrap">
  <tr>
    <td colspan="2"><h2>Admin Login </h2></td>
    </tr>
  <tr>
    <td>Username</td>
    <td><input type="text" name="username" required></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="password" required></td>
  </tr>
  <tr>
    <td><button type="submit">Login</button></td>
  </tr>
</table>

</form>
</div>

</body>
</html>