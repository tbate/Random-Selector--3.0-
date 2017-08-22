var numOfPlayers = 0;
var totalAmount = 0;
var reroll = true;
var song = new Audio('https://upload.wikimedia.org/wikipedia/en/d/d0/Rick_Astley_-_Never_Gonna_Give_You_Up.ogg');
var pauseMode = false;
var paused = false;
var listOfSelected = [];
var songEntered = true;

////////////////////////////////////////////////////////////////////////////////
$(document).on('focus', 'input', function(){
  thisValue = $(this).val();
  $(this).attr('value', '');
});

window.onload = reset;

function reset()
{
    document.getElementById("results").style.visibility = "hidden";
    document.getE("options").style.visibility = "hidden";
    $("results-list").html('');
    $("#table").html('');
    document.getElementById("results").style.visibility = "hidden";
}

function addPlayer(isNew)
{
  $("#table").html('');
  numOfPlayers++;
  if(isNew)
  {
    var player = document.getElementById("newName").value;
    $("#results-list").append("<li id='player" + numOfPlayers + "'><input type='checkbox' id='checkbox" + numOfPlayers + "'>" + player + "</input></li>");
    document.getElementById("results-list").style.visibility = "visible";
    $("#newPlayerDiv").html('');
  }
  else {
    var selection = document.getElementById("playerChoices");
    var player = selection.options[selection.selectedIndex].innerText;
    $("#results-list").append("<li id='player" + numOfPlayers + "'><input type='checkbox' id='checkbox" + numOfPlayers + "'>" + player + "</input></li>");
    document.getElementById("results-list").style.visibility = "visible";
    var list = [];

    for(i = 0; i < selection.length; i++)
    {
      if(selection.options[i].innerText != player)
      {
        list.push(selection.options[i]);
      }
    }

    $("#playerChoices").html('');
    for(k in list)
    {
      $("#playerChoices").append(list[k]);
    }
  }
  showOptions();
}

function newPlayer()
{
  var newP = $("#newPlayerDiv");
  newP.html('');
  newP.append("<input type='text' value='Name' id='newName'>");
  newP.append("<button id='newnameButton' onclick='addPlayer(true);' type='button'>Submit Player</button>");
}

function remove()
{
  $("#table").html('');
  var removed = 0;
  var len = document.getElementById("playerChoices").length;
  var optionList = [];
  for(i = 1; i <= numOfPlayers; i++)
  {
    if(document.getElementById("checkbox" + i).checked)
    {
      $("#playerChoices").append("<option value='name" + (len + 1) + "' id='name" + (len + 1) + "'>" + document.getElementById("player" + i).innerText + "</option>");
      len++;
      removed++;
    }
    else {
      optionList.push(document.getElementById("player" + i));
    }
  }

  $("#results-list li").has("input:checked").remove();
  numOfPlayers -= removed;
  $("#results-list").html('');
  for(z = 1; z <= numOfPlayers; z++)
  {
    $("#results-list").append("<li id='player" + z + "'><input type='checkbox' id='checkbox" + z + "'>" + optionList[z-1].innerText + "</input></li>");
  }

  if(numOfPlayers === 0)
  {
    document.getElementById("results-list").style.visibility = "hidden";
    document.getElementById("options").style.visibility = "hidden";
  }
  else {
    document.getElementById("results").style.visibility = "visible";
    showOptions();
  }
}

function addAll()
{
  var selection = document.getElementById("playerChoices");
  for(i = 0; i < selection.length; i++)
  {
    numOfPlayers++;
    var player = selection.options[i].innerText;
    $("#results-list").append("<li id='player" + numOfPlayers + "'><input type='checkbox' id='checkbox" + numOfPlayers + "'>" + player + "</input></li>");
  }

  $("#playerChoices").empty();

  document.getElementById("results-list").style.visibility = "visible";
  showOptions();
}

function showOptions()
{
  document.getElementById("options").style.visibility = "visible";
    document.getElementById("spin").style.visibility = "hidden";
}

function submitOptions()
{
  isReroll();
  while(songEntered)
  {
    songChoice();
  }
  songEntered = true;
  pauseCheck();

  totalAmount = Math.pow(Math.ceil(Math.sqrt(numOfPlayers)), 2);
  document.getElementById("spin").style.visibility = "visible";

  setupTable();
}

function isReroll()
{
    if(document.getElementById("yesReroll").checked)
    {
      reroll = true;
    }
    else {
      reroll = false;
    }
}

function songChoice()
{
  if(document.getElementById("yesSong").checked)
  {
    customSong();
  }
  else
  {
    song = new Audio('https://upload.wikimedia.org/wikipedia/en/d/d0/Rick_Astley_-_Never_Gonna_Give_You_Up.ogg');
    songEntered = false;
  }
}

function customSong()
{
  var songURL = $("#song");
  songURL.html("");
  songURL.append("<input type='text' value='Put URL Here' id='songLink'></input>");
  songURL.append("<button id='songButton' onclick='changeSong();' type='button'>Submit URL</button>");
}

function changeSong()
{
  song = new Audio(document.getElementById("songLink").value);
  var songDiv = $("#song");
  songDiv.html("");
  songDiv.append("<p><strong>Song Entered!</strong></p>");
  songDiv.append("<p>Want to Change Songs?</p>");
  songDiv.append("<div id='songRadio'>");
  songDiv.append("<input type='radio' value='yesSong' name='songOption' id='yesSong'>Yes</input>");
  songDiv.append("<button type='button' id='songAgain' onclick='customSong();'>Submit</button>")
  songDiv.append("</div>");
  songEntered = false;
}

function pauseCheck()
{
  if(document.getElementById("pauseMode").checked)
  {
    pauseMode = true;
  }
  else {
    pauseMode = false;
  }
}

function setupTable()
{
  var table = $("#table");
  table.html("");
  table.append("<table id='board'>");
  var dim = Math.ceil(Math.sqrt(totalAmount));
  if(reroll)
  {
    for(row = 0; row < dim; row++)
    {
      table.append("<tr>");
      for(col = 1; col < (dim + 1); col++)
      {
        table.append("<td id='" + ((row * dim) + col) + "'></td>");
        if(((row * dim) + col) <= numOfPlayers)
        {
          $("#" + ((row * dim) + col)).append(document.getElementById("player" + ((row * dim) + col)).innerText);
        }
        else {
          $("#" + ((row * dim) + col)).append("Reroll");
        }
      }
      table.append("</tr>");
    }
    table.append("</table>");

    if(pauseMode)
    {
      table.append("<button class='stop' id='stop' onclick='paused = true;' type='button'>Stop Music</button>");
    }
  }
  //not reroll
  else {
    var tempSum = 0;
    for(row = 0; row < dim; row++)
    {
      var temp = 1;
      table.append("<tr>");
      while(temp <= dim)
      {
        if((temp + tempSum) <= numOfPlayers)
        {
          table.append("<td id='" + ((row * dim) + temp) + "'></td>");
          $("#" + ((row * dim) + temp)).append(document.getElementById("player" + ((row * dim) + temp)).innerText);
        }
        temp++;
      }
      tempSum += dim;
      table.append("</tr>");
    }
    table.append("</table>");

    if(pauseMode)
    {
      table.append("<button class='stop' id='stop' onclick='paused = true;' type='button'>Stop Music</button>");
    }
  }

  resetBoard();
}

function buttonLock(toggle)
{
  $(":button").prop('disabled', toggle);
}

function resetBoard()
{
  if(reroll)
  {
    for(i = 1; i <= totalAmount; i++)
    {
      if(document.getElementById(i).innerText == "Reroll")
      {
        document.getElementById(i).style.background = "-moz-linear-gradient(#3BB3B2, #79FFFE)";
      }
      else {
        document.getElementById(i).style.background = "white";
      }
      document.getElementById(i).style.border = "1px solid black";
      document.getElementById(i).style.borderRadius = "5px";
    }
  }
  else {
    for(i = 1; i <= numOfPlayers; i++)
    {
      document.getElementById(i).style.background = "-moz-linear-gradient(#3BB3B2, #79FFFE)";
      document.getElementById(i).style.border = "1px solid black";
      document.getElementById(i).style.borderRadius = "5px";
    }
  }
}

function spin()
{
  song.currentTime = 0;
  buttonLock(true);
  resetBoard();
  paused = false;
  listOfSelected = [];
  var index = 0;
  var len = 0;
  var playBack = song.playbackRate + 0;
  var randomTime = Math.floor((Math.random() * 20) + 7);

  song.play();

  var curRun = setInterval(function(){
    if(song.currentTime >= song.duration - 1)
    {
      song.currentTime = 0;
    }
    if(pauseMode)
    {
      document.getElementById("stop").disabled = false;
      if(paused)
      {
        song.playbackRate = (song.playbackRate / 1.2);
        var numOfReds = Math.floor((Math.random() * 3) + 1);
        var endRun = setInterval(function(){
          if(index  === len + numOfReds)
          {
            var getOutOfJail = Math.floor((Math.random() * 1000) + 1);
            if(document.getElementById(listOfSelected[index - 1]).innerText == "Reroll" || getOutOfJail === 666)
            {
              clearInterval(endRun);
              playSound(0.5, 150);
              song.pause();
              song.playbackRate = playBack;
              spin();
            }
            else {
              playWin(listOfSelected[index - 1]);
              buttonLock(false);
              song.pause();
              song.playbackRate = playBack;
              clearInterval(endRun);
            }
          }
          else {
            var randomRed = 0;
            if(reroll)
            {
              randomRed = Math.floor((Math.random() * totalAmount) + 1);
            }
            else {
              randomRed = Math.floor((Math.random() * numOfPlayers) + 1);
            }
            listOfSelected.push(randomRed);
            setColor(false, randomRed, index);
            playSound(0.5, 400);
            song.playbackRate = (song.playbackRate / 1.1);
            index++;
          }
        }, 1000);
        clearInterval(curRun);
      }
      else {
        var randomYellow = 0;
        if(reroll)
        {
          randomYellow = Math.floor((Math.random() * totalAmount) + 1);
        }
        else {
          randomYellow = Math.floor((Math.random() * numOfPlayers) + 1);
        }

        listOfSelected.push(randomYellow);
        setColor(true, randomYellow, index);
        index++;
        len++;
      }
    }
    else {
      if(randomTime === index)
      {
        song.playbackRate = (song.playbackRate / 1.5);
        var numOfReds = Math.floor((Math.random() * 3) + 1);
        var endRun = setInterval(function(){
          if(index  === len + numOfReds)
          {
            var getOutOfJail = Math.floor((Math.random() * 1000) + 1);
            if(document.getElementById(listOfSelected[index - 1]).innerText == "Reroll" || getOutOfJail === 666)
            {
              playSound(0.5, 150);
              song.pause();
              song.playbackRate = playBack;
              clearInterval(endRun);
              spin();
            }
            else {
              playWin(listOfSelected[index - 1]);
              buttonLock(false);
              song.pause();
              song.playbackRate = playBack;
              clearInterval(endRun);
            }
          }
          else {
            var randomRed = 0;
            if(reroll)
            {
              randomRed = Math.floor((Math.random() * totalAmount) + 1);
            }
            else {
              randomRed = Math.floor((Math.random() * numOfPlayers) + 1);
            }
            listOfSelected.push(randomRed);
            setColor(false, randomRed, index);
            playSound(0.5, 400);
            song.playbackRate = (song.playbackRate / 1.1);
            index++;
          }
        }, 1000);
        clearInterval(curRun);
      }
      else {
        var randomYellow = 0;
        if(reroll)
        {
          randomYellow = Math.floor((Math.random() * totalAmount) + 1);
        }
        else {
          randomYellow = Math.floor((Math.random() * numOfPlayers) + 1);
        }

        listOfSelected.push(randomYellow);
        setColor(true, randomYellow, index);
        index++;
        len++;
      }
    }
  }, 333);
}

function setColor(isYellow, currentSquare, index)
{
  if(isYellow)
  {
    if(reroll)
    {
      if(index === 0)
      {
        document.getElementById(currentSquare).style.background = "yellow";
      }
      else if(document.getElementById(listOfSelected[index - 1]).innerText == "Reroll")
      {
        document.getElementById(listOfSelected[index - 1]).style.background = "-moz-linear-gradient(#3BB3B2, #79FFFE)";
        document.getElementById(currentSquare).style.background = "yellow";
      }
      else {
        document.getElementById(listOfSelected[index - 1]).style.background = "white";
        document.getElementById(currentSquare).style.background = "yellow";
      }
    }
    else {
      if(index === 0)
      {
        document.getElementById(currentSquare).style.background = "yellow";
      }
      else {
        document.getElementById(listOfSelected[index - 1]).style.background = "-moz-linear-gradient(#3BB3B2, #79FFFE)";
        document.getElementById(currentSquare).style.background = "yellow";
      }
    }
  }
  else {
    if(reroll)
    {
      if(document.getElementById(listOfSelected[index - 1]).innerText == "Reroll")
      {
        document.getElementById(listOfSelected[index - 1]).style.background = "-moz-linear-gradient(#3BB3B2, #79FFFE)";
        document.getElementById(currentSquare).style.background = "-moz-linear-gradient(#B22C28, #FF706C)";
      }
      else {
        document.getElementById(listOfSelected[index - 1]).style.background = "white";
        document.getElementById(currentSquare).style.background = "-moz-linear-gradient(#B22C28, #FF706C)";
      }
    }
    else {
        document.getElementById(listOfSelected[index - 1]).style.background = "-moz-linear-gradient(#3BB3B2, #79FFFE)";
        document.getElementById(currentSquare).style.background = "-moz-linear-gradient(#B22C28, #FF706C)";
    }
  }
}

function playSound(time, freq)
{
  var audio = new (window.AudioContext || window.webkitAudioContext)();
  var o = audio.createOscillator();
  o.connect(audio.destination);
  o.frequency.value = freq;
  o.start(0);
  o.stop(time);
}

function playWin(finalSquare)
{
  var audio = new (window.AudioContext || window.webkitAudioContext)();
  var o = audio.createOscillator();
  o.connect(audio.destination);
  o.frequency.value = 500;
  o.start(0);
  o.stop(0.5);

  document.getElementById(finalSquare).style.background = "-moz-linear-gradient(#2DDE1C, #85FF79)";
  document.getElementById(finalSquare).style.border = "2px solid orange";
}
//////////////////////////////////////////////////////////////////////////////////////////

/*
function nameQ()
{
  document.getElementById("spin").disabled = true;
  imgList = [];
  names = [];
  var nextQ = $("#names");
  nextQ.empty();
  people = document.getElementById("amt").value;
  if(people <= 0 || isNaN(people))
  {
    document.getElementById("amt").value = "Invalid Number";
  }
  else
  {
    amt = Math.pow(Math.ceil(Math.sqrt(people)), 2);
    nextQ.append("<h5><u>Names</u></h5>");
    for(i = 0; i < people; i++)
    {
      nextQ.append("<div id='nameDiv" + i + "'>")
      nextQ.append("<input type='text' value='Name' id='name" + i + "'></input>");
      nextQ.append("<button id='img" + i + "' type='button' onclick='addImg(" + (i + 1) + ");'>Add Image?</button>");
      nextQ.append("</div>");
    }
    document.getElementById("amt").value = "Amount of People: " + people;
    songB();
  }
}

function addImg(id)
{
  $("#img" + id).html('');
  var add = $("#nameDiv" + (id-1));
  add.append("<input type='text' value='URL/File Location of Image' id='imgLink" + id + "'></input>");
  add.append("<button id='imgB" + id + "' type='button' onclick='addImgtoTable(" + id + ");'>Add Image</button>");
}

function addImgtoTable(id)
{
  var img  = "<img src='" + document.getElementById("imgLink" + id).value + "' id='pic" + id + "'/>";
  imgList.push(img);
  imgId.push("pic" + id)
}
*/
