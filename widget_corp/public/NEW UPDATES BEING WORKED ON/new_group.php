<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php logout(); ?>

<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <h2>Create Group</h2>
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo form_errors($errors); ?>
        <form action="create_player.php" method="post">
            <p>Group Name:
                <input type="text" name="group_id" value="" />
            </p>
            <p>Group Password:
                <input type="password" name="group_password" value="" />
            </p>
            <input type="submit" name="submit" value="Create Group" />
        </form>
        <br />
        <a href="login.php">Cancel</a>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>