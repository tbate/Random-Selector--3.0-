<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Create Account</h2>
        <form action="create_account.php" method="post">
            <p>Player Name:
                <input type="text" name="player_name" value="" />
            </p>
            <p>Username:
                <input type="text" name="username" value="" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Create Player" />
        </form>
        <br />
        <a href="login.php">Cancel</a>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>