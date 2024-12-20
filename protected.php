<?php
require_once 'engine/init.php';
// To direct users here, add: protect_page(); Here before loading header.
include 'layout/overall/header.php';
if (user_logged_in() === true) {
?>

<h1>PARE!</h1>
<p>Ummh... Por que você está farejando por aqui?</p>

<?php
} else {
?>

<h1>Desculpe, você precisa estar logado para fazer isso!</h1>
<p>Por favor, registre-se ou faça login.</p>

<?php
}
include 'layout/overall/footer.php'; ?>
