<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="header.css">


<header>
  <nav>
    
    <ul>
        
        <li class="<?php if ($currentPage == 'index_prof_lgd') { echo 'active'; } ?>"><a href="index_prof_logged.php">Acasa</a></li>
        <li class="<?php if($currentPage =='proiecte_profesor'){echo 'active';}?>" ><a href="proiecte_profesor.php">Proiecte</a></li>
        <li class="<?php if($currentPage =='contact_prof'){echo 'active';}?>" ><a href="contact_prof.php">Contact</a></li>
        <li style="float:right">
                <form action="logout.php" method="post">
                    <button type="submit" style="width:auto;">Logout</button>
                </form>
        </li>
    </ul>
    
    <div class="header">
        <h1>UniProject Manager</h1>
        <img src="logoUlbs.jpg" alt="logo">
    </div>
    
  </nav>
</header>

