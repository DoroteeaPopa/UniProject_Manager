<!DOCTYPE html>
<html lang="ro">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
      color: #fff;
      margin: 0;
      padding: 0;
      text-align: center;
    }
    .container {
      max-width: 1200px;
      margin: auto;
      padding: 50px 20px;
    }
    h1 {
      font-size: 48px;
      margin-bottom: 20px;
    }
    h2 {
      font-size: 36px;
      margin-bottom: 40px;
    }
    .description img {
      width: 80%;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .description p {
      font-size: 18px;
      margin: 20px 0;
    }
    .project-header {
      background-color: #0D3165;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 40px;
    }
  </style>
</head>
<body>

<?php
    $currentPage = 'index';
    require_once "./header.php"
?>

<div class="container">
  <div class="project-header">
    <h1>Accelerează-ți proiectele cu UniProject Manager</h1>
    <p>Accelerează planificarea și execuția proiectelor cu UniProject Manager. Simplifică gestionarea sarcinilor și îmbunătățește colaborarea student-profesor. Organizează toate aspectele unui proiect într-un singur loc. Beneficiază de o interfață intuitivă care facilitează urmărirea progresului și identificarea rapidă a problemelor, asigurând livrarea proiectelor la timp.</p>
  </div>

  <div class="description">
    <img style="width: 30%;" src="interfata1.jpg" alt="Pagina Principală">
    <img src="interfata2.jpg" alt="Încărcare și Management Fișiere">
    <p><strong>Profil Utilizator</strong>: Utilizatorii pot vizualiza detaliile profilului lor, inclusiv specializarea, numele, email-ul, anul de studiu și subgrupa. Această secțiune centralizată asigură accesul rapid la informațiile academice.</p>
    <p><strong>Note Academice</strong>: Un format de tabel prezintă o vedere clară asupra materiilor, profesorilor corespunzători, anului academic, semestrului și notelor. Acest lucru permite studenților să își monitorizeze eficient performanțele academice.</p>


    <img style="width: 30%;" src="interfata3.jpg" alt="Profil Utilizator">
    <br><img style="width: 30%;" src="interfata3_2.jpg" alt="Profil Utilizator">
    <img style="width: 30%;" src="interfata3_3.jpg" alt="Profil Utilizator">
    <p><strong>Prezentare Cursuri</strong>: Fiecare curs este prezentat ca un card cu detalii despre subiect, profesor, anul academic și semestru. Layout-ul cardurilor este vizual distinct și ajută la identificarea rapidă a cursurilor.</p>

    <img src="interfata4.jpg" alt="Note Academice">
    <p><strong>Cerințe Proiect</strong>: Pentru cursuri precum Programare Web, cerințele specifice ale proiectelor sunt clar conturate. Formatul de checklist ajută studenții să își urmărească progresul pe diverse sarcini precum implementarea unui site web full stack, crearea de formulare și documentație.</p>

    <img src="interfata5.jpg" alt="Prezentare Cursuri">
    <img src="interfata6.jpg" alt="Cerințe Proiect">
    <p><strong>Încărcare și Management Fișiere</strong>: Utilizatorii pot încărca cu ușurință fișierele proiectelor lor. Interfața oferă un buton intuitiv „Alege fișier” și un câmp de descriere pentru a adăuga context fișierului încărcat. Istoricul încărcărilor este afișat cu detalii precum data încărcării, numele fișierului și descrierea pentru o referință rapidă.</p>
  </div>
</div>

</body>
</html>
