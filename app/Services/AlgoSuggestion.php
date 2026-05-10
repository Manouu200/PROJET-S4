<?php 

namespace App\Services;

use App\Models\RegimeModel;
use App\Models\RegimePrixModel;
use App\Models\ActiviteSportiveModel;

class AlgoSuggestion
{
    public function suggererProgrammes($poidsActuel, $poidsMin, $poidsMax)
    {
        $regimeModel = new RegimeModel();
        $prixModel = new RegimePrixModel();
        $sportModel = new ActiviteSportiveModel();

        $regimes = $regimeModel->findAll();
        $sports = $sportModel->findAll();

        $suggestions = [];

        foreach ($regimes as $regime) {

            // récupérer les durées disponibles pour ce régime
            $durees = $prixModel
                ->where('id_regime', $regime['id'])
                ->findAll();

            foreach ($durees as $duree) {

                // calcul perte régime (linéaire simple)
                $variationRegime = ($regime['poids_variation'] / $regime['duree_jours']) * $duree['duree_jours'];

                // version SANS sport
                if ($this->dansIntervalle($variationRegime + $poidsActuel, $poidsMin, $poidsMax)) {
                    $suggestions[] = [
                        'type' => 'simple',
                        'regime' => $regime['nom'],
                        'duree' => $duree['duree_jours'],
                        'perte' => round($variationRegime, 2),
                        'prix' => $duree['prix']
                    ];
                }

                // version AVEC sport
                foreach ($sports as $sport) {

                    $perteSport = $sport['poids_variation'] * ($duree['duree_jours'] / 7);

                    $total = $variationRegime + $perteSport;

                    if ($this->dansIntervalle($total, $poidsMin, $poidsMax)) {
                        $suggestions[] = [
                            'type' => 'sport',
                            'regime' => $regime['nom'],
                            'sport' => $sport['nom'],
                            'duree' => $duree['duree_jours'],
                            'perte' => round($total, 2),
                            'prix' => $duree['prix']
                        ];
                    }
                }
            }
        }

        return $suggestions;
    }

    private function dansIntervalle($val, $min, $max)
    {
        return $val >= $min && $val <= $max;
    }
}

?>