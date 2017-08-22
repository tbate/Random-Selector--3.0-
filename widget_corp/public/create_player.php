<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
    if(isset($_POST['submit']))
    {
        $player_name = mysql_prep($_POST['player_name']);
        $username = mysql_prep($_POST['username']);
        $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10]);
        $is_admin = (int) $_POST['is_admin'];
        $group_id = mysql_prep(str_replace(' ', '', $_POST['group_id']));

        $required_fields = array('player_name', 'username', 'password', 'group_id', 'is_admin');
        validate_presences($required_fields);
        $fields_with_max_length = array('player_name' => 30, 'username' => 30, 'password' => 30, 'group_id' => 30);
        validate_max_lengths($fields_with_max_length);

        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;
            redirect_to("new_player.php");
        }

        $query = "INSERT INTO {$group_id} (";
        $query .= " group_id, player_name, username, hashed_password, score, is_admin";
        $query .= ") VALUES (";
        $query .= " '{$group_id}', '{$player_name}', '{$username}', '{$hashed_password}', 0, {$is_admin}";
        $query .= ")";

        $secondQuery = "INSERT INTO groups (";
        $secondQuery .= " group_id, username, hashed_password, is_admin";
        $secondQuery .= ") VALUES (";
        $secondQuery .= " '{$group_id}', '{$username}', '{$hashed_password}', {$is_admin}";
        $secondQuery .= ")";

        $result = mysqli_query($connection, $query);
        $result2 = mysqli_query($connection, $secondQuery);

        if($result && $result2)
        {
            $_SESSION["message"] = "Player created";
            redirect_to("manage_content.php");
        }
        else
        {
            $_SESSION["message"] = "Player creation failed";
            redirect_to("new_player.php");
        }
    }
    else
    {
        redirect_to("new_player.php");
    }
?>

<?php if(isset($connection)) { mysqli_close($connection); } ?>