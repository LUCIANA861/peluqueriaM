<?php
session_start();

if(isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost","root","","peluqueria");
    if($conexion->connect_error) die("Error: ".$conexion->connect_error);

    $stmt = $conexion->prepare("SELECT usuario, contrasena FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        if(password_verify($contrasena, $fila['contrasena'])) {
            $_SESSION['usuario'] = $fila['usuario'];
            header("Location: admin.php"); 
            exit;
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Dueña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- MaterializeCSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background: url('ca3.jpg') center/cover no-repeat;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .brand-logo {
       font-family: 'Great Vibes', cursive;
      font-size: 2rem;
      margin-left: 10px;
    }

    /* NAV */
    nav {
      background: linear-gradient(90deg, #000000, #4c4c4d);
       height: 11vh;

     position: fixed;       /* posición fijo*/ 
      padding: 10px 0;       /* posicion de la letras*/ 
      z-index: 1000;         /*visible el nav*/
    }

     /* ...existing code... */
    
    /* Ajustes para el sidenav */
    .sidenav {
        top: 11vh !important; /* Mismo alto que el navbar */
        z-index: 999;
    }

    /* Ajuste adicional para el navbar */
    nav {
        width: 100%;
        left: 0;
        right: 0;
    }


    @media (max-width: 992px) {
        /* ...existing code... */
        
        .sidenav {
            top: 100 !important; /* En móvil, el sidenav empieza desde arriba */
        }
    }
     
    nav .brand-logo {
      font-weight: bold;
      font-size: 1.7rem;
      margin-left: 20px;
    }




    /* CONTENEDOR LOGIN */
    .login-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }
    .login-card {
      background: rgba(0, 0, 0, 0.85);
      padding: 40px;
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0,0,0,0.4);
      color: white;
      backdrop-filter: blur(8px);
    }
    .login-card h4 {
      margin-bottom: 30px;
      font-weight: bold;
    }
    .input-field label {
      color: #ccc;
    }
    input[type=text], input[type=password] {
      color: white;
    }
    input[type=text]:focus, input[type=password]:focus {
      border-bottom: 2px solid #f57c00 !important;
      box-shadow: 0 1px 0 0 #f57c00 !important;
    }

    /* BOTONES */
    .btn-custom {
      background: linear-gradient(90deg, #000000, #4c4c4d);
      color: #fff;
      font-weight: bold;
      width: 100%;
      border-radius: 30px;
      transition: transform 0.3s ease;
    }
    .btn-custom:hover {
      transform: scale(1.05);
      background: linear-gradient(90deg, #4c4c4d, #000000);
    }

    .btn-volver {
      margin-bottom: 20px;
      border-radius: 30px;
      width: 100%;
      background: #f57c00 !important;
    }

    /* ERROR */
    .error-msg {
      color: #ff5252;
      margin-bottom: 15px;
      font-weight: bold;
    }

    /* FOOTER */
    footer {
      background: linear-gradient(90deg, #000000, #4c4c4d);
      color: #fff;
      padding: 15px 0;
      text-align: center;
    }
     /* 📱 RESPONSIVE */
    @media (max-width: 992px) {
      .brand-logo {
        font-size: 1.8rem;
      }

      .hero {
        height: 60vh;
      }
      .hero h1 {
        font-size: 2.5rem;
      }
      .hero p {
        font-size: 1rem;
      }

      .carousel .carousel-item img {
        width: 90%;
        border-radius: 20px;
      }

      footer {
        font-size: 0.9rem;
        padding: 10px 0;
      }

      .section.white h2, .section.grey.lighten-3 h2 {
        font-size: 1.8rem;
      }
    }

    @media (max-width: 600px) {
      .hero {
        height: 50vh;
      }
      .hero h1 {
        font-size: 2rem;
      }
      .hero p {
        font-size: 0.9rem;
      }
      .collection-item {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

 <!-- NAVBAR -->
  <nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">Peluquería M</a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="index.html">Inicio</a></li>
        <li><a href="servicios.html">Servicios</a></li>
        <li><a href="ubicacion2.html">Ubicación</a></li>
        <li><a href="login.php">Administrador</a></li>
      </ul>
    </div>
  </nav>

     <!-- MENÚ LATERAL (para celular) -->
  <ul class="sidenav" id="mobile-demo">
    <li><a href="index.html">Inicio</a></li>
    <li><a href="servicios.html">Servicios</a></li>
    <li><a href="ubicacion2.html">Ubicación</a></li>
    <li><a href="login.php">Administrador</a></li>
  </ul>

  <!-- LOGIN -->
  <div class="login-container">
    <div class="login-card z-depth-5">
      <a href="index.html" class="btn btn-volver"><i class="fas fa-arrow-left"></i> VOLVER</a>
      <h4>Login Dueña</h4>
      <?php if(!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
      <form method="POST">
        <div class="input-field">
          <input type="text" name="usuario" id="usuario" required>
          <label for="usuario"><i class="fas fa-user"></i> Usuario</label>
        </div>
        <div class="input-field">
          <input type="password" name="contrasena" id="contrasena" required>
          <label for="contrasena"><i class="fas fa-lock"></i> Contraseña</label>
        </div>
        <button class="btn btn-custom waves-effect waves-light" type="submit">
          <i class="fas fa-sign-in-alt"></i> Entrar
        </button>
      </form>
    </div>
  </div>

  <!-- FOOTER -->
  <footer>
    © 2025 Peluquería M | Todos los derechos reservados
  </footer>

  <!-- Materialize JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

   <!-- JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.sidenav');
      M.Sidenav.init(elems);

      var elem = document.querySelector('.carousel.carousel-slider');
      var instance = M.Carousel.init(elem, { fullWidth: true, indicators: true });

      setInterval(() => instance.next(), 5000);

      document.getElementById('next').addEventListener('click', () => instance.next());
      document.getElementById('prev').addEventListener('click', () => instance.prev());
    });
  </script>
</body>
</html>
