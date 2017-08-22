<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php confirm_logged_in(); ?>
<?php $player_set = find_all_players(); ?>
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
        <form action="update_admins.php" method="post">
        <table>
            <tr>
                <th>Player Name</th>
                <th>Username</th>
                <th>Is Admin?</th>
            </tr>
            <?php while($player = mysqli_fetch_assoc($player_set)) {?>
            <tr>
                <td><?php echo htmlentities($player['player_name']); ?></td>
                <td><?php echo htmlentities($player['username']); ?></td>
                <td><?php 
                    if(htmlentities($player['is_admin']) == 1)
                    {
                        echo "<input type='checkbox' value='1' name='{$player['username']}' checked>";
                    }
                    else
                    {
                        echo "<input type='checkbox' value='0' name='{$player['username']}'>";
                    }
                ?></td>

            </tr>
            <?php } ?>
        </table>
        <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>