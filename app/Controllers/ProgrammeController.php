<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\HistoriqueRemisesGoldModel;
use App\Models\ProgrammeUtilisateurModel;
use App\Models\HistoriqueSanteModel;
use App\Libraries\ProgrammePdf;
use App\Services\AlgoSuggestion;
use App\Services\ProgrammeService;

require_once APPPATH . 'Libraries/FPDF/fpdf.php';
require_once APPPATH . 'Libraries/ProgrammePdf.php';

class ProgrammeController extends BaseController
{

    public function validerPaiement()
    {
        if (!$this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'Requête invalide']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        $programmeData = $this->request->getJSON(true);
        $result = ProgrammeService::validerPaiement($userId, $programmeData);

        // If payment succeeded, store full programme details for robust matching/fallback
        if (isset($result['success']) && $result['success']) {
            session()->set('last_programme_bought', [
                'regime' => $programmeData['regime'] ?? null,
                'poids_final' => $programmeData['poids_final'] ?? null,
                'sport' => $programmeData['sport'] ?? null,
            ]);
        }

        return $this->response->setJSON($result);
    }

    // Affiche la page de paiement (infos du programme récupérées côté JS)
    public function payer()
    {
        return view('client/pages/payer_programme');
    }

    public function show()
    {
        $algo = new \App\Services\AlgoSuggestion();

        $poidsIndividu = $this->request->getPost("poidsIndividu");
        $poidsMinCible = $this->request->getPost("poidsMin");
        $poidsMaxCible = $this->request->getPost("poidsMax");

        $resultats = $algo->suggererProgrammes(
            (float) $poidsIndividu,
            (float) $poidsMinCible,
            (float) $poidsMaxCible
        );

        $estGold = (new UtilisateurModel())->estGold(session()->get('user_id'));
        if ($estGold) {
            $remiseGold = (new HistoriqueRemisesGoldModel())->getInfosActuelGold()['pourcent_remise'];
            for ($i = 0; $i < count($resultats); $i++) {
                $resultats[$i]['prix'] = ((float) $resultats[$i]['prix']) * (100. - $remiseGold) / 100.;
            }
        }

        return $this->response->setJSON($resultats);
    }

    public function exportPdf($programmeId)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setBody('Non authentifié');
        }

        // Récupérer le programme spécifique pour cet utilisateur
        $model = new ProgrammeUtilisateurModel();
        $programme = $model
            ->select(
                'programme_utilisateur.*,' .
                    ' regime.nom AS regime_nom,' .
                    ' regime.pourcent_viande AS pourcent_viande,' .
                    ' regime.pourcent_poisson AS pourcent_poisson,' .
                    ' regime.pourcent_volaille AS pourcent_volaille,' .
                    ' regime.poids_variation AS poids_variation,' .
                    ' regime.duree_jours AS duree_regime,' .
                    ' activite_sportive.nom AS activite_nom'
            )
            ->join('regime', 'regime.id = programme_utilisateur.id_regime', 'left')
            ->join('activite_sportive', 'activite_sportive.id = programme_utilisateur.id_activite', 'left')
            ->where('programme_utilisateur.id', (int)$programmeId)
            ->where('programme_utilisateur.id_utilisateur', (int)$userId)
            ->first();

        if (!$programme) {
            return $this->response->setStatusCode(404)->setBody('Programme non trouvé');
        }

        // Récupérer le poids actuel de l'utilisateur
        $historiqueSante = new HistoriqueSanteModel();
        $derniereMesure = $historiqueSante->getDerniereMesureByUserId((int)$userId);
        $poidsActuel = $derniereMesure['poids'] ?? null;

        // Calculer le poids final
        if ($poidsActuel && isset($programme['poids_variation'])) {
            $poidsFinal = (float)$poidsActuel + (float)$programme['poids_variation'];
            $poidsFinalDisplay = number_format($poidsFinal, 1, ',', '') . ' kg';
        } else {
            $poidsFinal = null;
            $poidsFinalDisplay = '--';
        }

        // Ajouter les données calculées au programme
        $programme['poids_final_value'] = $poidsFinal;
        $programme['poids_final_display'] = $poidsFinalDisplay;

        // Générer le PDF
        $pdfBinary = $this->generateProgrammePdf($programme);

        $filename = 'Programme_' . str_replace(' ', '_', $programme['regime_nom']) . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($pdfBinary);
    }

    private function generateProgrammePdf(array $programme): string
    {
        $duree = $programme['duree_regime'] ?? '--';
        $activite = $programme['activite_nom'] ?? 'Aucune';
        $dateDecision = $programme['date_decision'] ?? '--';
        $poidsFinal = $programme['poids_final_display'] ?? '--';
        $viande = isset($programme['pourcent_viande']) ? $programme['pourcent_viande'] . ' %' : '--';
        $poisson = isset($programme['pourcent_poisson']) ? $programme['pourcent_poisson'] . ' %' : '--';
        $volaille = isset($programme['pourcent_volaille']) ? $programme['pourcent_volaille'] . ' %' : '--';

        $pdf = new ProgrammePdf();
        $pdf->regimeNom = (string) $programme['regime_nom'];
        $pdf->duree = (string) $duree;
        $pdf->activite = (string) $activite;
        $pdf->dateDecision = (string) $dateDecision;
        $pdf->poidsFinal = (string) $poidsFinal;
        $pdf->viande = (string) $viande;
        $pdf->poisson = (string) $poisson;
        $pdf->volaille = (string) $volaille;

        $pdf->SetTitle('Programme - ' . $programme['regime_nom']);
        $pdf->SetAuthor('Mes Régimes');
        $pdf->SetMargins(12, 12, 12);
        $pdf->SetAutoPageBreak(true, 18);
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(3, 64, 120);
        $pdf->Cell(0, 10, $pdf->encode((string) $programme['regime_nom']), 0, 1, 'L');
        $pdf->Ln(2);

        $leftWidth = 65;
        $rightWidth = 115;

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(51, 51, 51);
        $pdf->Cell($leftWidth, 10, $pdf->encode('Objectif final'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell($rightWidth, 10, $pdf->encode((string) $poidsFinal), 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell($leftWidth, 10, $pdf->encode('Durée'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell($rightWidth, 10, $pdf->encode((string) $duree . ' jours'), 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell($leftWidth, 10, $pdf->encode('Activité sportive'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell($rightWidth, 10, $pdf->encode((string) $activite), 1, 1, 'L');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(3, 64, 120);
        $pdf->Cell(0, 9, $pdf->encode('Répartition Alimentaire'), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(3, 64, 120);
        $pdf->Cell(94, 10, $pdf->encode('Aliment'), 1, 0, 'L', true);
        $pdf->Cell(94, 10, $pdf->encode('Pourcentage'), 1, 1, 'L', true);

        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(51, 51, 51);
        $pdf->SetFillColor(249, 249, 249);
        $pdf->Cell(94, 10, $pdf->encode('Viande'), 1, 0, 'L', true);
        $pdf->Cell(94, 10, $pdf->encode((string) $viande), 1, 1, 'L', true);
        $pdf->Cell(94, 10, $pdf->encode('Poisson'), 1, 0, 'L');
        $pdf->Cell(94, 10, $pdf->encode((string) $poisson), 1, 1, 'L');
        $pdf->Cell(94, 10, $pdf->encode('Volaille'), 1, 0, 'L', true);
        $pdf->Cell(94, 10, $pdf->encode((string) $volaille), 1, 1, 'L', true);

        return $pdf->Output('S');
    }
}
