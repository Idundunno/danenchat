<?php

session_start();

if(isset($_GET['logout'])){    
	
	//Simple exit message 
    $logout_message = "<div class='msgln'> <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
	
	session_destroy();
	header("Location: index.php"); //Redirect the user 
}

if(isset($_POST['enter2'])){
    $_SESSION['name'] = "Dana";
    $logout_message = "<div class='msgln'> <b class='user-name-left'>". $_SESSION['name'] ."</b> has joined the chat.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
}
if(isset($_POST['enter'])){
    $_SESSION['name'] = "Radu";
    $logout_message = "<div class='msgln'> <b class='user-name-left'>". $_SESSION['name'] ."</b> has joined the chat.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
}

function loginForm(){
	echo' 
<div id="loginform"> 
<p>Please choose your name!</p> 
<form action="index.php" method="post"> 
<input for="name" type="submit" name="enter" id="name" value="Radu" /> 
<input for="name" type="submit" name="enter2" id="name" value="Dana" /> 
</form> 
</div> 
';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>Chat Page</title>
        <meta name="description" content="proiect" />
        <link rel="stylesheet" href="style.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    </head>
    <body>
    <script>function menuOnClick() {
    document.getElementById("menu-bar").classList.toggle("change");
    document.getElementById("nav").classList.toggle("change");
    document.getElementById("menu-bg2").classList.toggle("change-bg");
  }</script>
      <div id="menu">
        <div id="menu-bar" onclick="menuOnClick()">
          <div id="bar1" class="bar"></div>
          <div id="bar2" class="bar"></div>
          <div id="bar3" class="bar"></div>
        </div>
        <nav class="nav" id="nav">
          <ul>
            <li><a href="/demo/index.html">Home</a></li>
            <li><a class="active" href="./">Chat</a></li>
          </ul>
        </nav>
      </div>
      <div class="menu-bg2" id="menu-bg2"></div>
      <div class="text-box">
            
    <section>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
        <div id="wrapper">
            <div id="menus">
                <p class="welcome">hi dana, here below you can find the chat</p>
                <p class="logout"><a id="exit" href="#">Go back</a></p>
            </div>

            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");          
                echo $contents;
            }
            ?>
            </div>

            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document 
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });

                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request 

                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div 

                            //Auto-scroll 
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request 
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div 
                            }	
                        }
                    });
                }

                setInterval (loadLog, 2500);

                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
        </script>
        <section>
    </body>
</html>
<?php
    }
?>