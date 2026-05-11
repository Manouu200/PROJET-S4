<?php

namespace App\Libraries;

class ProgrammePdf extends \FPDF
{
    public string $regimeNom = '';
    public string $duree = '--';
    public string $activite = 'Aucune';
    public string $dateDecision = '--';
    public string $poidsFinal = '--';
    public string $viande = '--';
    public string $poisson = '--';
    public string $volaille = '--';

    public function Header()
    {
        $this->SetTextColor(3, 64, 120);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10, $this->encode('NutriPlan'), 0, 1, 'C');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 7, $this->encode('Programme Nutritionnel Personnalisé'), 0, 1, 'C');
        $this->Ln(3);
        $this->SetDrawColor(3, 64, 120);
        $this->SetLineWidth(0.8);
        $this->Line(10, 28, 200, 28);
        $this->Ln(8);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 8, $this->encode('Page ') . $this->PageNo(), 0, 0, 'C');
    }

    public function encode(string $text): string
    {
        $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
        return $converted !== false ? $converted : $text;
    }
}
