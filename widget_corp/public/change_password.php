<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php confirm_logged_in(); ?>

<div id="main">
    <div id="navigation">
    <?php if($_SESSION['is_admin']) { ?>
        <a href="admin.php">&laquo; Main Menu</a></br />
    <?php } else { ?>
        <a href="player.php">&laquo; Main Menu</a></br />
    <?php } ?>
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Change Password for <?php echo htmlentities($_SESSION['username']); ?></h2>
        <form action="change_password_work.php" method="post">
            <p>Original Password:
                <input type="password" name="old_password" value="" />
            </p>
            <p>New Password:
                <input type="password" name="new_password" value="" />
            </p>
            <p>Repeat Password:
                <input type="password" name="new_password2" value="" />
            </p>
            <input type="submit" name="submit" value="Submit" />
        </form>
        <br />
        <?php if($_SESSION['is_admin']) { ?>
            <a href="manage_content.php?player=<?php echo $_SESSION['id']; ?>">Cancel</a>
        <?php} else{ ?>
            <a href="manage_content_player.php?player=<?php echo $_SESSION['id']; ?>">Cancel</a>
        <?php } ?>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>