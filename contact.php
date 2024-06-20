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
          <p class="card-text"><strong>Email:</strong> <a href="mailto:doroteeacristina.popa@ulbsibiu.ro">doroteeacristina.popa@ulbsibiu.ro</a></p>
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
