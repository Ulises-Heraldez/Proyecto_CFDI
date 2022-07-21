<?php
session_start();
error_reporting(0);
include "connection.php";
$datos = json_decode($_POST["json"]);
$id = $_SESSION["id_usuario"];

var_dump($datos);

foreach($datos -> {"data"} as $data){
    $fecha = $data -> {"fecha"};
    $tipo = $data -> {"tipo"};
    $serie = $data -> {"serie"};
    $fact = $data -> {"fact"};
    $razon = $data -> {"razónsocial"};
    $impE = $data -> {"importeexcento"};
    $impAg = $data -> {"importegravado"};
    $iva = $data -> {"iva"};
    $impoRet = $data -> {"importeretenido"};
    $total = $data -> {"total"};
    $rfcPDio = $data -> {"rfcparadiot"};
    $concepto = $data -> {"conceptodelgasto"};
    $nombreRec = $data -> {"nombrereceptor"};
    $rfcRec = $data -> {"rfcreceptor"};
    $nombre_archivo = $data -> {"nombredelarchivoxml"};
    if($fecha != "Fecha"){
        insertar($fecha, $tipo, $serie, $fact, $razon, $impE, $impAg, $iva, $impoRet, $total, $rfcPDio, $concepto, $nombreRec, $rfcRec, $id, $con, $nombre_archivo);
    }
}

function insertar($fecha, $tipo, $serie, $fact, $razon, $impE, $impAg, $iva, $impoRet, $total, $rfcPDio, $concepto, $nombreRec, $rfcRec, $id_usuario, $con, $nombre_archivo){
    $sql = 'insert into tb_cfdis values (null, "'.$fecha.'", "'.$tipo.'", "'.$serie.'", "'.$fact.'", "'.$razon.'", "'.$impE.'","'.$impAg.'","'.$iva.'", "'.$impoRet.'", "'.$total.'", "'.$rfcPDio.'", "'.$concepto.'", "'.$nombreRec.'", "'.$rfcRec.'", "'.$id_usuario.'", "'.$nombre_archivo.'")';
    echo $sql;
    mysqli_query($con, $sql);  
}