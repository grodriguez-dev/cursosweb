<?php include("../template/cabezera.php"); ?>
<?php
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID']:"";
    $txtTitulo = (isset($_POST['txtTitulo'])) ? $_POST['txtTitulo']:"";
    $txtProfesor = (isset($_POST['txtProfesor'])) ? $_POST['txtProfesor']:"";
    $txtSkill = (isset($_POST['txtSkill'])) ? $_POST['txtSkill']:"";
    $txtPlataforma = (isset($_POST['txtPlataforma'])) ? $_POST['txtPlataforma']:"";
    $txtDuracion = (isset($_POST['txtDuracion'])) ? $_POST['txtDuracion']:"";
    $txtRepositorio = (isset($_POST['txtRepositorio'])) ? $_POST['txtRepositorio']:"";
    $txtImg = (isset($_FILES['txtImg']['name'])) ? $_FILES['txtImg']['name']:"";
    $accion = (isset($_POST['accion'])) ? $_POST['accion']:"";
    include("../config/db.php");

    switch ($accion) {
        case 'Agregar':
            $sentenciaSQL = $conexion->prepare("INSERT INTO cursos (titulo,img,profesor,skill,plataforma,duracion,repositorio ) VALUES (:titulo,:img,:profesor,:skill,:plataforma,:duracion,:repositorio);");
            $sentenciaSQL->bindParam(':titulo',$txtTitulo);
            $sentenciaSQL->bindParam(':profesor',$txtProfesor);
            $sentenciaSQL->bindParam(':skill',$txtSkill);
            $sentenciaSQL->bindParam(':plataforma',$txtPlataforma);
            $sentenciaSQL->bindParam(':duracion',$txtDuracion);
            if ($txtRepositorio == '') {
                $txtRepositorio = 'https://github.com/grodriguez-dev';
            }
            $sentenciaSQL->bindParam(':repositorio',$txtRepositorio);

            $fecha = new DateTime();
            $nombreArchivo = ($txtImg != "") ? $fecha->getTimestamp()."_".$_FILES['txtImg']['name']: 'imagen.jpg';
            $tmpImg = $_FILES['txtImg']['tmp_name'];

            if ($tmpImg != '') {
                move_uploaded_file($tmpImg, '../../img/'.$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':img',$nombreArchivo);
            $sentenciaSQL->execute();

            header('Location:cursos.php');

        break;

        case 'Modificar':
            $sentenciaSQL = $conexion->prepare("UPDATE cursos SET titulo = :titulo, profesor = :profesor, skill = :skill, plataforma = :plataforma, duracion = :duracion repositorio = :repositorio WHERE id = :id; ");
            $sentenciaSQL->bindParam(':titulo',$txtTitulo);
            $sentenciaSQL->bindParam(':profesor',$txtProfesor);
            $sentenciaSQL->bindParam(':skill',$txtSkill);
            $sentenciaSQL->bindParam(':plataforma',$txtPlataforma);
            $sentenciaSQL->bindParam(':duracion',$txtDuracion);
            $sentenciaSQL->bindParam(':repositorio',$txtRepositorio);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if($txtImg != '') {
                $fecha = new DateTime();
                $nombreArchivo = ($txtImg != "") ? $fecha->getTimestamp()."_".$_FILES['txtImg']['name']: 'imagen.jpg';
                $tmpImg = $_FILES['txtImg']['tmp_name'];

                move_uploaded_file($tmpImg, '../../img/'.$nombreArchivo);

                $sentenciaSQL = $conexion->prepare("SELECT img FROM cursos WHERE id = :id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $cursos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
                if (isset($cursos['img']) && ($cursos['img'] != 'imagen.jpg')) {
                    if (file_exists('../../img/'.$cursos['img'])) {
                        unlink('../../img/'.$cursos['img']);
                    }
                }

                $sentenciaSQL = $conexion->prepare("UPDATE cursos SET img=:img WHERE id=:id; ");
                $sentenciaSQL->bindParam(':img',$nombreArchivo);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
            }
            header('Location:cursos.php');

        break;

        case 'Borrar':
            $sentenciaSQL = $conexion->prepare("SELECT img FROM cursos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $cursos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($cursos['img']) && ($cursos['img'] != 'imagen.jpg')) {
                if (file_exists('../../img/'.$cursos['img'])) {
                    unlink('../../img/'.$cursos['img']);
                }
            }
    
            $sentenciaSQL = $conexion->prepare("DELETE FROM cursos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header('Location:cursos.php');

        break;

        case 'Seleccionar':
            $sentenciaSQL = $conexion->prepare("SELECT * FROM cursos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $cursos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtTitulo = $cursos['titulo'];
            $txtProfesor = $cursos['profesor'];
            $txtSkill = $cursos['skill'];
            $txtPlataforma = $cursos['plataforma'];
            $txtDuracion = $cursos['duracion'];
            $txtRepositorio = $cursos['repositorio'];
            $txtImg = $cursos['img'];
        break;

        default:
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM cursos ORDER BY id DESC");
    $sentenciaSQL->execute();
    $listaCursos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Datos del curso
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" >

                    <div class = "form-group">
                        <label for="txtID">ID: </label>
                        <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                    </div>

                    <div class = "form-group">
                        <label for="txtTitulo">Titulo: </label>
                        <input type="text" required class="form-control" value="<?php echo $txtTitulo; ?>" name="txtTitulo" id="txtTitulo" placeholder="Titulo del curso">
                    </div>

                    <div class = "form-group">
                        <label for="txtProfesor">Profesor: </label>
                        <input type="text" required class="form-control" value="<?php echo $txtProfesor; ?>" name="txtProfesor" id="txtProfesor" placeholder="Profesor del curso">
                    </div>

                    <div class = "form-group">
                        <label for="txtSkill">Skill: </label>
                        <input type="text" required class="form-control" value="<?php echo $txtSkill; ?>" name="txtSkill" id="txtSkill" placeholder="Skill del curso">
                    </div>

                    <div class = "form-group">
                        <label for="txtPlataforma">Plataforma: </label>
                        <input type="text" required class="form-control" value="<?php echo $txtPlataforma; ?>" name="txtPlataforma" id="txtPlataforma" placeholder="Donde viste el curso">
                    </div>

                    <div class = "form-group">
                        <label for="txtDuracion">Duracion: </label>
                        <input type="text" required class="form-control" value="<?php echo $txtDuracion; ?>" name="txtDuracion" id="txtDuracion" placeholder="Duracion el curso">
                    </div>

                    <div class = "form-group">
                        <label for="txtRepositorio">Repositorio: </label>
                        <input type="text" class="form-control" value="<?php echo $txtRepositorio; ?>" name="txtRepositorio" id="txtRepositorio" placeholder="Repositorio del curso">
                    </div>

                    <div class = "form-group">
                        <label for="txtImg">Imagen: </label>
                        <?php if ($txtImg != '') {?>
                            <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImg; ?>" width="50">
                        <?php } ?>
                        <br/>
                        <input type="file" name="txtImg" id="txtImg" require>
                    </div>
                    
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" <?php echo ($accion == 'Seleccionar')?'disabled':''?> value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?php echo ($accion != 'Seleccionar')?'disabled':''?> value="Modificar" class="btn btn-warning">Modificar</button>
                        <a href="" class="btn btn-info">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Profesor</th>
                    <th>Skill</th>
                    <th>Plataforma</th>
                    <th>Duracion</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaCursos as $curso) {?>
                    <tr>
                        <td><?php echo $curso['id']?></td>
                        <td><?php echo $curso['titulo']?></td>
                        <td><?php echo $curso['profesor']?></td>
                        <td><?php echo $curso['skill']?></td>
                        <td><?php echo $curso['plataforma']?></td>
                        <td><?php echo $curso['duracion']?></td>
                        <td>
                            <img class="img-thumbnail rounded" src="../../img/<?php echo $curso['img']?>" width="50">
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $curso['id']; ?>" />
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                            </form>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php include("../template/pie.php"); ?>