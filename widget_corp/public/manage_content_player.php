<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_player(); ?>

<div id="main">
    <div id="navigation">
        <br />
        <a href="player.php">&laquo; Main Menu</a></br />
        <?php echo navigation($current_player); ?>
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php if($current_player){ ?>
            <h2>Player Profile</h2>
            Player Name: <?php echo htmlentities($current_player["player_name"]); ?><br />
            Username: <?php echo $current_player['username']; ?><br />
            Is an Admin: <?php echo $current_player['is_admin'] == 1 ? 'yes' : 'no'; ?><br />
            Score: <?php echo $current_player['score']; ?><br />
        <?php } ?>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>d