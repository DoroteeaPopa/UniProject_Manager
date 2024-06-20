<?php
session_start(); // Inițializare sesiune
include("config.php");
$username = mysqli_real_escape_string($db, $_POST['uname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$pass = mysqli_real_escape_string($db, $_POST['password']);
$statut =  mysqli_real_escape_string($db,$_POST['status']);

switch ($statut) {
  case 'student':
      $student_check_query = "SELECT * FROM student WHERE email='$email' LIMIT 1";
      $result = mysqli_query($db, $student_check_query);
      $user_student = mysqli_fetch_assoc($result);
      break;
  case 'prof':
  case 'prof_coord':
      $prof_check_query = "SELECT * FROM profesori_depcie WHERE email='$email' LIMIT 1";
      $result2 = mysqli_query($db, $prof_check_query);
      $user_prof = mysqli_fetch_assoc($result2);
      break;
  default:
      // Cod pentru manipulare caz neașteptat
      break;
}


$user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result3 = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result3);


if ($user) 
{ // if user already exists
    if ($user['username'] === $username) {
        header("Location: index.php?username=existent");
        exit();
    }
    if ($user['email'] === $email) {
        header("Location: index.php?email=existent");
        exit();
    }
} 
else if($user_student || $user_prof) { // if user does not exist, insert new user, only if it s a student or a professor
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    if($statut=='student' && $user_student){
                // Fetch the courses associated with the student's specialization and insert into `cerinte`
                $sql = "SELECT * FROM student CROSS JOIN specializare ON student.specializare=specializare.id_specializare WHERE email='$email'";
                $result = $db->query($sql);
                
                $developer = mysqli_fetch_assoc($result);
                $specializare=$developer['denumire'];
                $id_student=$developer['id_student'];
                
                
                if($specializare=='Tehnologia Informatiei'){
                  $sql3 ="SELECT* 
                    FROM orar 
                    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                    WHERE (profesori.dep='0' OR profesori.dep='1') 
                          AND orar.id_tip='4' 
                          AND (nivele_seri.nume_ns='214/1' OR nivele_seri.nume_ns='224/1' OR nivele_seri.nume_ns='233/1' OR nivele_seri.nume_ns='243/1')
                    ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                
                }
                else if($specializare=='ISM'){
                  $sql3 ="SELECT* 
                    FROM orar 
                    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                    WHERE (profesori.dep='0' OR profesori.dep='1') 
                          AND orar.id_tip='4' 
                          AND (nivele_seri.nume_ns='216/1' OR nivele_seri.nume_ns='225/1' OR nivele_seri.nume_ns='234/1' OR nivele_seri.nume_ns='244/1')
                    ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                
                }
                else if($specializare=='C'){
                  $sql3 ="SELECT* 
                    FROM orar 
                    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                    WHERE (profesori.dep='0' OR profesori.dep='1') 
                          AND orar.id_tip='4' 
                          AND (nivele_seri.nume_ns='211/1' OR nivele_seri.nume_ns='221/1' OR nivele_seri.nume_ns='231/1' OR nivele_seri.nume_ns='241/1')
                    ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);  
                }
                else if($specializare=='EM'){
                  $sql3 ="SELECT* 
                    FROM orar 
                    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                    WHERE (profesori.dep='0' OR profesori.dep='1') 
                          AND orar.id_tip='4' 
                          AND (nivele_seri.nume_ns='311/1' OR nivele_seri.nume_ns='321/1' OR nivele_seri.nume_ns='331/1' OR nivele_seri.nume_ns='341/1')
                    ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                
                }
                else if($specializare=='EA'){
                  $sql3 ="SELECT* 
                    FROM orar 
                    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                    WHERE (profesori.dep='0' OR profesori.dep='1') 
                          AND orar.id_tip='4' 
                          AND (nivele_seri.nume_ns='312/1' OR nivele_seri.nume_ns='322/1' OR nivele_seri.nume_ns='332/1' OR nivele_seri.nume_ns='342/1')
                    ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                
                }
                else if($specializare=='mACS'){
                  $sql3 = "SELECT* 
                  FROM orar 
                  CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                  CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                  CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                  WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mACS'   
                  ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                }
                else if($specializare=='mES'){
                  $sql3 = "SELECT* 
                  FROM orar 
                  CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                  CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                  CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                  WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mES'   
                  ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                }
                else if($specializare=='mICAI'){
                  $sql3 = "SELECT* 
                  FROM orar 
                  CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                  CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                  CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                  WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND (nivele_seri.nume_ns='An_I_mICAI' OR nivele_seri.nume_ns='An_II_mICAI')
                  ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                }
                else if($specializare=='mAAIE'){
                  $sql3 = "SELECT* 
                  FROM orar 
                  CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
                  CROSS JOIN materi ON orar.id_materie=materi.id_materie 
                  CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
                  WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mAAIE'   
                  ORDER BY materi.id_an, nume";
                  $result_materie = $db->query($sql3);
                }
              

                while ($course = mysqli_fetch_assoc($result_materie)) {//pt fiecare materie
                    $id_materie = $course['id_materie'];
                    $sql_task="SELECT id_task FROM taskuri WHERE id_materie=$id_materie";
                    $result_task= $db->query($sql_task);
                    while($task=mysqli_fetch_assoc($result_task)){//adauga fiecare task
                    $id_task = $task['id_task'];
                    // Inserează în tabelul cerințe
                    $insert_cerinte_sql = "INSERT INTO cerinte (id_student, id_materie, id_task) VALUES ($id_student, $id_materie, $id_task)";
                    $db->query($insert_cerinte_sql);
                    }
                }
              
                $sql = "INSERT INTO users (username, email, pass, statut ) VALUES ('$username', '$email', '$hashedPassword', 0)";


    }
    else if($statut=='prof' && $user_prof){
      $sql = "INSERT INTO users (username, email, pass, statut ) VALUES ('$username', '$email', '$hashedPassword', 1)";
    }
    else if($statut=='prof_coord' && $user_prof){
      $sql = "INSERT INTO users (username, email, pass, statut ) VALUES ('$username', '$email', '$hashedPassword', 2)";
    }
    if ($db->query($sql) === TRUE) {
      $_SESSION['login'] = true;
      $_SESSION['email'] = $email;
      if ($statut == 'student') {

                //redirect the user to the logged-in page

                header("Location: index_logged.php");
                exit();
    }
    else if($statut=='prof' || $statut=='prof_coord' ){
        header("Location: index_prof_logged.php");
        exit();
    }else {
        header("Location: index.php?formular=NOK");
        exit();
    }
}
else 
{
  header("Location: index.php?formular=NOKK");
  exit();
}
}
$db->close();
?>

