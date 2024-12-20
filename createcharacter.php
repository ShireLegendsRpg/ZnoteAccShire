<?php require_once 'engine/init.php';
protect_page();
include 'layout/overall/header.php';

if (empty($_POST) === false) {
    // $_POST['']
    $required_fields = array('name', 'selected_town');
    foreach ($_POST as $key => $value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'You need to fill in all fields.';
            break 1;
        }
    }

    // check errors (= user exist, pass long enough)
    if (empty($errors) === true) {
        if (!Token::isValid($_POST['token'])) {
            $errors[] = 'Token is invalid.';
        }
        $_POST['name'] = validate_name($_POST['name']);
        if ($_POST['name'] === false) {
            $errors[] = 'Your name can not contain more than 2 words.';
        } else {
            if (user_character_exist($_POST['name']) !== false) {
                $errors[] = 'Sorry, that character name already exist.';
            }
            if (!preg_match("/^[a-zA-Z ]+$/", $_POST['name'])) {
                $errors[] = 'Your name may only contain a-z, A-Z and spaces.';
            }
            if (strlen($_POST['name']) < $config['minL'] || strlen($_POST['name']) > $config['maxL']) {
                $errors[] = 'Your character name must be between ' . $config['minL'] . ' - ' . $config['maxL'] . ' characters long.';
            }
            // name restriction
            $resname = explode(" ", $_POST['name']);
            foreach ($resname as $res) {
                if (in_array(strtolower($res), $config['invalidNameTags'])) {
                    $errors[] = 'Your username contains a restricted word.';
                } else if (strlen($res) == 1) {
                    $errors[] = 'Too short words in your name.';
                }
            }
            // Validate vocation id
            if (!in_array((int)$_POST['selected_vocation'], $config['available_vocations'])) {
                $errors[] = 'Permission Denied. Wrong vocation.';
            }
            // Validate town id
            if (!in_array((int)$_POST['selected_town'], $config['available_towns'])) {
                $errors[] = 'Permission Denied. Wrong town.';
            }
            // Validate gender id
            if (!in_array((int)$_POST['selected_gender'], array(0, 1))) {
                $errors[] = 'Permission Denied. Wrong gender.';
            }
            if (vocation_id_to_name($_POST['selected_vocation']) === false) {
                $errors[] = 'Failed to recognize that vocation, does it exist?';
            }
            if (town_id_to_name($_POST['selected_town']) === false) {
                $errors[] = 'Failed to recognize that town, does it exist?';
            }
            if (gender_exist($_POST['selected_gender']) === false) {
                $errors[] = 'Failed to recognize that gender, does it exist?';
            }
            // Char count
            $char_count = user_character_list_count($session_user_id);
            if ($char_count >= $config['max_characters']) {
                $errors[] = 'Your account is not allowed to have more than ' . $config['max_characters'] . ' characters.';
            }
            if (validate_ip(getIP()) === false && $config['validate_IP'] === true) {
                $errors[] = 'Failed to recognize your IP address. (Not a valid IPv4 address).';
            }
        }
    }
}
?>

<h1>Criar Personagem</h1>

<?php if (isset($_GET['success']) && empty($_GET['success'])) {
    echo 'Congratulations! Your character has been created. See you in-game!';
} else {
    if (empty($_POST) === false && empty($errors) === true) {
        if ($config['log_ip']) {
            znote_visitor_insert_detailed_data(2);
        }
        // Register
        $character_data = array(
            'name'        => format_character_name($_POST['name']),
            'account_id'  => $session_user_id,
            'vocation'    => $_POST['selected_vocation'],
            'town_id'     => $_POST['selected_town'],
            'sex'         => $_POST['selected_gender'],
            'lastip'      => getIPLong(),
            'created'     => time()
        );

        user_create_character($character_data);
        header('Location: createcharacter.php?success');
        exit();
    } else if (empty($errors) === false) {
        echo '<font color="red"><b>';
        echo output_errors($errors);
        echo '</b></font>';
    }
?>

<!-- Estilo do Formulário -->
<style>

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

    .form-container li input[type="text"],
    .form-container li select {
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

<!-- Formulário HTML -->
<div class="form-container">
    <form action="" method="post">
        <ul>
            <li>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name">
            </li>
            <li>
                <label for="selected_vocation">Vocation:</label>
                <select name="selected_vocation" id="selected_vocation">
                    <?php foreach ($config['available_vocations'] as $id) { ?>
                    <option value="<?php echo $id; ?>"><?php echo vocation_id_to_name($id); ?></option>
                    <?php } ?>
                </select>
            </li>
            <li>
                <label for="selected_gender">Gender:</label>
                <select name="selected_gender" id="selected_gender">
                    <option value="1">Male (Boy)</option>
                    <option value="0">Female (Girl)</option>
                </select>
            </li>
            <?php
            $available_towns = $config['available_towns'];
            if (count($available_towns) > 1):
            ?>
            <li>
                <label for="selected_town">Town:</label>
                <select name="selected_town" id="selected_town">
                    <?php foreach ($available_towns as $tid): ?>
                    <option value="<?php echo $tid; ?>"><?php echo town_id_to_name($tid); ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <?php else: ?>
            <input type="hidden" name="selected_town" value="<?php echo end($available_towns); ?>">
            <?php endif; ?>

            <!-- Form file -->
            <?php Token::create(); ?>
            <li>
                <input type="submit" value="Create Character">
            </li>
        </ul>
    </form>
</div>

<?php } ?>

<?php include 'layout/overall/footer.php'; ?>
