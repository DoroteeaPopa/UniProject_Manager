<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="proiecte.css">
  <style>
    /* Custom styles for the info modal */
    #id_popup .modal-content {
        width: 35%;
        margin: auto;
    }
  </style>
</head>
<?php
include("config.php");
$sql = "SELECT * FROM materi WHERE dep='1' OR dep='0'";
$result = $db->query($sql);

$sql2 = "SELECT* 
      FROM orar 
      CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
      CROSS JOIN materi ON orar.id_materie=materi.id_materie 
      CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
      WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' 
      ORDER BY materi.id_an, nume"; 
$result2 = $db->query($sql2);
$db->close();
?>

<body>
<?php
    $currentPage = 'proiecte';
    require_once "./header.php"
?>
  
<br>
<div class="container">
    <?php
    $seen_materii = array();
    while ($developer = mysqli_fetch_assoc($result2)) { 
        if (!in_array($developer['materie'], $seen_materii)) {
            $seen_materii[] = $developer['materie'];
            $class = '';
            switch ($developer['id_an']) {
                case 1:
                    $class = 'first-year';
                    break;
                case 2:
                    $class = 'second-year';
                    break;
                case 3:
                    $class = 'third-year';
                    break;
                case 4:
                    $class = 'fourth-year';
                    break;
                default:
                    $class = '';
                    break;
            }
    ?>
        <div class="card <?php echo $class; ?>" id="<?php echo $developer['id_orar']; ?>" onclick="document.getElementById('id_popup').style.display='block'">
            <h3><?php echo $developer['materie']; ?></h3>
            <p><strong>Profesor:</strong> <?php echo $developer['nume']; ?></p>
            <p><strong>An:</strong> <?php echo $developer['id_an']; ?></p>
            <p><strong>Semestru:</strong> <?php echo $developer['sem']; ?></p>
        </div>
    <?php 
        }
    } 
    ?>
</div>

<!-- Custom Info Modal -->
<div id="id_popup" class="modal" style="text-align: center">
  <div class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id_popup').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>
    <div>
      <p>Inregistrati-va pentru a avea acces la informatii despre acest proiect!</p>
    </div>
    <div>
      <button type="button" onclick="document.getElementById('id_popup').style.display='none'" class="cancelbtn">Inchide</button>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $(".card").click(function(){
        $("#id_popup").css("display", "block");
    });

    $(".close, .cancelbtn").click(function(){
        $("#id_popup").css("display", "none");
    });

    $(window).click(function(event) {
        if (event.target == document.getElementById('id_popup')) {
            document.getElementById('id_popup').style.display = "none";
        }
    });
});
</script>

</body>
</html>
