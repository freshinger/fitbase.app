<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskUebersaeuerungData extends AbstractFixture implements OrderedFixtureInterface
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

        $item1977 = new Weeklytask();
        $item1977->setFormat("richhtml");
        $item1977->setTag("Übersäuerung");
        $item1977->setWeekId(29);
        $item1977->setQuiz($this->getReference('weeklyquiz_29'));
        $item1977->setCountPoint(1);
        $item1977->setName("Wochenaufgabe 29");
        $item1977->setContent(<<<EOT
<em> In unserer heutigen Einheit geht es um den Zusammenhang von wenig Bewegung, Unterversorgung der Muskeln und Muskelschwäche, als Gründe für Beschwerden.</em>
<h3> Übersäuerung</h3>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa29.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa29.png" alt = "wa29" width = "271" height = "246" class="alignright wp-image-1978 size-full" /></a> Alle Körperzellen brauchen Sauerstoff, um zu funktionieren. Jeder von uns hat nach intensivem Sport schon einmal Muskelkater gehabt und gespürt, was es bedeutet, wenn Muskeln nicht mit ausreichend Sauerstoff versorgt wurden und übersäuern. Diese Übersäuerung tritt nicht nur beim Sport, sondern auch beim stundenlangen Sitzen vor dem PC oder mehrere Stunden währende Autofahrten auf. Vor allem die Schulter - und Nackenmuskulatur, aber auch die untere Rückenmuskulatur sind bei der starren PC - Arbeit ohne Bewegung einem extremen Sauerstoffmangel ausgesetzt und können nicht ausreichend versorgt werden.
<strong> Eine Klassische Übung, die die Versorgung der Schulter - Nacken - Partie sicherstellt und die Sie überall durchführen können ist Schulterkreisen <em>.</em></strong>
<h3></h3>
<h3> Muskelschwäche</h3>
Die Wirbelsäule wird von ca. 150 Muskeln umgeben und geschützt. Gut trainiert, fangen diese rund 90 % der einwirkenden Kräfte ab und schonen damit Knorpel, Knochen und Bandscheiben. Durch mangelnde oder fehlerhafte Beanspruchung verkürzen bzw. verspannen sich jedoch die Muskeln und können die Wirbelsäule nicht mehr ausreichend schützen und die Gelenke nicht mehr führen. Ist ein Muskel verspannt, kann er nicht mehr richtig arbeiten und schmerzt. Dies wirkt sich wiederum auf den Gegenspieler - Muskel aus, der unterfordert wird und sich zurückbildet. Zudem verändert sich bei einer Verspannung die Haltung und Bewegung, so dass weitere Verspannungen die häufige Folge sind.
Neben den großen sichtbaren oberflächlichen Rückenmuskeln, die jeder am eigenen Leib ertasten kann, gibt es die für den Schutz vor Schmerzen weitaus wichtigere und von außen nicht ersichtliche Tiefenmuskulatur. Diese bildet sich sehr viel schneller zurück und sorgt dann für den größten Stabilitätsverlust: Die Wirbelkörper werden nicht mehr gehalten und können verrutschen oder blockieren. Entzündungen und Schmerzen, die auch in Arme und Beine ausstrahlen können, sind die Folge.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa29b.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa29b-300x295.png" alt = "wa29b" width = "300" height = "295" class="alignleft wp-image-1980 size-medium" /></a> Bei herkömmlichen Übungen werden diese tiefliegenden Muskeln kaum trainiert. Online - Rückenschule berücksichtigt in den ausgearbeiteten Übungsprogrammen gerade diese tiefliegende Muskulatur, so dass Sie durch die regelmäßige Durchführung die Stabilität Ihrer Wirbelsäule maßgeblich positiv beeinflussen können.
<strong> Aufgabe: Bitte führen Sie in der kommenden Woche die folgende </strong><strong> Übung zur Kräftigung der tiefen Rückenmuskeln </strong><strong> täglich einmal durch: </strong><a href = "http://online-rueckenschule.de/mitgliederbereich/uebungen/unterer-ruecken/2-kraeftigung-tiefe-rueckenmuskulatur/" target = "_blank"> Übungslink</a>
EOT
        );
        $manager->persist($item1977);
        $manager->flush();


    }

}
