<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskAtmungData extends AbstractFixture implements OrderedFixtureInterface
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

        $item1712 = new Weeklytask();
        $item1712->setFormat("richhtml");
        $item1712->setTag("Atmung");
        $item1712->setWeekId(9);
        $item1712->setQuiz($this->getReference('weeklyquiz_9'));
        $item1712->setCountPoint(1);
        $item1712->setName("Wochenaufgabe 09");
        $item1712->setContent(<<<EOT
Heute beginnen Sie mit dem Bereich <strong>Atmung </strong>. In dieser Kategorie lernen Sie, richtig zu atmen und mit der Atmung die Köperhaltung zu verbessern. Ganz nebenbei versorgen Sie Ihren Körper mit mehr Sauerstoff, aktivieren unterschiedliche Körperfunktionen und bauen Stress ab.
<em> In den letzten beiden Woche haben Sie erfahren, wie Sie aufrecht sitzen und stehen und haben erlebt, wie gut und tief man in einer aufrechten Haltung atmen kann. Wussten Sie, dass wir täglich 11.000 mal ein - und 11.000 mal ausatmen ? Wir wollen uns diese lebenswichtige Funktion daher heute und in den kommenden Wochen genauer anschauen.</em>
<em><a href = "http://online-rueckenschule.de/wp-content/uploads/atmung_de.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/atmung_de-300x256.jpg" alt = "atmung_de" width = "282" height = "241" class="alignleft wp-image-1851 " /></a></em>
<strong> Wie funktioniert Atmen eigentlich ?</strong>
Um einatmen zu können(Bild links), muss sich die Lunge ausdehnen. Dafür wird der Brustkorb aktiv durch Muskelarbeit erweitert. Der Brustkorb hebt sich, ein Unterdruck entsteht und wir atmen ein(= Brustatmung).
Außerdem kontrahiert das Zwerchfell als wichtigster Atemmuskel und macht Platz, sodass sich die Lunge auch nach unten ausdehnen kann(= Bauchatmung).
Bei der Ausatmung(Bild rechts) entspannen sich die beteiligten Muskeln, der Platz im Brustkorb verkleinert sich und die Luft wird nach außen gepresst.
<strong> Die optimale Atemtechnik ? </strong> Schauen Sie sich ein Baby an. Ein Baby atmet tief und gleichmäßig in den Bauch, die Seiten bewegen sich mit, während Schultern und Nacken locker und entspannt bleiben. Leider verlernen wir diese sogenannte Vollatmung(= Brustatmung + Bauchatmung) im Laufe der Zeit nach und nach. Die Gründe sind vielfältig: Sitzende Tätigkeiten, Bewegungsarmut, schlechte Körperhaltung, Stress und Anspannung.
<a href = "http://online-rueckenschule.de/wp-content/uploads/atmung_de_merkbox1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/atmung_de_merkbox1.jpg" alt = "atmung_de_merkbox" width = "281" height = "259" class="alignleft wp-image-1888 size-full" /></a>
<strong> Aufgabe: <strong> Vergegenwärtigen Sie sich das Zahnradmodell von vor zwei Wochen, setzen Sie sich aufrecht und locker hin, schließen Sie die Augen und konzentrieren Sie sich auf die Atmung. Atmen Sie tief ein und füllen Sie zuerst den Bauch und dann die Brust mit Luft. Zählen Sie leise bis drei. Atmen Sie dann vollständig aus und zählen Sie erneut leise bis drei. Wiederholen Sie die Atmung drei Mal und spüren Sie bewusst die Entspannung.</strong></strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
&nbsp
EOT
        );
        $manager->persist($item1712);


        $item1715 = new Weeklytask();
        $item1715->setFormat("richhtml");
        $item1715->setTag("Atmung");
        $item1715->setWeekId(10);
        $item1715->setQuiz($this->getReference('weeklyquiz_10'));
        $item1715->setCountPoint(1);
        $item1715->setName("Wochenaufgabe 10");
        $item1715->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Atmung </strong>. In dieser Kategorie lernen Sie, richtig zu atmen und mit der Atmung die Köperhaltung zu verbessern. Ganz nebenbei versorgen Sie Ihren Körper mit mehr Sauerstoff, aktivieren unterschiedliche Körperfunktionen und bauen Stress ab.
<em> In der letzten Woche haben Sie den Unterschied zwischen der Brust - und der Bauchatmung kennengelernt. Heute wollen wir uns anschauen, welchen Einfluss die Vollatmung(= Brustatmung + Bauchatmung) auf die Wirbelsäule hat.</em>
<strong> Jeder Atemzug bewegt die Wirbelsäule </strong>, wie in den folgenden Bildern schematisch dargestellt. Die Bewegungen sind sehr klein und nicht mit bloßem Auge erkennbar. Aber sie sind vorhanden und nehmen Einfluss auf die Wirbelsäule.
<a href = "http://online-rueckenschule.de/wp-content/uploads/einatmen.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/einatmen-300x209.jpg" alt = "einatmen" width = "288" height = "200" class="alignleft wp-image-1857" /></a> Beim <strong> Einatmen</strong> wird die natürliche Krümmung der Wirbelsäule verstärkt. Der Kopf kippt ganz leicht nach hinten, das Becken in entgegengesetzter Richtung oben nach vorn. Die Wirbelsäule wird dadurch etwas kürzer.
<a href = "http://online-rueckenschule.de/wp-content/uploads/ausatmen1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/ausatmen1.jpg" alt = "ausatmen" width = "142" height = "198" class="alignleft wp-image-1859" /></a> Beim <strong> Ausatmen</strong> tritt die entgegengesetzte Bewegung ein: Die Wirbelsäule wird etwas länger und die Krümmung verringert sich. Der Kopf beugt sich nach vorne, der Hinterkopf nach oben und das Becken kippt oben nach hinten.
Auch wenn die Bewegung der Wirbelsäule durch die Vollatmung nur sehr klein ist, so macht sie mit jedem Atemzug eine ziehharmonikaähnliche Mikro - Bewegung: Die Wirbel werden mobilisiert und die Durchblutung gefördert.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/merbox_atmung1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/merbox_atmung1.jpg" alt = "merbox_atmung" width = "280" height = "270" class="alignright wp-image-1890 size-full" /></a> Aufgabe: Üben Sie die Vollatmung immer wieder zwischendurch und denken Sie dabei an die kleinen Mikro - Bewegungen, die Ihre Wirbelsäule dabei macht. </strong>
<strong> Wiederholung: </strong> Vollatmung = Bauchatmung + Brustatmung. Atmen Sie tief ein und füllen Sie zuerst den Bauch und dann die Brust mit Luft. Zählen Sie nach dem Einatmen leise bis drei. Atmen Sie dann vollständig aus und zählen Sie erneut leise bis drei. Wiederholen Sie die Atmung drei Mal und spüren Sie bewusst die Entspannung.
<em> Zur Vertiefung empfehlen wir Ihnen die Studie der orthopädischen Universitätsklinik Rizzoli in Bologna von Professor Dr. P. G. Marchetti:„Einsatz von Bio - Feedback und ZILGREI - Methode in der nicht - operativen Behandlung von LWS - Schmerzen“.</em>
EOT
        );
        $manager->persist($item1715);

        $item1721 = new Weeklytask();
        $item1721->setFormat("richhtml");
        $item1721->setTag("Atmung");
        $item1721->setWeekId(11);
        $item1721->setQuiz($this->getReference('weeklyquiz_11'));
        $item1721->setCountPoint(1);
        $item1721->setName("Wochenaufgabe 11");
        $item1721->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Atmung </strong>. In dieser Kategorie lernen Sie, richtig zu atmen und mit der Atmung die Köperhaltung zu verbessern. Ganz nebenbei versorgen Sie Ihren Körper mit mehr Sauerstoff, aktivieren unterschiedliche Körperfunktionen und bauen Stress ab.
<em> In der letzten Woche haben wir Ihnen gezeigt, wie die Wirbelsäule durch eine tiefe Vollatmung bewegt und mobilisiert wird. Stellen Sie sich diesen positiven Einfluss bei jedem bewussten Atemzug vor. Nach diesen guten Nachrichten wollen wir heute einen Blick auf die negativen Folgen von Fehlatmungen werfen, wie Sie diese verhindern können und wie Sie mit Ihrer Atmung Einfluss auf Ihr Stresslevel nehmen können.</em>
<strong> 2 / 3 aller Menschen atmen nicht optimal, d. h. zu flach und uneffektiv.</strong> Eine Fehlatmungsform kann z. B. die Schulteratmung sein: Anstatt beim Einatmen Platz nach vorne(Brustatmung) bzw. nach unten(Bauchatmung) zu schaffen, werden bei dieser Fehlatmungsform die Schultern nach oben gezogen. Dabei werden verschiedene Muskeln des Schultergürtels angespannt, die nichts mit der Atmung zu tun haben und in der Folge verspannen. Dies hat außerdem zur Folge, dass die Sauerstoffversorgung nicht optimal gewährleistet ist.
Hauptproblem von Fehlatmungen ist der unvollständige Luftaustausch. Bei einer flachen, oberflächlichen Atmung(z. B. bei Aufregung und Stress) wird die „verbrauchte“ Luft nicht vollständig ausgeatmet. Dadurch steigen der Kohlendioxidgehalt in der Lunge und der CO2 - Spiegel im Blut an. Dies entspricht einer kurzzeitigen Vergiftung bzw. Mangelversorgung. Dauert dieser Zustand längere Zeit an, kann es zu Kreislaufproblemen, Erschöpfung, Kopfschmerzen und Muskelverspannungen kommen.
<strong> Stressabbau durch Bauchatmung </strong>
Das vegetative(unwillkürliche) Nervensystem ist für die automatisch ablaufenden innerkörperlichen Vorgänge zuständig und kann vom Menschen lediglich über die Atmung aktiv beeinflusst werden. Deutlich wird der Zusammenhang in Stresssituationen, denn bei Stress atmen wir flach und verkrampft, während wir in einer Entspannungsphase(z. B. Schlaf) tief und regelmäßig a <img class="floating - border alignright" title = "merkbox_fehlatmung" src = "https://www.fitbase.de/wp-content/uploads/merkbox_fehlatmung-300x248.png" height = "248" width = "300" />tmen.
<strong> Stress und eine ruhige tiefe Atmung schließen sich gegenseitig aus – aber auch anders herum gilt: Bei einer ruhigen und tiefen Atmung, kann man nicht in Stress geraten </strong>. Dieser Umstand ermöglicht es uns, durch gezielte Atemübungen, wie z. B. die tiefe Bauch - oder Vollatmung, einen positiven Einfluss auf das vegetative Nervensystem zu nehmen und damit Stress zu beseitigen.
<strong> Aufgabe: Versuchen Sie, sich diese Zusammenhänge in Stress - Situationen bewusst zu machen und konzentriert, ruhig und gleichmäßig dagegen anzuatmen. Denken Sie an das vegetative Nervensystem, das zwingend Stress beseitigt, wenn Sie die erlernte Voll - oder Bauchatmung anwenden.</strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1721);

        $item1728 = new Weeklytask();
        $item1728->setFormat("richhtml");
        $item1728->setTag("Atmung");
        $item1728->setWeekId(12);
        $item1728->setQuiz($this->getReference('weeklyquiz_12'));
        $item1728->setCountPoint(1);
        $item1728->setName("Wochenaufgabe 12");
        $item1728->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Atmung </strong>. In dieser Kategorie lernen Sie, richtig zu atmen und mit der Atmung die Köperhaltung zu verbessern. Ganz nebenbei versorgen Sie Ihren Körper mit mehr Sauerstoff, aktivieren unterschiedliche Körperfunktionen und bauen Stress ab.
<em> In der letzten Woche haben Sie erfahren, welche negativen Folgen dauerhafte Fehlatmungen haben und wie Sie mit der Bauchatmung Ihr Stresslevel beeinflussen können. Heute wollen wir Ihnen eine einfache Rückenübung zeigen, die zudem die Bauchatmung optimiert.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/Bild-1.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/Bild-1-233x300.png" alt = "Bild 1" width = "174" height = "216" class="alignleft wp-image-1863 " /></a> Bitte sitzen Sie aufrecht und nehmen Sie die Grundhaltung ein.
Lassen Sie nun die Arme locker nach unten hängen. Atmen Sie tief in Bauch und Brust ein <strong>ohne </strong> die Schultern nach oben zu ziehen und drehen Sie dabei die Daumen nach außen. Halten Sie in dieser Position ca. 3 Sekunden inne.
Bewegen Sie das Brustbein in Richtung Becken und atmen Sie langsam maximal aus. Rollen Sie dabei die Wirbelsäule bewusst ein und drehen Sie die Daumen nach innen.
<a href = "http://online-rueckenschule.de/wp-content/uploads/Bild-2.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/Bild-2-298x300.png" alt = "Bild 2" width = "226" height = "228" class="alignright wp-image-1864 " /></a>
Anschließend aus dieser Position die Wirbelsäule maximal aufrichten, indem Sie das Brustbein nach vorne oben bewegen und gleichzeitig die Daumen nach außen drehen.
Atmen Sie während der Aufrichtung tief in den Bauch und in die Brust ein ohne die Schultern nach oben zu ziehen. Halten Sie in der aufrechten Position ca. 3 Sekunden inne und wiederholen Sie diese Übung ca. 5 - mal.
<strong> Hinweis</strong>: Diese Übung hilft nicht nur die Vollatmung zu verstärken, sondern mobilisiert zudem die Brustwirbelsäule. Sie finden die Übung daher auch in unserem Übungsprogramm.
<strong> Aufgabe: Führen Sie die kombinierte Atem - und Mobilisationsübung regelmäßig zwischendurch aus. Sie eignet sich sehr gut für das Büro, aber auch zu Hause für die Couch.</strong>
EOT
        );
        $manager->persist($item1728);


        $item1732 = new Weeklytask();
        $item1732->setFormat("richhtml");
        $item1732->setTag("Atmung");
        $item1732->setWeekId(13);
        $item1732->setCountPoint(1);
        $item1732->setName("Wochenaufgabe 13");
        $item1732->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Atmung </strong>. In dieser Kategorie lernen Sie, richtig zu atmen und mit der Atmung die Köperhaltung zu verbessern. Ganz nebenbei versorgen Sie Ihren Körper mit mehr Sauerstoff, aktivieren unterschiedliche Körperfunktionen und bauen Stress ab.
<em> Bereits letzte Woche haben wir Ihnen eine einfache Rückenübung gezeigt, mit der Sie die Bauchatmung trainieren können. Heute möchten wir Ihnen eine weitere Übung zeigen, </em><em style = "line - height: 19px"> die die Bauchatmung trainiert, Stress abbaut und </em><em> zusätzlich die Lendenwirbelsäule mobilisiert.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa13_pic1.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa13_pic1.png" alt = "wa13_pic1" width = "174" height = "297" class="alignleft wp-image-1866 size-full" /></a>
Bitte sitzen Sie aufrecht und nehmen Sie die <strong>Grundhaltung </strong> ein.
Umfassen Sie mit beiden Händen den jeweiligen Beckenkamm(Bild 1). Kippen Sie nun mit langsamen bewussten Bewegungen das <strong>Becken oben nach vorne </strong> und wieder zurück. Eine Video dazu finden Sie bei unseren Mobilisationsübungen für den unteren Rücken.
Nehmen Sie nun die Atmung hinzu, indem Sie das Becken oben nun nach vorne kippen(Bild 2), den Bauch locker lassen und <strong>in den Bauch hinein atmen </strong>. 3 Sekunden warten.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa13_pic2.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa13_pic2-300x96.png" alt = "wa13_pic2" width = "456" height = "146" class="alignleft wp-image-1867" /></a> Beim Ausatmen das Becken oben nach hinten kippen(Bild 3), die <strong>Bauchmuskeln leicht anspannen und ausatmen </strong>. 3 Sekunden warten.
<strong> Hinweis</strong>: Diese Übung hilft nicht nur, bewusst in den Bauch zu atmen, sondern mobilisiert zudem die Lendenwirbelsäule. Zudem wird durch die Bauchatmung weniger Energie verbraucht als durch die reine Brustatmung. Außerdem werden die Organe in der Bauchhöhle angeregt, Stress abgebaut und mehr Sauerstoff aufgenommen.
<strong> Aufgabe: Führen Sie die kombinierte Atem - und Mobilisationsübung regelmäßig zwischendurch aus. Sie eignet sich sehr gut für das Büro, aber auch für eine Durchführung im Auto.</strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1732);

        $item1740 = new Weeklytask();
        $item1740->setFormat("richhtml");
        $item1740->setTag("Atmung");
        $item1740->setWeekId(14);
        $item1740->setCountPoint(1);
        $item1740->setName("Wochenaufgabe 14");
        $item1740->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Atmung </strong>. In dieser Kategorie lernen Sie, richtig zu atmen und mit der Atmung die Köperhaltung zu verbessern. Ganz nebenbei versorgen Sie Ihren Körper mit mehr Sauerstoff, aktivieren unterschiedliche Körperfunktionen und bauen Stress ab.
<em> Bereits letzte Woche haben wir Ihnen eine einfache Rückenübung gezeigt, mit der Sie die Bauchatmung trainieren können. Heute möchten wir Ihnen eine weitere Übung zeigen, die die Brustwirbelsäule mobilisiert und eine tiefe Atmung fördert.</em>
Bitte sitzen Sie aufrecht und nehmen Sie die <strong>Grundhaltung </strong> ein.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/wa14.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa14.png" alt = "wa14" width = "278" height = "242" class="alignleft wp-image-1870 " /></a> Heben Sie die Arme an </strong>, so dass sie seitlich einen <strong>90° Winkel zum Oberkörper </strong> bilden. Die Unterarme bilden ebenfalls einen 90° Winkel zu den Unterarmen. Führen Sie die Arme nun leicht nach vorn und <strong>atmen Sie aus </strong>.
Führen Sie die Arme anschließend langsam soweit es geht nach hinten und atmen Sie dabei tief in den Bauch ein. Die Schulterblätter werden dabei bewusst nach hinten unten „gezogen“.
<strong> Warten Sie drei Sekunden </strong> und atmen Sie dann wieder aus, während Sie die Arme vorne langsam wieder zusammenführen. Spannen Sie die Bauchmuskeln beim Ausatmen leicht an.
Ein Video zur Übungen finden Sie in unserem <strong>Übungsprogramm </strong>.
<strong> Hinweis</strong>: Mit dieser Übung trainieren Sie nicht nur das Zwerchfell und die Bauchmuskeln als sogenannte Atemhilfsmuskulatur, sondern mobilisieren zudem die Brustwirbelsäule.
<strong> Wiederholung</strong>: Durch die Bauchatmung wird weniger Energie verbraucht als durch die reine Brustatmung. Außerdem werden die Organe in der Bauchhöhle angeregt, Stress abgebaut und mehr Sauerstoff aufgenommen.
<strong> Aufgabe: Führen Sie die kombinierte Atem - und Mobilisationsübung regelmäßig zwischendurch aus. Sie eignet sich sehr gut für zwischendurch, um dauerhafte Sitzhaltungen zu unterbrechen.</strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1740);

        $manager->flush();
    }

}
