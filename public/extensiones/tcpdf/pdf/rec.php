<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header ('Content-type: text/html; charset=utf-8');
require("../../../conexion.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB


class imprimirReceta {
    
    // REALIZA LA QUERY A LA DB
    
public $idhistorial;

public function traerImpresionReceta(){
$conexion = conexion(); // CREA LA CONEXION
// REALIZA LA QUERY A LA DB
$registros = mysqli_query($conexion, "SELECT * FROM historial INNER JOIN pacientes ON historial.idpaciente = pacientes.idpaciente WHERE historial.idhistorial = ".$_GET['idhistorial']);

// SI EL USUARIO EXISTE OBTIENE LOS DATOS Y LOS GUARDA EN UN ARRAY
if($resultado = mysqli_fetch_array($registros)){
$datos[] = $resultado;
}
header('Content-Type: application/json; charset=utf-8');

$nompaciente = json_encode($datos[0]['nompaciente'], JSON_UNESCAPED_UNICODE);
$nompaciente = str_replace('"','',$nompaciente); 
$edadpaciente = json_encode($datos[0]['edadpaciente'], JSON_UNESCAPED_UNICODE);
$edadpaciente = str_replace('"','',$edadpaciente); 
$fechahistorial = json_encode($datos[0]['fechahistorial'], JSON_UNESCAPED_UNICODE);
$fechahistorial = str_replace('"','',$fechahistorial); 
$pesohistorial  = json_encode($datos[0]['pesohistorial'], JSON_UNESCAPED_UNICODE);
$pesohistorial = str_replace('"','',$pesohistorial); 
$tallahistorial  = json_encode($datos[0]['tallahistorial'], JSON_UNESCAPED_UNICODE);
$tallahistorial = str_replace('"','',$tallahistorial); 
$fchistorial  = json_encode($datos[0]['fchistorial'], JSON_UNESCAPED_UNICODE);
$fchistorial = str_replace('"','',$fchistorial); 
$frhistorial  = json_encode($datos[0]['frhistorial'], JSON_UNESCAPED_UNICODE);
$frhistorial = str_replace('"','',$frhistorial); 
$temphistorial  = json_encode($datos[0]['temphistorial'], JSON_UNESCAPED_UNICODE);
$temphistorial = str_replace('"','',$temphistorial); 
$tahistorial  = json_encode($datos[0]['tahistorial'], JSON_UNESCAPED_UNICODE);
$tahistorial = str_replace('"','',$tahistorial); 
$diagnostico = json_encode(nl2br($datos[0]['diagnostico']), JSON_UNESCAPED_UNICODE);
$diagnostico = str_replace('"','',$diagnostico); 
$diagnostico = str_replace('\n','',$diagnostico); 



//$valorVenta = $this->idhistorial;


require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

$bloque1 = <<<EOF
    
    <table style="border-top-color: blue; border-bottom-color: blue; 
    @font-face {
        font-family: gigi;
        src: url('./fonts/GIGI.ttf');
    }">
        <tr><th style="width: 540px; height: 10px;"></th></tr>
        <tr align="center">
            <th style="width: 70px; height: 50px;"><img src="images/images.jpg" width="50px" height="50px" alt=""></th>
            <th style="width: 380px;">
                <label style="line-height: 13px; color: blue; font-size: 11px; font-family: gigi;">Dra. Gabriela Perez Martínez</label><br>
                <label style="line-height: 13px; color: blue; font-size: 9px; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">Especialista en Ginecología y Obstetricia</label><br>
                <label style="line-height: 13px; color: blue; font-size: 9px;">Certificada por el Consejo Mexicano de Ginecología Obstetricia</label><br>
                <label style="line-height: 13px; color: blue; font-size: 9px;">Ced. Prof. 0000000 - Ced. Esp. 0000000</label>
            </th>
            <th style="width: 70px; height: 50px;"><img src="images/escudo.png" width="50px" height="50px" alt=""></th>
        </tr>    
    </table>
    <p>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2 = <<<EOF
    <table>
        <tr>
            <td style="width:50px; height:15px; color:blue; font-size: 10px;">Nombre: </td>            
            <td style="width:290px; height:15px; font-size: 10px;">$nompaciente </td>            
            <td style="width:90px; height:15px; text-align:right; font-size: 10px;">Edad: $edadpaciente </td>
            <td style="width:110px; height:15px; text-align:right; font-size: 10px;">Fecha: $fechahistorial </td>
        </tr>
        <tr>
            <td style="width:50px; height:15px; color:blue; font-size: 10px;">Peso: </td>            
            <td style="width:70px; height:15px; font-size: 10px;">$pesohistorial </td>            
            <td style="width:420px; height:15px; text-align:left"></td>
        </tr>
        <tr>
            <td style="width:50px; height:15px; color:blue; font-size: 10px;">Talla: </td>            
            <td style="width:70px; height:15px; font-size: 10px;">$tallahistorial </td>            
            <td style="width:420px; height:15px; text-align:left; font-size: 10px; line-height: 9px;"></td>
        </tr>
        <tr>
            <td style="width:50px; height:15px; color:blue; font-size: 10px;">FC: </td>            
            <td style="width:70px; height:15px; font-size: 10px;">$fchistorial </td>            
            <td style="width:420px; height:12px; text-align:left; color:blue; font-size: 10px; line-height: 8px;">Rp.:</td>
        </tr>
        <tr>
            <td style="width:50px; height:15px; color:blue; font-size: 10px;">FR: </td>            
            <td style="width:70px; height:15px; font-size: 10px;">$frhistorial </td>            
            <td rowspan="3" style="width:420px; height:15px; text-align:left; font-size: 10px; line-height: 9px;">$diagnostico</td>
        </tr>
        <tr>
            <td style="width:50px; height:15px; color:blue; font-size: 10px;">Temp: </td>            
            <td style="width:70px; height:15px; font-size: 10px;">$temphistorial </td>            
            <td rowspan="3" style="width:420px; height:15px; text-align:left; font-size: 10px; line-height: 9px;"></td>
        </tr>
        <tr>
            <td style="width:50px; height:110px; color:blue; font-size: 10px;">TA: </td>            
            <td style="width:70px; height:110px; font-size: 10px;">$tahistorial </td>            
            <td rowspan="3" style="width:420px; height:110px; text-align:left; font-size: 10px; line-height: 9px;"></td>
        </tr>        
    </table>
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
// ---------------------------------------------------------

$bloque3 = <<<EOF
    
    <table style="border-top-color: blue; ">
        
        <tr >
            <th style="line-height: 10px; width: 280px; height: 100px; " >
                <label style="color: blue; font-size: 9px; font-family: serif;">Consultorio No. 6 3er. Piso</label><br>
                <label style="color: blue; font-size: 9px; font-family: serif;">Ing. Luis Galindo Perez No. 21</label><br>
                <label style="color: blue; font-size: 9px; font-family: serif;">Col. San Isidro, Mexico, México C.P. 00000</label>
            </th>
            <th style="width: 80px; height: 100px" ></th>
            <th align="right" style="line-height: 10px; width: 180px; height: 100px;">
                <label style="color: blue; font-size: 9px; font-family: serif;">Centro Médico de Especialidades</label> <br>
                <label style="color: blue; font-size: 9px; font-family: serif;">Tel. (000) 122 00 33</label><br>
                <label style="color: blue; font-size: 9px; font-family: serif;">Urgencias (000) 367 00 13</label>
            </th>
        </tr>    
    </table>
    <p>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('receta.pdf');

}

}

$receta = new imprimirReceta();
$receta -> idhistorial = $_GET["idhistorial"];
$receta -> traerImpresionReceta();


//============================================================+
// END OF FILE
//============================================================+


?>