<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskVerspannungenData extends AbstractFixture implements OrderedFixtureInterface
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

        $item1973 = new Weeklytask();
        $item1973->setFormat("richhtml");
        $item1973->setTag("Verspannungen");
        $item1973->setWeekId(28);
        $item1973->setQuiz($this->getReference('weeklyquiz_28'));
        $item1973->setCountPoint(1);
        $item1973->setName("Wochenaufgabe 28");
        $item1973->setContent(<<<EOT
<h2> Entstehung einer Verspannung </h2>
In dieser Einheit lernen Sie, wie eine sogenannte Verspannung entsteht und was Sie dagegen tun können.
Was ist eigentlich eine <strong><em> Verspannung</em></strong>? Eine Verspannung entsteht dadurch, dass wir Muskeln längere Zeit als notwendig anspannen. Dies geschieht in der Regel unbewusst, zum Beispiel wenn wir auf andere Dinge konzentriert sind oder müde werden. Sehr typisch ist die Arbeitshaltung am PC: Sie konzentrieren sich auf Ihre Arbeit, haben den Bildschirm fest im Blick und vergessen, Ihre Körperhaltung.
<img class="alignright size-medium wp-image-4531" title = "wa5_sitting wrong" src = "http://www.officephysio.de/wp-content/uploads/wa5_sitting-wrong-300x223.jpg" alt = "" width = "300" height = "223" />Betrachten wir unsere Schulter - und Nackenmuskulatur: In einem Spiegelbild würden wir sehen, dass wir ganz oft die Schultern hochgezogen und den Kopf in Richtung Bildschirm nach vorn geschoben haben. So wie auf dem Bild dargestellt.
Hier hilft schon, wenn wir uns die Fehlhaltung und Verspannungen bewusster machen. Wie ist Ihre Sitzposition, wie fühlt sich Ihre Schulter - Nackenpartie an ? Richten Sie sich auf und entspannen Sie die Schultern, so dass diese wieder nach unten sinken können. <strong> Machen Sie genau das bitte jetzt.</strong>
Wenn Sie schon lange in einer Position gearbeitet haben, versuchen Sie, diese zu wechseln, Ihre Schultern zu lockern oder aufzustehen und ein paar Schritte zu gehen.
Was ist passiert, wenn dies keine Wirkung mehr zeigt, es schon unangenehm ist oder sogar schmerzt ?
Der betroffene Muskel ist aufgrund der noch längeren Anspannung deutlich weniger durchblutet. Der Muskel kann daher bestimmte Stoffwechselprodukte nicht mehr abtransportieren und verbleibt passiv in der Anspannungsposition. In den am meisten betroffenen Regionen des Muskels kommt es zu Verhärtungen bis hin zu Schmerzen.
Abhilfe schafft hier, die Durchblutung dieser Regionen wieder zu steigern. Dies kann beispielsweise durch Bewegung, Massage, Wärmeanwendung oder Dehnung geschehen. Kreisen Sie zum Beispiel die Schultern nach hinten, massieren Sie den verspannten Bereich mit Ihren Fingern oder legen Sie ein warmes Kirschkernkissen auf.
<strong><em> TIPP:</em></strong><em> Zu geringe Flüssigkeitsaufnahme fördert Verspannungen!Bei der Arbeit immer eine Flasche Wasser, Tee o. ä. in Reichweite haben und täglich ca. 2 - 3 l trinken.</em>
EOT
        );
        $manager->persist($item1973);

        $manager->flush();

    }

}
