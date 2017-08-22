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

        $required_fields = array('player_name', 'username', 'password');
        validate_presences($required_fields);
        $fields_with_max_length = array('player_name' => 30, 'username' => 30, 'password' => 30);
        validate_max_lengths($fields_with_max_length);

        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;
            redirect_to("login.php");
        }

        $query = "INSERT INTO groups (";
        $query .= " group_id, player_name, username, hashed_password, is_admin";
        $query .= ") VALUES (";
        $query .= " '', '{$player_name}', '{$username}', '{$hashed_password}', 0";
        $query .= ")";

        $result = mysqli_query($connection, $query);

        if($result)
        {
            $_SESSION["message"] = "Account Created";
            redirect_to("login_group.php");
        }
        else
        {
            $_SESSION["message"] = "Account Creation Failed";
            redirect_to("new_account.php");
        }
    }
    else
    {
        redirect_to("new_account.php");
    }
?>

<?php if(isset($connection)) { mysqli_close($connection); } ?>