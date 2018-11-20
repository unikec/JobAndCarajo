<?php
use Problema1\app\models\Conexion;

/*Incluimos el fichero de la clase Conf*/
require 'Configuration.php';

/*Incluimos el fichero de la clase Conexion*/
require 'Conexion.php';


/** Con getProvincias se pretende obtener una lista de las provincias
 * mediante getInstance podemos tener acceso a la conexión si tener que 
 * duplicarla reiteradamente*/
function getProvincias(){
        $conex=Conexion::getInstance();
        // Prepare
       
        $stmt = $conex->dbh->prepare("SELECT * FROM provincias");
        // Especificamos el fetch mode antes de llamar a fetch()
            
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Excecute
        $stmt->execute();
        // Acumulamos los resultados
        $provincias=[];
        while ($row = $stmt->fetch()){
           
            $provincias[]=  $row['provincia'];
          //  echo "Ciudad: {$row["provincia"]} <br><br>";
        }
 return $provincias;
}
function getTabla($tabla, $campo){
    $dbh=Conexion::getInstance();
    // Prepare
    $stmt = $dbh->dbh->prepare("SELECT * FROM $tabla");
    // Especificamos el fetch mode antes de llamar a fetch()
    
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Excecute
    $stmt->execute();
    // Acumulamos los resultados
    $tabla=[];
    while ($row = $stmt->fetch()){
        
        $tabla[]=  $row[$campo];
        //  echo "Ciudad: {$row["provincia"]} <br><br>";
    }
    return $tabla;
}

/** En verOfertas() se obtienen los datos contendidos en la tabla ofertas, 
 * haciendo un join con la tabla provincias
 * para darle mayor legibilidad a los datos*/
function verOfertas(){
    $conex=Conexion::getInstance();     
    $sql="SELECT * FROM ofertas LEFT JOIN provincias ON ofertas.id_provincia=provincias.id";
    // Especificamos el fetch mode antes de llamar a fetch()
    $stmt = $conex->dbh->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Excecute
    $stmt->execute();
    // Acumulamos los resultados
    $ofertas=[];
    while ($row = $stmt->fetch()){
        
        //$ofertas[]=  $row['descripcion'];
        $ofertas[$row['id_oferta']]=['id'=> $row['id_oferta'],'descripcion'=>$row['descripcion'],'contacto'=>$row['persona_contacto'],
            'telefono'=>$row['telefono'], 'email'=>$row['email'], 'direccion'=>$row['direccion'],
            'poblacion'=>$row['poblacion'],'cp'=>$row['cp'], 'id_provincia'=>$row['id_provincia'],
            'provincia'=>$row['provincia'], 'estado'=>$row['estado'],'fechaInicial'=>$row['fecha_creacion'],
            'fechaFin'=>$row['fecha_comunicacion'],'psicologo'=>$row['psicologo'],
            'candidato'=>$row['candidato_selecionado'],'otros_datos'=>$row['otros_datos_candidato']];
    }
    return $ofertas;
}

/**Para obtener toda la información detalle de una sola oferta*/
function getOferta($id){
    $conex=Conexion::getInstance();
    $sql="SELECT * FROM ofertas LEFT JOIN provincias ON ofertas.id_provincia=provincias.id where id_oferta=$id";
    // Especificamos el fetch mode antes de llamar a fetch()
    $stmt = $conex->dbh->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Excecute
    $stmt->execute();
    // Acumulamos los resultados
    $ofertas=[];
    while ($row = $stmt->fetch()){
        
        //$ofertas[]=  $row['descripcion'];
        $ofertas[$row['id_oferta']]=['id'=> $row['id_oferta'],'descripcion'=>$row['descripcion'],'contacto'=>$row['persona_contacto'],
            'telefono'=>$row['telefono'], 'email'=>$row['email'], 'direccion'=>$row['direccion'],
            'poblacion'=>$row['poblacion'],'cp'=>$row['cp'], 'id_provincia'=>$row['id_provincia'],
            'provincia'=>$row['provincia'], 'estado'=>$row['estado'],'fechaInicial'=>$row['fecha_creacion'],
            'fechaFin'=>$row['fecha_comunicacion'],'psicologo'=>$row['psicologo'],
            'candidato'=>$row['candidato_selecionado'],'otros_datos'=>$row['otros_datos_candidato']];
    }
    return $ofertas;
}
 /** Función para introducir una nueva oferta, solo estará disponible para el usuario Administrador*/
function nuevaOferta( $id,$descripcion, $persona_contacto, $telefono, $email, $direccion, $poblacion,
    $cp, $id_provincia, $estado, $fecha_creacion, $fecha_comunicacion, $psicologo,$candidato_seleccionado, 
    $otro_datos_candidato) {
  $conex=Conexion::getInstance();
 
  $sql="insert into ofertas  values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";// 15 con fecha Inicio
  $query= $conex->dbh->prepare($sql);
 
   $result=  $query->execute([$id,$descripcion, $persona_contacto, $telefono, $email, $direccion, $poblacion,
       $cp, $id_provincia, $estado, $fecha_creacion,$fecha_comunicacion, $psicologo,$candidato_seleccionado,
       $otro_datos_candidato]);
 

 if($result){
  echo "insertado<br>";
 }else{
     echo " error insercion<br>";
 }
}

/**
 * Revisar!!!!
 * Esta función no forma parte de esta futura clase oferta
 *  la función insert usuario es igual que la nueva oferta pero usando bindParadm
 * */
function insert_usuario($id,$tipo,$usuario,$contraseña)
{
    $conex=Conexion::getInstance();
    try {
        $query=$conex->dbh->prepare('insert into usuario values(?,?,?,?)');
       
        $query->bindParam(1, $id);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $usuario);
        $query->bindParam(4, $contraseña);
        $query->execute();
      //  $query->execute([$id,$tipo,$usuario,$contraseña]);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


/**Esta función precisa de una operación previa pero independiente donde que confirme que realmente se quiere
 * borrar el registro selecionado, para evitar borrados por error
 * Esta función solo estará dispobible para el usario administrador
 * Previo a la eliminación se procederá a confirmar, interactuando con el servidor (no vale un alert de javascript).
 * Se mostrará una página de confirmación en la que se muestren los datos más importantes de la tarea 
 * y se pregunte si se desea borrar o no.
*/
function eliminarOferta($id) {
    /*no olvidar pedir confirmación, esta puede ser una forma 
     * a href="#" onclick="return confirm('Estás seguro que deseas eliminar el registro?');">Eliminar registro</a>*/
    $conex=Conexion::getInstance();
    $sql = "delete from ofertas where id_oferta = ?";   //prepared statements
    
    $query = $conex->dbh-> prepare($sql);
    
    $result = $query -> execute(array($id));   //prepared statements value
    
    /*Esta parte final, pueden ser elimminados una vez se compruebe la correcta ejecución del codigo
     * así como la variable result, que solo está para depurar más rapido
     */
    if($result){
        echo "<script>alert('Eliminado')</script>";
    }else{
        echo "<script>alert('error al eliminar')</script>";
    }
            
}
/**En principio esta función permite modificar todos los campos de ofertas, salvo id y fecha de creación
 * Esta función solo estará dispobible para el usario administrador*/
function modificarOferta( $descripcion, $persona_contacto, $telefono, $email, $direccion, $poblacion,
    $cp, $id_provincia, $estado, $fecha_comunicacion, $psicologo,$candidato_seleccionado,
    $otro_datos_candidato, $id_oferta){
        
        $conex=Conexion::getInstance();
       $sql=" UPDATE `ofertas` SET `descripcion`=?,`persona_contacto`=?, `telefono`=?,`email`=?,`direccion`=?,
            `poblacion`=?,`cp`=?, `id_provincia`=?,`estado`=?, `fecha_comunicacion`=?,`psicologo`=?,`candidato_selecionado`=?,
            `otros_datos_candidato`=? WHERE 'oferta_id'=?";
      
        $query= $conex->dbh->prepare($sql);
        
        $result=  $query->execute([$descripcion, $persona_contacto, $telefono, $email, $direccion, $poblacion,
            $cp, $id_provincia, $estado, $fecha_comunicacion, $psicologo,$candidato_seleccionado,
            $otro_datos_candidato, $id_oferta]);
        
        //esta parte final, pueden ser elimminados una vez se compruebe la correcta ejecución del codigo
        
        if($result){
            echo "<script>alert('modificado correctamente')</script>";
        }else{
            echo "<script>alert('error al modificar')</script>";
        }
}

/**Esta función es semejante a modificarOferta pero estando limitado su uso 
 * Esta función solo es para uso del usuario psicologo*/
function cambiarEstado($id_oferta,$estado){
    $conex=Conexion::getInstance();
    $sql=" UPDATE `ofertas` SET `estado` = ? WHERE `ofertas`.`id_oferta` = ?";
    
    $query= $conex->dbh->prepare($sql);
    
    $result=  $query->execute([$estado, $id_oferta]);
    
    //esta parte final, pueden ser elimminados una vez se compruebe la correcta ejecución del codigo
    
    if($result){
        echo "<script>alert('Estado modificado correctamente')</script>";
    }else{
        echo "<script>alert('Error al modificar Estado')</script>";
    }
}

/**Esta función es para uso del usuario psicologo
 * cuando el radio buttom de Estado esté en R(realizando Selección) o
 * bien esté activo S (seleccionando candidato)*/
function modificarCandidato($candidato_selecionado, $otros_datos_candidato,$id_oferta){
    $conex=Conexion::getInstance();
    $sql=" UPDATE `ofertas` SET `candidato_selecionado`=?,
            `otros_datos_candidato`=? WHERE `ofertas`.`id_oferta` = ?";
    
    $query= $conex->dbh->prepare($sql);
    
    $result=  $query->execute([$candidato_selecionado, $otros_datos_candidato, $id_oferta]);
    
    //esta parte final, pueden ser elimminados una vez se compruebe la correcta ejecución del codigo
    
    if($result){
        echo "<script>alert('Estado modificado correctamente')</script>";
    }else{
        echo "<script>alert('Error al modificar Estado')</script>";
    }
}
//nuevaOferta(null,'programador', 'Tom Hanns', '912632126', 'rrhh.th@guachi.es', 'AV. Estrella de la muerte 170', 'Alcobendas', '28005', '28', 'S',NULL, '2018-11-30', 'Enrique Velardo', '', '');
//modificarOferta('programador', 'Tom Hanns', '912632126', 'rrhh.th@guachi.es', 'AV. Estrella de la muerte 170', 'Madrid', '28005', '28', 'R', '2018-11-30', 'Enrique Velardo', '', '', '24');
//eliminarOferta('24');

//cambiarEstado('25','P');
//$x=verOfertas();
//print_r($x);


