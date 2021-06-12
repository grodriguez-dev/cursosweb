<?php
    session_start();
    if (isset($_POST['login'])) {

        $usuario = "";
        $clave = "";

        if (!empty($_POST['usuario'])) {
            $usuario = $_POST['usuario'];
        }else {
            $mensaje_u = 'Por favor ingrese un usuario.';
        }

        if (!empty($_POST['contrasenia'])) {
            $clave = $_POST['contrasenia'];
        }else {
            $mensaje_c = 'Por favor ingrese una contraseña.';
        }

        include("../administrador/config/db.php");

        $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND clave = :clave");
        $sentenciaSQL->bindParam(':usuario',$usuario);
        $sentenciaSQL->bindParam(':clave',$clave);
        $sentenciaSQL->execute();
        $result = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $_SESSION['usuario'] = 'ok';
            $_SESSION['nombreUsuario'] = $usuario;
            header('location:inicio.php');
        }else {
            $mensaje = 'Lo siento, usuario no encontrado.';
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
          <div class="row">
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <br/> <br/> <br/>
                  <div class="card">
                      <div class="card-header">
                          Login
                      </div>
                      <div class="card-body">
                        <?php if (isset($mensaje)) {?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php }?>
                          <form method="POST">
                            <div class = "form-group">
                                <label>Usuario</label>

                                <?php if (isset($mensaje_u)) {?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $mensaje_u; ?>
                                    </div>
                                <?php }?>

                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>

                                <?php if (isset($mensaje_c)) {?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $mensaje_c; ?>
                                    </div>
                                <?php }?>

                                <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                            </div>

                            <div class="form-group">
                                <a href="seccion/registrar.php">¿No tengo un usuario?</a>
                            </div>

                            <input type="submit" name="login" class="btn btn-primary" value="Entrar" style="width: -moz-available;" />
                          </form>  
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>
</html>