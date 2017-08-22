<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("/../includes/layouts/header.php"); ?>
<?php find_selected_player(); ?>

<div id="main">
    <div id="navigation">
        <br />
        <a href="admin.php">&laquo; Main Menu</a></br />
        <?php echo navigation($current_player); ?>
    <br />
    <u><a href="new_player.php">+ Add a Player</a></u>
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php if($current_player){ ?>
            <h2>Player Profile</h2>
            Player Name: <?php echo htmlentities($current_player["player_name"]); ?><br />
            Username: <?php echo $current_player['username']; ?><br />
            Is an Admin: <?php echo $current_player['is_admin'] == 1 ? 'yes' : 'no'; ?><br />
            Score: <?php echo $current_player['score']; ?><br />
            <br />
            <a href="delete_player.php?player=<?php echo urlencode($current_player['id']); ?>" onclick="return confirm('Are you sure you want to remove this player?');">Delete Player</a>
        <?php } ?>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>d