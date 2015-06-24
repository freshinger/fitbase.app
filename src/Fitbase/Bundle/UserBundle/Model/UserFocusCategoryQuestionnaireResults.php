<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/04/15
 * Time: 10:28
 */
namespace Fitbase\Bundle\UserBundle\Model;

use Application\Sonata\ClassificationBundle\Entity\Category;

class UserFocusCategoryQuestionnaireResults
{
    protected $results = [];

    /**
     * Add result entry
     *
     * @param $points
     * @param $category
     * @return $this
     */
    public function addResult($points, $category)
    {
        array_push($this->results, [
            'points' => $points,
            'category' => $category,
        ]);

        return $this;
    }

    /**
     * Get winners from results
     * @return array
     */
    public function getWinners()
    {
        $max = 0;
        $winners = [];
        $categories = [];
        if (count($this->results)) {
            foreach ($this->results as $result) {
                if (isset($result['category'])) {
                    $category = $result['category'];
                    if (isset($result['points'])) {
                        $points = $result['points'];

                        if ($points > $max) {
                            $max = $points;
                            $winners = [$result];
                            array_push($categories, $category->getId());
                        } else if ($points == $max) {
                            if (!in_array($category->getId(), $categories)) {
                                array_push($winners, $result);
                                array_push($categories, $category->getId());
                            }
                        }
                    }
                }
            }
        }

        return $winners;
    }

    /**
     * Get winner categories
     *
     * @return array
     */
    public function getWinnerCategories()
    {
        $categories = [];
        if (($winners = $this->getWinners())) {
            foreach ($winners as $winner) {
                array_push($categories, $winner['category']);
            }
        }

        return $categories;
    }

    /**
     * Get description for a winners
     *
     * @param null $slug
     * @return string
     */
    public function getDescription($slug = null)
    {
        switch ($slug) {

            case 'oberer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen vor allem Übungen für Ihren oberen Rücken, den
                Schulter-Nacken Bereich empfehlen. Bitte setzen Sie den entsprechenden Haken, so dass die Übungsauswahl
                individuell auf Sie zugeschnitten werden kann. Wenn Sie künftig in der Erinnerungsemail auf den Link
                „Meine heutige Übung starten“ klicken, werden Ihnen vor allem Übungen für diesen Bereich vorgeschlagen.
                Schauen Sie sich doch auch gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden Haken.
                Hier finden Sie weitere, vielfältige Übungen für alle Bereiche des Rückens - natürlich
                auch speziell für den oberen Rücken.';

            case 'mittlerer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen vor allem Übungen für Ihren mittleren Rücken
                empfehlen. Bitte setzen Sie den entsprechenden Haken, so dass die Übungsauswahl individuell auf Sie
                zugeschnitten werden kann. Wenn Sie künftig auf den Link „Meine heutige Übung starten“ in der
                Erinnerungsemail klicken, werden Ihnen vor allem Übungen für diesen Bereich vorgeschlagen. Schauen Sie
                sich doch auch gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden Haken.
                Hier finden Sie weitere, vielfältige Übungen für alle Bereiche des Rückens - natürlich
                auch speziell für den mittleren Rücken.';

            case 'unterer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen vor allem Übungen für Ihren unteren Rücken
                empfehlen. Bitte setzen Sie den entsprechenden Haken, so dass die Übungsauswahl individuell auf Sie
                zugeschnitten werden kann. Wenn Sie künftig in der Erinnerungsemail auf den Link „Meine heutige Übung
                starten“ klicken, werden Ihnen vor allem Übungen für diesen Bereich vorgeschlagen. Schauen Sie sich
                doch auch gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden Haken. Hier
                finden Sie weitere, vielfältige Übungen für alle Bereiche des Rückens -
                natürlich auch speziell für den unteren Rücken.';

            case 'mittlerer-ruecken-unterer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen vor allem Übungen für Ihren mittleren und
                unteren Rücken empfehlen. Bitte setzen Sie die entsprechenden Haken, so dass die Übungsauswahl
                individuell auf Sie zugeschnitten werden kann. Wenn Sie künftig in der Erinnerungsemail auf den Link
                „Meine heutige Übung starten“ klicken, werden Ihnen vor allem Übungen für diese Bereiche vorgeschlagen.
                Schauen Sie sich doch auch gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden
                Haken. Hier finden Sie weitere, vielfältige Übungen für alle Bereiche des Rückens - natürlich auch
                speziell für den mittleren und unteren Rücken.';

            case 'oberer-ruecken-unterer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen vor allem Übungen für Ihren oberen und unteren
                Rücken empfehlen. Bitte setzen Sie die entsprechenden Haken, so dass die Übungsauswahl individuell auf
                Sie zugeschnitten werden kann. Wenn Sie künftig in der Erinnerungsemail auf den Link „Meine heutige
                Übung starten“ klicken, werden Ihnen vor allem Übungen für diese Bereiche vorgeschlagen. Schauen Sie
                sich doch auch gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden Haken.
                Hier finden Sie weitere, vielfältige Übungen für alle Bereiche des Rückens - natürlich auch speziell
                für den oberen und unteren Rücken.';

            case 'mittlerer-ruecken-oberer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen vor allem Übungen für Ihren oberen und
                mittleren Rücken empfehlen - dies betrifft in erster Linie den Schulter-Nacken-Bereich.
                Bitte setzen Sie die entsprechenden Haken, so dass die Übungsauswahl individuell auf Sie zugeschnitten
                werden kann. Wenn Sie künftig in der Erinnerungsemail auf den Link „Meine heutige Übung starten“
                klicken, werden Ihnen vor allem Übungen für diese Bereiche vorgeschlagen. Schauen Sie sich doch auch
                gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden Haken. Hier finden Sie
                weitere, vielfältige Übungen für alle Bereiche des Rückens - natürlich auch speziell
                für den oberen und mittleren Rücken.';

            case 'mittlerer-ruecken-oberer-ruecken-unterer-ruecken':
                return 'Vielen Dank für Ihre Teilnahme. Wir möchten Ihnen Übungen für Ihren gesamten Rücken empfehlen.
                Bitte setzen Sie die entsprechenden Haken, so dass die Übungsauswahl individuell auf Sie zugeschnitten
                werden kann. Wenn Sie künftig in der Erinnerungsemail auf den Link „Meine heutige Übung starten“
                klicken, werden Ihnen Übungen für alle Bereiche des Rückens vorgeschlagen. Sie können die Übungsauswahl
                jederzeit durch Klicken eines Hakens entsprechend auf einen Bereich fokussieren. Schauen
                Sie sich doch auch gerne einmal unsere Thera-Band Übungen an und setzen dazu den entsprechenden Haken.
                Hier finden Sie weitere, vielfältige Übungen für alle Bereiche des Rückens. ';
        }

        return '';
    }

    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        $slugs = [];
        if (($winners = $this->getWinners())) {
            foreach ($winners as $winner) {

                if (!isset($winner['category']) or !$winner['category'] instanceof Category) {
                    throw new \LogicException('Category object must be defined');
                }

                array_push($slugs, $winner['category']->getSlug());
            }

            asort($slugs, SORT_NATURAL | SORT_FLAG_CASE);

            return $this->getDescription(implode('-', $slugs));
        }

        return '';
    }
}