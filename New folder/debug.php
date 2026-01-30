<?php
$db_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
echo "<h1>Hash Verification</h1>";
echo "Testing '1234': " . (password_verify('1234', $db_hash) ? '✅ MATCH' : '❌ NO MATCH') . "<br>";
echo "Testing 'password': " . (password_verify('password', $db_hash) ? '✅ MATCH' : '❌ NO MATCH') . "<br>";
echo "Generated hash for '1234': " . password_hash('1234', PASSWORD_DEFAULT) . "<br>";
?>
