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
        $prixModel   = new RegimePrixModel();
        $sportModel  = new ActiviteSportiveModel();

        $regimes = $regimeModel->findAll();
        $sports  = $sportModel->findAll();

        $poidsCible = ($poidsMin + $poidsMax) / 2;

        $suggestions = [];

        foreach ($regimes as $regime) {

            $durees = $prixModel
                ->where('id_regime', $regime['id'])
                ->findAll();

            foreach ($durees as $duree) {

                // REGIME
                $variationRegime =
                    ($regime['poids_variation'] / $regime['duree_jours'])
                    * $duree['duree_jours'];

                $poidsFinal = $poidsActuel + $variationRegime;

                if ($this->dansIntervalle($poidsFinal, $poidsMin, $poidsMax)) {

                    $suggestions[] = [
                        'type' => 'simple',
                        'regime' => $regime['nom'],
                        'duree' => $duree['duree_jours'],
                        'sport' => null,
                        'poids_final' => round($poidsFinal, 2),
                        'score' => abs($poidsFinal - $poidsCible),
                        'prix' => $duree['prix']
                    ];
                }
                // SPORT
                foreach ($sports as $sport) {

                    $variationSport =
                        $sport['poids_variation']
                        * ceil($duree['duree_jours'] / 7);

                    $poidsFinalSport =
                        $poidsActuel
                        + $variationRegime
                        + $variationSport;

                    if ($this->dansIntervalle($poidsFinalSport, $poidsMin, $poidsMax)) {

                        $suggestions[] = [
                            'type' => 'sport',
                            'regime' => $regime['nom'],
                            'sport' => $sport['nom'],
                            'duree' => $duree['duree_jours'],
                            'poids_final' => round($poidsFinalSport, 2),
                            'score' => abs($poidsFinalSport - $poidsCible),
                            'prix' => $duree['prix']
                        ];
                    }
                }
            }
        }

        // TRI DES RESULTATS et on prend les 5 meilleurs
        usort($suggestions, function ($a, $b) {
            return $a['score'] <=> $b['score'];
        });

        return array_slice($suggestions, 0, 5);
    }
    private function dansIntervalle($val, $min, $max){
        return $val >= $min && $val <= $max;
    }
}

?>