<?php

/* Muesta la lista de tareas */

include(MODEL_PATH.'funcionesOfertas.php');

$ofertas=  verOfertas();

// En un planteamiento real puede que incluyesemos más cosas
echo CargaVista('plantilla/layout', array(
    'titulo'=>'Listado de Ofertas',
    'menu'=>CargaVista('plantilla/menu'),
    'cuerpo'=>CargaVista('listaOfertasVista', array('ofertas'=>$ofertas)),
));
