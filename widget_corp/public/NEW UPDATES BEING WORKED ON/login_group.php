<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php
    $errors = null;
    $group_name = "";
    if(isset($_POST['submit']))
    {
        $required_fields = array("group_name", "password");
        validate_presences($required_fields);

        if(empty($errors))
        {
            $group_name = mysql_prep($_POST['group_name']);
            $password = mysql_prep($_POST['password']);
            $found_group = attempt_group_login($group_name, $password);

            if($found_group)
            {
                $_SESSION['group_id'] = $group_name;
                if($_SESSION['is_admin'])
                {
                    redirect_to("admin.php");
                }
                else
                {
                    redirect_to("player.php");
                }
            }
            else
            {
                $_SESSION['message'] = "Group Name/Password not found";
            }
        }
    }
?>

<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Login Into A Group</h2>
        <form action="login.php" method="post">
            <p>Group Name:
                <input type="text" name="group_name" value="<?php echo htmlentities($group_name); ?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>