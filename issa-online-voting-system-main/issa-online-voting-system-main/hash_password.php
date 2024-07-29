<?php
$password = '123456'; // Replace this with the actual password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $hashedPassword;
?>
