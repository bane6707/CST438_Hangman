<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--

//  CST438: Hangman
//
//  Created by
//  Name: Debajyoti Banerjee
//  ID: bane6707
//  Date: 3/9/18.
//  Abstract: entry page for the webpage
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CST438 : Hangman</title>
</head>

<?php
include 'config.php';
include 'functions.php';
?>
<body>
  <center>
  <table border="1">
    <tr><th  align="center">Welcome to Hangman</th></tr>
    <tr><td  align="center">You have max <? echo $MAX_ATTEMPTS+1; ?>
      attempts to win the game </td></tr>
<?php
    //include 'config.php';
    //include 'functions.php';
    if (isset($_POST['newWord'])) unset($_SESSION['answer']);
    if (!isset($_SESSION['answer']))
    {
        $_SESSION['attempts'] = 0;
        echo '<tr><td align="center"><img src="img/Hangman-0.png"></td></tr>';
        $answer = fetchWordArray($WORDLISTFILE);
        $_SESSION['answer'] = $answer;
        $_SESSION['hidden'] = hideCharacters($answer);
        echo '<tr><td align="center">Attempts remaining: '.($MAX_ATTEMPTS -
          $_SESSION['attempts'] + 1).'</td></tr>';
    }else
    {
        if (isset ($_POST['userInput']))
        {
            $userInput = $_POST['userInput'];
            $_SESSION['hidden'] = checkAndReplace(strtolower($userInput),
              $_SESSION['hidden'], $_SESSION['answer']);
            checkGameOver($MAX_ATTEMPTS,$_SESSION['attempts'],
              $_SESSION['answer'],$_SESSION['hidden']);
        }
        $_SESSION['attempts'] = $_SESSION['attempts'] + 1;
        $imgNo = intval($_SESSION['attempts']);
        echo "<tr><td align='center'>";
        echo "<img src='img/Hangman-$imgNo.png'></td></tr>";
        //echo '<img src=-"$img">';
        echo '<tr><td align="center">Attempts remaining: '.($MAX_ATTEMPTS -
          $_SESSION['attempts'] + 1)."</td></tr>";
    }
    $hidden = $_SESSION['hidden'];
    foreach ($hidden as $char) echo $char."  ";
?>
<script type="application/javascript">
function validateInput()
{
  var x=document.forms["inputForm"]["userInput"].value;

  if (!/[a-zA-Z]/.test(x)) {
    alert("Please enter a character.");
    return false;
  }

}
</script>
<form name = "inputForm" action = "" method = "post">
<tr><td align="center">Your Guess: <input name = "userInput"
  type = "text" size="1" maxlength="1"  /></td></tr>
<tr><td align="center"><input type = "submit"  value = "Check"
  onclick="return validateInput()"/></td></tr>
<tr><td align="center"><input type = "submit" name = "newWord"
  value = "Try another Word"/></td></tr>
</form>
  </table>
</center>
</body>
</html>
