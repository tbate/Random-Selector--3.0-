<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
    $current_player = find_player_by_id($_GET['player']);
    if(!$current_player)
    {
        redirect_to("manage_content.php");
    }

    $id = $current_player['id'];
    $query = "DELETE FROM {$current_player['group_id']} WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($connection, $query);

    $query2 = "DELETE FROM groups WHERE id = {$id} LIMIT 1";
    $result2 = mysqli_query($connection, $query2);

    if($result && mysqli_affected_rows($connection) == 1)
    {
        $_SESSION['message'] = "Player deleted";
        redirect_to("manage_content.php");
    }
    else
    {
        $_SESSION['message'] = "Player deletion failed";
        redirect_to("manage_content.php?player={$id}");
    }
?>