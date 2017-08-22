<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
    if(isset($_POST['submit']))
    {
        if(empty($errors))
        {
            $player_list = generate_list($_SESSION['group_id']);

            foreach($player_list as $player)
            {
                if(isset($_POST[$player['username']]))
                {
                    $query = "UPDATE {$_SESSION['group_id']} SET ";
                    $query .= " is_admin = 1";
                    $query .= " WHERE username = '{$player['username']}'";
                    mysqli_query($connection, $query);
                }
                else
                {
                    $query = "UPDATE {$_SESSION['group_id']} SET ";
                    $query .= " is_admin = 0";
                    $query .= " WHERE username = '{$player['username']}'";
                    mysqli_query($connection, $query);
                }
            }

            $_SESSION['message'] = "Admin Succesfully Updated";
            redirect_to("manage_admins.php");
        }
        else
        {
            redirect_to("manage_admins.php");
        }
    }
    else
    {
        redirect_to("manage_admins.php");
    }
?>

<?php if(isset($connection)) { mysqli_close($connection); } ?>