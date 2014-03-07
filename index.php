<?
// Parsear los k/v pares de Request URI y ponerlos en _REQUEST variables
$string = preg_replace("/\?.+/", "", $_SERVER['REQUEST_URI']);
$array  = explode("/", $string);
$length = count($array);
for ($i = 2; $i < $length - 1; ++$i) {
    $_REQUEST[$array[$i]] = $array[$i+1];
    $i                    = $i+1;
}

// Validar que el parametro cédula esté definido
if (isset($_REQUEST['cedula'])) 
{
    // Validar el formato de la cédula, 9 dígitos consecutivos.
    if (preg_match('/\d{9}/', $_REQUEST['cedula'])) 
    {
        // Connectarse al DB
        $m = new MongoClient();
        $db = $m->selectDB('padron');
        $collection = new MongoCollection($db, 'padron');
        // Buscar
        $info = $collection->findOne(array("CEDULA"=>(int)$_REQUEST['cedula']));
        // Validar Resultado
        if(!is_null($info)) {
          // Crear el arreglo de respuesta
          $result['cedula']          = $info['CEDULA'];
          $result['nombre']          = $info['NOMBRE'];
          $result['apellidoPaterno'] = $info['PAPELLIDO'];
          $result['apellidoMaterno'] = $info['SAPELLIDO'];
          $result['sexo']            = $info['SEXO']==1?'Masculino':'Femenino';
          $result['vencimiento']     = $info['FECHACADUC'];
        }else {
          $result[] = "No encontrado";
        }
        // Respuesta
        header('Content-type: text/json');
        echo json_encode($result);
    } else {
        // Respuesta en caso de que la cédula tenga un formato no soportado
        header('Content-type: text/plain');
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo "Número de cédula debe ser de nueve dígitos";
    }
} else {
    // Respuesta en caso de que no tenga parametros.
    header('Content-type: text/plain');
    echo "Uso:\n  http://mae.cr/padron/cedula/122223333";
}
