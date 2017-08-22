<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_player(); ?>

<div id="main">
    <div id="navigation">
        <?php echo navigation($current_player) ?>
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo form_errors($errors); ?>
        <h2>Add New Player</h2>
        <form action="create_player.php" method="post">
            <p>Player Name:
                <input type="text" name="player_name" value="" />
            </p>
            <p>Username:
                <input type="text" name="username" value="" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <p>Company Name:
                <input type="text" name="group_id" value="" />
            </p>
            <p>Is an Admin:
                <input type="radio" name="is_admin" value="0" /> No
                &nbsp;
                <input type="radio" name="is_admin" value="1" /> Yes
            </p>
            <input type="submit" name="submit" value="Create Player" />
        </form>
        <br />
        <a href="admin.php">Cancel</a>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>