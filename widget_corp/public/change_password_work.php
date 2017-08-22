<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
    if(isset($_POST['submit']))
    {
        $required_fields = array('old_password', 'new_password', 'new_password2');
        validate_presences($required_fields);
        $fields_with_max_length = array('old_password' => 60, 'new_password' => 60, 'new_password2' => 60);
        validate_max_lengths($fields_with_max_length);

        if(empty($errors))
        {   
            $old_password = $_POST['old_password'];

            if(attempt_login($_SESSION['username'], $old_password))
            {
                $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT, ['cost' => 10]);
                $new_password2 = $_POST['new_password2'];

                if(password_verify($new_password2, $new_password))
                {
                    $query = "UPDATE '{$_SESSION['group_id']}' SET ";
                    $query .= "hashed_password = '{$new_password}' ";
                    $query .= "WHERE id = '{$_SESSION['id']}' ";
                    $query .= "LIMIT 1";
                    $result = mysqli_query($connection, $query);

                    $query2 = "UPDATE groups SET ";
                    $query2 .= "hashed_password = '{$new_password}' ";
                    $query2 .= "WHERE username = '{$_SESSION['username']}' ";
                    $query2 .= "LIMIT 1";
                    $result2 = mysqli_query($connection, $query2);

                    if($result && $result2)
                    {
                        $_SESSION["message"] = "Password Changed";
                        if($_SESSION['is_admin'])
                        {
                            redirect_to("admin.php");
                        }
                        else
                        {
                            redirect_to("manage_content_player.php?player={$_SESSION['id']}");
                        }
                    }
                    else
                    {
                        if($_SESSION['is_admin'])
                        {
                            redirect_to("manage_content.php?player={$_SESSION['id']}");
                        }
                        else
                        {
                            redirect_to("manage_content_player.php?player={$_SESSION['id']}");
                        }
                    }
                }
                else
                {
                    $_SESSION['message'] = "New Passwords Do Not Match";
                    redirect_to("change_password.php");
                }
            }
            else
            {
                $_SESSION['message'] = "Incorrect Password";
                redirect_to("change_password.php");
            }
        }
    }
?>