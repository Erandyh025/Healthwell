<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use App\Models\Domicile;
use App\Models\Hospitals;
use App\Models\inquiries;
use App\Models\Patients;
use App\Models\Persons;
use App\Models\Recipe;
use App\Models\User;
use App\Models\allowed_foods;
use App\Models\Bread_and_sustitute;
use App\Models\forbidden_foods;
use Uuid;
use Illuminate\Support\Facades\Log;

require public_path('fpdf/fpdf.php');

class PDFScontroller extends Controller
{

    public function receta($uuid)
    {
        $recipe = Recipe::where('uuid', '=', $uuid)->first();
        $inquiries = inquiries::where('uuid', '=', $recipe->inquiries->uuid)->first();
        $patient = Patients::where('uuid', '=', $inquiries->patients->uuid)->first();
        $person = Persons::where('uuid', '=', $patient->persons->uuid)->first();
        $doctors = Doctors::where('uuid', '=', $inquiries->doctors->uuid)->first();
        $hospital = Hospitals::where('uuid', '=', $doctors->hospitals->uuid)->first();
        $doctors_data = Persons::where('uuid', '=', $doctors->persons->uuid)->first();
        $domicilie = Domicile::where('uuid', '=', $doctors_data->domicilie->uuid)->first();
        $user = User::where('uuid', '=', $doctors->persons->users->uuid)->first();

        $masvar = [
            'id' => $person['id'],
            'uuid' => $person['uuid'],
            'doctor' => $user['name'],
            'cell_phone' => $doctors_data['cell_phone'],
            'domicilie' => $domicilie['street'] . ' ' . $domicilie['colony'] . ' ' . $domicilie['municipality'] . '' . $domicilie['state'],
            'specialty' => $doctors['specialty'],
            'photo' => $hospital['photo'],
            'patient' => $person['name'] . ' ' . $person['ap_patern'] . ' ' . $person['ap_matern'],
            'prescription' => $recipe['prescription'],
            'start_date' => $recipe['start_date'],
            'ending_date' => $recipe['ending_date'],
            'inquiries_id' => $recipe['inquiries_id'],
            'age' => $patient['age'],
        ];

        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $size = 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage('L', 'A4', 0);
        $pdf->Image('loguito.png', 10, 8, 33);
        $pdf->Image('hospital/' . $masvar['photo'], 240, 20, 40);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(276, 5, 'Doctor(a):' . ' ' . $masvar['doctor'], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 10, 'Especialidad:' . ' ' . $masvar['specialty'], 0, 0, 'C');
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->SetLineWidth(2);
        $pdf->Line(60, $pdf->getY() + 10, 230, $pdf->GetY() + 10);
        $pdf->Ln(15);
        $pdf->Cell(180, 0, 'Paciente :' . '' . $masvar['patient'], 0, 1, 'C');
        $pdf->Cell(350, 0, 'Fecha :' . '' . $masvar['start_date'], 0, 1, 'C', false);
        $pdf->Line(60, $pdf->getY() + 4, 230, $pdf->getY() + 4);
        $pdf->Ln(15);
        $pdf->SetLineWidth(0, 2);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->Ln(15);

        $pdf->Cell(80, 0, $masvar['prescription'], 0, 1, 'C');
        $pdf->Ln(120);

        $pdf->Cell(100, 0, 'Direccion: ' . '' . $masvar['domicilie'], 0, 1, 'C', false);
        $pdf->Cell(260, 0, 'Telefono: ' . '' . $masvar['cell_phone'], 0, 1, 'C', false);
        $pdf->Cell(250, 0, 'Fecha Finalizacion :' . '' . $masvar['ending_date'], 0, 1, 'R', false);

        $pdf->Line(10, $pdf->getY() + 4, 280, $pdf->getY() + 4);
        $pdf->Output('I');

    }
    public function downloadReceta($uuid)
    {
        try{
        $recipe = Recipe::where('uuid', '=', $uuid)->first();
        $inquiries = inquiries::where('uuid', '=', $recipe->inquiries->uuid)->first();
        $patient = Patients::where('uuid', '=', $inquiries->patients->uuid)->first();
        $person = Persons::where('uuid', '=', $patient->persons->uuid)->first();
        $doctors = Doctors::where('uuid', '=', $inquiries->doctors->uuid)->first();
        $hospital = Hospitals::where('uuid', '=', $doctors->hospitals->uuid)->first();
        $doctors_data = Persons::where('uuid', '=', $doctors->persons->uuid)->first();
        $domicilie = Domicile::where('uuid', '=', $doctors_data->domicilie->uuid)->first();
        $user = User::where('uuid', '=', $doctors->persons->users->uuid)->first();

        $masvar = [
            'id' => $person['id'],
            'uuid' => $person['uuid'],
            'doctor' => $user['name'],
            'cell_phone' => $doctors_data['cell_phone'],
            'domicilie' => $domicilie['street'] . ' ' . $domicilie['colony'] . ' ' . $domicilie['municipality'] . '' . $domicilie['state'],
            'specialty' => $doctors['specialty'],
            'photo' => $hospital['photo'],
            'patient' => $person['name'] . ' ' . $person['ap_patern'] . ' ' . $person['ap_matern'],
            'prescription' => $recipe['prescription'],
            'start_date' => $recipe['start_date'],
            'ending_date' => $recipe['ending_date'],
            'inquiries_id' => $recipe['inquiries_id'],
            'age' => $patient['age'],
        ];

        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $size = 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage('L', 'A4', 0);
        $pdf->Image('loguito.png', 10, 8, 33);
        $pdf->Image('hospital/' . $masvar['photo'], 240, 20, 40);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(276, 5, 'Doctor(a):' . ' ' . $masvar['doctor'], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 10, 'Especialidad:' . ' ' . $masvar['specialty'], 0, 0, 'C');
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->SetLineWidth(2);
        $pdf->Line(60, $pdf->getY() + 10, 230, $pdf->GetY() + 10);
        $pdf->Ln(15);
        $pdf->Cell(180, 0, 'Paciente :' . '' . $masvar['patient'], 0, 1, 'C');
        $pdf->Cell(350, 0, 'Fecha :' . '' . $masvar['start_date'], 0, 1, 'C', false);
        $pdf->Line(60, $pdf->getY() + 4, 230, $pdf->getY() + 4);
        $pdf->Ln(15);
        $pdf->SetLineWidth(0, 2);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->Ln(15);

        $pdf->Cell(80, 0, $masvar['prescription'], 0, 1, 'C');
        $pdf->Ln(120);

        $pdf->Cell(100, 0, 'Direccion: ' . '' . $masvar['domicilie'], 0, 1, 'C', false);
        $pdf->Cell(260, 0, 'Telefono: ' . '' . $masvar['cell_phone'], 0, 1, 'C', false);
        $pdf->Cell(250, 0, 'Fecha Finalizacion :' . '' . $masvar['ending_date'], 0, 1, 'R', false);

        $pdf->Line(10, $pdf->getY() + 4, 280, $pdf->getY() + 4);
        $pdf->Output('Receta.pdf','D');
        Log::info('PDFScontroller - downloadReceta - Se descargo una receta');

    } catch (\Exception $ex){
        Log::emergency('PDFScontroller','downloadReceta','Documento inexistente');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function dieta()
    {
     $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $size = 'letter');
     $pdf->AliasNbPages();
     $pdf->AddPage('L', 'A4', 0);
     $pdf->Image('loguito.png', 10, 4, 33);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 5, 'DIETA', 0, 0, 'C');
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 10, 'SU SALUD DEPENDE DE SU ALIMENTO "CUIDE SU SALUD"', 0, 0, 'C');
     $pdf->SetDrawColor(30, 174, 152);
     $pdf->SetLineWidth(2);
     $pdf->Line(60, $pdf->getY() + 10, 230, $pdf->GetY() + 10);
     $pdf->Ln(15);
     $pdf->Cell(276, 5, 'Ejemplo de una dieta blanca de 1500 calorias:', 0, 0, $pdf->SetXY(35,35));
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 12);
     $pdf->Cell(276, 0, 'Desayuno:', 0, 0, $pdf->SetXY(35,45));
     $pdf->Cell(276, 0, 'Comida:', 0, 0, $pdf->SetXY(125,45));
     $pdf->Cell(276, 0, 'Cena:', 0, 0, $pdf->SetXY(199,45));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(35,50));
     $pdf->Cell(276, 0, 'Fruta: 150 gr:', 0, 0, $pdf->SetXY(125,50));
     $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(199,50));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Carne: 21 gr', 0, 0, $pdf->SetXY(35,55));
     $pdf->Cell(276, 0, 'Vegetal: 200 gr:', 0, 0, $pdf->SetXY(125,55));
     $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(199,55));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(35,60));
     $pdf->Cell(276, 0, 'Pan: 40 gr:', 0, 0, $pdf->SetXY(125,60));
     $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(199,60));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(35,65));
     $pdf->Cell(276, 0, 'Grasa: 10 gr:', 0, 0, $pdf->SetXY(125,65));
     $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(199,65));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(35,70));
     $pdf->Cell(276, 0, 'Carne: 40 gr:', 0, 0, $pdf->SetXY(125,70));
     $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(199,70));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(35,75));
     $pdf->Ln();
     $pdf->SetLineWidth(0, 2);
     $pdf->SetFillColor(240, 240, 240);
     $pdf->SetTextColor(40, 40, 40);
     $pdf->SetDrawColor(30, 174, 152);
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 0, 'ALIMENTOS PROHIBIDOS:', 0, 0, $pdf->SetXY(35,90));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(45,5,"Carne de cerdo en general", 1, 0,'C', $pdf->SetXY(40,95));
     $pdf->Cell(45,5,"Tocino",1, 0, 'C');
     $pdf->Cell(45,5,"Chorizo",1, 0, 'C');
     $pdf->Cell(45,5,"Longaniza",1, 0, 'C');
     $pdf->Cell(45,5,"Mariscos en general",1);
     $pdf->Ln();
     $pdf->Cell(45,5,"Moronga",1, 0, 'C', $pdf->SetXY(40,100));
     $pdf->Cell(45,5,"Higado",1, 0, 'C');
     $pdf->Cell(45,5,"Panza",1, 0, 'C');
     $pdf->Cell(45,5,"Sesos",1, 0, 'C');
     $pdf->Cell(45,5,"Frutas cocidas",1);
     $pdf->Ln();
     $pdf->Cell(45,5,"Frutas con azucar",1, 0, 'C', $pdf->SetXY(40,105));
     $pdf->Cell(45,5,"Frutas con miel",1, 0, 'C');
     $pdf->Cell(45,5,"Ensaladas en general",1, 0, 'C');
     $pdf->Cell(45,5,"Pan dulce",1, 0, 'C');
     $pdf->Cell(45,5,"Galletas",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Jaleas",1, 0, 'C', $pdf->SetXY(40,110));
     $pdf->Cell(45,5,"Bombon",1, 0, 'C');
     $pdf->Cell(45,5,"Pasteleria",1, 0, 'C');
     $pdf->Cell(45,5,"Reposteria",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de coco",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Frituras",1, 0, 'C', $pdf->SetXY(40,115));
     $pdf->Cell(45,5,"Fritangas",1, 0, 'C');
     $pdf->Cell(45,5,"Postres a base de leche",1, 0, 'C');
     $pdf->Cell(45,5,"Flanes",1, 0, 'C');
     $pdf->Cell(45,5,"Merengues",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Jaleas",1, 0, 'C', $pdf->SetXY(40,120));
     $pdf->Cell(45,5,"Mieles",1, 0, 'C');
     $pdf->Cell(45,5,"Mermeladas",1, 0, 'C');
     $pdf->Cell(45,5,"Cajetas",1, 0, 'C');
     $pdf->Cell(45,5,"Refrescos",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Refresco dietetico",1, 0, 'C', $pdf->SetXY(40,125));
     $pdf->Cell(45,5,"Bebidas alcoholicas",1, 0, 'C');
     $pdf->Cell(45,5,"Jugos",1, 0, 'C');
     $pdf->Cell(45,5,"Nectares",1, 0, 'C');
     $pdf->Cell(45,5,"Agua mineral",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Consome",1, 0, 'C', $pdf->SetXY(40,130));
     $pdf->Cell(45,5,"Comida empanizada",1, 0, 'C');
     $pdf->Cell(45,5,"Comida capeada",1, 0, 'C');
     $pdf->Cell(45,5,"Moles",1, 0, 'C');
     $pdf->Cell(45,5,"Pipianes y adobos",1, 0, 'C');
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 0, 'ALIMENTOS PERMITIDOS:', 0, 1, $pdf->SetXY(35,140));
     $pdf->Ln(10);
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(45,5,"Leche Descremada",1, 0, 'C', $pdf->SetXY(40,145));
     $pdf->Cell(45,5,"Leche semidescremada",1, 0, 'C');
     $pdf->Cell(45,5,"Queso panela",1, 0, 'C');
     $pdf->Cell(45,5,"Queso cottage",1, 0, 'C');
     $pdf->Cell(45,5,"Huevo",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Frutas natuales ",1, 0, 'C', $pdf->SetXY(40,150));
     $pdf->Cell(45,5,"Verduras naturales",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de cartamo",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de ajonjoli",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de jirasol",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Aceite de maiz",1, 0, 'C', $pdf->SetXY(40,155));
     $pdf->Cell(45,5,"Gelatina de agua sin azucar",1, 0, 'C');
     $pdf->Cell(45,5,"Te y agua natural",1, 0, 'C');
     $pdf->Cell(45,5,"Consome desgrasado",1, 0, 'C');
     $pdf->Cell(45,5,"Agua hervida de jamaica",1, 0, 'C');
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 0, 'PAN Y SUSTITUTOS:', 0, 1, $pdf->SetXY(35,165));
     $pdf->Ln(10);
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(45,5,"Bolillo - 1/3pz",1, 0, 'C', $pdf->SetXY(40,170));
     $pdf->Cell(45,5,"Tortilla integral - 1pz",1, 0, 'C');
     $pdf->Cell(45,5,"Pan tostado - 1pz",1, 0, 'C');
     $pdf->Cell(45,5,"Arroz - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Avena - 1/2 taza",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Sopa de pasta - 1/2 taza",1, 0, 'C', $pdf->SetXY(40,175));
     $pdf->Cell(45,5,"Corn Flakes - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"All Bran - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Frijol -1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Lenteja - 1/2 taza",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Alubia - 1/2 taza",1, 0, 'C', $pdf->SetXY(40,180));
     $pdf->Cell(45,5,"Garbanzo - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Haba - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Papa - 1pz",1, 0, 'C');
     $pdf->Cell(45,5,"Camote - 1/3 taza",1, 0, 'C');
     $pdf->Output('I');

 }

 public function downloadieta()
    {
     $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $size = 'letter');
     $pdf->AliasNbPages();
     $pdf->AddPage('L', 'A4', 0);
     $pdf->Image('loguito.png', 10, 4, 33);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 5, 'DIETA', 0, 0, 'C');
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 10, 'SU SALUD DEPENDE DE SU ALIMENTO "CUIDE SU SALUD"', 0, 0, 'C');
     $pdf->SetDrawColor(30, 174, 152);
     $pdf->SetLineWidth(2);
     $pdf->Line(60, $pdf->getY() + 10, 230, $pdf->GetY() + 10);
     $pdf->Ln(15);
     $pdf->Cell(276, 5, 'Ejemplo de una dieta blanca de 1500 calorias:', 0, 0, $pdf->SetXY(35,35));
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 12);
     $pdf->Cell(276, 0, 'Desayuno:', 0, 0, $pdf->SetXY(35,45));
     $pdf->Cell(276, 0, 'Comida:', 0, 0, $pdf->SetXY(125,45));
     $pdf->Cell(276, 0, 'Cena:', 0, 0, $pdf->SetXY(199,45));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(35,50));
     $pdf->Cell(276, 0, 'Fruta: 150 gr:', 0, 0, $pdf->SetXY(125,50));
     $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(199,50));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Carne: 21 gr', 0, 0, $pdf->SetXY(35,55));
     $pdf->Cell(276, 0, 'Vegetal: 200 gr:', 0, 0, $pdf->SetXY(125,55));
     $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(199,55));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(35,60));
     $pdf->Cell(276, 0, 'Pan: 40 gr:', 0, 0, $pdf->SetXY(125,60));
     $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(199,60));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(35,65));
     $pdf->Cell(276, 0, 'Grasa: 10 gr:', 0, 0, $pdf->SetXY(125,65));
     $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(199,65));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(35,70));
     $pdf->Cell(276, 0, 'Carne: 40 gr:', 0, 0, $pdf->SetXY(125,70));
     $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(199,70));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(35,75));
     $pdf->Ln();
     $pdf->SetLineWidth(0, 2);
     $pdf->SetFillColor(240, 240, 240);
     $pdf->SetTextColor(40, 40, 40);
     $pdf->SetDrawColor(30, 174, 152);
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 0, 'ALIMENTOS PROHIBIDOS:', 0, 0, $pdf->SetXY(35,90));
     $pdf->Ln();
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(45,5,"Carne de cerdo en general", 1, 0,'C', $pdf->SetXY(40,95));
     $pdf->Cell(45,5,"Tocino",1, 0, 'C');
     $pdf->Cell(45,5,"Chorizo",1, 0, 'C');
     $pdf->Cell(45,5,"Longaniza",1, 0, 'C');
     $pdf->Cell(45,5,"Mariscos en general",1);
     $pdf->Ln();
     $pdf->Cell(45,5,"Moronga",1, 0, 'C', $pdf->SetXY(40,100));
     $pdf->Cell(45,5,"Higado",1, 0, 'C');
     $pdf->Cell(45,5,"Panza",1, 0, 'C');
     $pdf->Cell(45,5,"Sesos",1, 0, 'C');
     $pdf->Cell(45,5,"Frutas cocidas",1);
     $pdf->Ln();
     $pdf->Cell(45,5,"Frutas con azucar",1, 0, 'C', $pdf->SetXY(40,105));
     $pdf->Cell(45,5,"Frutas con miel",1, 0, 'C');
     $pdf->Cell(45,5,"Ensaladas en general",1, 0, 'C');
     $pdf->Cell(45,5,"Pan dulce",1, 0, 'C');
     $pdf->Cell(45,5,"Galletas",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Jaleas",1, 0, 'C', $pdf->SetXY(40,110));
     $pdf->Cell(45,5,"Bombon",1, 0, 'C');
     $pdf->Cell(45,5,"Pasteleria",1, 0, 'C');
     $pdf->Cell(45,5,"Reposteria",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de coco",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Frituras",1, 0, 'C', $pdf->SetXY(40,115));
     $pdf->Cell(45,5,"Fritangas",1, 0, 'C');
     $pdf->Cell(45,5,"Postres a base de leche",1, 0, 'C');
     $pdf->Cell(45,5,"Flanes",1, 0, 'C');
     $pdf->Cell(45,5,"Merengues",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Jaleas",1, 0, 'C', $pdf->SetXY(40,120));
     $pdf->Cell(45,5,"Mieles",1, 0, 'C');
     $pdf->Cell(45,5,"Mermeladas",1, 0, 'C');
     $pdf->Cell(45,5,"Cajetas",1, 0, 'C');
     $pdf->Cell(45,5,"Refrescos",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Refresco dietetico",1, 0, 'C', $pdf->SetXY(40,125));
     $pdf->Cell(45,5,"Bebidas alcoholicas",1, 0, 'C');
     $pdf->Cell(45,5,"Jugos",1, 0, 'C');
     $pdf->Cell(45,5,"Nectares",1, 0, 'C');
     $pdf->Cell(45,5,"Agua mineral",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Consome",1, 0, 'C', $pdf->SetXY(40,130));
     $pdf->Cell(45,5,"Comida empanizada",1, 0, 'C');
     $pdf->Cell(45,5,"Comida capeada",1, 0, 'C');
     $pdf->Cell(45,5,"Moles",1, 0, 'C');
     $pdf->Cell(45,5,"Pipianes y adobos",1, 0, 'C');
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 0, 'ALIMENTOS PERMITIDOS:', 0, 1, $pdf->SetXY(35,140));
     $pdf->Ln(10);
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(45,5,"Leche Descremada",1, 0, 'C', $pdf->SetXY(40,145));
     $pdf->Cell(45,5,"Leche semidescremada",1, 0, 'C');
     $pdf->Cell(45,5,"Queso panela",1, 0, 'C');
     $pdf->Cell(45,5,"Queso cottage",1, 0, 'C');
     $pdf->Cell(45,5,"Huevo",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Frutas natuales ",1, 0, 'C', $pdf->SetXY(40,150));
     $pdf->Cell(45,5,"Verduras naturales",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de cartamo",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de ajonjoli",1, 0, 'C');
     $pdf->Cell(45,5,"Aceite de jirasol",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Aceite de maiz",1, 0, 'C', $pdf->SetXY(40,155));
     $pdf->Cell(45,5,"Gelatina de agua sin azucar",1, 0, 'C');
     $pdf->Cell(45,5,"Te y agua natural",1, 0, 'C');
     $pdf->Cell(45,5,"Consome desgrasado",1, 0, 'C');
     $pdf->Cell(45,5,"Agua hervida de jamaica",1, 0, 'C');
     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 14);
     $pdf->Cell(276, 0, 'PAN Y SUSTITUTOS:', 0, 1, $pdf->SetXY(35,165));
     $pdf->Ln(10);
     $pdf->SetFont('Times', '', 12);
     $pdf->Cell(45,5,"Bolillo - 1/3pz",1, 0, 'C', $pdf->SetXY(40,170));
     $pdf->Cell(45,5,"Tortilla integral - 1pz",1, 0, 'C');
     $pdf->Cell(45,5,"Pan tostado - 1pz",1, 0, 'C');
     $pdf->Cell(45,5,"Arroz - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Avena - 1/2 taza",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Sopa de pasta - 1/2 taza",1, 0, 'C', $pdf->SetXY(40,175));
     $pdf->Cell(45,5,"Corn Flakes - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"All Bran - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Frijol -1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Lenteja - 1/2 taza",1, 0, 'C');
     $pdf->Ln();
     $pdf->Cell(45,5,"Alubia - 1/2 taza",1, 0, 'C', $pdf->SetXY(40,180));
     $pdf->Cell(45,5,"Garbanzo - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Haba - 1/2 taza",1, 0, 'C');
     $pdf->Cell(45,5,"Papa - 1pz",1, 0, 'C');
     $pdf->Cell(45,5,"Camote - 1/3 taza",1, 0, 'C');
     $pdf->Output('Dieta.pdf','D');

 }

 public function expediente($uuid)
    {

        $recipe = Recipe::where('uuid', '=', $uuid)->first();
        $inquiries = inquiries::where('uuid', '=', $recipe->inquiries->uuid)->first();
        $patient = Patients::where('uuid', '=', $inquiries->patients->uuid)->first();
        $person = Persons::where('uuid', '=', $patient->persons->uuid)->first();
        $doctors = Doctors::where('uuid', '=', $inquiries->doctors->uuid)->first();
        $hospital = Hospitals::where('uuid', '=', $doctors->hospitals->uuid)->first();
        $doctors_data = Persons::where('uuid', '=', $doctors->persons->uuid)->first();
        $domicilie = Domicile::where('uuid', '=', $doctors_data->domicilie->uuid)->first();
        $user = User::where('uuid', '=', $doctors->persons->users->uuid)->first();

        
        $masvar = [
            'id' => $person['id'],
            'uuid' => $person['uuid'],
            'doctor' => $user['name'],
            'cell_phone' => $doctors_data['cell_phone'],
            'type' => $domicilie['type'],
            'street' => $domicilie['street'], 
            'colony' => $domicilie['colony'],
            'postalCode' =>$domicilie['postalCode'],
            'municipality' => $domicilie['municipality'],
            'state' => $domicilie['state'],
            'number_ext' => $domicilie['number_ext'],
            'number_int' => $domicilie['number_int'],
            'specialty' => $doctors['specialty'],
            'photo' => $hospital['photo'],
            'patient' => $person['name'] . ' ' . $person['ap_patern'] . ' ' . $person['ap_matern'],
            'prescription' => $recipe['prescription'],
            'start_date' => $recipe['start_date'],
            'ending_date' => $recipe['ending_date'],
            'inquiries_id' => $recipe['inquiries_id'],
            'age' => $patient['age'],
            'curp' => $person['curp'],
            'telefone'=> $person['telefone'],
            'socioeconomic_level'=> $patient['socioeconomic_level'],
            'religion'=> $patient['religion'],
            'ethnic_group'=> $patient['ethnic_group'],
            'disability'=> $patient['disability'],
            'blood_type'=> $patient['blood_type'],
            'num_inquirie'=> $inquiries['num_inquirie'],
            'tratamiento'=> $inquiries['tratamiento'],
        
        ];
        
        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $size = 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Image('healthwell.png', 75, 1, 80);
        $pdf->Ln(17);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->SetLineWidth(2);   
        $pdf->Line(30, $pdf->getY() + 10, 200, $pdf->GetY() + 10);
        $pdf->SetLineWidth(0, 2);
        $pdf->Ln(17);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'DATOS PERSONALES DEL PACIENTE:', 0, 0, $pdf->SetXY(15,50));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(15, 60);
        $pdf->Cell(20, 8, 'Nombre del paciente:'. ' ' . $masvar['patient'], 0, 'L');
        $pdf->Line(52, 65.5, 180, 65.5);
        $pdf->SetXY(15, 80);
        $pdf->Cell(20, 8, 'CURP:'. ' ' . $masvar['curp'], 0, 'L');
        $pdf->Line(30, 85.5, 90, 85.5);
        $pdf->SetXY(110, 80);
        $pdf->Cell(20, 8, 'Edad:'. ' ' . $masvar['age'], 0, 'L');
        $pdf->Line(122, 85.5, 175, 85.5);
        $pdf->SetXY(15, 100);
        $pdf->Cell(20, 8, 'Tel. Fijo:'. ' ' . $masvar['telefone'], 0, 'L');
        $pdf->Line(33, 105.5, 90, 105.5);
        $pdf->SetXY(110, 100);
        $pdf->Cell(20, 8, 'Tel. Celular:'. ' ' . $masvar['cell_phone'], 0, 'L');
        $pdf->Line(133, 105.5, 175, 105.5);
        $pdf->SetXY(15, 120);
        $pdf->Cell(20, 8, 'Nivel socioeconomico:'. ' ' . $masvar['socioeconomic_level'], 0, 'L');
        $pdf->Line(56, 125.5, 100, 125.5);
        $pdf->SetXY(110, 120);
        $pdf->Cell(20, 8, 'Religion:'. ' ' . $masvar['religion'], 0, 'L');
        $pdf->Line(128, 125.5, 180, 125.5);
        $pdf->SetXY(15, 140);
        $pdf->Cell(20, 8, 'Grupo etnico:'. ' ' . $masvar['ethnic_group'], 0, 'L');
        $pdf->Line(40, 145.5, 70, 145.5);
        $pdf->SetXY(75, 140);
        $pdf->Cell(20, 8, 'Discapacidad:'. ' ' . $masvar['disability'], 0, 'L');
        $pdf->Line(100, 145.5, 130, 145.5);
        $pdf->SetXY(130, 140);
        $pdf->Cell(20, 8, 'Tipo de sangre:'. ' ' . $masvar['blood_type'], 0, 'L');
        $pdf->Line(157, 145.5, 180, 145.5);
        $pdf->Ln(17);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'DOMICILIO:', 0, 0, $pdf->SetXY(15,180));
        $pdf->Ln();


        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(15, 200);
        $pdf->Cell(20, 8, 'Tipo:'. ' ' . $masvar['type'], 0, 'L');
        $pdf->Line(30, 205.5, 90, 205.5);
        $pdf->SetXY(110, 200);
        $pdf->Cell(20, 8, 'Calle:'. ' ' . $masvar['street'], 0, 'L');
        $pdf->Line(122, 205.5, 175, 205.5);
        $pdf->SetXY(15, 220);
        $pdf->Cell(20, 8, 'Num. Interior:'. ' ' . $masvar['number_int'], 0, 'L');
        $pdf->Line(41, 225.5, 90, 225.5);
        $pdf->SetXY(110, 220);
        $pdf->Cell(20, 8, 'Num. Exterior:'. ' ' . $masvar['number_ext'], 0, 'L');
        $pdf->Line(139, 225.5, 175, 225.5);
        $pdf->SetXY(15, 240);
        $pdf->Cell(20, 8, 'Estado:'. ' ' . $masvar['state'], 0, 'L');
        $pdf->Line(33, 245.5, 90, 245.5);
        $pdf->SetXY(110, 240);
        $pdf->Cell(20, 8, 'Municipio:'. ' ' . $masvar['municipality'], 0, 'L');
        $pdf->Line(133, 245.5, 175, 245.5);


        // Nueva pagina

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Image('healthwell.png', 75, 1, 80);
        $pdf->Ln(17);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->SetLineWidth(2);   
        $pdf->Line(30, $pdf->getY() + 10, 200, $pdf->GetY() + 10);
        $pdf->SetLineWidth(0, 2);
        $pdf->Ln(17);

        $pdf->SetXY(15, 60);
        $pdf->Cell(20, 8, 'Colonia:'. ' ' . $domicilie['colony'], 0, 'L');
        $pdf->Line(33, 65.5, 90, 65.5);
        $pdf->SetXY(110, 60);
        $pdf->Cell(20, 8, 'Codigo postal:'. ' ' . $domicilie['postalCode'], 0, 'L');
        $pdf->Line(139, 65.5, 175, 65.5);
        $pdf->Ln(17);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'DATOS MEDICOS DEL PACIENTE:', 0, 0, $pdf->SetXY(15,80));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(15, 100);
        $pdf->Cell(20, 8, 'Num.Consulta:'. ' ' . $inquiries['num_inquirie'], 0, 'L');
        $pdf->Line(50, 105.5, 90, 105.5);
        $pdf->SetXY(110, 100);
        $pdf->Cell(20, 8, 'Medico a cargo:'. ' ' . $user['doctor'], 0, 'L'); //checar aqui porque no se pinta en el pdf
        $pdf->Line(142, 105.5, 175, 105.5);
        $pdf->SetXY(15, 120);
        $pdf->Cell(20, 8, 'Tratamiento:'. ' ' . $inquiries['tratamiento'], 0, 'L');
        $pdf->Line(45, 125.5, 180, 125.5);
        $pdf->SetXY(15, 140);
        $pdf->MultiCell(20, 8, 'Receta:'. ' ' . $recipe['prescription'],0, 'L');
        // $pdf->Line(45, 145.5, 180, 145.5);

        $pdf->SetXY(15, 180);
        $pdf->Cell(20, 8, 'Fecha de inicio:'. ' ' . $recipe['start_date'], 0, 'L');
        $pdf->Line(45, 185.5, 65.5, 185.5);
        $pdf->SetXY(110, 180);
        $pdf->Cell(20, 8, 'Fecha de finalizacion:'. ' ' . $recipe['ending_date'], 0, 'L');
        $pdf->Line(149, 185.5, 175, 185.5);
        $pdf->Ln(17);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'Dieta recomendada:', 0, 0, $pdf->SetXY(15,190));

        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 5, 'Ejemplo de una dieta blanca de 1500 calorias:', 0, 0, $pdf->SetXY(15,200));
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'Desayuno:', 0, 0, $pdf->SetXY(15,220));
        $pdf->Cell(276, 0, 'Comida:', 0, 0, $pdf->SetXY(90,220));
        $pdf->Cell(276, 0, 'Cena:', 0, 0, $pdf->SetXY(150,220));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(15,225));
        $pdf->Cell(276, 0, 'Fruta: 150 gr:', 0, 0, $pdf->SetXY(90,225));
        $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(150,225));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Carne: 21 gr', 0, 0, $pdf->SetXY(15,230));
        $pdf->Cell(276, 0, 'Vegetal: 200 gr:', 0, 0, $pdf->SetXY(90,230));
        $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(150,230));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(15,235));
        $pdf->Cell(276, 0, 'Pan: 40 gr:', 0, 0, $pdf->SetXY(90,235));
        $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(150,235));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(15,240));
        $pdf->Cell(276, 0, 'Grasa: 10 gr:', 0, 0, $pdf->SetXY(90,240));
        $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(150,240));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(15,245));
        $pdf->Cell(276, 0, 'Carne: 40 gr:', 0, 0, $pdf->SetXY(90,245));
        $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(150,245));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(15,250));
        $pdf->Ln();
        $pdf->SetLineWidth(0, 2);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->Ln(15);
        $pdf->Output('I');

 }
 public function donwloadExpediente($uuid)
    {

        $recipe = Recipe::where('uuid', '=', $uuid)->first();
        $inquiries = inquiries::where('uuid', '=', $recipe->inquiries->uuid)->first();
        $patient = Patients::where('uuid', '=', $inquiries->patients->uuid)->first();
        $person = Persons::where('uuid', '=', $patient->persons->uuid)->first();
        $doctors = Doctors::where('uuid', '=', $inquiries->doctors->uuid)->first();
        $hospital = Hospitals::where('uuid', '=', $doctors->hospitals->uuid)->first();
        $doctors_data = Persons::where('uuid', '=', $doctors->persons->uuid)->first();
        $domicilie = Domicile::where('uuid', '=', $doctors_data->domicilie->uuid)->first();
        $user = User::where('uuid', '=', $doctors->persons->users->uuid)->first();

        
        $masvar = [
            'id' => $person['id'],
            'uuid' => $person['uuid'],
            'doctor' => $user['name'],
            'cell_phone' => $doctors_data['cell_phone'],
            'type' => $domicilie['type'],
            'street' => $domicilie['street'], 
            'colony' => $domicilie['colony'],
            'postalCode' =>$domicilie['postalCode'],
            'municipality' => $domicilie['municipality'],
            'state' => $domicilie['state'],
            'number_ext' => $domicilie['number_ext'],
            'number_int' => $domicilie['number_int'],
            'specialty' => $doctors['specialty'],
            'photo' => $hospital['photo'],
            'patient' => $person['name'] . ' ' . $person['ap_patern'] . ' ' . $person['ap_matern'],
            'prescription' => $recipe['prescription'],
            'start_date' => $recipe['start_date'],
            'ending_date' => $recipe['ending_date'],
            'inquiries_id' => $recipe['inquiries_id'],
            'age' => $patient['age'],
            'curp' => $person['curp'],
            'telefone'=> $person['telefone'],
            'socioeconomic_level'=> $patient['socioeconomic_level'],
            'religion'=> $patient['religion'],
            'ethnic_group'=> $patient['ethnic_group'],
            'disability'=> $patient['disability'],
            'blood_type'=> $patient['blood_type'],
            'num_inquirie'=> $inquiries['num_inquirie'],
            'tratamiento'=> $inquiries['tratamiento'],
        
        ];
        
        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $size = 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Image('healthwell.png', 75, 1, 80);
        $pdf->Ln(17);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->SetLineWidth(2);   
        $pdf->Line(30, $pdf->getY() + 10, 200, $pdf->GetY() + 10);
        $pdf->SetLineWidth(0, 2);
        $pdf->Ln(17);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'DATOS PERSONALES DEL PACIENTE:', 0, 0, $pdf->SetXY(15,50));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(15, 60);
        $pdf->Cell(20, 8, 'Nombre del paciente:'. ' ' . $masvar['patient'], 0, 'L');
        $pdf->Line(52, 65.5, 180, 65.5);
        $pdf->SetXY(15, 80);
        $pdf->Cell(20, 8, 'CURP:'. ' ' . $masvar['curp'], 0, 'L');
        $pdf->Line(30, 85.5, 90, 85.5);
        $pdf->SetXY(110, 80);
        $pdf->Cell(20, 8, 'Edad:'. ' ' . $masvar['age'], 0, 'L');
        $pdf->Line(122, 85.5, 175, 85.5);
        $pdf->SetXY(15, 100);
        $pdf->Cell(20, 8, 'Tel. Fijo:'. ' ' . $masvar['telefone'], 0, 'L');
        $pdf->Line(33, 105.5, 90, 105.5);
        $pdf->SetXY(110, 100);
        $pdf->Cell(20, 8, 'Tel. Celular:'. ' ' . $masvar['cell_phone'], 0, 'L');
        $pdf->Line(133, 105.5, 175, 105.5);
        $pdf->SetXY(15, 120);
        $pdf->Cell(20, 8, 'Nivel socioeconomico:'. ' ' . $masvar['socioeconomic_level'], 0, 'L');
        $pdf->Line(56, 125.5, 100, 125.5);
        $pdf->SetXY(110, 120);
        $pdf->Cell(20, 8, 'Religion:'. ' ' . $masvar['religion'], 0, 'L');
        $pdf->Line(128, 125.5, 180, 125.5);
        $pdf->SetXY(15, 140);
        $pdf->Cell(20, 8, 'Grupo etnico:'. ' ' . $masvar['ethnic_group'], 0, 'L');
        $pdf->Line(40, 145.5, 70, 145.5);
        $pdf->SetXY(75, 140);
        $pdf->Cell(20, 8, 'Discapacidad:'. ' ' . $masvar['disability'], 0, 'L');
        $pdf->Line(100, 145.5, 130, 145.5);
        $pdf->SetXY(130, 140);
        $pdf->Cell(20, 8, 'Tipo de sangre:'. ' ' . $masvar['blood_type'], 0, 'L');
        $pdf->Line(157, 145.5, 180, 145.5);
        $pdf->Ln(17);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'DOMICILIO:', 0, 0, $pdf->SetXY(15,180));
        $pdf->Ln();


        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(15, 200);
        $pdf->Cell(20, 8, 'Tipo:'. ' ' . $masvar['type'], 0, 'L');
        $pdf->Line(30, 205.5, 90, 205.5);
        $pdf->SetXY(110, 200);
        $pdf->Cell(20, 8, 'Calle:'. ' ' . $masvar['street'], 0, 'L');
        $pdf->Line(122, 205.5, 175, 205.5);
        $pdf->SetXY(15, 220);
        $pdf->Cell(20, 8, 'Num. Interior:'. ' ' . $masvar['number_int'], 0, 'L');
        $pdf->Line(41, 225.5, 90, 225.5);
        $pdf->SetXY(110, 220);
        $pdf->Cell(20, 8, 'Num. Exterior:'. ' ' . $masvar['number_ext'], 0, 'L');
        $pdf->Line(139, 225.5, 175, 225.5);
        $pdf->SetXY(15, 240);
        $pdf->Cell(20, 8, 'Estado:'. ' ' . $masvar['state'], 0, 'L');
        $pdf->Line(33, 245.5, 90, 245.5);
        $pdf->SetXY(110, 240);
        $pdf->Cell(20, 8, 'Municipio:'. ' ' . $masvar['municipality'], 0, 'L');
        $pdf->Line(133, 245.5, 175, 245.5);


        // Nueva pagina

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Image('healthwell.png', 75, 1, 80);
        $pdf->Ln(17);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->SetLineWidth(2);   
        $pdf->Line(30, $pdf->getY() + 10, 200, $pdf->GetY() + 10);
        $pdf->SetLineWidth(0, 2);
        $pdf->Ln(17);

        $pdf->SetXY(15, 60);
        $pdf->Cell(20, 8, 'Colonia:'. ' ' . $domicilie['colony'], 0, 'L');
        $pdf->Line(33, 65.5, 90, 65.5);
        $pdf->SetXY(110, 60);
        $pdf->Cell(20, 8, 'Codigo postal:'. ' ' . $domicilie['postalCode'], 0, 'L');
        $pdf->Line(139, 65.5, 175, 65.5);
        $pdf->Ln(17);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'DATOS MEDICOS DEL PACIENTE:', 0, 0, $pdf->SetXY(15,80));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(15, 100);
        $pdf->Cell(20, 8, 'Num.Consulta:'. ' ' . $inquiries['num_inquirie'], 0, 'L');
        $pdf->Line(50, 105.5, 90, 105.5);
        $pdf->SetXY(110, 100);
        $pdf->Cell(20, 8, 'Medico a cargo:'. ' ' . $user['doctor'], 0, 'L'); //checar aqui porque no se pinta en el pdf
        $pdf->Line(142, 105.5, 175, 105.5);
        $pdf->SetXY(15, 120);
        $pdf->Cell(20, 8, 'Tratamiento:'. ' ' . $inquiries['tratamiento'], 0, 'L');
        $pdf->Line(45, 125.5, 180, 125.5);
        $pdf->SetXY(15, 140);
        $pdf->MultiCell(20, 8, 'Receta:'. ' ' . $recipe['prescription'],0, 'L');
        // $pdf->Line(45, 145.5, 180, 145.5);

        $pdf->SetXY(15, 180);
        $pdf->Cell(20, 8, 'Fecha de inicio:'. ' ' . $recipe['start_date'], 0, 'L');
        $pdf->Line(45, 185.5, 65.5, 185.5);
        $pdf->SetXY(110, 180);
        $pdf->Cell(20, 8, 'Fecha de finalizacion:'. ' ' . $recipe['ending_date'], 0, 'L');
        $pdf->Line(149, 185.5, 175, 185.5);
        $pdf->Ln(17);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'Dieta recomendada:', 0, 0, $pdf->SetXY(15,190));

        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 5, 'Ejemplo de una dieta blanca de 1500 calorias:', 0, 0, $pdf->SetXY(15,200));
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(276, 0, 'Desayuno:', 0, 0, $pdf->SetXY(15,220));
        $pdf->Cell(276, 0, 'Comida:', 0, 0, $pdf->SetXY(90,220));
        $pdf->Cell(276, 0, 'Cena:', 0, 0, $pdf->SetXY(150,220));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(15,225));
        $pdf->Cell(276, 0, 'Fruta: 150 gr:', 0, 0, $pdf->SetXY(90,225));
        $pdf->Cell(276, 0, 'Leche: 200 ml', 0, 0, $pdf->SetXY(150,225));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Carne: 21 gr', 0, 0, $pdf->SetXY(15,230));
        $pdf->Cell(276, 0, 'Vegetal: 200 gr:', 0, 0, $pdf->SetXY(90,230));
        $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(150,230));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Fruta: 150 gr', 0, 0, $pdf->SetXY(15,235));
        $pdf->Cell(276, 0, 'Pan: 40 gr:', 0, 0, $pdf->SetXY(90,235));
        $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(150,235));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Vegetal: 200 gr', 0, 0, $pdf->SetXY(15,240));
        $pdf->Cell(276, 0, 'Grasa: 10 gr:', 0, 0, $pdf->SetXY(90,240));
        $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(150,240));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Pan: 20 gr', 0, 0, $pdf->SetXY(15,245));
        $pdf->Cell(276, 0, 'Carne: 40 gr:', 0, 0, $pdf->SetXY(90,245));
        $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(150,245));
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(276, 0, 'Grasa: 5 gr', 0, 0, $pdf->SetXY(15,250));
        $pdf->Ln();
        $pdf->SetLineWidth(0, 2);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetDrawColor(30, 174, 152);
        $pdf->Ln(15);
        $pdf->Output('Historial medico.pdf','D');

 }

}
