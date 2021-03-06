
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Campañas sociales</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans" rel="stylesheet">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/normalize.css"> 
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/simple-sidebar.css">
  <link rel="stylesheet" href="../css/colorbox.css">
  
</head>

<body>
  <?php include_once ('header.php'); ?>

  <nav class=" barra navbar navbar-default" style="background-color: #da273e;">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
           <a class="navbar-brand" href="../../index.php"><img src="../img/logo.png" height="30px" alt="logo de la UTP" style="background: white;" ></a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right" >
              <li><a href="reuniones.php"  style="color: #FFFFFF">Reuniones</a></li>
               <li><a href="calendario.php" style="color: #FFFFFF">Calendario</a></li>
           
              <li><a href="../login.php" style="color: #FFFFFF">Ingresar</a></li>
              <li><a href="../registrousuario.php" style="color: #FFFFFF">Registrar</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->
  </nav>
  
  <section class="seccion contenedor">
    <h2>Calendario de Reuniones</h2>

    <?php
      try {
        require_once('../../modelo/conexion.php');
        conectar();
        $sql = "SELECT reunion_id, topic, dates,title,firstname,lastname ";
        $sql .= " FROM reunions ";
        $sql .= " INNER JOIN campaigns ";
        $sql .= " ON reunions.reunion_id = campaigns.campaign_id ";
        $sql .= " INNER JOIN users ";
        $sql .= " ON users.user_id = reunions.user_id ";
        $sql .= " ORDER BY dates ";

        $resultado = ejecutar($sql);
      } catch (\Exception $e) {
        echo $e->getMessage();
      }
    ?>

    <div class="calendario">
      <?php
      $calendario = array();
        while ($reuniones = $resultado->fetch_assoc()) {
            // captura la fecha de cada evento
            $fecha = $reuniones['dates'];


            $reunion = array(
            'Tema' => $reuniones['topic'],
            'Campaña' => $reuniones['title'],
            'Fecha' => $reuniones['dates'],
            /*'Hora' => $reuniones['time'],*/
            'Encargado' => $reuniones['firstname'] . " " . $reuniones['lastname'],
            );

            $calendario[$fecha][] = $reunion;
          ?>
  <?php } ?>


  <?php
  //imprimir todos los eventos
    foreach ($calendario as $dia => $lista_campanas) { ?>

    <h3>
        <i class="fas fa-calendar-alt" aria-hidden="true"> </i>
        <?php
        setlocale(LC_TIME, 'spanish');
        echo utf8_encode(strftime("%A, %d de %B del %Y", strtotime($dia))) ;
        ?>
    </h3>
    <?php foreach ($lista_campanas as $reunion) { ?>
      <div class="dia">
        <p class="titulo"> <?php echo $reunion['Tema']; ?>  </p>
        <p class="hora">
            <i class="fas fa-clock" aria-hidden="true"></i>
            <?php echo $reunion['Fecha']; ?>
        </p>
        <p><i class="fas fa-map-marker-alt"></i>  <?php echo $reunion['Campaña']; ?></p>
        <p>
          <i class="fas fa-user" aria-hidden="true"></i>
          <?php echo $reunion['Encargado']; ?>
        </p>

      </div>
    <?php }//for each campañas ?>
  <?php }  //For each días ?>


    </div>

    

  </section>

<?php include_once ('footer.php'); ?>

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>


  <script src="js/jquery.colorbox-min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>