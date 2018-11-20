<?php
/**
 * Vista para ver en detalle la información contenida en la base de datos sobre una oferta en concreto*/
?>
<h1>Informe Oferta</h1>
<table>
                <?php foreach($ofertas as $oferta) : ?>
                <tr><td>id</td>
                    <td><?=$oferta['id']?></td>
                </tr>
                <tr><td>Descripción</td>
                     <td><?=$oferta['descripcion']?></td>
                </tr>
                <tr><td>Contacto</td>
                    <td><?=$oferta['contacto']?></td>
                </tr>
                <tr><td>Telefono</td>
                    <td><?=$oferta['telefono']?></td>
                </tr>
                <tr><td>email</td>
                    <td><?=$oferta['email']?></td>
                </tr>
                <tr><td>Dirección</td>
                    <td><?=$oferta['direccion']?></td>
                </tr>
                <tr><td>Poblacion</td>
                    <td><?=$oferta['poblacion']?></td>
                </tr>
                <tr><td>CP</td>
                    <td><?=$oferta['cp']?></td>
                </tr>
                <tr><td>Provincia</td>
                    <td><?=$oferta['provincia']?></td>
                </tr>
                <tr><td>Estado</td>
                    <td><?=$oferta['estado']?></td>
                </tr>
                <tr><td>Fecha_Creación</td>
                    <td><?=$oferta['fechaInicial']?></td>
                </tr>
                <tr><td>Fecha_Comunicacion</td>
                    <td><?=$oferta['fechaFin']?></td>
                </tr>
                <tr><td>Psicólogo</td>
                    <td><?=$oferta['psicologo']?></td>
                </tr>
                <tr><td>Candidato</td>
                    <td><?=$oferta['candidato']?></td>
                </tr>
                <tr><td>Otros datos candidato</td>
                    <td><?=$oferta['otros_datos']?></td>
                </tr>
            </table>  

<?php endforeach; ?>











