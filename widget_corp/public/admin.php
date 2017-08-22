<?php include("../includes/layouts/header.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_player(); ?>

<div id="main">
    <div id="navigation">
        <?php echo navigation($current_player); ?>
    <br />
    <u><a href="new_player.php">+ Add a Player</a></u>
    </div>
    <div id="page">
        <h2>Admin Page</h2>
        <p>Welcome to the admin area, <?php echo htmlentities($_SESSION['username'])?>.</p>
        <p>You are in the group, <?php echo htmlentities($_SESSION['group_id'])?>.</p>
        <ul>
            <li><a href="../board/index.php?group=<?php echo $_SESSION['group_id']; ?>">Load Board</a></li>
            <li><a href="manage_admins.php">Manage Admin Users</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>