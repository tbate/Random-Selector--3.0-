<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php
    $errors = null;
    $username = "";
    if(isset($_POST['submit']))
    {
        $required_fields = array("username", "password");
        validate_presences($required_fields);

        if(empty($errors))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $found_account = attempt_login($username, $password);

            if($found_account)
            {
                $player_list = generate_list($found_account['group_id']);
                $id = null;
                foreach($player_list as $player)
                {
                    if($player['username'] == $found_account['username'])
                    {
                        $id = $player['id'];
                        break;
                    }
                }

                $_SESSION['id'] = $id;
                $_SESSION['group_id'] = $found_account['group_id'];
                $_SESSION['username'] = $found_account['username'];
                $_SESSION['is_admin'] = $found_account['is_admin'];
                if($found_account['is_admin'])
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
                $_SESSION['message'] = "Username/Password not found";
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
        <h2>Login</h2>
        <form action="login.php" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>