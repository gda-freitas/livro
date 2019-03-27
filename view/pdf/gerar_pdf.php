<?php

#require_once '..\cabecalho_geral.php';
require_once '..\..\model\Locacao.php';
require_once '..\..\fpdf\fpdf.php';
require_once '..\..\database\Database.php';



$resultado= Locacao::listarLivros();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,utf8_decode('Relatório de Locações'),0,0,"C");
$pdf->Ln(15);

$pdf->SetFont("Arial","I",7);
$pdf->Cell(10,7,utf8_decode('Cod Loc'),1,0,"C");
$pdf->Cell(10,7,utf8_decode('Cod Liv'),1,0,"C");
$pdf->Cell(20,7,utf8_decode('Titulo'),1,0,"C");
$pdf->Cell(20,7,utf8_decode('Gênero'),1,0,"C");
$pdf->Cell(20,7,utf8_decode('Autor'),1,0,"C");
$pdf->Cell(35,7,utf8_decode('Data Locação'),1,0,"C");
$pdf->Cell(35,7,utf8_decode('Data Prev Retorno'),1,0,"C");
$pdf->Cell(35,7,utf8_decode('Data Devolução'),1,0,"C");
$pdf->Ln();
foreach ($resultado as $chave){
    
   $pdf->Cell(10,10,utf8_decode($chave['loc_codigo']),1,0,"C");
   $pdf->Cell(10,10,utf8_decode($chave['liv_codigo']),1,0,"C");
   $pdf->Cell(20,10,utf8_decode($chave['liv_titulo']),1,0,"C");
   $pdf->Cell(20,10,utf8_decode($chave['gen_descricao']),1,0,"C");
   $pdf->Cell(20,10,utf8_decode($chave['aut_nome']),1,0,"C");   
   $pdf->Cell(35,10,utf8_decode($chave['loc_data_locacao']),1,0,"C");
   $pdf->Cell(35,10,utf8_decode($chave['loc_data_previsao_retorno']),1,0,"C");
   $pdf->Cell(35,10,utf8_decode($chave['loc_data_devolucao']),1,0,"C");
   $pdf->Ln();
}
$pdf->Output();




?>
