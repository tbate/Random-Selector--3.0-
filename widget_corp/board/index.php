<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<!DOCTYPE html>
<html>
  <head>
    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Person Chooser (Final)</title>
  </head>
  <center><body>
    <h1>Random Person Selector</h1>
    <?php
      if($_SESSION['is_admin'])
      {
        echo "<a href='../public/admin.php'>Back to Admin Page</a>";
      }
      else
      {
        echo "<a href='../public/player.php'>Back to Player Page</a>";
      }
    ?>
    <div id="desc">
      <h4><u>How it works</u></h4>
      <p>The board randomly chooses a person. This version allows the user to enter the number
          of people being considered, filling in any extra spots with a reroll square. When
          submitting the amount, the inputs for the names are given. After submitted, the table
          is created and spinning will start the game. After a randomly generated number of cycles,
          it will slow to the red panels. The amount of red beeps are randomly chosen (1, 2, or 3)
          and will determine who is chosen. There is also a random number deciding if the chosen
          person turns into a reroll (1 in 1000 chance). Both this case and a reroll tile will
          automatically reroll the board. Only works in Firefox, you can resubmit amount and names.</p>
    </div>
    <div id="players">
      <div>
      <select id="playerChoices">
        <?php
          $list_of_players = generate_list($_SESSION['group_id']);
          $index = 0;
          foreach($list_of_players as $player)
          {
              echo "<option value='name";
              echo $index;
              echo "' id='name";
              echo $player['id'];
              echo "'>";
              echo $player['player_name'];
              echo "</option>";
              $index++;
          }
        ?>
      </select>
      <button id="add" type="button" onclick="addPlayer(false);">Add Player</button>
      <button id="remove" type="button" onclick="remove();">Remove Player</button>
      <button id="addAll" type="button" onclick="addAll();">Add All</button>
    </div>
      <button id="new" type="button" onclick="newPlayer();">New Player</button>
      <div id='newPlayerDiv'></div>
    </div>
    <div id="results">
      <ul id="results-list"></ul>
    </div>
    <div id="options">
      <div id="reroll">
        <h4>Reroll?</h4>
        <input type="radio" value="yes" name="rerollOption" id="yesReroll" checked>Yes</input>
        <input type="radio" value="no" name="rerollOption" id="noReroll">No</input>
      </div>
      <div id="song">
        <h4>Have a song in mind?</h4>
        <div id="songRadio">
          <input type="radio" value="yes" name="songOption" id="yesSong">Yes</input>
          <input type="radio" value="no" name="songOption" id="noSong" checked>No</input>
        </div>
      </div>
      <div id="pause">
        <h4>Pick a Mode</h4>
        <input type="radio" value="pause" name="pauseOption" id="pauseMode">Pause</input>
        <input type="radio" value="random" name="pauseOption" id="randomMode" checked>Random</input>
      </div>
      <button type='button' id='buttonOptions' onclick='submitOptions();'>Submit Options</button>
    </div>
    <button id="spin" onclick="spin();">Spin</button>
    <div id="table"></div>
  </body></center>
</html>