<?php 
include("template/cabecera.php");
include("administrador/config/db.php");

$sentenciaSQL = $conexion->prepare("SELECT * FROM cursos ORDER BY id DESC");
$sentenciaSQL->execute();
$listaCursos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    foreach ($listaCursos as $curso) {?>
       <div class="col-md-3">
            <div class="card text-center">
                <img class="card-img-top" src="./img/<?php echo $curso['img']?>" alt="">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $curso['titulo']?></h2>
                    <h4 class="card-title"><?php echo $curso['profesor']?></h4>
                    <h4 class="card-title"><?php echo $curso['plataforma']?></h4>
                    <h4 class="card-title"><?php echo $curso['skill']?></h4>
                    <h6 class="card-title"><?php echo $curso['duracion']?></h6>
                    <a href="<?php echo $curso['repositorio']?>" class="btn btn-light">Ver mas</a>
                </div>
            </div>
        </div>
    <?php }
include("template/pie.php"); ?>
