<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskKoerperhaltungData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Set loading order.
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->getClassMetaData(get_class(new Weeklytask()))->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $item1703 = new Weeklytask();
        $item1703->setFormat("richhtml");
        $item1703->setTag("Koerperhaltung");
        $item1703->setWeekId(7);
        $item1703->setQuiz($this->getReference('weeklyquiz_7'));
        $item1703->setCountPoint(2);
        $item1703->setName("Wochenaufgabe 07");
        $item1703->setContent(<<<EOT
Sie beginnen jetzt den Bereich <strong>Körperhaltung </strong>. In dieser Kategorie erlernen Sie, wie Sie eine aufrechte Körperhaltung einnehmen und dadurch nicht nur Ihrer Gesundheit etwas Gutes tun, sondern auch mehr Selbstbewusstsein ausstrahlen.
<em> In den letzten Wochen haben Sie erfahren, wie Sie Ihren Arbeitsplatz ergonomisch einrichten. In den nächsten Wochenaufgaben geht es um das Thema Körperhaltung. Heute erfahren Sie mehr über die aufrechte Sitzhaltung – also die Position, in der Sie tagsüber vermutlich die meiste Zeit verbringen.</em>
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/posture_1_officephysio.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/posture_1_officephysio-280x300.jpg" alt = "posture_1_officephysio" width = "220" height = "236" class="alignleft wp-image-1846 " /></a> Bild 1 zeigt eine typische Sitzhaltung:</strong> Das Becken(1) ist nach hinten gekippt, das Brustbein(2) und die Schultern sind nach vorne gefallen und die Halswirbelsäule(3) wird vorgestreckt. Die Zahnräder verdeutlichen den Zusammenhang.
So finden wir uns regelmäßig vor dem Bildschirm wieder. Das ist nicht weiter schlimm, da es eine Entspannungsposition für die Haltemuskulatur darstellt und Muskeln von Spannung und Entspannung leben. Wird diese Position jedoch über einen längeren Zeitraum eingenommen, werden Muskeln und Bänder zu einseitig belastet. Daher sollten Sie sich während des täglichen Sitzmarathons regelmäßig aufrichten.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/posture_2_officephysio.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/posture_2_officephysio-284x300.jpg" alt = "posture_2_officephysio" width = "223" height = "236" class="alignleft wp-image-1847 " /></a> Bild 2 zeigt eine aufrechte Sitzhaltung: </strong> Diese startet immer aus der Aufrichtung des Beckens heraus. <strong> Eine leichte Beckenkippung </strong> (1)<strong> </strong> fördert die natürliche Wirbelsäulenkrümmung im Lendenbereich, die als Voraussetzung für eine aufrechte Sitzhaltung gilt.
<strong> Eine Hebung des Brustkorbs </strong> erfolgt dann fast automatisch im Sinne eines sich entgegengesetzt drehenden Zahnrades(2) und ermöglicht eine tiefe Atmung. <strong> Eine Streckung der Halswirbelsäulen(3) </strong> komplettiert die aufrechte Haltung und verhindert eine übermäßige Belastung von Bandscheiben und Nackenmuskulatur. Achten Sie darauf, das Kinn nach innen zu führen.
<a href = "http://online-rueckenschule.de/wp-content/uploads/haltung_merkbox_officephysio.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/haltung_merkbox_officephysio-300x273.jpg" alt = "haltung_merkbox_officephysio" width = "265" height = "241" class="alignright wp-image-1886 " /></a>
<strong> Aufgabe: Überprüfen Sie regelmäßig Ihre Sitzposition und richten Sie sich bewusst auf. Nutzen Sie hierfür die Abbildung. Drucken Sie diese aus und legen Sie sie auf Ihren Schreibtisch, damit Sie täglich an eine aufrechte Haltung erinnert werden.</strong>
<strong>  </strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1703);

        $item1707 = new Weeklytask();
        $item1707->setFormat("richhtml");
        $item1707->setTag("Koerperhaltung");
        $item1707->setWeekId(8);
        $item1707->setQuiz($this->getReference('weeklyquiz_8'));
        $item1707->setCountPoint(2);
        $item1707->setName("Wochenaufgabe 08");
        $item1707->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Körperhaltung </strong>. In dieser Kategorie erlernen Sie, wie Sie eine aufrechte Körperhaltung einnehmen und dadurch nicht nur Ihrer Gesundheit etwas Gutes tun, sondern auch mehr Selbstbewusstsein ausstrahlen.
<em> In der letzten Woche haben Sie erfahren, wie Sie aufrecht sitzen. Heute geht es um eine aufrechte Haltung im Stand. Haben Sie schon mal bewusst Ihre Körperhaltung im Stand angeschaut, z. B. mithilfe eines Spiegels oder eines Fotos ?</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/Körperhaltung-schwach.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/Körperhaltung-schwach-182x300.png" alt = "Körperhaltung schwach" width = "256" height = "423" class="alignleft wp-image-1854 " /></a> Wie schon beim Sitzen, gilt auch für die Körperhaltung im Stand, dass es nicht die eine richtige Haltung gibt. <strong> Bild 1 </strong> zeigt eine typische Körperhaltung im Stehen: <strong> Das Becken(1) </strong> ist oben nach vorne gekippt, das <strong>Brustbein(2) </strong> und die Schultern sind eingefallen und die <strong>Halswirbelsäule(3) </strong> wird vorgestreckt. Fällt man ein Lot, erfasst dieses nicht die <strong>rot markierten Punkte </strong>. Außerdem sind die Achsen(hier als grüne Striche dargestellt) verschoben.
Wie auch bei der Sitzposition ist diese schlaffe Haltung erst einmal nicht weiter schlimm, da es eine Entspannungsposition für die Haltemuskulatur darstellt und Muskeln von Spannung und Entspannung leben. Wird diese Position jedoch über einen längeren Zeitraum eingenommen, werden Muskeln und Bänder zu einseitig belastet.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/Körperhaltung-gut.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/Körperhaltung-gut-197x300.png" alt = "Körperhaltung gut" width = "271" height = "412" class="alignright wp-image-1855 " /></a></strong><strong> Bild 2 </strong> zeigt eine aufrechte(optimale) Körperhaltung: Die Füße stehen schulterbreit, tragen gleich viel Gewicht und die Fußspitzen zeigen leicht nach außen. Die Knie sind leicht gebeugt.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/Körperhaltung-gut.png"></a> Kippen Sie das Becken(1) </strong> oben leicht nach hinten, z. B. indem Sie die Gesäßmuskeln leicht anspannen.<strong></strong>
<strong> Führen Sie dann das Brustbein nach vorne - oben(2) </strong> und atmen Sie tief in den Bauch ein. Spüren Sie bewusst den vorhandenen Platz. Lassen Sie die Schultern und Arme locker hängen.
<strong> Strecken Sie Ihre Halswirbelsäule(3) </strong> indem Sie sich vorstellen, dass ein Faden oben an Ihrem Hinterkopf befestigt ist und daran gezogen wird. Achten Sie darauf, das Kinn nach innen zu führen. Jetzt ist die Haltung wieder im Lot und schon lässt diese Haltung erkennen, dass Sie ein bisschen stolzer und selbstbewusster in den Tag starten. In dieser Haltung lässt es sich auch viel besser Atmen. Mehr dazu erfahren Sie in den nächsten Wochen.
<img class="floating-border alignleft" title = "merkbox_wa8" src = "https://www.fitbase.de/wp-content/uploads/merkbox_wa8-300x280.png" height = "280" width = "300" />
<strong> Aufgabe: Überprüfen Sie Ihre Körperhaltung im Stand und richten Sie sich bewusst auf. Nutzen Sie hierfür die Abbildung. Üben Sie einen aufrechten und bewussten Stand immer wieder zwischendurch, z. B. im Fahrstuhl, an der Haltestelle oder beim Zähneputzen.</strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1707);
        $manager->flush();

    }

}
