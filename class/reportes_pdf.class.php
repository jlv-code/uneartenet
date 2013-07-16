<?php

	require('./../class/fpdf.class.php');
	class reportes_pdf extends FPDF {
		//METODO HEADER DE FPDF 
		function Header(){
			$this->SetMargins(10,10);
			$this->SetFont('Arial','B',15);
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255,255,255);
			$this->SetTextColor(000,000,000);
			//$this->Cell(157,15,date("d - m - Y", time()),0,0,'R',true);
			$this->Ln(12);
			$this->Cell(0,0,'','',0,'C',true);
			$this->Ln(10);
			$this->Image('./../media/images/logo.jpg',20,5,25,27);
			$this->Image('./../media/images/top_gobierno.jpg',45,16,115,10);
			$this->Cell(0,3,'','B','C');
			$this->Ln(5);
		}
		
		function Footer(){
			$this->SetMargins(10,10);
			$this->SetY(-15);
			$this->SetFont('Arial','',8);
			$this->Cell(0,3,'','T','C');
			$this->Ln(3);
			$this->Cell(0,0,utf8_decode("AV. MEXICO CON CALLE TITO SALAS, EDIF. SANTA MARÍA, BELLAS ARTES, SECTOR LA CANDELARIA, CARACAS"),0,0,'C',true);
			$this->Ln(2);
			$this->Cell(0,6,utf8_decode("TELF: 0212-636.83.47, FAX: 0212-574.24.42, CORREO: comprasunearte@hotmail.com"),0,0,'C',true);
			$this->Ln(2);
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		}
	}

?>
