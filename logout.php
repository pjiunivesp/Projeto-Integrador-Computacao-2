<?php
session_start();
session_destroy(); // Finaliza a sessão
header("Location: index.html"); // Redireciona para a página principal
exit();
?>
