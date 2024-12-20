<?php require_once 'engine/init.php';
protect_page();

if (empty($_POST) === false) {
    /* Token usado para segurança contra Cross-Site Scripting */
    if (!Token::isValid($_POST['token'])) {
        $errors[] = 'O token é inválido.';
    }

    $required_fields = array('current_password', 'new_password', 'new_password_again');

    foreach ($_POST as $key => $value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Você precisa preencher todos os campos.';
            break 1;
        }
    }

    $pass_data = user_data($session_user_id, 'password');

    // Compatibilidade .3
    if ($config['ServerEngine'] == 'TFS_03' && $config['salt'] === true) {
        $salt = user_data($session_user_id, 'salt');
    }

    if (sha1($_POST['current_password']) === $pass_data['password'] ||
        ($config['ServerEngine'] == 'TFS_03' && $config['salt'] === true && sha1($salt['salt'] . $_POST['current_password']) === $pass_data['password'])) {

        if (trim($_POST['new_password']) !== trim($_POST['new_password_again'])) {
            $errors[] = 'As novas senhas não coincidem.';
        } else if (strlen($_POST['new_password']) < 6) {
            $errors[] = 'Sua nova senha deve ter pelo menos 6 caracteres.';
        } else if (strlen($_POST['new_password']) > 100) {
            $errors[] = 'Sua nova senha deve ter no máximo 100 caracteres.';
        }
    } else {
        $errors[] = 'Sua senha atual está incorreta.';
    }
}

include 'layout/overall/header.php'; ?>


<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo '
    <div id="successModal" style="display: flex; justify-content: center; align-items: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
        <div style="background-color: #fff; padding: 30px; border-radius: 5px; text-align: center; max-width: 500px; width: 90%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <p style="background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px;">
                Sua senha foi alterada com sucesso.<br>Você precisará fazer login novamente com a nova senha.
            </p>
            <button onclick="closeModal()" style="margin-top: 20px; padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Fechar
            </button>
        </div>
    </div>
    <script>
        function closeModal() {
            document.getElementById("successModal").style.display = "none";
            window.location.href = "index.php"; // Redireciona após fechar o modal
        }
    </script>';
    session_destroy();
    exit();
}

else {
    if (empty($_POST) === false && empty($errors) === true) {
        // Postou o formulário sem erros
        if ($config['ServerEngine'] == 'TFS_02' || $config['ServerEngine'] == 'TFS_10' || $config['ServerEngine'] == 'OTHIRE') {
            user_change_password($session_user_id, $_POST['new_password']);
        } else if ($config['ServerEngine'] == 'TFS_03') {
            user_change_password03($session_user_id, $_POST['new_password']);
        }
        header('Location: changepassword.php?success');
    } else if (empty($errors) === false) {
        echo '<font color="red"><b>';
        echo output_errors($errors);
        echo '</b></font>';
    }
}
?>

<!-- Estilo do Formulário -->
<style>

body{
    height: 50%;
}
    h1 {
        text-align: center;
        color: #2a2a2a;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .form-container {
        width: 50%;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 30px;
    }

    .form-container ul {
        list-style-type: none;
        padding: 0;
    }

    .form-container li {
        margin-bottom: 15px;
    }

    .form-container li label {
        font-size: 1.1rem;
        color: #555;
    }

    .form-container li input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-container li input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 1.2rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 15px;
    }

    .form-container li input[type="submit"]:hover {
        background-color: #45a049;
    }

    .form-container li input[type="submit"]:focus {
        outline: none;
    }

    .error {
        color: red;
        font-weight: bold;
    }
</style>

<h1>Trocar Senha:</h1>
<!-- Formulário HTML -->
<div class="form-container">
    <form action="" method="post">
        <ul>
            <li>
                <label for="current_password">Senha atual:</label>
                <input type="password" name="current_password" id="current_password">
            </li>
            <li>
                <label for="new_password">Nova senha:</label>
                <input type="password" name="new_password" id="new_password">
            </li>
            <li>
                <label for="new_password_again">Repita a nova senha:</label>
                <input type="password" name="new_password_again" id="new_password_again">
            </li>
            <!-- Token do formulário -->
            <?php Token::create(); ?>
            <li>
                <input type="submit" value="Alterar senha">
            </li>
        </ul>
    </form>
</div>

<?php include 'layout/overall/footer.php'; ?>
