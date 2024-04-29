<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="header.css">
<header>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="login_action.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="password"><b>Parola</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>



<div id="id02" class="modal">
  
  <form class="modal-content animate" action="signup_action.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label for="email">Email</label>
      <input type="text" placeholder="Email" name="email" required><br>

      <label for="uname"><b>Nume de utilizator</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="password"><b>Parola</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Sign Up</button>

    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>

    <?php
$fullurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($fullurl, "email=gresit") == true)
{
    echo "<p class=\"eroare\"> Emailul exista!</p>";
    exit();
}
else if(strpos($fullurl, "username=gresit") == true)
{
    echo "<p class=\"eroare\">User name exista</p>";
}


?>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    else if(event.target == modal2){
        modal2.style.display = "none";
    }
}


</script>
  <nav>
    

    <ul>
        
        <li class="<?php if($currentPage =='index'){echo 'active';}?>" ><a href="index.php">Acasa</a></li>
        <li class="<?php if($currentPage =='proiecte'){echo 'active';}?>" ><a href="proiecte.php">Proiecte</a></li>
        <li class="<?php if($currentPage =='contact'){echo 'active';}?>" ><a href="contact.php">Contact</a></li>
        <li style="float:right"><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button></li>
        <li style="float:right"><button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign Up</button></li>

    </ul>
    <div class="header">
        <h1>UniProject Manager</h1>
        <img src="logoUlbs.jpg" alt="logo">
    </div>
    


  </nav>
</header>

