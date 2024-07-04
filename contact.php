<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
        body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
}

.card-title {
  font-size: 1.25rem;
  color: #343a40;
}

.card-text {
  color: #6c757d;
}

.btn-primary {
  background-color: #606c81b3; /* Culoarea de fundal specificată */
  border: none;
  color: #fff;
}

.btn-primary:hover,
.btn-primary:active {
  background-color: #606c81b3; /* Aceeași culoare la hover și active */
  opacity: 0.8; /* Opacitate la hover și active */
}

#despre-noi {
  display: none;
  margin-top: 20px;
}

#despre-noi p {
  color: #6c757d;
}

.btn-secondary {
  font-size: 0.875rem; /* Smaller font size */
  padding: 0.25rem 0.5rem; /* Smaller padding */
}

.btn-container {
  display: flex;
  gap: 0.5rem; /* Space between buttons */
  margin-top: 1rem;
}
</style>
<?php
  $currentPage = 'contact';
  require_once "./header.php";
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-lg-4 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Director Departament</h5>
          <p class="card-text"><strong>Conf. dr. Radu CREȚULESCU</strong></p>
          <p class="card-text">Facultatea de Inginerie<br>Universitatea “Lucian Blaga” din Sibiu<br>Str. Emil Cioran 4 550025<br>Sibiu, ROMANIA</p>
          <p class="card-text"><strong>Telefon:</strong> 0269-216062 int. 460</p>
          <p class="card-text"><strong>Email:</strong> <a href="mailto:radu.kretzulescu@ulbsibiu.ro">radu.kretzulescu@ulbsibiu.ro</a></p>
          <div class="btn-container">
            <a href="http://csac.ulbsibiu.ro" target="_blank" class="btn btn-primary">Website</a>
            <button onclick="showDespreNoi()" class="btn btn-secondary">Despre Noi</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Secretariat Departament</h5>
          <p class="card-text"><strong>Monica STROIA</strong></p>
          <p class="card-text">Facultatea de Inginerie<br>Universitatea “Lucian Blaga” din Sibiu<br>Str. Emil Cioran 4 550025<br>Sibiu, ROMANIA</p>
          <p class="card-text"><strong>Telefon:</strong> 0269-216062 int. 461</p>
          <p class="card-text"><strong>Email:</strong> <a href="mailto:depcalc@ulbsibiu.ro">depcalc@ulbsibiu.ro</a></p>
          <div class="btn-container">
            <a href="http://csac.ulbsibiu.ro" target="_blank" class="btn btn-primary">Website</a>
            <button onclick="showDespreNoi()" class="btn btn-secondary">Despre Noi</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Administrator Site</h5>
          <p class="card-text"><strong>Doroteea Cristina POPA</strong></p>
          <p class="card-text">Facultatea de Inginerie<br>Universitatea “Lucian Blaga” din Sibiu<br>Str. Emil Cioran 4 550025<br>Sibiu, ROMANIA</p>
          <p class="card-text"><strong>Telefon:</strong> 0269-216062</p>
          <p class="card-text"><strong>Email:</strong> <a href="mailto:doroteea.popa@ulbsibiu.ro">doroteea.popa@ulbsibiu.ro</a></p>
          <div class="btn-container">
            <a href="http://csac.ulbsibiu.ro" target="_blank" class="btn btn-primary">Website</a>
            <button onclick="showDespreNoi()" class="btn btn-secondary">Despre Noi</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="despre-noi" class="row">
    <div class="col-12">
      <h5>Despre Noi</h5>
      <p>UniProject Manager este o platformă inovatoare creată în anul 2024 de Popa Doroteea Cristina, din cadrul Departamentului de Calculatoare și Inginerie Electrică, specializarea Tehnologia Informației. Scopul principal al acestei platforme este de a facilita gestionarea proiectelor academice atât pentru studenți, cât și pentru profesori, asigurând o experiență educațională optimizată și eficientă.</p>

      <p>Motivația din spatele creării UniProject Manager a fost nevoia de a oferi studenților un instrument centralizat unde aceștia să poată urmări și gestiona progresul proiectelor lor academice. Studenții au acum posibilitatea de a vizualiza proiectele atribuite, cerințele specifice fiecărui proiect și de a actualiza progresul realizat. În plus, platforma le permite să încarce arhive cu proiectele lor și să adauge descrieri relevante pentru fiecare fișier încărcat. Astfel, studenții pot avea o viziune clară asupra tuturor sarcinilor și pot gestiona mai eficient timpul și resursele alocate fiecărui proiect.</p>

      <p>Pe de altă parte, UniProject Manager oferă profesorilor un set de instrumente puternice pentru a monitoriza și evalua performanțele studenților. Profesorii pot vedea lista completă a studenților din fiecare semigrupă la care predau, pot urmări progresul individual al studenților și pot accesa arhivele încărcate de aceștia. În plus, platforma le permite să adauge cerințe de proiect detaliate și să evalueze proiectele studenților în mod transparent și organizat.</p>

      <p>UniProject Manager vine cu o interfață intuitivă și prietenoasă, concepută pentru a simplifica toate aspectele gestionării proiectelor academice. Atât studenții, cât și profesorii beneficiază de o organizare clară a informațiilor, de instrumente eficiente de urmărire a progresului și de un sistem centralizat de comunicare și evaluare. Platforma contribuie la crearea unui mediu educațional colaborativ, în care fiecare participant își poate îndeplini sarcinile cu ușurință și poate atinge obiectivele academice propuse.</p>

      <p>În concluzie, UniProject Manager este mai mult decât o simplă platformă de gestionare a proiectelor; este un partener educațional care își propune să sprijine atât studenții, cât și profesorii în procesul de învățare și predare. Cu ajutorul acestui instrument, procesul educațional devine mai organizat, mai transparent și mai eficient, asigurând astfel succesul academic al tuturor utilizatorilor săi.</p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showDespreNoi() {
    var despreNoi = document.getElementById('despre-noi');
    if (despreNoi.style.display === 'none' || despreNoi.style.display === '') {
      despreNoi.style.display = 'block';
    } else {
      despreNoi.style.display = 'none';
    }
  }
</script>
</body>
</html>
