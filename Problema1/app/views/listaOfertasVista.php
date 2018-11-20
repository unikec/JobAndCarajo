<?php
/**
 * VISTA QUE MUESTA LA LISTA DE TAREAS.
 * El controlador será el que nos proporcine en la variable $tareas
 * que contiene las tareas a mostrar
 */
?>
<h1>Ofertas de empleo</h1>
<table>
    <tr><th>id</th>
        <th>Descripción</th>
        <th>Contacto</th>
        <th>Telefono</th>
        <th>email</th>
        <th>Dirección</th>
        <th>Poblacion</th>
        <th>CP</th>
        <th>Provincia</th>
        <th>Estado</th>
        <th>Fecha_Creación</th>
        <th>Fecha_Comunicacion</th>
        <th>Psicólogo</th>
        <th>Candidato</th>
        <th>Otros datos candidato</th>
        <th></th>
    </tr>
<?php foreach($ofertas as $oferta) : ?>
    <tr>
   		 <td><?=$oferta['id']?></td>
        <td><?=$oferta['descripcion']?></td>
        <td><?=$oferta['contacto']?></td>
        <td><?=$oferta['telefono']?></td>
        <td><?=$oferta['email']?></td>
        <td><?=$oferta['direccion']?></td>
        <td><?=$oferta['poblacion']?></td>
        <td><?=$oferta['cp']?></td>
        <td><?=$oferta['provincia']?></td>
        <td><?=$oferta['estado']?></td>
        <td><?=$oferta['fechaInicial']?></td>
        <td><?=$oferta['fechaFin']?></td>
        <td><?=$oferta['psicologo']?></td>
        <td><?=$oferta['candidato']?></td>
        <td><?=$oferta['otros_datos']?></td>
        <td>
        	<a href="?ctrl=detalleOfertaControl&id=<?=$oferta['id']?>">[+info]</a>
            <a href="?<?=CTRL_VAR?>=<?=CTRL_EDIT?>&id=<?=$oferta['id']?>">[Modificar]</a> 
            <a href="?<?=CTRL_VAR?>=del&id=<?=$oferta['id']?>">[Borrar]</a> 
        </td>
    </tr>
<?php endforeach; ?>
</table>
