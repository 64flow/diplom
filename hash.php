<?php
$hashed_6412 = password_hash("6412", PASSWORD_DEFAULT);
$hashed_flow = password_hash("flow", PASSWORD_DEFAULT);

echo "Хеш для 6412: $hashed_6412 <br>";
echo "Хеш для flow: $hashed_flow";
