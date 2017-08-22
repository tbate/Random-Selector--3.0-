<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
    if(isset($_POST['submit']))
    {
        $group_name = mysql_prep(str_replace(' ', '', $_POST['group_name']));
        $hashed_password = password_hash($_POST['group_password'], PASSWORD_BCRYPT, ['cost' => 10]);

        $required_fields = array('group_name', 'group_password');
        validate_presences($required_fields);
        $fields_with_max_length = array('group_name' => 30, 'group_password' => 30);
        validate_max_lengths($fields_with_max_length);

        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;
            redirect_to("login.php");
        }

        $query = "CREATE TABLE '{$group_name}' ( ";
        $query .= "id INT(11) NOT NULL AUTO_INCREMENT, ";
        $query .= "group_id VARCHAR(30) NOT NULL, ";
        $query .= "player_name VARCHAR(30) NOT NULL, ";
        $query .= "username VARCHAR(30) NOT NULL, ";
        $query .= "hashed_password VARCHAR(60) NOT NULL, ";
        $query .= "score INT(3) NOT NULL, ";
        $query .= "is_admin TINYINT(1) NOT NULL, ";
        $query .= "PRIMARY KEY (id)";
        $query .= ")";

        $secondQuery = "INSERT INTO '{$group_name}' (";
        $secondQuery .= " group_id, player_name, username, hashed_password, score, is_admin";
        $secondQuery .= ") VALUES (";
        $secondQuery .= " '{$group_name}', '{$_SESSION['player_name']}', '{$_SESSION['username']}', '{$_SESSION['password']}, 0, {$_SESSION['is_admin']}";
        $secondQuery .= ")";

        $result = mysqli_query($connection, $query);
        $result2 = mysqli_query($connection, $secondQuery);

        if($result && $result2)
        {
            $_SESSION['group_id'] = $group_name;
            $_SESSION["message"] = "Group created";
            redirect_to("admin.php");
        }
        else
        {
            $_SESSION["message"] = "Group Creation Failed";
            redirect_to("new_group.php");
        }
    }
    else
    {
        redirect_to("new_group.php");
    }
?>

<?php if(isset($connection)) { mysqli_close($connection); } ?>