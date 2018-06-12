<?php

$password = 'student123';
$options = [
    'cost' => 12,
];

echo password_hash($password, PASSWORD_BCRYPT, $options);

?>
