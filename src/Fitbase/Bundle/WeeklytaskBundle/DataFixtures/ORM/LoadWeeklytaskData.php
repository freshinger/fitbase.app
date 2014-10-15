<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskData extends AbstractFixture implements OrderedFixtureInterface
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

        $item1644 = new Weeklytask();
        $item1644->setFormat("richhtml");
        $item1644->setWeekId(1);
        $item1644->setQuiz($this->getReference('weeklyquiz_1'));
        $item1644->setCountPoint(2);
        $item1644->setName("Wochenaufgabe 01");
        $item1644->setContent(<<<EOT
<h2> Informationen zur Bildschirmausrichtung </h2>
Sie befinden sich momentan im Bereich <strong>ergonomische Arbeitsplatzgestaltung,</strong> bei der es darum geht, die Arbeitsgeräte an die natürliche Haltung des Menschen anzupassen.  Diese Woche zeigen wir Ihnen, wie Ihr Bildschirm optimal eingestellt wird.
<strong> Der Bildschirm </strong> sollte so aufgestellt sein, dass die Haltung des Kopfes möglichst natürlich ist. Folgende Punkte sind dabei zu beachten:
<ul>
	<li> Die Entfernung zum Bildschirm sollte mind. 60cm betragen. Bei besonders großen Bildschirmen kann die optimale Entfernung bis zu 80cm betragen.</li>
</ul>
<p style = "padding - left: 90px"> 17 Zoll = Sehabstand: 60 cm
19 Zoll = Sehabstand: 70 cm
21 Zoll = Sehabstand: 80 cm </p>
<ul>
	<li> Die Bildschirm Neigung sollte so eingestellt sein, dass der Blick senkrecht auf die Bildschirm - Mitte trifft.</li>
	<li> Bei horizontalem Blick auf den Bildschirm muss die oberste Bildschirmzeile erkennbar sein.</li>
	<li> Das optimale Sichtfeld liegt 20° bis 50° unterhalb der horizontalen Linie. In diesem Blickfeld sollten sich die wichtigsten Informationen auf dem Bildschirm befinden.</li>
</ul>
Die folgende Grafik veranschaulicht die optimalen Einstellungen:
<a href = "http://online-rueckenschule.de/wp-content/uploads/PC1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/PC1-300x184.jpg" alt = "PC1" width = "300" height = "184" class="alignnone size-medium wp-image-1873" /></a>
<h2> Aufgabe diese Woche </h2>
<strong> Bitte überprüfen Sie die Ausrichtung Ihres Bildschirmes </strong><strong> anhand der oben genannten Punkte und nehmen sie gegebenenfalls Anpassungen vor.</strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr></tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1644);

        $item1662 = new Weeklytask();
        $item1662->setFormat("richhtml");
        $item1662->setWeekId(2);
        $item1662->setQuiz($this->getReference('weeklyquiz_2'));
        $item1662->setCountPoint(1);
        $item1662->setName("Wochenaufgabe 02");
        $item1662->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>ergonomische Arbeitsplatzgestaltung,</strong> bei der es darum geht, die Arbeitsgeräte an die natürliche Haltung des Menschen anzupassen.
<em>Letzte Woche haben Sie erfahren, wie Sie Ihren Bildschirm ergonomisch ausrichten. Diese Woche informieren wir Sie über die ergonomische Handhabung der Computermaus, um Beschwerden wie dem sogenannten Mausarm vorzubeugen.</em>
<h4>Auf <strong>drei Punkte</strong> möchten wir Sie aufmerksam machen:</h4>
<strong>Erstens, die Bewegung</strong>. Die Bewegung der Maus sollte überwiegend aus dem Ellenbogen erfolgen und weniger aus dem Handgelenk. Die Verwendung der Computer-Maus muss eine ergonomisch günstige Arbeitsposition ermöglichen, vor allem um Problemen im Handgelenk entgegenzuwirken. Beachten Sie, dass das Handgelenk während der Mausführung weder nach oben noch zur Seite abgeknickt wird, um die Entstehung von Beschwerden, z.B. eines Karpaltunnel-Syndroms zu verhindern.
<a href="http://online-rueckenschule.de/wp-content/uploads/mouse1.jpg"><img src="http://online-rueckenschule.de/wp-content/uploads/mouse1-300x172.jpg" alt="mouse" width="300" height="172" class="alignnone wp-image-1828 size-medium" /></a>
<em><strong> So sollte es nicht sein:</strong> In diesem Bild wird das Handgelenk sowohl nach oben, als auch zur Seite abgeknickt. Dadurch wird der Mittelhandnerv eingeengt, was auf Dauer zu einer Reizung führen kann.</em>
<strong> Zweitens, die Form </strong> der Maus : Eine speziell geformte oder flache Maus, aber auch eine Handgelenkauflage erleichtert die korrekte Bewegung.
<strong> Drittens, die Position: </strong> Die Maus sollte gerade vor der mausführenden Hand platziert werden, so dass der Unterarm im rechten Winkel zum Körper steht und nicht seitlich abgespreizt wird. Damit wird erreicht, dass der Arm, der die Maus führt, nicht übermäßig belastet wird.
Unser RSI - Präventions Programm kann Ihnen helfen, Beschwerden zu verhindern.
<a href = "http://online-rueckenschule.de/wp-content/uploads/mouse_merkbox1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/mouse_merkbox1.jpg" alt = "mouse_merkbox" width = "259" height = "256" class="alignnone  wp-image-1876" /></a>
<strong> Aufgabe: Bitte überprüfen Sie Ihre Computer - Maus – im Büro und zu Hause – hinsichtlich Bewegung, Form und Position und nehmen sie ggf. </strong><strong> Anpassungen vor.</strong>
<span> Bildquellen:
<a href = "http://www.freedigitalphotos.net/images/view_photog.php?photogid=2125"> photostock / FreeDigitalPhotos. net</a>
<a href = "http://www.freedigitalphotos.net/images/view_photog.php?photogid=1786"> photostock / FreeDigitalPhotos. net</a></span>
EOT
        );
        $manager->persist($item1662);

        $item1672 = new Weeklytask();
        $item1672->setFormat("richhtml");
        $item1672->setWeekId(3);
        $item1672->setQuiz($this->getReference('weeklyquiz_3'));
        $item1672->setCountPoint(1);
        $item1672->setName("Wochenaufgabe 03");
        $item1672->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>ergonomische Arbeitsplatzgestaltung,</strong> bei der es darum geht, die Arbeitsgeräte an die natürliche Haltung des Menschen anzupassen.
<em> Letzte Woche haben Sie erfahren, auf welche Dinge Sie bei der Nutzung der Computermaus achten sollten. Diese Woche informieren wir Sie über die ergonomische Handhabung der Tastatur, um Beschwerden durch zu starke Belastungen vorzubeugen. Wussten Sie, dass Vielschreiber auf ca. 80.000 Tastenanschläge pro Tag kommen ? Es ist also von großer Wichtigkeit, dass sich eine Tastatur der natürlichen Haltung des Menschen anpasst.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/keyboard_wrong.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/keyboard_wrong-300x154.jpg" alt = "keyboard_wrong" width = "300" height = "154" class="alignleft wp-image-1831 size-medium" /></a>
<a href = "http://online-rueckenschule.de/wp-content/uploads/keyboard_right.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/keyboard_right-300x166.jpg" alt = "keyboard_right" width = "275" height = "152" class="alignleft wp-image-1832" /></a>
<em> Im ersten Bild wird das Handgelenk nach oben abgeknickt. Dadurch wird der Mittelhandnerv eingeengt, was auf Dauer zu einer Reizung führen kann. Eine Handballenauflage – wie im zweiten Bild - kann helfen, den Höhenunterschied auszugleichen.</em>
<h4> Auf <strong> drei Punkte </strong> möchten wir Sie aufmerksam machen.</h4>
<strong> Erstens, die Bewegung:</strong> Bitte halten Sie die Handgelenke beim Tippen möglichst gerade, ohne nach oben oder zur Seite abzuknicken. Die Unterarme und Hände sollen möglichst eine Linie bilden. Das bedeutet, nicht aus dem Handgelenk sondern mehr aus dem Arm heraus zu tippen. Nutzen Sie kurze Pausen, um die Arme zu lockern.
<strong> Zweitens, die Form </strong> der Tastatur: Eine speziell geformte oder flache Tastatur, aber auch eine Handgelenkauflage kann eine ergonomisch optimale Bedienung erleichtern. Die Füße der Tastatur sollten flach eingestellt sein.
<strong> Drittens, die Position: </strong> Die Tastatur sollte direkt vor dem Körper und ca. 10 - 20cm von der Tischkante entfernt aufgestellt werden, sodass die Handballen aufliegen können und die Schulter - Nacken - Muskulatur keine Haltearbeit leisten muss. Es ist darauf zu achten, dass die Handgelenke nicht zu stark nach oben abgewinkelt werden, ggf. kann eine Handballenauflage helfen. Unterarme und Hände sollten stets eine waagerechte Linie bilden und Ober - und Unterarm sollten einen 90° - Winkel bilden, so dass die Last der Arme möglichst nah am Körper gehalten wird. Dies minimiert die Haltearbeit durch die Schulter - Nacken - Muskulatur und verhindert Verspannungen. In eingabefreien Zeiten müssen die Hände bequem aufgelegt werden können. Entspannungsübungen helfen, die Arme und Schultern in kurzen regelmäßigen Pausen zu lockern, z. B. mit unseren Übungen für den Schulter - Nacken - Bereich oder das RSI - Präventionsprogramm.   <a href = "http://online-rueckenschule.de/wp-content/uploads/officephysio_keyboard_merkbox1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/officephysio_keyboard_merkbox1.jpg" alt = "officephysio_keyboard_merkbox" width = "290" height = "274" class="alignnone size-full wp-image-1878" /></a>
<h5></h5>
<strong> Aufgabe: Bitte überprüfen Sie die Tastatur – im Büro und zu Hause – hinsichtlich Handhabung, Form und Position anhand der o. g. Punkte und nehmen sie ggf. </strong><strong> Anpassungen vor.</strong>
EOT
        );
        $manager->persist($item1672);

        $item1679 = new Weeklytask();
        $item1679->setFormat("richhtml");
        $item1679->setWeekId(4);
        $item1679->setQuiz($this->getReference('weeklyquiz_4'));
        $item1679->setCountPoint(2);
        $item1679->setName("Wochenaufgabe 04");
        $item1679->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>ergonomische Arbeitsplatzgestaltung,</strong> bei der es darum geht, die Arbeitsgeräte an die natürliche Haltung des Menschen anzupassen.
<em> Letzte Woche haben Sie erfahren, wie Sie die Tastatur optimal ausrichten. Diese Woche erfahren Sie, auf welche Punkte Sie beim Sitzen achten sollten. Haben Sie mal ausgerechnet, wie viele Stunden Sie täglich sitzen ? Sitzen ist aus unserem Arbeitsleben nicht mehr wegzudenken, daher ist es hilfreich, ein paar Regeln zu beachten.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/richtigsitzen_abbildung1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/richtigsitzen_abbildung1-163x300.jpg" alt = "richtigsitzen_abbildung" width = "163" height = "300" class="alignnone size-medium wp-image-1835" /></a>
<strong> Offener Sitzwinkel </strong>
Bitte achten Sie auf einen offenen Sitzwinkel, also einem <strong>Winkel von über 90° zwischen Oberkörper und Oberschenkel </strong>. Ein offener Sitzwinkel erleichtert die Aufrichtung im Sitzen und fördert dynamisches Sitzen(= Sitzen in Bewegung). Voraussetzung dafür ist allerdings, dass die Sitzfläche Ihres Stuhles sich nach vorne neigen lässt, also Ihren Sitzbewegungen nach vorne und hinten folgt oder so gut abgerundet ist, dass Sie keinen unangenehmen Druck an den Oberschenkelrückseiten verspüren. Wichtig: Sollten Sie zu einem starken Hohlkreuz neigen, empfiehlt sich in der Regel ein Sitzwinkel um 90°.
Die Füße müssen bequem aufgestellt werden können, ggf. ist eine Fußstütze hilfreich, um Höhenunterschiede auszugleichen. Besser ist es allerdings, den Tisch in der Höhe anzupassen(mehr dazu in der kommenden Wochenaufgabe). Passen Sie, wenn möglich, die Höhe der Rückenlehne, die Armlehnen und die Länge der Sitzfläche(Sitztiefe) an. Außerdem empfehlen wir unsere Übungen zur Mobilisation des unteren Rücken.
<a href = "http://online-rueckenschule.de/wp-content/uploads/richtigsitzen_merkbox1.jpg"></a><a href = "http://online-rueckenschule.de/wp-content/uploads/wa4_merkbox.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa4_merkbox-300x271.jpg" alt = "wa4_merkbox" width = "300" height = "271" class="alignleft size-medium wp-image-2284" /></a><a href = "http://online-rueckenschule.de/wp-content/uploads/richtigsitzen_merkbox1.jpg"></a>
<strong> Aufgabe: Bitte überprüfen Sie immer wieder Ihre Sitzposition – im Büro und zu Hause – und achten Sie auf einen offenen Sitzwinkel.</strong>
<table style = "border: solid 1px #ffffff;" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
&nbsp;
<div>
<div></div>
</div>
EOT
        );
        $manager->persist($item1679);

        $item1684 = new Weeklytask();
        $item1684->setFormat("richhtml");
        $item1684->setWeekId(5);
        $item1684->setQuiz($this->getReference('weeklyquiz_5'));
        $item1684->setCountPoint(1);
        $item1684->setName("Wochenaufgabe 05");
        $item1684->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>ergonomische Arbeitsplatzgestaltung,</strong> bei der es darum geht, die Arbeitsgeräte an die natürliche Haltung des Menschen anzupassen.
<em> Letzte Woche haben Sie erfahren, wie Sie eine ergonomische Sitzposition einnehmen. Diese Woche geht es um die ergonomische Ausrichtung des Bürotisches. Sie verbringen vermutlich viele Stunden täglich sitzend im Büro. Es ist also von großer Wichtigkeit, dass der Tisch mit Ihrer natürlichen Haltung harmoniert.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_sitting-wrong1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa5_sitting-wrong1-300x223.jpg" alt = "wa5_sitting wrong" width = "300" height = "223" class="alignnone size-medium wp-image-1839" /></a><a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_richtig-sitzen1.jpg"></a>  <a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_richtig-sitzen1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa5_richtig-sitzen1-300x204.jpg" alt = "wa5_richtig sitzen" width = "318" height = "223" class="alignnone  wp-image-1840" /></a><a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_sitting-correctly.jpg"></a><a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_richtig-sitzen1.jpg"></a><a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_sitting-correctly.jpg"></a>
<em><strong> So nicht:</strong> Bild 1 zeigt eine unergonomische Arbeitshaltung, während Bild 2 eine optimale Arbeitshaltung schematisch darstellt.</em>
Die richtige Tischhöhe hängt immer von der Körpergröße der Person ab. Wichtig: Stellen Sie zuerst Ihren Stuhl korrekt ein, um eine ergonomische Sitzhaltung einnehmen zu können(siehe Infos in der vorherigen Wochenaufgabe).
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa5_merkbox-tisch1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa5_merkbox-tisch1-300x272.jpg" alt = "wa5_merkbox tisch" width = "263" height = "238" class="alignright wp-image-1882 " /></a> Für eine sitzende Arbeitshaltung ist die Tischhöhe dann richtig eingestellt, wenn bei zuvor korrekt eingestellter Stuhlhöhe und geradem Rücken die Unterarme flach auf dem Arbeitstisch liegen können, ohne dass die Schultern hochgezogen werden müssen oder der Oberkörper gebeugt werden muss.
Gibt es keine Möglichkeit, die Tischhöhe zu verstellen, können stabile und sicher befestigte Unterlagen den Tisch auf die richtige Höhe bringen. Der Tisch ist dann in der optimalen Höhe, wenn ein rechter Winkel zwischen Ober - und Unterarm gebildet werden kann.
Steh - Sitz - Dynamik: Arbeitsplätze, die das Arbeiten im Sitzen und im Stehen ermöglichen, unterstützen einen gesundheitsförderlichen Haltungswechsel. Aber auch wenn Sie über keinen modernen Schreibtisch verfügen, bieten sich zahlreiche Möglichkeiten, um im Stehen zu arbeiten, z. B. Telefonieren, Ausdrucke lesen, Meetings abhalten.<strong></strong>
<strong> Aufgabe: Bitte überprüfen Sie die Höhe Ihres Schreibtisches – im Büro und zu Hause – in Zusammenhang mit einer ergonomischen Sitzhaltung. Stehen Sie diese Woche bewusst auf, wenn Sie Telefonieren oder eine Akte lesen.</strong>
<span style = "color: #000000"><strong>  </strong></span>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr></tr>
</tbody>
</table>
&nbsp;
<div>
<div>
</div>
</div>
EOT
        );
        $manager->persist($item1684);

        $item1694 = new Weeklytask();
        $item1694->setFormat("richhtml");
        $item1694->setWeekId(6);
        $item1694->setQuiz($this->getReference('weeklyquiz_6'));
        $item1694->setCountPoint(1);
        $item1694->setName("Wochenaufgabe 06");
        $item1694->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>ergonomische Arbeitsplatzgestaltung,</strong> bei der es darum geht, die Arbeitsgeräte an die natürliche Haltung des Menschen anzupassen.
<em> Letzte Woche haben Sie erfahren, wie Sie die Tischhöhe optimal einstellen. Diese Woche geht es um die ergonomische Einstellung des Autositzes. Auch wenn Sie nicht im Außendienst oder als Fernfahrer arbeiten, werden Sie vermutlich regelmäßig Autofahren und immer mal wieder auch lange Strecke fahren. Wie Sie den Rücken dabei schonen erfahren Sie heute.</em><strong></strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/car-seat.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/car-seat-300x237.jpg" alt = "car seat" width = "275" height = "217" class="alignleft wp-image-1843 " /></a> Drei Punkte sind zu beachten bei der Einstellung des Autositzes. Erstens, <strong> die Sitzfläche </strong>. Ein rückenfreundlicher Autositz sollte eine ausreichend lange Sitzfläche haben, um die Beine zu stützen. Dabei sollten die Knie bei durchgetretener Kupplung noch leicht gebeugt sein. Beachten Sie auch, dass die Sitzfläche, wie auch die Rückenlehne, nicht zu weich gepolstert sind.
Das bringt uns zu Punkt zwei: <strong> die Rückenlehne </strong>. Idealerweise reicht die Rückenlehne bis zu den Schultern und weist eine leichte, wirbelsäulenähnliche S - Form auf. Die Rückenlehne sollte nicht zu stark nach hinten geneigt sein, damit der Rücken nicht in eine runde Haltung und der Kopf nicht in eine ungünstige Stellung gezwungen werden. Häufig ist ein Neigungswinkel zwischen Rückenlehne und Sitzfläche von etwa 100 Grad ideal.
Das Gesäß sollte so dicht wie möglich an die Rückenlehne rücken, damit die Wirbelsäule in ihrer natürlichen Form unterstützt wird. Die natürliche Form kann durch ein professionelles Lordosekissen(lordose griechisch für „vorwärts gekrümmt“) oder auch einfach durch eine Handtuchrolle unterstützt werden. Übrigens, die Schultern liegen an der Rückenlehne an(auch bei Lenkbewegungen) und werden dadurch gestützt. Das Lenkrad sollte mit leicht angewinkelten Armen bedient werden.
Der dritte und letzte Punkt betrifft <strong>die Kopfstütze </strong>. Die Kopfstütze muss den ganzen Kopf stützen. Sie hat die richtige Höhe, wenn die Oberkanten von Kopfstütze und Kopf übereinstimmen. Der Kopf sollte jedoch nicht anliegen, sondern einen Abstand zur Kopfstütze von ca. 2 cm haben.<a href = "http://online-rueckenschule.de/wp-content/uploads/merkbox_autositz_officephysio.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/merkbox_autositz_officephysio-300x289.jpg" alt = "merkbox_autositz_officephysio" width = "277" height = "267" class="alignright wp-image-1884 " /></a>
Wenn Sie diese Tipps und Einstellungen beachten, wird die nächste Fahrt(fast) eine Erholung für Ihren Rücken sein. Wir wünschen eine gute Fahrt.
<strong> Aufgabe:</strong>
<strong> 1. Bitte drucken Sie sich diese Anleitung aus und nehmen Sie sie mit in Ihr Auto, um anhand der Tipps direkt Anpassungen vorzunehmen. </strong>
<strong> 2. Bitte schauen Sie sich die Übung "LWS kreisen" (Bereich: Unterer Rücken / Mobilisation) an und führen Sie diese Übung immer durch, wenn Sie an einer roten Ampel warten müssen.
</strong>
<table style = "border: solid 1px #ffffff" border = "0;">
<tbody>
<tr>
<td></td>
</tr>
</tbody>
</table>
EOT
        );
        $manager->persist($item1694);

        $item1703 = new Weeklytask();
        $item1703->setFormat("richhtml");
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


        $item1712 = new Weeklytask();
        $item1712->setFormat("richhtml");
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

        $item1894 = new Weeklytask();
        $item1894->setFormat("richhtml");
        $item1894->setWeekId(15);
        $item1894->setQuiz($this->getReference('weeklyquiz_15'));
        $item1894->setCountPoint(1);
        $item1894->setName("Wochenaufgabe 15");
        $item1894->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Gewohnheiten </strong>. Hier lernen Sie – basierend auf Studien aus der Hirnforschung – wie Gewohnheiten entstehen und welche Einflussmöglichkeiten Sie haben.
<em> In den letzten Wochen haben wir Ihnen Informationen zu Ergonomie, Körperhaltung und Atmung vermittelt. Hoffentlich haben Sie die kleine Aufgabe am Ende jeder Informationseinheit durchgeführt. Vermutlich jedoch nicht alle. Woran liegt es eigentlich, dass wir zwar erfahren(oder bereits wissen), was gut für uns ist und es dennoch nicht regelmäßig machen ? Es ist der innere Schweinehund - und diesem wollen wir uns in den nächsten Wochen einmal nähern.   </em>
<strong> Die Macht der Gewohnheit.</strong>
Wir alle haben bestimmte Routinen und führen Dinge ganz unbewusst nach einem bestimmten Schema durch, wie z. B. die Art und Weise einzuparken, die Reihenfolge beim Zähneputzen oder beim Einkaufen. Sie sind zur Gewohnheit geworden und laufen automatisiert ab. Unser Gehirn liebt Gewohnheiten, weil es weniger Aufwand betreiben muss als für neue Abläufe auf die wir uns konzentrieren müssen. Daher ist es auch so schwierig, alte Gewohnheiten abzustellen und durch neue zu ersetzen. Es ist aber jederzeit möglich.
<a href = "http://online-rueckenschule.de/wp-content/uploads/top.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/top-300x198.jpg" alt = "top" width = "244" height = "161" class="alignnone  wp-image-1903" /></a>
Forscher gehen davon aus, dass es - je nach Umfang der Aktivität - zwischen 30 und 66 Tage dauert, bis eine wiederholte Tätigkeit zur Gewohnheit geworden ist. So lange braucht das Gehirn, um eine neue Verhaltensweise zu automatisieren, indem die neuronalen Verknüpfungen in unserem Gehirn so gefestigt sind, dass wir nicht mehr „nachdenken“ müssen und die Informationen wie auf einer Autobahn schnell fließen können.
<strong> Aufgabe: Beziehen wir diese Tatsache aus der Gehirnforschung einmal auf die Durchführung einer täglichen 5 - Minuten - Physio - Pause mit der Online - Rückenschule:</strong>
<ul>
	<li><strong> Nehmen Sie sich vor, jeden Nachmittag eine Physio - Pause durchzuführen, z. B. immer wenn Sie sich Ihren Nachmittags - Kaffee geholt haben </strong></li>
	<li><strong> Stellen Sie die Erinnerungsmail so ein, dass es zeitlich in etwa passt, die Mail kann ja auch ein paar Minuten im Posteingang liegen </strong></li>
	<li><strong> Trinken Sie zwischen den Übungen einen Schluck und genießen Sie das gute Gefühl, das sich einstellt, wenn Sie aktiv gewesen sind </strong></li>
	<li><strong> Nach ca. 6 Wochen ist es zur Gewohnheit geworden und der innere Schweinehund muss nicht mehr aktiv besiegt werden </strong></li>
</ul>
Sie können nahezu alles zur Gewohnheit werden lassen, indem sie etwas regelmäßig durchführen und idealerweise an bestimmte andere Vorgänge knüpfen. Welche weiteren Punkte dabei helfen können, den inneren Schweinehund zu besiegen, erfahren Sie in der nächsten Woche.
<em> Weiterführend dazu: Phillippa Lally, et al., European Journal of Social Psychology, Volume 40, Issue 6, pages 998–1009, October 2010, London.</em>
Fotonachweis: www. freedigitalphotos. com / imagerymajestic
EOT
        );
        $manager->persist($item1894);


        $item1897 = new Weeklytask();
        $item1897->setFormat("richhtml");
        $item1897->setWeekId(16);
        $item1897->setQuiz($this->getReference('weeklyquiz_16'));
        $item1897->setCountPoint(1);
        $item1897->setName("Wochenaufgabe 16");
        $item1897->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Gewohnheiten </strong>. Hier lernen Sie – basierend auf Studien aus der Hirnforschung – wie Gewohnheiten entstehen und welche Einflussmöglichkeiten Sie haben.
<em> In der letzten Woche haben Sie erfahren, dass eine Gewohnheit durch eine Vielzahl von Wiederholungen entsteht und dass man dies erlernen kann. Der innere Schweinehund muss dann nicht mehr aktiv besiegt werden, denn das Gehirn hat alle neuronalen Verbindungen soweit verfestigt, dass diese Aktivitäten wie von selbst ablaufen. Heute erläutern wir Ihnen Methoden wie Sie neue Gewohnheiten erlernen können.</em>
<strong> Methoden zum Ändern von Gewohnheiten </strong>
    Nachfolgend zeigen wir Ihnen Schritte auf, mit denen man eine neue Gewohnheit(hier: Physio - Pause am Arbeitsplatz) installieren kann.
<strong> 1.      </strong><strong> Selbstverpflichtung</strong>
    Wenn Sie sich dazu entschieden haben, täglich eine Physio - Pause zu installieren, dann machen Sie diesen Vorsatz so öffentlich wie möglich: Sprechen Sie mit Ihren Freunden und Kollegen darüber. So machen Sie sich „öffentlich“ Druck, Ihr Vorhaben auch umzusetzen. Das Gute daran ist, dass
a) 80 % aller Menschen am eigenen Leibe erfahren haben, was Rückenschmerzen sind und Ihr Vorhaben begrüßen werden
b) Ihre Kollegen vermutlich auch einen Zugang zur Online - Rückenschule haben und ebenfalls eine neue Gewohnheit installieren wollen. Tun Sie sich also zusammen.
<strong> 2.      </strong> <strong> Training</strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/priority1.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/priority1.png" alt = "priority" width = "229" height = "193" class="alignright wp-image-1899" /></a>
    Eine Gewohnheit zu ändern ist eine Fertigkeit, die man erlernen kann und wie jede Fertigkeit braucht sie Übung. Nehmen Sie sich die kommenden 6 Wochen vor und investieren Sie jeden Arbeitstag 5 Minuten in eine Physio - Pause. Das sind insgesamt gerade 2,5 Stunden zur Erlernung eines gesunden Verhaltens. Wenn Sie einen Tag ausfallen lassen, ärgern Sie sich nicht lange darüber und machen Sie am nächsten Tag weiter. Die neuronale Verknüpfung findet trotzdem statt.
<strong> 3.      </strong><strong> Protokollieren</strong>
    Es hilft ungemein, wenn Sie die Fortschritte täglich notieren. Es stärkt die Eigenmotivation und die Zuversicht. Nehmen Sie z. B. eine Art Tagebuch und schreiben Sie die Rückenübungen auf, die sie absolviert haben. Notieren Sie auch, wie es Ihnen dabei ging. So können Sie schnell Vergleiche ziehen und Ihren Fortschritt verfolgen. Diese kleine Statistik kann auch einfach durch Ernährung oder andere Aspekte ergänzt werden.
    In der kommenden Woche folgen weitere 4 Schritte. Bis dahin haben Sie Zeit, die ersten drei Schritte anzugehen. Viel Erfolg!
    Fotonachweis: www. freedigitalphotos. com /   <em>Naypong </em><em> Weiterführend dazu:
Getting Things Done. The Art of Stress - Free Productivity von David Allen.
    Phillippa Lally, et al., European Journal of Social Psychology, Volume 40, Issue 6, pages 998–1009, October 2010, London.</em>
EOT
        );
        $manager->persist($item1897);

        $item1906 = new Weeklytask();
        $item1906->setFormat("richhtml");
        $item1906->setWeekId(17);
        $item1906->setQuiz($this->getReference('weeklyquiz_17'));
        $item1906->setCountPoint(1);
        $item1906->setName("Wochenaufgabe 17");
        $item1906->setContent(<<<EOT
Sie befinden sich momentan im Bereich <strong>Gewohnheiten </strong>. Hier lernen Sie – basierend auf Studien aus der Hirnforschung – wie Gewohnheiten entstehen und welche Einflussmöglichkeiten Sie haben.
<em> In der letzten Woche haben wir Ihnen die ersten 3 Schritte zur Installation einer Gewohnheit erläutert. Heute folgen weitere 4 Schritte: Unterstützung, Belohnung, Fokus und positives Denken.</em>
<strong> Methoden zum Ändern von Gewohnheiten </strong>
Nachfolgend möchten wir Ihnen 4 weitere Schritte aufzeigen, mit denen man eine neue Gewohnheit(hier: Physio - Pause am Arbeitsplatz) installieren kann.<strong></strong>
<strong> 1.      </strong><strong> Unterstützung</strong>
Suchen Sie sich Partner mit denselben Zielen. Wie in der letzten Einheit bereits beschrieben, werden Ihre direkten Arbeitskollegen vermutlich das gleiche Ziel verfolgen. Wenn nicht, können Sie sie dazu animieren. Richten Sie z. B. eine gemeinsame Physio - Pausen - Routine ein und machen Sie die Übungen gemeinsam. Oder richten Sie einen Wettbewerb innerhalb der Abteilung ein: „Wer macht die meisten Übungen pro Monat ?“<strong></strong>
<strong> 2.      </strong><strong> Belohnung</strong>
Sehen Sie jede durchgeführte Übung als Belohnung für Ihren Körper an oder gönnen Sie sich eine Süßigkeit auf die Sie sich den ganzen Tag schon freuen.<strong></strong>
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/mind.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/mind-286x300.png" alt = "mind" width = "175" height = "183" class="alignnone  wp-image-1908" /></a></strong>
<strong> 3.      </strong><strong> Fokus</strong>
Es ist sehr wichtig, dass Sie sich während der 6 Wochen auf eine Gewohnheitsänderung, nämlich die tägliche Physio - Pause am Arbeitsplatz, konzentrieren. Wenn Sie damit erfolgreich waren, können Sie jede andere Gewohnheit angehen. Nutzen Sie die Erinnerungsemail, um sich zu fokussieren.<strong></strong>
<strong> 4.      </strong><strong> Positives Denken </strong>
Ein sehr wichtiges Element zum Schluss: Glauben Sie an sich, dass Sie es schaffen werden. Dann wird es auch klappen. Sie stehen nicht vor einer unlösbaren Aufgabe, sondern müssen lediglich Ihren inneren Schweinehund besiegen und dem Gehirn ermöglichen, eine neuronale Autobahn zu bilden. Danach läuft es(fast) von selbst.
<strong> Aufgabe: Fangen Sie heute an und richten Sie wenn möglich auch einen Abteilungsinternen Wettkampf mit den Kollegen ein!
</strong>
Fotonachweis: www. freedigitalphotos. net <em></em>
EOT
        );
        $manager->persist($item1906);


        $item1911 = new Weeklytask();
        $item1911->setFormat("richhtml");
        $item1911->setWeekId(18);
        $item1911->setQuiz($this->getReference('weeklyquiz_18'));
        $item1911->setCountPoint(1);
        $item1911->setName("Wochenaufgabe 18");
        $item1911->setContent(<<<EOT
<em>Bereits in den letzten Wochen haben wir Ihnen im Rahmen der Installation einer neuen Gewohnheit etwas von neuronalen Verbindungen erzählt. Auch bei Brain - Gym®, einem in den 80er Jahren entwickelten Konzept zur Konzentrations - und Leistungssteigerung, geht es um neuronale Verbindungen und zwar zwischen der linken und der rechten Gehirnhälfte. Wird die Verbindung der beiden Gehirnhälften gestärkt, kann das Gehirn mehr leisten: Sie können sich besser konzentrieren und kommen schneller zu guten Ergebnissen. Es geht also nicht um Esoterik, sondern um biologisch - chemische Prozessen, die in unserem Gehirn ablaufen.</em>
<strong> Die beiden Gehirnhälften </strong>
Ein Großteil der Menschen in den Industrieländern nutzt beim Lernen nur die linke Gehirnhälfte. Sie ist für das rational - analytische Denken zuständig, während die rechte Gehirnhälfte für intuitiv - kreatives Denken zuständig ist. Nutzt man also nur die linke Gehirnhälfte, dauert es sehr viel länger, etwas zu lernen bzw. sich zu konzentrieren. Gelingt es uns jedoch, die beiden Gehirnhälften zu verknüpfen können wir uns besser konzentrieren und effektiver arbeiten.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/gehirnhaelften.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/gehirnhaelften.png" alt = "gehirnhaelften" width = "792" height = "354" class="alignright wp-image-1914 size-full" /></a><a href = "http://online-rueckenschule.de/wp-content/uploads/gehirnhaelften.png"></a> Beispiel für vernetzte Gehirnhälften </strong>
Versuchen Sie bitte, sich folgende Geschichte(von Bianca Pruckner) zu merken:
<em> Zweibein sitzt auf Dreibein und hat Einbein. Da kommt Vierbein, schnappt nach Zweibein und stiehlt Einbein. Da schlägt Zweibein mit Dreibein nach Vierbein und holt sich Einbein zurück.</em>
Mit dieser scheinbar sinnlosen Aneinanderreihung von abstrakten Ausdrücken wird ausschließlich die linke Gehirnhälfte angesprochen. Kaum hat man den Text gelesen, hat man ihn auch schon wieder vergessen. Nun verknüpfen wir das Ganze mit Bildern und sprechen so auch unsere rechte Gehirnhälfte an:
<em>
Ein Mann(Zweibein) sitzt auf einem Hocker(Dreibein) und hat ein Hühnerbein(Einbein). Da kommt ein Hund(Vierbein), schnappt nach dem Mann(Zweibein) und stiehlt das Hühnerbein(Einbein). Da schlägt der Mann(Zweibein) mit dem Hocker(Dreibein) nach dem Hund(Vierbein) und holt sich das Hühnerbein(Einbein) zurück. </em>
Sehen Sie, wie viel einfacher Sie sich die Geschichte merken können indem Sie nun beide Gehirnhälften nutzen ? Es gibt einfache Übungen mit denen Sie die Verknüpfung der Gehirnhälften verbessern können, so dass Sie beide Seiten ansprechen und dadurch schneller zu guten Ergebnisse kommen. Mehr dazu in den kommenden Wochen.
<em> Quelle: Bianca Pruckner, "Die Bedeutung der beiden Gehirnhälften“, domendos consulting GmbH, 12/2007</em>
EOT
        );
        $manager->persist($item1911);


        $item1920 = new Weeklytask();
        $item1920->setFormat("richhtml");
        $item1920->setWeekId(19);
        $item1920->setQuiz($this->getReference('weeklyquiz_19'));
        $item1920->setCountPoint(1);
        $item1920->setName("Wochenaufgabe 19");
        $item1920->setContent(<<<EOT
<em>In der vergangenen Woche haben wir Ihnen bewusst gemacht, dass Sie zwei Gehirnhälften haben, die für unterschiedliche Bereiche zuständig sind. Vermutlich können Sie sich noch gut an die Geschichte mit dem Mann, dem Hund und dem Hühnerbein erinnern. Diese Geschichte bleibt gut im Gedächtnis, weil mit den erzeugten Bildern beide Gehirnhälften angesprochen wurden.</em>
Die Beteiligung der Gehirnhälften im Denkprozess ist von Mensch zu Mensch unterschiedlich und nur selten ausgewogen. Wir wollen Ihnen heute einen Test zeigen, mit dem Sie Ihren eigenen Schwerpunkt feststellen können: <a href="http://www.trauner.at/sbx/beispiele/beispiel113.htm" title="Test - Gehirnhälften" target="_blank">Link zum Test</a>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa19.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa19-300x200.png" alt = "wa19" width = "263" height = "175" class="alignleft wp-image-1922" /></a>
    Ist das Ergebnis ausgeglichen oder überwiegt eine Seite ? Es ist gar kein Problem, wenn eine Seite dominiert, das ist bei den meisten Menschen der Fall. Es zeigt nur, dass Sie über Optimierungspotential verfügen und durch die Aktivierung der weniger angesprochenen Seite bei der Lösung von Aufgaben zu noch besseren Ergebnissen kommen und sich besser konzentrieren können.
    In den kommenden Wochen lernen Sie kleine Übungen kennen, mit denen Sie die Intensität der Verbindungen zwischen linker und rechter Gehirnhälfte verbessern können. Das kann z. B. durch Überkreuzbewegungen aktiv beeinflusst werden, sodass beide Seiten aktiviert werden. Dieses Ziel haben die sogenannten Brain - Gym® - Übungen.
    Das Brain - Gym® Konzept geht zurück auf Dr. Paul Dennison, der es in den 70er Jahren entwickelte. Die Kernthese dieses seit vielen Jahren von unterschiedlichen Professionen angewandten Konzeptes ist, dass Bewegung und Lernen(hier im Sinne von Konzentration und geistiger Arbeit zu sehen) eng miteinander verknüpft sind. Lernen geht nicht ohne Bewegung und mit gezielter Bewegung können wir gut Lernen. Übungen hierzu folgen in den kommenden Wochen.
<strong> Aufgabe: Führen Sie den obigen Test „Welcher Gehirntyp bin ich ?“ durch </strong>
<em>  Fotonachweis: <a href = "http://www.freedigitalphotos.com"> www. freedigitalphotos. com</a> / photo stock </em>
EOT
        );
        $manager->persist($item1920);


        $item1925 = new Weeklytask();
        $item1925->setFormat("richhtml");
        $item1925->setWeekId(20);
        $item1925->setQuiz($this->getReference('weeklyquiz_20'));
        $item1925->setCountPoint(1);
        $item1925->setName("Wochenaufgabe 20");
        $item1925->setContent(<<<EOT
<em>In der letzten Woche haben Sie mithilfe von Tests herausgefunden, welche Gehirnhälfte bei Ihnen überwiegend angesprochen wird. Wie bereits angekündigt, wollen wir uns heute mit dem Brain - Gym® - Konzept beschäftigen und einige Übungen kennenlernen, die die Verknüpfung beider Seiten unterstützen. Zuvor müssen wir zwei wichtige Begriffe klären, die Körpermittellinie und Überkreuzbewegungen.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa20_1_mittellinie.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa20_1_mittellinie.png" alt = "wa20_1_mittellinie" width = "99" height = "250" class="alignleft wp-image-1927 size-full" /></a>
<strong> Die Körpermittellinie </strong>
Die Körpermittellinie ist eine gedachte Linie. Sie verläuft durch die Mitte unseres Körpers, vom Kopf durch den Rumpf und das Becken und endet zwischen den Fußsohlen.
<strong> Überkreuzbewegungen</strong>
Überkreuzbewegungen sind Bewegungen der Hände, Arme, Beine und Füße, bei denen die eigene Körpermitte zur gegenüberliegenden Seite hin überquert wird. So sind z. B. Gehen und Laufen(rechter Arm schwingt vor, während das linke Bein vorgesetzt wird) alltägliche Bewegungen, bei denen die Gehirnhälften durch ständige Überkreuzbewegungen besser verknüpft werden.
Während der Alltag der Menschen in der Steinzeit von Laufen geprägt war(ca. 40 Kilometer pro Tag), so ist das Laufen in unserem Alltag durch Sitzen(ca. 10 Stunden täglich bei Büromenschen) ersetzt worden. Beim Sitzen und Arbeiten an einem PC finden so gut wie keine Überkreuzbewegungen statt und es wird überwiegend die linke Gehirnhälfte beansprucht(Logik, Analytik, Fakten). Wir müssen die Verknüpfung der Gehirnhälften also aktiv angehen, um beide Seiten gleich stark nutzen zu können. Dies kann einerseits durch Sport geschehen oder aber durch kurze gezielte Einheiten zwischendurch.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa20_2_guy-at-laptop.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa20_2_guy-at-laptop-300x196.png" alt = "wa20_2_guy at laptop" width = "300" height = "196" class="alignnone size-medium wp-image-1931" /></a>
<strong> Auf der Stelle Gehen </strong>
Die Laufbewegung können Sie bewusst und übertrieben nachahmen in dem Sie auf der Stelle gehen und mit jeder Hand das gegenüberliegende Knie berühren(mit der rechten Hand das linke Knie und mit der linken Hand das rechte Knie). Sie überqueren dabei jedes Mal die Körpermittellinie. Alternativ können Sie diese Übung auch im Sitzen durchführen und die Hände jeweils für einige Sekunden auf dem gegenüberliegenden Knie ruhen lassen. Das geht gut zwischendurch ohne, dass es jemand mitbekommt.
<strong> Die liegende Acht </strong>
Eine andere Übung ist die liegende Acht: Legen Sie ein DIN A4 Papier mittig vor sich auf den Tisch und zeichnen Sie eine große liegende Acht. Achten Sie hier auf die richtige Bewegungsrichtung, siehe Pfeile. Zeichnen Sie so oft sie mögen auf der gleichen Stelle. Auch diese Übung dient der Verknüpfung der Gehirnhälften und führt zu einem sofortigen Konzentrationsschub. Sie kann jederzeit und überall durchgeführt werden, z. B. indem Sie mit dem Finger malen und auf Stift und Papier verzichten.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa20_3_die-acht.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa20_3_die-acht-300x144.png" alt = "wa20_3_die acht" width = "300" height = "144" class="alignleft wp-image-1933 size-medium" /></a>
Gerade in wichtigen Situationen, wie einem Vorstellungsgespräch oder einer Präsentation lohnt es sich, vorher beide Hirnhälften in Balance zu bringen, um eine optimale Konzentration zu erreichen. Je öfter Sie es trainieren umso schneller kommen beide Hälften ins Gleichgewicht.
<em> Vertiefend dazu:</em>
<em> Olsen, Eric „Fit Kids, Smart Kids – New Research Confirms that Excercise Boosts Brainpower“ in Parents Magazine, 1994, S. 33 </em>
<em> Brink, Susan “Smart Moves. New Research Suggests that Folks from 8 to 80 Can Shape Up Their Brains with Aerobic Exercise” in U. S. News & amp; World Report, 1995, S. 78 - 82 </em>
<em> Fotonachweis: <a href = "http://www.freephotostock.com"> www. freedigitalphotos. com</a> / photostock </em>
EOT
        );
        $manager->persist($item1925);


        $item1936 = new Weeklytask();
        $item1936->setFormat("richhtml");
        $item1936->setWeekId(21);
        $item1936->setQuiz($this->getReference('weeklyquiz_21'));
        $item1936->setCountPoint(1);
        $item1936->setName("Wochenaufgabe 21");
        $item1936->setContent(<<<EOT
<em>In der vergangenen Einheit haben Sie zwei Übungen kennengelernt, die die Verknüpfung der beiden Gehirnhälften und damit Ihre Leistungsfähigkeit verbessern. Heute zeigen wir Ihnen eine weitere Übung aus dem Brain - Gym® Konzept mit dem Namen Denkmütze.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa21_denkmuetze.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa21_denkmuetze-300x221.png" alt = "wa21_denkmuetze" width = "225" height = "166" class="alignleft wp-image-1938" /></a>
<strong> Denkmütze </strong>
Durch Stress, Lärm und andauernde Geräusche sind unsere Ohren starken Belastungen ausgesetzt. Der Körper schützt sich vor dieser Reizüberflutung indem die Ohren „abgeschaltet“ werden und das Gehörte nicht in unser Bewusstsein eindringt.
Durch eine Massage der Ohren werden über 400 Energiepunkte, die mit den wichtigsten Körperfunktionen in Verbindung stehen, aktiviert. Dadurch können wir die Ohren quasi wieder „anschalten“ und aktives Zuhören wird möglich. Wir können uns besser konzentrieren und gehörte Informationen besser verarbeiten und speichern.
Mit der "Denkmütze" schalten wir unsere Ohren wieder an. Die Denkmütze stimuliert über 400 Energiepunkte am Außenohr, die mit wichtigen Gehirn - und Körperfunktionen in enger Verbindung stehen. Die sanfte Massage dieser Punkte macht frisch und entspannt, sie können wieder konzentriert hinhören und dadurch Informationen besser verarbeiten und speichern. Probieren Sie es jetzt aus und wenden Sie es im nächsten Meeting an. Sie werden den anderen Zuhörern etwas voraushaben.
<strong> Aufgabe: Aktivieren Sie Ihre Ohren mit der Denkmütze </strong>
<ul>
	<li> Sie können diese Übung im Sitzen oder Stehen durchführen </li>
	<li> Nehmen Sie eine aufrechte Haltung ein und halten Sie den Kopf aufrecht </li>
	<li> Beginnen Sie mit Daumen und Zeigefinger die Ohren leicht von innen nach außen zu massieren </li>
	<li> Massieren Sie drei Mal das gesamte Ohr von oben nach unten </li>
</ul>
Fotonachweis: <a href = "http://www.freedigitalphotos.com"> www. freedigitalphotos. com</a> / Jeroen van Oostrom
EOT
        );
        $manager->persist($item1936);

        $item1940 = new Weeklytask();
        $item1940->setFormat("richhtml");
        $item1940->setWeekId(22);
        $item1940->setCountPoint(1);
        $item1940->setName("Wochenaufgabe 22");
        $item1940->setContent(<<<EOT
Haben Sie die Denkmütze aus der letzten Einheit im letzten Meeting ausprobiert oder gab es noch kein Meeting ? Heute greifen wir noch einmal die Aktivierung beider Gehirnhälften auf und verknüpfen dies mit einer Mobilisationsübung für den Nacken:
<a href = "http://online-rueckenschule.de/wp-content/uploads/WA-22.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/WA-22-300x300.png" alt = "WA 22" width = "214" height = "214" class="alignnone  wp-image-2118" /></a>
<strong> Durchführung</strong>
<ul>
	<li> Bitte nehmen Sie für diese Übung zunächst die Grundhaltung ein </li>
	<li> Lassen Sie die Arme locker hängen und legen Sie die Hände auf die Oberschenkel </li>
	<li> Führen Sie mit dem Kopf eine Halbkreis - Bewegung durch </li>
	<li> Das Kinn soll dabei möglichst dicht an der Brust geführt werden </li>
</ul>
EOT
        );
        $manager->persist($item1940);


        $item1944 = new Weeklytask();
        $item1944->setFormat("richhtml");
        $item1944->setWeekId(23);
        $item1944->setCountPoint(1);
        $item1944->setName("Wochenaufgabe 23");
        $item1944->setContent(<<<EOT
Zum Abschluss des Bereiches <em>Konzentration </em> zeigen wir Ihnen heute drei weitere kleine Übungen, die zu einem besseren Zusammenspiel der Gehirnhälften führen.
<strong> Simultanzeichnen</strong>
Bitte nehmen Sie ein Blatt Papier und in jede Hand einen Stift. Zeichnen Sie dann simultan spiegelbildliche Formen. Beginnen Sie mit einfachen Formen wie Dreiecken und Quadraten. Wenn das gut klappt, können Sie den Schwierigkeitsgrad beliebig erhöhen.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa23.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa23.jpg" alt = "wa23" width = "181" height = "222" class="alignleft wp-image-1946" /></a>
<strong> An ein X denken </strong>
Dies ist die auf den ersten Blick einfachste Übung zur Gehirnintegration. Sie werden aber schnell merken, dass es etwas Übung bedarf und Sie sich dafür konzentrieren müssen.
Schließen Sie bitte die Augen und stellen Sie sich für die Dauer von 3 Bauch - Atemzügen ein <strong>X </strong> vor. Schon die Vorstellung von sich kreuzenden Linien, unterstützt die Verknüpfung der Gehirnhälften. Diese Übung lässt sich nahezu überall durchführen und ist für Fortgeschrittene auch mit geöffneten Augen möglich.
<strong> Hook - Ups</strong>
Diese Übung lässt sich sehr gut am Schreibtisch durchführen. Strecken Sie dafür die Beine aus und legen Sie den rechten Fußknöchel über den linken. Strecken Sie dann die Arme aus und legen Sie das rechte Handgelenk über das linke. Verschränken Sie Ihre Finger indem Sie sie wie beim Beten falten und drehen Sie die Hände nach innen und nach oben, so dass sie vor Ihnen auf der Brust liegen. Die Ellenbogen bleiben unten. Atmen Sie drei Atemzüge tief in den Bauch ein.
Diese komplexe Überkreuzhaltung erzielt im Gehirn eine ähnliche Wirkung wie die Überkreuzbewegungen, nämlich ein verbessertes Zusammenspiel der beiden Gehirnhälften, was zu einer höheren Konzentrations - und Leistungsfähigkeit führt.
EOT
        );
        $manager->persist($item1944);


        $item1952 = new Weeklytask();
        $item1952->setFormat("richhtml");
        $item1952->setWeekId(24);
        $item1952->setQuiz($this->getReference('weeklyquiz_24'));
        $item1952->setCountPoint(1);
        $item1952->setName("Wochenaufgabe 24");
        $item1952->setContent(<<<EOT
<em>Liebe Online - Rückenschule Nutzerinnen und Nutzer,</em>
<em> wir möchten die vergangenen Informationseinheiten einmal zusammenfassen und Ihnen noch einmal in Erinnerung rufen, welche Inhalte Sie bereits gelernt haben, bevor wir dann in die nächste Kategorie Rückenschmerzen einsteigen.</em>
<strong> Kurzer Rückblick </strong>
<strong> 1. Ergonomie </strong> – Anordnung und Einstellung von Hardware und Mobiliar an Ihrem Arbeitsplatz als Voraussetzung für eine gesunde Arbeitshaltung.
<strong> 2. Körperhaltung </strong> – Darstellung einer optimalen Haltung im Stehen und im Sitzen.
<strong> 3. Atmung </strong> – Vorteile und Übungen für eine tiefe Bauchatmung, u. a. als Stresskiller
    <strong>4. Gewohnheiten </strong> – Installieren von Gewohnheiten: Automatismen durch Schaffung neuronaler Verknüpfungen
    <strong>5. Konzentration </strong> – Steigerung von Konzentration und Leistung durch Bewegung und Verknüpfung beider Gehirnhälften
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa24.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa24-198x300.png" alt = "wa24" width = "198" height = "300" class="alignleft wp-image-1954 size-medium" /></a>
<strong> Rückenschmerzen</strong>
Als nächstes widmen wir uns dem Bereich Rückenschmerzen – Entstehung und Prävention. Bevor wir in der kommenden Woche damit starten, möchten wir Sie bitten, den folgenden Test von der Bertelsmann Stiftung und der Universität Lübeck durchzuführen. Die Angabe persönlicher Daten ist nicht erforderlich und Sie können ein anonymes Risikoprofil erstellen.
Über folgenden Link verlassen Sie unsere Seite und können das Rückenscreening online durchführen: <a href = "http://www.rueckentest.de/" target = "_blank"> Rückentest. de</a>
<strong> Ganz wichtig vorab:</strong> Der allergrößte Teil der Rückenbeschwerden wird nicht durch gefährliche Krankheiten oder Schäden an der Wirbelsäule verursacht, sondern geht auf ein Zusammenspiel von Risikofaktoren aus dem täglichen Leben und der Arbeitswelt und ein wenig auch auf die eigene Einstellung zu Schmerzen und Beeinträchtigungen zurück. Ihr Arzt oder Ihre Ärztin kann gefährliche Ursachen in der Regel mit ein paar Fragen ausschließen. So lange Beschwerden noch relativ "frisch" sind, d. h. nicht länger als 4 - 6 Wochen andauern, stehen die Chancen ziemlich gut, dass nach wenigen Wochen wieder alles in Ordnung ist. Vorausgesetzt Sie versuchen, so gut es geht, die Alltagstätigkeiten weiterzuführen. Das Einzige, was sich in diesem Stadium wirklich als ungünstig erwiesen hat, ist Schonung und(Bett -)Ruhe.
<em>
Fotonachweis: <a href = "http://www.freedigitalphotos.com/"> www. freedigitalphotos. com</a> /graur razvan ionut </em>
EOT
        );
        $manager->persist($item1952);


        $item1958 = new Weeklytask();
        $item1958->setFormat("richhtml");
        $item1958->setWeekId(25);
        $item1958->setQuiz($this->getReference('weeklyquiz_25'));
        $item1958->setCountPoint(1);
        $item1958->setName("Wochenaufgabe 25");
        $item1958->setContent(<<<EOT
<em>In den kommenden Wochen erläutern wir Ihnen unterschiedliche Entstehungsmöglichkeiten von Rückenbeschwerden und wie man sich schützen kann. Zuvor beginnen wir jedoch mit unterschiedlichen Schmerztypen und ihrer Funktion.</em>
<h1> Warum gibt es Schmerzen ?</h1>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa24.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa24-198x300.png" alt = "wa24" width = "198" height = "300" class="alignleft wp-image-1954 size-medium" /></a>
Schmerz ist eine Warnung des Körpers, damit wir unser Verhalten(z. B. eine akute Bewegung oder eine dauerhafte Fehlhaltung) ändern. Schmerzen sind damit eine Schutzfunktion des Körpers, die uns vor dauerhaften Schädigungen schützen wollen und uns signalisieren, stärker auf unseren Körper und seine Bedürfnisse zu achten. Bei über 90 % der Rückenschmerzen gibt es keine eindeutige Diagnose und noch keine Schädigung des Rückens, so dass diese Schmerzen durch eine Umstellung der Lebens - und Arbeitsgewohnheiten relativ einfach behoben werden können. Der Rücken warnt mit diesen Schmerzen vor bleibenden Schäden, wenn das Verhalten nicht geändert wird.
Im gesamten Körper sind unzählige kleine Rezeptoren, die auf unterschiedliche Reize reagieren und die laufend Informationen über körperliche Empfindungen sammeln. Diese Informationen werden über das Rückenmark an das Gehirn weitergeleitet. Hier wird entschieden, ob und wie reagiert wird. Einige Meldungen werden ignoriert, andere werden gesammelt und erst bei einer bestimmten Menge oder Kombination erfolgt eine Reaktion. Wir verfügen damit über keinen Schmerzsinn, sondern das Rückenmark oder das Gehirn bestimmen, ob die Meldung der Rezeptoren als Schmerz interpretiert wird oder nicht.
<strong> Aufgabe: Bitte denken Sie zurück an die vergangenen 4 Wochen und versuchen Sie, sich in Erinnerung zu rufen, ob und wann Sie Schmerzen gehabt haben.  Wenn nicht, umso besser, aber wenn doch: In welchem Zusammenhang und wie ist der Schmerz entstanden ? War es ein akuter(Alarm -)Schmerz oder eher ein Überlastungsschmerz ? Mehr zu den unterschiedlichen Formen, gibt es in der nächsten Woche.
</strong>
<em>
Fotonachweis: <a href = "http://www.freedigitalphotos.com/"> www. freedigitalphotos. com</a> /graur razvan ionut </em>
EOT
        );
        $manager->persist($item1958);


        $item1964 = new Weeklytask();
        $item1964->setFormat("richhtml");
        $item1964->setWeekId(26);
        $item1964->setQuiz($this->getReference('weeklyquiz_26'));
        $item1964->setCountPoint(1);
        $item1964->setName("Wochenaufgabe 26");
        $item1964->setContent(<<<EOT
<em>In der vergangenen Woche haben Sie gelernt, dass überall im Körper Rezeptoren bereitstehen, die laufend Informationen sammeln und über das Rückenmark an das Gehirn weiterleiten. Im Gehirn werden diese Informationen beurteilt und z. B. als Schmerz eingestuft. Neben diesen Meldungen greift das Gehirn außerdem auf Erfahrungswerte zurück, um die Intensität eines möglichen Schmerzes festzulegen. Hier kann zwischen drei Stufen entschieden werden:</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa26.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa26-300x207.png" alt = "wa26" width = "300" height = "207" class="alignnone size-medium wp-image-1966" /></a>
<strong> 1. Der Überlastungsschmerz </strong>
Beim Überlastungsschmerz handelt es sich um die leichteste Schmerzform und der Körper warnt damit vor einer drohenden Schädigung. In fast allen Fällen ist dieser Schmerz muskulär bedingt und deutet auf eine zu schwache und überforderte Muskulatur hin. Wenn die Belastung ausgesetzt wird, dann verschwindet der Schmerz in der Regel schnell. Ein typischer Überlastungsschmerz, den jeder kennt, ist im Schulter - Nacken Bereich zu finden.
Ursächlich hierfür sind das Hochziehen der Schultern und das Vorstrecken des Kopfes bei der Arbeit am PC. Durch eine Entspannungsphase, eine Massage oder lockere Bewegung(z. B. <a href = "http://online-rueckenschule.de/mitgliederbereich/uebungen/schulter-nacken/1-mobilisation-kopfschaukeln/" target = "_blank"> Übungen für den Schulter - Nacken - Bereich </a>) kann dieser Schmerz schnell behoben werden. Bereits jetzt muss das Verhalten geändert werden, um die zweite Stufe zu vermeiden.
<strong> 2. Der Alarmschmerz </strong>
Werden Überlastungsschmerzen über einen längeren Zeitraum ignoriert, reagiert der Körper mit einem Alarmschmerz, um den Körper zu einer Änderung des Verhaltens zu zwingen. Ein typisches Beispiel hierfür ist der sogenannte Hexenschuss, dessen Schmerz plötzlich den gesamten Körper lahm legt und zur Bettruhe zwingt. Die Muskeln spannen sich extrem an, um den Rücken zu schützen und um eine Änderung herbeizuführen.
Anders als der Überlastungsschmerz verschwindet der Alarmschmerz nicht durch eine einfache Bewegungs - oder Entspannungsphase. Das Verhalten muss korrigiert und für mehrere Wochen umgestellt werden, bis der Schmerz verschwindet. Einfaches Abwarten und Pausen reichen nicht mehr aus. Wie beim Überlastungsschmerz sind auch beim Alarmschmerz fast immer muskuläre Gründe die Ursache.
<strong> 3. Der Schädigungsschmerz </strong>
Hierbei handelt es sich um den intensivsten Schmerz, der tatsächliche Schädigungen mit sich bringt und keine warnende Funktion mehr einnimmt. Glücklicherweise lassen es nur wenige Menschen soweit kommen. In diesem Schmerzstadium werden häufig Knorpel an den Gelenken dauerhaft überlastet. Diese Gelenkknorpel nutzen sich ab und die Belastung trifft direkt auf den Knochen, der sich entzünden kann. Ähnlich verläuft es bei einem echten Bandscheibenvorfall, der jedoch nur in einem Bruchteil der gestellten Diagnosen tatsächlich vorliegt.
<strong> Aufgabe: Bitte denken Sie zurück an das letzte halbe Jahr. Können Sie sich eine oder mehrere der drei Schmerzarten in Erinnerung rufen ? Vermutlich ja. Welcher Schmerz sitzt wo und was können Sie dagegen unternehmen ?</strong>
<em>
Fotonachweis: <a href = "http://www.freedigitalphotos.com/"> www. freedigitalphotos. com</a>   /  <em> Ambro</em></em>
EOT
        );
        $manager->persist($item1964);


        $item1968 = new Weeklytask();
        $item1968->setFormat("richhtml");
        $item1968->setWeekId(27);
        $item1968->setQuiz($this->getReference('weeklyquiz_27'));
        $item1968->setCountPoint(1);
        $item1968->setName("Wochenaufgabe 27");
        $item1968->setContent(<<<EOT
<em>Heute erläutern wir Ihnen den Zusammenhang zwischen Rückenschmerzen und Bewegungsmangel, der vor allem von unserem vom Sitzen geprägten Lebensstil gefördert wird. Wir erklären Ihnen die Auswirkungen von Bewegungsmangel und geben Ihnen Tipps wie Sie den Mangel kompensieren können.</em>
<h2> Bewegungsmangel als Hauptursache </h2>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa27.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa27-300x220.png" alt = "wa27" width = "316" height = "232" class="alignright wp-image-1970 " /></a> Die Hauptursache für Rückenschmerzen sind Bewegungsmangel und Fehlbelastungen, wie z. B. falsches Heben oder eingefahrene Haltungsmuster. Beides zusammen findet sich vor allem bei Menschen, die am PC arbeiten und Tag aus Tag ein die meiste Zeit sitzen. Geht man von einer sitzenden Erwerbstätigkeit am PC, einer täglichen Auto - oder U - Bahnfahrt zum Arbeitsplatz, sitzende Mahlzeiten und dem abendlichen Plausch auf dem Sofa aus, so ergeben sich durchschnittlich 10 - 12 Stunden, die täglich in sitzender Weise verbracht werden.
Einige Menschen ergänzen diesen Sitzmarathon durch regelmäßigen Sport, dies allein kann jedoch nicht immer vor dauerhaften Schäden schützen. Die starre Haltung am PC(oder auf dem Sofa) muss durch regelmäßige kurze Bewegungsphasen und sich ändernden Sitzhaltungen unterbrochen werden, um Fehlbelastungen zu verhindern. Der Rücken sollte entgegen langjähriger Propaganda nicht geschont sondern(richtig) belastet werden, damit er nicht einrostet. Jede Bewegung zählt!
<h2>Dauerhafter Bewegungsmangel sorgt für </h2>
<ul>
	<li> Schrumpfende Muskeln, die die Wirbelsäule nicht ausreichen schützen und stützen können(Bitte schauen Sie sich hierzu die <a href = "http://online-rueckenschule.de/mitgliederbereich/uebungen/unterer-ruecken/2-kraeftigung-tiefe-rueckenmuskulatur/" target = "_blank"> Übung zur Kräftigung der tiefen Rückenmuskeln </a>)</li>
	<li> Lockere Bänder, die den Rücken nicht mehr stabilisieren können </li>
	<li> Unterversorgte Bandscheiben, die durch fehlende Be - und Entlastung nicht mit ausreichend Nährstoffen versorgt werden </li>
	<li> Verstopftes Bindegewebe, das Muskeln und Bänder nicht mehr versorgen und schützen kann </li>
	<li> Beeinträchtigte Nerven, die aufgrund fehlender Beweglichkeit erstarren </li>
	<li> Knorpelabbau und Entstehung von Arthrose </li>
	<li> Poröse Knochen, die unterversorgt sind und brüchig werden </li>
	<li> Versteifende Hüft - oder Schultergelenke, die die Wirbelsäule zusätzlich belasten </li>
</ul>
Nutzen Sie unser ständig wachsendes Angebot an einfach durchzuführenden Rückenübungen und wählen Sie einzelne Übungen gezielt aus der Übersicht aus.
<strong> Aufgabe: Bitte zählen oder schätzen Sie in der kommenden Woche jeden Abend, wie viele Stunden Sie gesessen haben und schreiben Sie sich die Zahl auf. Versuchen Sie doch einmal für jede gesessene Stunde eine Online - Rückenschule - Übung als Ausgleich zu machen. Also für 60 Minuten sitzen, 1 Minute Bewegung.</strong>
<em>
Fotonachweis: <em><em><a href = "http://www.freedigitalphotos.com/"> www. freedigitalphotos. net /</a><em> imagerymajestic</em></em></em></em>
EOT
        );
        $manager->persist($item1968);


        $item1973 = new Weeklytask();
        $item1973->setFormat("richhtml");
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


        $item1977 = new Weeklytask();
        $item1977->setFormat("richhtml");
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


        $item1985 = new Weeklytask();
        $item1985->setFormat("richhtml");
        $item1985->setWeekId(30);
        $item1985->setQuiz($this->getReference('weeklyquiz_30'));
        $item1985->setCountPoint(1);
        $item1985->setName("Wochenaufgabe 30");
        $item1985->setContent(<<<EOT
<em> In der vergangenen Einheit haben Sie den Zusammenhang zwischen Beschwerden und Übersäuerung & amp; Muskelschwäche kennengelernt. Heute möchten wir auf die Nerven eingehen.</em>
<h3> Nerven im Engpass </h3>
Bewegungsmangel belastet auch die Nerven, die ihre Elastizität einbüßen und verhärten können, was Entzündungen und Schmerzen zur Folge haben kann. Häufiger noch entstehen jedoch Beschwerden durch Nerven, die von Muskeln oder Wirbeln eingeengt und dadurch gereizt werden. Dies ist u. a. der Fall, wenn das Nervengeflecht <em>Ischias </em> (dies ist unser größter Nerv, der aus den Nerven im Kreuzbein entsteht und über beide Beine verläuft) im Lendenwirbelbereich z. B. durch verschobene Wirbel oder verkrampfte Muskeln beeinträchtigt wird. Ausstrahlende Schmerzen in verschiedene Richtungen sind die Folge und im Volksmund hört man dann: „Ich habe Ischias“.
<h3> Thoracic Outlet Syndrom </h3>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa30.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa30-300x160.png" alt = "wa30" width = "365" height = "195" class="alignright wp-image-1986 " /></a> Während mit dem Ischias - Nerv verbundene Probleme sehr bekannt sind, gibt es zahlreiche weitere Nerven, die an unzählbaren Stellen von verkrampften Muskeln oder verschobenen Wirbeln bedrängt werden können und für schwer zu lokalisierende Schmerzen verantwortlich sind. Bei der Arbeit am PC beispielsweise kippen die Schultern häufig nach vorn und es werden über die Hals - und Brustmuskeln verlaufende Nerven eingeklemmt, die für anfangs leichte und später sehr starke Schmerzen in den Armen sorgen können. Man spricht dann von einem Thoracic Outlet Syndrom(kurz: TOS, <em> Thoracic</em> = Brust, <em> Outlet</em> = Durchlass) Dies wird häufig jedoch nicht richtig diagnostiziert. So sind vermeintliche RSI - oder Karpaltunnel - Syndrome(vertiefend dazu kommende Einheiten) häufig durch eine Fehlhaltung beeinträchtigte Nerven, die für Schmerzen sorgen.
Die Übungsauswahl von Online - Rückenschule, wie z. B. die Dehnübung für den Brustmuskel, können Sie vor einem TOS schützen und Sie in einer aufrechten Haltung am PC unterstützen.
<strong> Aufgabe: Bitte wiederholen Sie die Wochenaufgabe Körperhaltung – Aufrecht Sitzen und führen Sie die Übung Schulter öffnen diese Woche durch, um die dort verlaufenden Nerven vor einer Einengung zu schützen.</strong>
EOT
        );
        $manager->persist($item1985);


        $item1990 = new Weeklytask();
        $item1990->setFormat("richhtml");
        $item1990->setWeekId(31);
        $item1990->setQuiz($this->getReference('weeklyquiz_31'));
        $item1990->setCountPoint(1);
        $item1990->setName("Wochenaufgabe 31");
        $item1990->setContent(<<<EOT
<em> In der vergangenen Woche haben wir uns mit dem Thoracic Outlet Syndrom und eingeklemmten Nerven beschäftigt. In der heutigen Einheit wollen wir diesen Aspekt aufgreifen und uns die Nerven im Hand - Arm - Bereich anschauen.</em>
<h2> Bereich: Hand - Arm </h2>
Unsere Hände sind ein komplexes Meisterwerk, das unseren Fingern sehr präzise, kraftvolle Bewegungen ermöglicht. Aufgrund des feingliedrigen Aufbaus sind sie aber auch sehr verletzlich, die Knochen sind relativ dünn und liegen, gemeinsam mit Sehnen und Nerven, direkt unter der Haut ohne von schützendem Muskel - oder Fettgewebe bedeckt zu sein.
Unsere Hände und Arme sind ständig in Gebrauch und erhalten nur selten eine Pause. Wenn Sie z. B. an einem Computerarbeitsplatz arbeiten, dann werden Sie vermutlich täglich zwischen 50.000 – 200.000 Tastenanschläge pro Tag mit Ihren Fingern ausführen. Selbst für unsere von der Natur perfekt konzipierten und für den Dauereinsatz gemachten Hände, stellt dies eine sehr große Belastung dar. Denn für diese kleine Bewegung des Tastenanschlags wird eine Vielzahl von Muskeln und Sehnen beansprucht – durch den intensiven Gebrauch leider häufig überbeansprucht. Wird diese Belastung kombiniert mit einem nicht - ergonomisch eingerichteten Arbeitsplatz, Stress, einer schlechten Körperhaltung und zu wenig Pausen, sind Schmerzen und Taubheitsgefühle in den Fingern häufig die Folge.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa31.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa31-300x177.png" alt = "wa31" width = "341" height = "201" class="alignright wp-image-1991 " /></a> Es wird dann von einem Mausarm oder - in der Fachsprache - von einem RSI - Syndrom gesprochen(RSI = Repetitive Strain Injury, engl. <em> repetitive</em> = sich wiederholend; <em> strain</em> = Anspannung, Belastung; <em> injury</em> = Beschädigung). Mit RSI wird also umschrieben, dass Muskeln durch oft und sich schnell wiederholende, ohne viel Kraftaufwand ausgeführte Bewegungen(typisch für die Arbeit mit Tastatur und Maus) dauerhaft geschädigt werden können. RSI ist jedoch keine Krankheit im klassischen Sinne und mit eindeutigen Beschwerden, die eine klare Diagnose ermöglichen. RSI ist vielmehr ein Sammelbegriff für unterschiedliche Beschwerdebilder, die im Verdacht stehen, durch zig - tausendfache Wiederholungen(Repetitionen) derselben Bewegung auslösbar zu sein und zu chronischen Beschwerden führen. Mehr dazu in der kommenden Einheit.
<strong> Aufgabe:  </strong><strong style = "line-height: 19px"> Führen Sie diese Woche täglich eine Einheit für den Hand - Arm - Bereich aus und überprüfen Sie erneut Ihren Arbeitsplatz nach ergonomischen Gesichtspunkten sowie Ihre Körperhaltung, um sich vor der Entstehung eines RSI - Syndroms zu schützen.   </strong>
EOT
        );
        $manager->persist($item1990);


        $item1996 = new Weeklytask();
        $item1996->setFormat("richhtml");
        $item1996->setWeekId(32);
        $item1996->setQuiz($this->getReference('weeklyquiz_32'));
        $item1996->setCountPoint(1);
        $item1996->setName("Wochenaufgabe 32");
        $item1996->setContent(<<<EOT
In der vergangenen Woche haben Sie erfahren, dass ein RSI - Syndrom ein Sammelbegriff ist und durch repetitive Belastungen entsteht. Auch eine <em>Sehnenscheidenentzündung </em> oder ein <em>Karpaltunnelsyndrom </em> zählen zu den Krankheitsbildern eines <em>RSI - Syndroms </em> und können durch repetitive Bewegungen hervorgerufen werden.
<strong> Sehnenscheidenentzündung</strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa31.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa31-300x177.png" alt = "wa31" width = "331" height = "195" class="alignright wp-image-1991 " /></a> Eine <strong> Sehnenscheide </strong> ist eine mit „Gelenkschmiere“ gefüllte Hülle um eine Sehne, die eine Schutzfunktion inne hat und die Reibung reduziert. Eine Sehnenscheidenentzündung resultiert aus einer Überlastung, z. B. wenn die Sehne ständig durch immer gleiche Bewegungen(Repetitionen) belastet wird und sich so kleinste Verletzungen bilden. Vor allem im Hand - Arm - Bereich tritt diese äußerst schmerzvolle Entzündung auf, die dann mit einer Ruhigstellung(Gipsverband oder Schiene) behandelt wird.
Dehnübungen für den Hand - Arm - Bereich können dazu beitragen, eine Sehnenscheidenentzündung zu verhindern.
<strong> Karpaltunnelsyndrom</strong>
Der Karpaltunnel  ist der Raum zwischen den Handwurzelknochen und dem darüber liegenden Karpalband, durch den verschiedene Sehnen und der Mittelhandnerv verlaufen, siehe Abbildung. Dieser Nerv ist für die Empfindung des Daumens sowie des Zeige - und zum Teil auch des Mittelfingers zuständig. Außerdem ist er für die Steuerung bestimmter Hand - und Fingermuskeln verantwortlich. Ein Karpaltunnelsyndrom entsteht, wenn der Mittelhandnerv durch erhöhten Druck innerhalb des Karpalkanals geschädigt wird, z. B. weil die Sehnen aufgrund einer Sehnenscheidenentzündung durch Überlastung angeschwollen sind oder ein Knochenbruch die Strukturen verschoben hat.
Typisch für die Entstehung ist außerdem ein abgeknicktes Handgelenk durch die Arbeit an Maus und Tastatur. Aber auch eine Schwangerschaft, Infektionen im Handbereich, Nierenschädigungen oder eine Schilddrüsenunterfunktion stehen im Verdacht, die Entstehung eines Karpaltunnelsyndroms zu begünstigen.
Dehnübungen für den Hand - Arm - Bereich können dazu beitragen, ein Karpaltunnelsyndrom zu verhindern.
EOT
        );
        $manager->persist($item1996);


        $item1999 = new Weeklytask();
        $item1999->setFormat("richhtml");
        $item1999->setWeekId(33);
        $item1999->setQuiz($this->getReference('weeklyquiz_33'));
        $item1999->setCountPoint(1);
        $item1999->setName("Wochenaufgabe 33");
        $item1999->setContent(<<<EOT
<em> In der vergangenen Woche haben Sie erfahren, dass auch eine Sehnenscheidenentzündung oder ein Karpaltunnelsyndrom zu den Krankheitsbildern eines RSI - Syndroms zählen. Heute wollen wir uns anschauen, was gegen die Entstehung eines RSI - Syndroms getan werden kann.</em>
<strong> RSI Prävention </strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa31.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa31-300x177.png" alt = "wa31" width = "300" height = "177" class="alignright wp-image-1991 size-medium" /></a>
Nach Prof. Dr. H. Sorgatz von der Technischen Universität Darmstadt, der das Thema RSI in Deutschland federführend erforscht und den ersten Interventionskurs entwickelt hat, sollte die RSI Prävention ganzheitlich betrachtet werden und die folgenden Bausteine berücksichtigen:
<ul>
	<li><strong> Ergonomische Arbeitsplatzgestaltung </strong> (u. a. optimale Anpassung der Tisch - und Stuhlhöhe, Ausrichtung des Bildschirms, Geräteanordnung, optimale Lichtverhältnisse) – diese Arbeitsplatzgestaltung sollte anfangs professionell angeleitet werden und regelmäßig selbstständig vom Nutzer überprüft werden.</li>
	<li><strong> Angenehmes Raumklima und Raumtemperatur </strong> – eine zu kalte Raumtemperatur kann beispielsweise die Verletzungsgefahr bei der PC - Arbeit fördern.</li>
	<li><strong> Nutzung alternativer Eingabegeräte </strong> STATT der handelsüblichen PC - Maus(z. B. Nutzung von Stifttabletts, vertikalen PC - Mäusen) um das für die PC - Maus typische Abknicken des Handgelenks, und somit die Gefahr einer Reibung an Sehnen und Nerven im Handgelenkkanal(Karpaltunnel), zu minimieren. Ideal wäre der Wechsel von verschiedenen Eingabegeräten über den Tag hinweg, um einer einseitigen Beanspruchung einzelner Muskeln, Sehnen und Nerven entgegenzuwirken.</li>
	<li><strong> Angemessenes Arbeitstempo und Pausenverhalten </strong> – durch sogenanntes "speed typing" kommt es zu einer hochrepetitiven Dauerbeanspruchung, welche das Risiko von Mikroverletzungen im Hand -/Armbereich erhöhen kann. Das Arbeitstempo am PC sollte nicht über einen längeren Zeitraum hinweg auf "high speed" laufen. Weiterhin sollten bei der PC - Arbeit mind. alle 30 Minuten eine Kurzpausen von 2 - 3 Minuten einlegt werden, um den Regenerierungsprozess der beanspruchten Sehnen, Muskeln und Nerven zu fördern.</li>
	<li><strong> Durchführen physiotherapeutischer Dehn - und Kräftigungsübungen </strong> am PC - Arbeitsplatz als "Warm-up" vor Beginn der PC - Arbeit und während der genannten Kurzpausen über den Tag hinweg.</li>
	<li><strong> Dynamisches Arbeiten:</strong> statt einer starren Sitzhaltung über den ganzen Tag hinweg sollten Sitz - und Arbeitshaltungen möglichst oft variiert werden, z. B. durch Nutzung eines Gelkissens, Sitzen auf einem Sitzballs, Nutzung dynamischer Sitzmöbel und eines Stehpults.</li>
	<li><strong> Schmerzedukation</strong> zur Vermittlung von Wissen über die Entstehung und Chronifizierung von Bewegungsschmerzen </li>
	<li><strong> Stressmanagement und Organisation des Arbeitsalltags </strong> zum angemessenen Umgang mit hohen Arbeitsanforderungen und Arbeitsvolumen </li>
	<li><strong> Psychologische Aspekte </strong> zur Selbstbewertung und eigenen Leistungsansprüchen </li>
	<li><strong> Entspannungs - und Achtsamkeits - basierte Verfahren </strong> welche sich gut in den Arbeitsalltag integrieren lassen </li>
	<li><strong> Motivationale Strategien </strong> zur langfristigen Aufrechterhaltung eines angemessenen Arbeitsverhaltens.</li>
</ul>
<strong> Aufgabe: Führen Sie diese Woche täglich eine Einheit für den Hand - Arm - Bereich aus, achten Sie auf ausreichend Pausen nach intensiver Tastatur / Maus - Nutzung und überprüfen Sie erneut Ihren Arbeitsplatz nach ergonomischen Gesichtspunkten sowie Ihre Körperhaltung, um sich vor der Entstehung eines RSI - Syndroms zu schützen.</strong>
<em> Quelle</em>: Prof. Dr. H. Sorgatz, <a href = "http://www.rsi-online.de/"> http://www.rsi-online.de/</a>
<em> Vertiefend dazu </em>: Prof. Dr. H. Sorgatz „Repetitive strain injuries“ -Unterarm -/Handbeschwerden aufgrund repetitiver Belastungsreaktionen des Gewebes in: Der Orthopäde 10 / 2002 – 31:1006 - 1014,  download unter: <a href = "http://www.rsi-online.de/download/1321006.pdf"> http://www.rsi-online.de/download/1321006.pdf</a>
EOT
        );
        $manager->persist($item1999);


        $item2002 = new Weeklytask();
        $item2002->setFormat("richhtml");
        $item2002->setWeekId(34);
        $item2002->setQuiz($this->getReference('weeklyquiz_34'));
        $item2002->setCountPoint(1);
        $item2002->setName("Wochenaufgabe 34");
        $item2002->setContent(<<<EOT
<em> In den vergangenen Einheiten haben Sie bereits verschiedene Ursachen für Rückenbeschwerden kennengelernt. Heute und in den kommenden Einheiten geht es um die Bandscheiben.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa341.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa341-182x300.png" alt = "wa34" width = "257" height = "423" class="alignright wp-image-2004 " /></a> Um die Bandscheibe ranken sich zahlreiche Mythen und Geschichten. Wenn es mal am Rücken zwickt, erhält jeder der sagt „oh, das muss die Bandscheibe sein“ zustimmendes Nicken. Jedoch ist es in den allerseltensten Fällen tatsächlich eine der 23 Bandscheiben, die zwischen unseren Wirbeln sitzen. Da Rückenschmerzen jedoch zahlreiche schwer zu diagnostizierende Ursachen haben können, wird in vielen Fällen ein Bandscheibenvorfall als Ursache festgestellt und eine Operation durchgeführt. Diese Operation führt jedoch nur sehr selten zum Erfolg, da nur 2 - 3 % aller Rückenschmerzen tatsächlich auf kaputte Bandscheiben zurückzuführen sind. Im Großteil der Fälle stellt sich keine Besserung der Schmerzen ein, da die Ursachen anderweitig zu suchen sind und viele Menschen Bandscheibenvorfälle haben, die keinerlei Probleme bereiten. Im schlimmsten Fall führt eine unnötige Operation zu weiteren Beschwerden. Dennoch werden Operationen an der Bandscheibe häufig durchgeführt, da die Diagnose anderer Ursachen, wie z. B. Stress, weitaus schwieriger ist.
Lesen Sie hierzu auch eine Information des wissenschaftlichen Dienstes der AOK, nach dem die Bandscheibenoperationen innerhalb von 5 Jahren um 38 Prozent gestiegen sind.   <a href = "http://www.presseportal.de/pm/30621/2303397/rheinische-post-zahl-der-bandscheiben-operationen-sprunghaft-gestiegen-kassen-vermuten" target = "_blank"> Infos hier </a>.
EOT
        );
        $manager->persist($item2002);


        $item2008 = new Weeklytask();
        $item2008->setFormat("richhtml");
        $item2008->setWeekId(35);
        $item2008->setQuiz($this->getReference('weeklyquiz_35'));
        $item2008->setCountPoint(1);
        $item2008->setName("Wochenaufgabe 35");
        $item2008->setContent(<<<EOT
<em> In der vergangenen Einheit haben wir Ihnen einige Informationen zur Bandscheiben vermittelt. Dies wollen wir heute vertiefen und uns den Aufbau und die Funktion der Bandscheiben genauer anschauen.</em>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa351.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa351-300x136.png" alt = "wa35" width = "397" height = "180" class="alignleft wp-image-2009" /></a> Die Bandscheiben sind sehr robuste knorpelige Gebilde zwischen zwei Wirbeln, die mit den umliegenden Bändern und Muskeln ein sehr stabiles Gerüst bilden. Dass sich die Bandscheiben mit der Zeit abnutzen ist normal und kein Grund zur Sorge. Sie Schmerzen nicht einmal, solange das Gesamtpaket aus Bändern und Muskeln gesund und kräftig ist. Durch zu wenig Bewegung und Training der Muskeln und Bänder, die die Bandscheiben umspannen, wird das Schutzsystem geschwächt und anfällig für Schmerzen.
Neben der Kräftigung von Muskeln und Bändern, die die gesamte Wirbelsäule schützen, führt Bewegung zudem zur Be - und Entlastung der Bandscheiben. Das wiederum ist wichtig für ihre Versorgung, da sie nicht durchblutet werden. Bei Belastung geben sie Flüssigkeit an die Umgebung ab und bei Entlastung saugen sie Flüssigkeit auf. Dadurch werden sie „ernährt“. Sitzt man nun den ganzen Tag, wird die Bandscheibe überwiegend be - aber nicht entlastet. Durch die mangelhafte Versorgung werden die Bandscheiben spröde und es kommt zu Rissen. Diese Risse begünstigen die Veränderung der Form und es kann zu einem Bandscheibenvorfall oder –vorwölbung kommen.
Bei einem Bandscheibenvorfall kommt es zu einer Verlagerung(sog. Vorwölbung) bzw. zum Austritt von Teilen des Gallertkerns der Bandscheibe(siehe Darstellung). Zustande kommt der Schmerz dadurch, dass Teile der Bandscheibe einen Nerv oder dessen Wurzel einengt und diese sich entzünden. Hierbei handelt es sich dann um einen echten Bandscheibenvorfall, der aber erst einmal mit entzündungshemmenden Injektionen und Training behandelt werden sollte.
Wichtig ist zu wissen, dass viele Menschen eine vorgewölbte Bandscheibe haben, die jedoch zu keiner Entzündung am Nerv führt und daher auch keine Schmerzen oder anderweitige Probleme verursacht.   Rund 20 % der Menschen haben so einen „stummen“ Bandscheibenvorfall, der in der Regel auch nicht behandelt werden muss und durch Bewegung und Stärkung der Muskeln in diesem Bereich von selbst heilt.
<strong> Aufgabe: Schauen Sie sich dieses Video zur Entstehung eines Bandscheibenvorfalls an, um die Entstehung besser zu verstehen: <a href = "http://www.onmeda.de/video/orthop%C3%A4die-unfallchirurgie-14/bandscheibenvorfall-v54.html" target = "_blank"> Zum Video </a>.</strong>
EOT
        );
        $manager->persist($item2008);


        $item2013 = new Weeklytask();
        $item2013->setFormat("richhtml");
        $item2013->setWeekId(36);
        $item2013->setQuiz($this->getReference('weeklyquiz_36'));
        $item2013->setCountPoint(1);
        $item2013->setName("Wochenaufgabe 36");
        $item2013->setContent(<<<EOT
<em> Nach einigen anatomischen Informationen in den letzten Wochen, wollen wir uns heute konkret anschauen, in welchen alltäglichen Situationen die Bandscheibe wie belastet wird.</em>
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/wa361.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa361.png" alt = "wa36" width = "222" height = "233" class="alignright wp-image-2015 size-full" /></a> Das Bild rechts </strong>  zeigt eine typische Sitzhaltung mit einem runden, angelehnten Rücken. Die Wirbelsäule wird bei dieser Haltung entgegen ihrer natürlichen Form gekrümmt. Bitte wiederholen Sie ggf. die <a href = "http://online-rueckenschule.de/mitgliederbereich/wochenaufgaben/wochenaufgabe-07/" target = "_blank"> Wochenaufgabe zur aufrechten Körperhaltung im Sitzen </a>. Es ist überhaupt kein Problem, wenn Sie ab und zu diese oder eine andere „krumme“ Sitzhaltung einnehmen und sich entspannen. Auch ihre Rückenmuskeln brauchen Entspannungsphasen.
Bitte seien Sie sich aber bewusst, dass der Druck auf die Bandscheiben in dieser Position nicht gleichmäßig ist und der Gallertkern nach außen gedrückt wird. Auch das ist kein Problem, solange Sie sich bewegen und nicht dauerhaft in solch einer Position verharren. Leider ist letzteres aber vor dem Bildschirm häufig der Fall.
<strong><a href = "http://online-rueckenschule.de/wp-content/uploads/wa36_21.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa36_21-300x92.png" alt = "wa36_2" width = "300" height = "92" class="alignleft wp-image-2017 size-medium" /></a> Das erste Bild links </strong>  zeigt eine schematische Darstellung der Bandscheibe unter gleichmäßigem Druck, während <strong>das zweite Bild links </strong>  eine Bandscheibe „unter Zug“ darstellt. Der Gallertkern verlagert sich und die Bandscheibe wird leicht nach außen gedrückt(schematisch). Dies ist z. B. der Fall, wenn der Rücken „rund“ ist, wie im Bild links.<a href = "http://online-rueckenschule.de/wp-content/uploads/wa36_21.png"></a>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa36_31.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa36_31-300x135.png" alt = "wa36_3" width = "331" height = "149" class="alignright wp-image-2021 " /></a> Tritt der Gallertkern aus, spricht man von einem echten Bandscheibenvorfall, der für starke Schmerzen sorgen kann, wenn ein Nerv getroffen wird, wie <strong>im Bild rechts </strong>  schematisch dargestellt. Ist kein Nerv betroffen, kann ein Bandscheibenvorfall ohne Schmerzen und völlig unbemerkt verlaufen.
EOT
        );
        $manager->persist($item2013);


        $item2024 = new Weeklytask();
        $item2024->setFormat("richhtml");
        $item2024->setWeekId(37);
        $item2024->setQuiz($this->getReference('weeklyquiz_37'));
        $item2024->setCountPoint(1);
        $item2024->setName("Wochenaufgabe 37");
        $item2024->setContent(<<<EOT
<em> Nachdem wir uns in den vergangenen Wochen überwiegend mit theoretischen Informationen rund um die Bandscheiben beschäftigt haben, werden wir Ihnen heute einige praktische Übungen zeigen mit denen Sie gezielt positiven Einfluss auf Ihre Bandscheiben nehmen können.</em>
<strong> Bandscheibengymnastik</strong>
    Ein ausgewogener Wechsel von Be - und Entlastung ist für die Gesunderhaltung unserer Bandscheiben enorm wichtig. Kräftige Muskeln stützen außerdem die Wirbelsäule und entlasten die Bandscheiben.  Sie können aktiv etwas dafür tun: Mit den folgenden Übungen entlasten Sie die Bandscheiben, verbessern deren Nährstoffversorgung und kräftigen Ihre Rückenmuskulatur.
<strong> Hinweis: </strong>
<ul>
	<li> Da sich die Durchführung der Übungen kaum für den Arbeitsplatz eignet, empfiehlt es sich, diese Einheit auszudrucken und die Übungen zu Hause durchzuführen.</li>
	<li> Kombinieren Sie die Durchführung der Übungen mit einer tiefen Bauchatmung(vgl. <a href = "http://online-rueckenschule.de/mitgliederbereich/wochenaufgaben/wochenaufgabe-10/" target = "_blank"> Wochenaufgabe 10 </a>).</li>
</ul>
<strong> 1.  </strong><strong> Stufenlagerung</strong>
    Ziel: Entlastung der Bandscheibe, Förderung der Nährstoffaufnahme und Entspannung der Rückenmuskulatur. Positiver Nebeneffekt: Durch eine sitzende oder stehende Tätigkeit sammelt sich das Blut im Laufe des Tages in den Beinen. Bei dieser Übung fließt es zurück.
<em><a href = "http://online-rueckenschule.de/wp-content/uploads/wa37_1.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa37_1-300x166.jpg" alt = "wa37_1" width = "300" height = "166" class="alignleft wp-image-2025 size-medium" /></a> Durchführung:</em>
<ul>
	<li> Legen Sie sich auf einer Matte oder einem Teppich auf den Rücken </li>
	<li> Die Unterschenkel werden auf einer Erhöhung, z. B. Stuhl oder Gymnastikball, so abgelegt, dass Rumpf und Oberschenkel bzw. Oberschenkel und Unterschenkel jeweils einen Winkel zwischen 90 und 100 Grad bilden </li>
	<li> Position mindestens 10 Minuten beibehalten.</li>
</ul>
<strong> </strong>
<strong> 2.  </strong><strong> H</strong><strong> ü</strong><strong> ftschwung</strong>
    Ziel: Mobilisation der Lendenwirbelsäule
    <a href = "http://online-rueckenschule.de/wp-content/uploads/wa37_2.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa37_2-146x300.jpg" alt = "wa37_2" width = "146" height = "300" class="alignleft wp-image-2028 size-medium" /></a> Durchführung:
<ul>
	<li> Legen Sie sich auf einer Matte oder einem Teppich auf den Rücken </li>
	<li> Strecken Sie Arme und Beine lang aus </li>
	<li> Ziehen Sie die rechte Hüfte seitlich in Richtung Achsel und schieben Sie gleichzeitig die linke Hüfte in Richtung Füße </li>
	<li> Diese Position in der Endstellung 5 Sekunden halten. Dann zurück in die Ausgangsstellung gehen und die Seiten wechseln </li>
	<li> Führen Sie die Übung auf jeder Seite fünfmal langsam durch </li>
</ul>
<strong> Aufgabe: Bitte führen Sie diese beiden Übungen heute Abend zu Hause einmal durch und beobachten Sie, wie sich Ihr Körper anschließend anfühlt. Wenn Ihnen diese Übungen zusagen und sich ein positives Gefühl einstellt, dann machen Sie diese Übung doch regelmäßig abends zu Hause vor dem Fernseher.</strong>
<strong>  </strong>
EOT
        );
        $manager->persist($item2024);


        $item2034 = new Weeklytask();
        $item2034->setFormat("richhtml");
        $item2034->setWeekId(38);
        $item2034->setQuiz($this->getReference('weeklyquiz_38'));
        $item2034->setCountPoint(1);
        $item2034->setName("Wochenaufgabe 38");
        $item2034->setContent(<<<EOT
<em> Nachdem wir uns <em>bereits </em> in der vergangenen Woche mit Übungen zur Versorgung der Bandscheiben beschäftigt haben, möchten wir Ihnen heute weitere praktische Übungen zeigen, mit denen Sie gezielt positiven Einfluss auf Ihre Bandscheiben nehmen können.</em>
<strong> Bandscheibengymnastik</strong>
Ein ausgewogener Wechsel von Be - und Entlastung ist für die Gesunderhaltung unserer Bandscheiben enorm wichtig. Kräftige Muskeln stützen außerdem die Wirbelsäule und entlasten die Bandscheiben.  Sie können aktiv etwas dafür tun: Mit den folgenden Übungen entlasten Sie die Bandscheiben, verbessern deren Nährstoffversorgung und kräftigen Ihre Rückenmuskulatur.
<strong> Hinweis: </strong>
<ul>
	<li> Da sich die Durchführung der Übungen kaum für den Arbeitsplatz eignet, empfiehlt es sich, diese Einheit auszudrucken und die Übungen zu Hause durchzuführen.</li>
	<li> Kombinieren Sie die Durchführung der Übungen mit einer tiefen Bauchatmung(vgl. <a href = "http://online-rueckenschule.de/mitgliederbereich/wochenaufgaben/wochenaufgabe-10/" target = "_blank"> Wochenaufgabe 10 </a>).</li>
</ul>
<strong> 1.  </strong><strong> Kniewedeln</strong>
Ziel: Mobilisation der Lendenwirbelsäule, Förderung der Nährstoffversorgung der Bandscheibe
<em>Durchführung:</em>
<ul>
	<li><a href = "http://online-rueckenschule.de/wp-content/uploads/wa38.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa38-300x164.png" alt = "wa38" width = "300" height = "164" class="alignright wp-image-2036 size-medium" /></a> Legen Sie sich auf einer Matte oder einem Teppich auf den Rücken </li>
	<li> Stellen Sie die Beine etwa im 45 Grad Winkel im Knie auf </li>
	<li> Legen Sie dann beide Knie langsam gleichzeitig soweit wie möglich zur linken Seite ab </li>
	<li> Behalten Sie diese Position 5 Sekunden inne </li>
	<li> Gehen Sie  anschließend zurück in die Ausgangsposition und legen Sie anschließend soweit wie möglich die Knie auf der rechten Seite ab </li>
	<li> Behalten Sie auch diese Position 5 Sekunden inne </li>
	<li> Bitte fünf Mal zu jeder Seite durchführen </li>
</ul>
<strong> 2. Beckenwippe</strong>
Ziel: Kräftigung der Bauchmuskulatur und Mobilisation der Lendenwirbelsäule
Durchführung:
<ul>
	<li><a href = "http://online-rueckenschule.de/wp-content/uploads/wa38_2.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa38_2-300x126.png" alt = "wa38_2" width = "300" height = "126" class="alignright wp-image-2037 size-medium" /></a> Legen Sie sich auf einer Matte oder einem Teppich auf den Rücken </li>
	<li> Stellen Sie die Beine etwa im 45 Grad Winkel im Knie auf </li>
	<li> Ziehen Sie den Bauchnabel ein und drücken Sie gleichzeitig die Lendenwirbelsäule auf den Boden </li>
	<li> Diese Position 5 Sekunden halten </li>
	<li> Führen Sie danach die Gegenbewegung aus, indem Sie den Bauchnabel in Richtung Decke drücken und dabei leicht ins Hohlkreuz gehen.</li>
	<li> Bitte fünf Mal wiederholen.</li>
</ul>
<strong> Aufgabe:  <strong>Bitte führen Sie diese beiden Übungen heute Abend zu Hause einmal durch und beobachten Sie, wie sich Ihr Körper anschließend anfühlt. Wenn Ihnen diese Übungen zusagen und sich ein positives Gefühl einstellt, dann machen Sie diese Übung doch regelmäßig abends zu Hause vor dem Fernseher.</strong></strong>
EOT
        );
        $manager->persist($item2034);

        $item2039 = new Weeklytask();
        $item2039->setFormat("richhtml");
        $item2039->setWeekId(39);
        $item2039->setQuiz($this->getReference('weeklyquiz_39'));
        $item2039->setCountPoint(1);
        $item2039->setName("Wochenaufgabe 39");
        $item2039->setContent(<<<EOT
<em>Nachdem wir uns in den vergangenen Wochen mit theoretischen und praktischen Übungen zum Thema Bandscheiben beschäftigt haben, wenden wir uns heute einem neuen Thema zu: Entspannung.</em><em></em>
<h1> Progressive Relaxation am Arbeitsplatz </h1>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa39.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa39-300x197.png" alt = "wa39" width = "300" height = "197" class="alignright wp-image-2041 size-medium" /></a> Entspannen ist eine Kunst die nicht jedem gegeben ist. Oder können Sie sich auf Kommando „entspannen“, z. B. wenn Sie verkrampft sind, genervt sind, unter Stress stehen etc.?
Muskuläre Verspannungen, egal durch was hervorgerufen, können oft mit der "Progressiven Muskelentspannung" nach Edmund Jacobson(auch "Progressive Muskel Relaxation" PMR genannt) verringert oder beseitigt werden. PMR geht von der Tatsache aus, dass ein Muskel nach einer längeren Anspannung ermüdet und sich automatisch entspannt und erholt. Ziel ist es, zu lernen, Spannungszustände in der Muskulatur zu lokalisieren und diese eigenständig durch bewusstes Entspannen zu beheben.
Um diese Spannungs - und Entspannungszustände im Körper mit allen dabei auftretenden Empfindungen wahrnehmen zu können, werden die Muskeln des Körpers in einer bestimmten Reihenfolge nacheinander angespannt und wieder entspannt. Dies ist verbunden mit bewusster Beobachtung dieser Muskulatur und entsprechender Konzentration und Wahrnehmung. Die Entspannungsphase ist dabei ca. drei bis vier Mal so lang wie die Anspannphase.
Diese Methode ist allerdings nur bei "normalen" Verspannungen und nicht bei extremen Schmerzen(hier bitte einen Arzt aufsuchen) anwendbar, da die betroffene Muskulatur dann nicht angespannt werden kann.
<strong> Übungsrahmen
</strong> Progressive Relaxation kann im Sitzen oder im Liegen ausgeführt werden, wobei das Liegen zwar günstiger ist, das Üben im Sitzen jedoch häufiger und vor allem überall angewendet werden kann, also auch am Arbeitsplatz. Eine ruhige Lage und gedämpftes Licht begünstigen den Entspannungserfolg.
<strong> Übungshäufigkeit</strong>
Regelmäßig täglich eine Übungseinheit von ca. zehn Minuten Dauer reicht völlig aus, mehrere Übungseinheiten bringen nicht unbedingt mehr Nutzen, können allerdings in großen Stressphasen zur kurzfristigen Regeneration der Schaffenskräfte sehr nützlich sein.
Ein genereller Zyklus besteht aus
<ul>
	<li> Anspannung,</li>
	<li> Halten der Anspannung und </li>
	<li> Loslassen der Spannung.</li>
</ul>
<strong> Wie geht dies konkret ?</strong>
<strong></strong> 1. Anspannungsphase insgesamt: ca. zehn Sekunden
    <ul>
	<li> langsames, gleichmäßiges Anspannen der Muskeln mit kontinuierlicher Steigerung bis zur maximalen Anspannung(ca. 3 - 5 Sekunden)</li>
	<li> Halten der maximalen Anspannung ca. 5 - 7Sekunden </li>
	<li> Normal weiteratmen, keine Pressatmung </li>
	<li> Bei Armen und Beinen mit der dominanten Seite(Sprungbein, Rechtshänder rechte Hand) beginnen </li>
</ul>
2. Entspannungsphase: ca. 30 - 40 Sekunden.
<ul>
	<li> Entspannen der Muskeln und Wahrnehmen der Entspannung </li>
	<li> Möglichst die Augen schließen </li>
</ul>
3. Nach der Übungssequenz(siehe unten) die Entspannung wieder zurücknehmen, "wach werden"
<strong> Durchführung der Übung </strong>
In der heutigen Einheit befassen wir uns mit zwei Übungen(Arm und Gesicht), in der kommenden Woche folgen weitere Übungen für Nacken, Schultern, Rumpf und Beine.
Ausgangsstellung ist „gemütlicher“ Sitz im Bürostuhl oder die Kutscherstellung mit auf den Oberschenkeln abgestützten Unterarmen.
<strong> Erster Arm(i. d. R. rechts) </strong>
<ul>
	<li> Hand zur Faust schließen, Unterarm gegen den Oberschenkel drücken, Bizeps anspannen, oder:
Faust ballen, Unterarm stark anwinkeln und Hände nach innen drehen </li>
	<li> Sieben bis zehn Sekunden anspannen </li>
	<li> 30 - 40 Sekunden Pause mit "Hineindenken" in die angespannte Muskulatur, Wahrnehmung, Konzentration auf die Entspannung in Hand und Arm.</li>
</ul>
Dann diese Übung mit dem zweiten Arm wiederholen.
<strong> Gesicht</strong>
<ul>
	<li> Zähne zusammenbeißen, Lippen aufeinanderpressen, Zunge gegen den Gaumen pressen, Augen zusammenkneifen, Stirn runzeln, kurz: eine Grimasse schneiden.</li>
	<li> Sieben bis zehn Sekunden anspannen.</li>
	<li> 30 - 40 Sekunden Pause mit "Hineindenken" in die angespannte Muskulatur, Kon - zentration auf die Entspannung im Gesicht.</li>
</ul>
EOT
        );
        $manager->persist($item2039);


        $item2043 = new Weeklytask();
        $item2043->setFormat("richhtml");
        $item2043->setWeekId(40);
        $item2043->setQuiz($this->getReference('weeklyquiz_40'));
        $item2043->setCountPoint(1);
        $item2043->setName("Wochenaufgabe 40");
        $item2043->setContent(<<<EOT
<em> Vergangene Woche haben wir zwei Übungen aus der Progressiven Muskelentspannung kennengelernt. Heute zeigen wir Ihnen drei weitere Übungen für Schultern, Rumpf und Beine.</em><em></em>
<h1> Eine kurze Wiederholung </h1>
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa39.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa39-300x197.png" alt = "wa39" width = "300" height = "197" class="alignright wp-image-2041 size-medium" /></a> Muskuläre Verspannungen, egal durch was hervorgerufen, können oft mit der "Progressiven Muskelentspannung" verringert oder beseitigt werden. PMR geht von der Tatsache aus, dass ein Muskel nach einer längeren Anspannung ermüdet und sich automatisch entspannt und erholt. Ziel ist es, zu lernen, Spannungszustände in der Muskulatur zu lokalisieren und diese eigenständig durch bewusstes Entspannen zu beheben.
<strong> Wie geht dies konkret ?</strong>
<strong></strong> 1. Anspannungsphase insgesamt: ca. zehn Sekunden
    <ul>
	<li> langsames, gleichmäßiges Anspannen der Muskeln mit kontinuierlicher Steigerung bis zur maximalen Anspannung(ca. 3 – 5 Sekunden)</li>
	<li> Halten der maximalen Anspannung ca. fünf bis sieben Sekunden </li>
	<li> Normal weiteratmen, keine Pressatmung </li>
	<li> Bei Armen und Beinen mit der dominanten Seite(Sprungbein, Rechtshänder rechte Hand) beginnen </li>
</ul>
2. Entspannungsphase: ca. 30 - 40 Sekunden.
<ul>
	<li> Entspannen der Muskeln und Wahrnehmen der Entspannung </li>
	<li> Möglichst die Augen schließen </li>
</ul>
3. Nach der Übungssequenz(siehe unten) die Entspannung wieder zurücknehmen, "wach werden"
<h1> Übungsteil II </h1>
<strong> Durchführung der Übung </strong>
Ausgangsstellung ist „gemütlicher“ Sitz im Bürostuhl oder die Kutscherstellung mit auf den Oberschenkeln abgestützten Unterarmen.
<strong> Nacken und Hals </strong>
<ul>
	<li> Kinn leicht Richtung Brust ziehen, Kopf nach oben schieben, Nacken anspannen.</li>
	<li> Sieben bis zehn Sekunden anspannen.</li>
	<li> 30 - 40 Sekunden Pause mit "Hineindenken" in die angespannte Muskulatur, Wahrnehmung, Konzentration auf die Entspannung in Hals und Nacken </li>
</ul>
<strong> Schultern und Rumpf </strong>
<ul>
	<li> Schulterblätter zurückziehen, Bauch ganz hart machen und einziehen, Gesäß zusammenkneifen.</li>
	<li> Sieben bis zehn Sekunden anspannen.</li>
	<li> 30 - 40 Sekunden Pause mit "Hineindenken" in die angespannte Muskulatur, Wahrnehmung, Konzentration auf die Entspannung in Schulter und Rumpf </li>
</ul>
<strong> Beinmuskeln(dominantes Bein)</strong>
<ul>
	<li> Wadenmuskel und Oberschenkelmuskeln anspannen, dabei Ferse heben.</li>
	<li> Sieben bis zehn Sekunden anspannen.</li>
	<li> 30 - 40 Sekunden Pause mit "Hineindenken" in die angespannte Muskulatur, Konzentration auf die Entspannung im Bein.</li>
</ul>
Diese Übung mit dem zweiten Bein wiederholen.
Vielen Dank und viel Spaß beim Ausprobieren!
EOT
        );
        $manager->persist($item2043);


        $item2045 = new Weeklytask();
        $item2045->setFormat("richhtml");
        $item2045->setWeekId(41);
        $item2045->setCountPoint(1);
        $item2045->setName("Wochenaufgabe 41");
        $item2045->setContent(<<<EOT
<em> In den letzten Einheiten ging es um die Muskelentspannung. Heute beschäftigen wir uns mit dem Gegenteil, nämlich um Stress und Verspannungen.</em>
<strong> Was ist eigentlich Stress ?</strong>
Stress(engl. = Druck, Anspannung) ist eine natürliche Anpassung des Körpers auf eine bedrohliche Situation. Der menschliche Körper ist für Stress - Situationen, wie z. B. einen Angriff, ausgelegt, benötigt aber auch Entspannungsphasen, um das aufgebaute Stresslevel wieder abzubauen. Die Wissenschaft spricht beim Anspannungszustand vom <em>Sympathicus </em> und beim Entspannungszustand vom <em>Parasympathicus </em>.
<strong> Was passiert bei Stress ?</strong>
Eine Stress - Situation aus der Urzeit könnte z. B. ein Angriff sein und der Mensch muss innerhalb kürzester Zeit entscheiden, ob er flieht oder kämpft(fight -or-flight). In einer akuten Stresssituation(z. B. dem Moment eines Angriffs) wird Adrenalin ausgeschüttet. Der Körper wird dadurch in Alarmbereitschaft versetzt und leistungsfähiger: Das Gehirn wird stärker durchblutet, das Herz schlägt schneller, die Atmung geht schneller, die Muskelanspannung wird erhöht und stärker durchblutet, um sofort reagieren zu können, die Verdauung wird weitestgehend eingestellt, um Blut und Energie für die lebenswichtigen Vorgänge bereitzustellen.
Während in der Urzeit dieser Energieschub für die Reaktion fliehen oder kämpfen genutzt wurde, kann man in der heutigen Zeit bei – wenn auch nicht lebensgefährdenden – Stresssituationen im privaten oder beruflichen Umfeld weder Angreifen noch Fliehen. Wenn der Stress dann nicht auf andere Art und Weise abgebaut wird, wie z. B. durch Sport, gezielte Entspannung oder ähnliches, kommt es zu einem latenten Dauerstress für den Körper. Dieser hat zahlreiche negative Auswirkungen auf den Körper, z. B.:
<ul>
	<li> Ständiger Anspannungszustand führt zu Herz - Kreislauf - Erkrankungen </li>
	<li> Erhöhter Zuckerspiegel erzeugt Leber - und andere Organerkrankungen </li>
	<li> Erhöhter Cholesterinspiegel erhöht das Schlaganfallrisiko </li>
	<li><strong> Erhöhte Muskelanspannung ist für Verspannungen, Haltungs - und Gelenksschäden, Spannungskopfschmerz verantwortlich </strong></li>
	<li> Chronische Stressbelastung führt zu Erschöpfung und Leistungsverlust </li>
</ul>
Wir wollen uns in dieser Einheit mit der Erhöhung der Muskelanspannung beschäftigen, denn jeder kennt das Problem eines verspannten Nackens.
Stress und ein verspannter Nacken treten meist gemeinsam auf. Achten Sie einmal darauf, wie sich Ihr Körper in einer stressigen Situation - zu Hause oder im Beruf - verändert. Dies kann ein Streit sein, eine negatives Kundentelefonat, das(positive oder negative) Jahresgespräch mit dem Vorgesetzten oder einfach eine hohe Arbeitsbelastung sein. Wie oben ausgeführt, versetzt der Körper die Muskeln in Alarmbereitschaft und in einen Anspannungszustand. Sie können förmlich spüren, wie sich die Nackenmuskulatur in diesen Situationen anspannt.
<a href = "http://online-rueckenschule.de/wp-content/uploads/WA-41.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/WA-41-300x200.png" alt = "WA 41" width = "300" height = "200" class="alignright wp-image-2122 size-medium" /></a> Diese Anspannung kann schnell zu einer Verspannung, Haltungsschäden oder Kopfschmerzen führen. Versuchen Sie also, die anspannende Situation zu lösen und Ihren Nacken ganz bewusst zu entspannen. Wiederholen Sie an dieser Stelle bitte die vergangene Einheit zur Verspannung und wie Sie Abhilfe verschaffen können. Lassen Sie die Schultern fallen und lockern Sie die Anspannung z. B. mit einer Übung wie Schulternkreisen oder führen Sie eine Progressive Muskelentspannung durch, wie in den letzten beiden Einheiten vorgestellt. Richten Sie sich regelmäßig auf, um den Körper nicht zusätzlich mit einer Fehlhaltung zu belasten, denn gerade bei Stress achtet man selten auf die Körperhaltung und verstärkt dadurch noch die Anspannung.
Wiederholen Sie dafür noch einmal die Wochenaufgaben 7 und 8 zum aufrecht Sitzen und Stehen.
EOT
        );
        $manager->persist($item2045);


        $item2047 = new Weeklytask();
        $item2047->setFormat("richhtml");
        $item2047->setWeekId(42);
        $item2047->setCountPoint(1);
        $item2047->setName("Wochenaufgabe 42");
        $item2047->setContent(<<<EOT
<em> In der vergangen Einheit war vom Sympathicus und Parasympathicus – dem Anspannungs - und Entspannungszustand die Rede. Außerdem ging es um Muskelverspannungen als Folge stressbedingter Anspannung. Heute wollen wir einen Blick auf Stressmuster und Stressauslöser werfen.</em>
<strong> Kein Leben ohne Stress - und ohne Stress kein Leben. </strong>
Akute Belastungen sind zunächst gesund, denn nur durch innere Anstrengung ist innere Befriedigung möglich. Ein gesunder Körper braucht den Wechsel zwischen Be - und Entlastung, es ist dann auch die Rede von Eustress(=anregend). Erst die Dosis macht das Gift: Denn wenn eine Stress - Situation länger anhält gehen die Vorteile verloren. So ist es vermehrt in unserem Alltag, da wir dem Stress nicht oft genug ausweichen(können) und für Ausgleichsphasen sorgen. Es ist dann die Rede von Disstress(=zerstörend).
<strong> Das Stressmuster </strong>
Eine Stress - Situation kann in drei Phasen(Stressmuster) unterteilt werden:
<strong> 1.       </strong><strong> Alarmreaktion</strong>
Der Körper reagiert mit Anpassungen, wie Adrenalinausschüttung, erweiterte Pupillen etc. auf eine akute Gefahrensituation, z. B. einen Angriff(vgl. vergangene Einheit)
<strong> 2.       </strong><strong> Widerstandsphase</strong>
In dieser Phase erreicht die Anpassungsleistung ihr Optimum. Bei länger andauernden Stressreaktionen kommt es zu einer Gegensteuerung mithilfe des Parasympathikus. Die aktivierende Wirkung des Sympathikus wird dadurch abgeschwächt.
<strong> 3.       </strong><strong> Erschöpfungsphase</strong>
Dauert der Stressreiz weiterhin an, kommt es in der Erschöpfungsphase zu Energiebereitstellungsproblemen, mit negativen Folgen wie z. B. psychosomatischen Störungen, Herzkrankheiten, Allergien, schlechte Immunabwehr etc.
<a href = "http://online-rueckenschule.de/wp-content/uploads/wa42.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/wa42.png" alt = "wa42" width = "494" height = "189" class="alignnone wp-image-2048 size-full" /></a>
<strong> Durch was wird Stress ausgelöst ? </strong>
Das ist von Mensch zu Mensch unterschiedlich. Den Einen stresst es, im Stau zu stehen, den Anderen stresst laute Musik oder die Stimme des neuen Kollegen. Grundsätzlich kann zwischen körperlichen und psychischen Stressoren unterschieden werden.
<strong> Körperliche Stressauslöser sind z. B.</strong>
<ul>
	<li> Körperliche Verfassung(Unwohlsein,…)</li>
	<li> Hitze, Lärm, Vibration, Licht, Dunkelheit </li>
	<li> Krankheiten und Schmerzen </li>
	<li> Schlafentzug</li>
	<li> Medikamente, Drogen </li>
</ul>
<strong> Psychische Stressauslöser sind z. B.</strong>
<ul>
	<li> Verantwortung, insbesondere für Menschen </li>
	<li> neue und unbekannte Situationen </li>
	<li> Reisen, Termindruck </li>
	<li> Aufregung, Gefahr, Angst, Sorgen, Verunsicherung </li>
	<li> soziale Faktoren wie Konflikte mit anderen Menschen </li>
</ul>
Wie Sie sehen gibt es ganz schön viele Ursachen für Stress. Nicht alle kann man beeinflussen, man kann aber die eigene Reaktion auf Stressreize verändern. Mehr dazu in den kommenden Einheiten.
EOT
        );
        $manager->persist($item2047);


        $item2054 = new Weeklytask();
        $item2054->setFormat("richhtml");
        $item2054->setWeekId(43);
        $item2054->setCountPoint(1);
        $item2054->setName("Wochenaufgabe 43");
        $item2054->setContent(<<<EOT
<em>In der vergangen Einheit haben wir die Stressphasen und typische Auswirkungen von Stress betrachtet. Heute wollen wir einen Blick auf die Folgen von Dauerstress werfen.</em>
    Unser Organismus reagiert auch heute noch nach dem uralten Schema, wie es sich in Jahrmillionen entwickelt hat. Denken wir zurück an die Stressreaktion in der Urzeit: Ein Mensch wird angegriffen und muss in kürzester Zeit entscheiden, ob er flieht oder kämpft. Der Körper stellt in einer Stress - Situation viel Energie bereit(vgl. Einheit 41), die in der Urzeit durch körperliche Aktivität(fliehen oder kämpfen) genutzt wurde. Dies ist heute jedoch nicht mehr möglich.
    Wir greifen einen Kunden, der uns am Telefon unter Druck gesetzt hat, nicht an. Wir könnten nach dem Telefonat um das Bürogebäude rennen, das wäre hilfreich – wir tun es aber nicht. Trotz der vorbereiteten Höchstleistung verharren unsere Körper meist völlig bewegungslos. Auf Dauer mit fatalen Folgen. Denn die vom Körper bereitgestellte Energie wird nicht verbraucht, z. B. durch Bewegung, sondern die Fettsäuren werden in Cholesterin umgewandelt und in die Gefäßwände eingebaut. Durch die Verschiebung des Hormonhaushaltes entstehen Störungen im vegetativen System, usw. Da die bio - chemischen Zusammenhänge kompliziert sind, möchten wir an dieser Stelle nur auf die greifbaren Folgen von Dauerstress eingehen:
<strong> Körperliche Folgen </strong>
<ul>
	<li> Verspannungen, Rückenschmerzen(vgl. Einheit 41), Kopfschmerzen, Migräne </li>
	<li> Sodbrennen, Magenbeschwerden </li>
	<li> Ohrensausen, Tinitus </li>
	<li> Herz - Kreislauferkrankungen</li>
	<li> Verdauungsbeschwerden</li>
	<li> Allergien, Hautausschlag </li>
</ul>
<strong> Seelische Folgen </strong>
<ul>
	<li> Innere Unruhe </li>
	<li> schlechte Laune, Reizbarkeit, Aggressivität </li>
	<li> Ärger und Wut </li>
	<li> Angst</li>
	<li> sinkende Belastbarkeit </li>
</ul>
    Was können wir also tun, um uns vor diesen Folgen zu schützen, wenn wir die Stress - Situationen nicht komplett ausschalten können ? Mehr dazu in der kommenden Einheit.
EOT
        );
        $manager->persist($item2054);


        $item2056 = new Weeklytask();
        $item2056->setFormat("richhtml");
        $item2056->setWeekId(44);
        $item2056->setCountPoint(1);
        $item2056->setName("Wochenaufgabe 44");
        $item2056->setContent(<<<EOT
<em> In der vergangen Einheit haben wir die körperlichen Folgen von Dauerstress betrachtet. Heute geht es darum, wie wir diese negativen Folgen verhindern können.</em>
Stress wird sehr unterschiedlich empfunden. Um eine Stress - Situation dauerhaft zu lösen, muss bei der Ursache angesetzt werden. Da das nicht immer möglich ist, möchten wir hier ein paar Möglichkeiten bei akutem Stress aufzeigen. Nicht alle Tipps helfen jedem, suchen Sie sich aus, was Sie anspricht:
<strong style = "font - size: 13px"> 1.       </strong><strong style = "font - size: 13px"> Bewegung</strong>
Der beste Weg aus der Stressfalle ist immer noch Bewegung. Negative Energie wird bei Bewegung mit sofortiger Wirkung abgebaut. Probieren Sie es einmal aus und gehen Sie nach einem „schlechten“ Tag Joggen oder Spazieren.
<strong style = "font - size: 13px"> 2.       </strong><strong style = "font - size: 13px"> Reden</strong>
Wenn man einen guten Zuhörer hat, kann man sich den Stress auch von der Seele reden.
<strong style = "font - size: 13px"> 3.       </strong><strong style = "font - size: 13px"> Lachen</strong>
Beim Lachen werden nicht nur Glückshormone freigesetzt, sondern lachen hemmt auch die Produktion der Stresshormone Adrenalin und Cortisol. Gleichzeitig sorgt lachen für eine bessere Sauerstoffzufuhr.
<strong style = "font - size: 13px"> 4.       </strong><strong style = "font - size: 13px"> Abschalten</strong>
Gönnen Sie sich Ruhe. Kein Handy, kein Fernseher, vielleicht ein gutes Buch lesen oder einfach nur im Sessel vor dem Kamin sitzen, in die Sauna gehen oder ein Vollbad nehmen. Oder wenden Sie die Progressive Muskelentspannung aus Einheit 39, 40 an.
<strong style = "font - size: 13px"> 5.       </strong><strong style = "font - size: 13px"> Pausen</strong>
Regelmäßige Pausen bei der Arbeit sind keine Faulenzerei sondern steigern nachweislich die Produktivität und Ihre Gesundheit. Stehen Sie auf, gehen Sie ein paar Schritte, machen Sie eine Bewegungseinheit mit der Online - Rückenschule und arbeiten Sie entspannt weiter.
<strong style = "font - size: 13px"> 6.       </strong><strong style = "font - size: 13px"> Essen</strong>
Stress entzieht dem Körper Vitamine und Mineralstoffe. Greifen Sie in Stress - Situationen vor allem zu frischem Obst, Vollkornprodukten und Gemüse statt zu Schokolade.
<strong style = "font - size: 13px"> 7.       </strong><strong style = "font - size: 13px"> Wasser</strong>
Wasser ist das Elixier gegen Stress, weil es das Nervensystem überlistet. Trinken Sie ein Glas Wasser – so schnell wie möglich. Durch das Schlucken wird der Parasympathikus, der Nerv für Ihre Entspannung, angeregt und die Anspannung lässt merklich nach.
<strong style = "font - size: 13px"> 8.       </strong><strong style = "font - size: 13px"> Atmen</strong>
Ist man gestresst, geht der Atem hastig und flach – der Körper bekommt zu wenig Sauerstoff. Atmen Sie in Stress - Situationen deshalb ganz bewusst tief und konzentrieren Sie sich auf die Atmung. Wiederholen Sie die Einheiten 9 - 14 zur Atmung inkl. Übungen.
<em> Wie geht es weiter ? Nächste Woche zeigen wir Ihnen Akupressur - Punkte mit denen Sie Ihr Stresslevel reduzieren und Verspannungen lösen können.</em>
EOT
        );
        $manager->persist($item2056);


        $item2058 = new Weeklytask();
        $item2058->setFormat("richhtml");
        $item2058->setWeekId(45);
        $item2058->setCountPoint(1);
        $item2058->setName("Wochenaufgabe 45");
        $item2058->setContent(<<<EOT
Hatten Sie im Laufe der vergangenen Woche eine oder mehrere akute Stresssituation(en) ? Wenn nicht, freuen wir uns für Sie, wenn doch, hoffen wir, dass Sie sich die vergangene Einheit zur Hand genommen und sich eine Sofortmaßnahme ausgesucht haben. Haben Sie vielleicht gezielt Sport getrieben oder die die Progressive Muskelentspannung(Einheit 39, 40) angewandt ?
Heute werfen wir einen Blick auf eine Methode bei Stress: Akupressur. Wir erklären die heilende Wirkung und zeigen beispielhaft die Anwendung.
<strong> Was ist Akupressur ?</strong>
Die Akupressur ist eine alte Heilkunst aus der traditionellen chinesischen Medizin, bei der man mit den Fingern bestimmte Punkte(sog. Energie - oder Akupressurpunkte) auf der Hautoberfläche drückt, um natürliche Selbstheilungskräfte des Körpers anzuregen. Ziel der Akupressur ist die Linderung von Schmerzen und Beschwerden, bevor sich eine Krankheit entwickelt. Die Akupressur ist eine der wirksamsten Methoden der Selbstbehandlung bei spannungsbedingten Beschwerden. Der große Vorteil ist, dass man eine Akupressur gefahrlos an sich selbst oder jemand anderen praktizieren kann, selbst wenn man noch keine Erfahrung darin hat. Da es keine negativen Auswirkungen gibt, kann man im schlimmsten Fall den Akuppressurpunkt verfehlen und nichts passiert. Wird der Punkt getroffen, werden Endorphine ausgeschüttet, die den Schmerz blockieren und den betroffenen Bereich besser mit Blut und Sauerstoff versorgt.
<strong> Wie finde ich die Akupressurpunkte ?</strong>
Es gibt mehrere Hundert Akupressurpunkte im menschlichen Körper, die alle entlang der Meridiane verlaufen. Unter Meridiane werden Kanäle verstanden, durch die elektrische Energie durch den Körper fließt und die Punkte untereinander sowie mit den inneren Organen verbindet. Das Auffinden der Punkte wird für Laien durch markante Körperstellen beschrieben. Trifft man einen Punkt, fühlt man es, denn der leichte Druckschmerz fühlt sich etwas anders an als bei anderen Punkten.
<strong> Wie wird eine Akupressur durchgeführt ?</strong>
Es existieren unterschiedliche Techniken, wie massieren, drücken, klopfen, reiben oder kneten, wobei <strong>massieren </strong> und <strong> drücken</strong> die einfachsten Formen darstellen. Wenn Sie einen Punkt identifiziert haben, bitte den Druck langsam aufbauen und 2 - 3 Minuten halten bzw. 2 - 3 Minuten massieren.
<strong> Beispiele für Akupressur bei Stress</strong>
<em> Akupressur an der Hand </em>
Strecken Sie Ihre Hand so, dass Sie gut an die Stelle zwischen Daumen und Zeigefinger kommen. Tasten Sie mit Daumen und Zeigefinger der anderen Hand, wie mit einer Zange, das weiche Gewebe in diesem Winkel ab. Spüren Sie eine empfindlichere Stelle ? Hier sind Sie richtig.
Sie befindet sich fast schon dort, wo die Fingerknochen an der Handwurzel zusammenkommen. Pressen Sie den Punkt für ungefähr zehn Sekunden kräftig zusammen. Lassen Sie dann für dieselbe Zeit wieder locker. Wiederholen Sie den Durchgang ca. dreimal und widmen Sie sich anschließend Ihrer anderen Hand. Dieser Punkt wirkt nicht nur gegen Stress, sondern stärkt gleichzeitig Ihre Immunabwehr.
<em> Akupressur am Kopf </em>
Ein weiterer Akupressurpunkt befindet sich am Hinterkopf. Sie können diesen Punkt massieren oder drücken und damit Stress, Nacken - und Kopfschmerzen verbessern. Schauen Sie sich unser Video dazu an:
<a href = "http://online-rueckenschule.de/mitgliederbereich/uebungen/augen-entspannung/akupressur-hinterkopf/" target = "_blank"> Link zum Video </a>
<em> Akupressur mit einem Golfball </em>
Um generell Stress abzubauen, gibt es den äußerst wirksamen Akupressur - Punkt Fuss. Das Hin - und - Her - Rollen des Fußes über einen Golfball kann Wunder wirken, denn auf diese Weise werden fast alle Akupressurpunkte des Fußes beansprucht.
<strong> Aufgabe: Wenden Sie eine Akupressurübung an und erfahren Sie die wohltuende Wirkung.</strong><strong> Wie geht´s weiter ? Nächste Woche zeigen wir Ihnen weitere Akupressurpunkte und eine Übersicht...</strong>
EOT
        );
        $manager->persist($item2058);

        $item2060 = new Weeklytask();
        $item2060->setFormat("richhtml");
        $item2060->setWeekId(46);
        $item2060->setCountPoint(1);
        $item2060->setName("Wochenaufgabe 46");
        $item2060->setContent(<<<EOT
<em> In den vergangenen Wochen haben Sie bereits Akupressur an sich selbst ausprobiert und haben sich mit dieser Thematik beschäftigt. Heute zeigen wir Ihnen eine letzte Anwendung mit der Sie relativ einen positiven Stimmungswechsel erzeugen können. Kurz: Akupressur gegen schlechte Laune.</em>
<strong> Akupressur der Fingerspitzen </strong>
Mit der Akupressur der Fingerspitzen kann man relativ schnell einen Stimmungswechsel erzeugen, was bei Stress sehr hilfreich sein kann. Die Anwendung ist sehr einfach und lässt sich überall durchführen: Mit dem Daumen einer Hand pressen Sie kurz die Fingerkuppen der anderen Hand. Wechseln Sie die Hände und wiederholen Sie die Sequenz etwa fünfmal.
<strong> Abschließend...</strong>
Aufgrund der Komplexität und der Vielzahl an Möglichkeiten können wir Ihnen im Rahmen dieser Einheiten nur einen kleinen Einblick geben. Vielleicht finden Sie Geschmack daran und beschäftigen sich eingehender damit. Schauen Sie sich auch gerne die beiden externen Links unten dazu an.
Eine Übersicht zu Akupressurpunkten aufgeteilt nach Beschwerden vom Eva Marbach Verlag finden Sie hier: <a href = "http://akupressurpunkte-liste.de/liste/index.htm" target = "_blank"> http://akupressurpunkte-liste.de/liste/index.htm</a>
Eine schöne Übersicht zu den unterschiedlichen Meridianen existiert  hier: <a href = "http://www.akupressur-punkte.de/12_meridiane_akupressurpunkte.html" target = "_blank"> http://www.akupressur-punkte.de/12_meridiane_akupressurpunkte.html</a>
<strong> Aufgabe: Wenden Sie die Akupressur der Fingerspitzen gezielt an, wenn Sie einmal schlecht gelaunt sind oder Ihre Stimmung generell aufheitern wollen.</strong>
EOT
        );
        $manager->persist($item2060);


        $item2066 = new Weeklytask();
        $item2066->setFormat("richhtml");
        $item2066->setWeekId(47);
        $item2066->setCountPoint(1);
        $item2066->setName("Wochenaufgabe 47");
        $item2066->setContent(<<<EOT
<em> Wir haben bereits verschiedene körperliche Symptome betrachtet, die durch Stress verursacht werden und uns zudem angeschaut, mit welchen Sofortmaßnahmen man dem entgegen wirken kann. In den kommenden Einheiten werfen wir einen Blick auf unsere Augen und die Auswirkungen von Stress auf das Sehen.</em>
<strong> Warum strengt Bildschirmarbeit die Augen an ?</strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/WA-47.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/WA-47.png" alt = "WA 47" width = "254" height = "228" class="alignright wp-image-2124 size-full" /></a> Ursprünglich ist das Sehen in der Nähe an den Entspannungszustand des vegetativen Nervensystems gekoppelt(vgl. <a href = "http://online-rueckenschule.de/mitgliederbereich/wochenaufgaben/wochenaufgabe-41/" target = "_blank"> Wochenaufgabe 41 </a>).
Bildschirmarbeit zwingt den Menschen oft durch statische  Körperhaltung und starre Blickposition in eine unbewegte und damit nicht entspannte Haltung. Zeitdruck oder hohe nervliche Beanspruchung verursachen Anspannungen, der Körper reagiert mit Stressphänomenen, d. h. Hormonausschüttungen, Veränderung von Herzschlag und Atmung.
Bei der Arbeit am Bildschirm sind die Augenlinse und die Augenmuskeln über lange Zeit auf einen kleinen Raum und eine gleiche Entfernung fixiert. Lidschläge erfolgen nicht mehr so häufig, dadurch werden die Sauerstoffversorgung und der Stoffwechsel des Auges reduziert. Die Augenlinse, zuständig für die Scharfeinstellung, verkrampft und verhärtet. Lesebrillen werden früher erforderlich.
Klassisches räumliches Sehen bedeutet, dass die Seheindrücke von rechtem und linkem Augen im Gehirn zu einem Bild fusioniert werden. Die Zweidimensionalität des Bildschirms erfordert nicht unbedingt räumliches Sehen und die Augen stellen sich darauf ein. Häufig übernimmt dann nur ein Auge die anstrengenden Sehaufgaben in der Nähe.
Gute Koordination der Augen und abwechslungsreiches, entspanntes  Sehen sind eine Voraussetzungen für  langanhaltende Konzentration und Erhalt der Arbeitsfähigkeit am Bildschirm. Nutzen Sie daher unsere Augenübungen, vor allem die folgende Übung: <a href = "http://online-rueckenschule.de/mitgliederbereich/uebungen/augen-entspannung/augenbewegung/" target = "_blank"> Link zur Übung </a>
<strong> Bitte vergessen Sie den heutigen Reminder nicht und investieren Sie einige Minuten in Ihre Augengesundheit. Vielen Dank!</strong>
Interesse geweckt ? Mehr dazu finden Sie auf unserer ganzheitlichen Gesundheits - Plattform <a href = "http://www.fitbase.de/"> www. fitbase. de</a>. Hier finden Sie z. B. ein interaktives Sehtraining…
EOT
        );
        $manager->persist($item2066);


        $item2069 = new Weeklytask();
        $item2069->setFormat("richhtml");
        $item2069->setWeekId(48);
        $item2069->setCountPoint(1);
        $item2069->setName("Wochenaufgabe 48");
        $item2069->setContent(<<<EOT
<em> Die heutige Wochenaufgabe beschäftigt sich mit dem Zusammenhang von Stress und Sehen, erklärt wie trockene und müde Augen enstehen und wie Sie sie vermeiden.</em><strong></strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/WA-48.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/WA-48-300x198.png" alt = "WA 48" width = "300" height = "198" class="alignright wp-image-2126 size-medium" /></a><a href = "http://www.officephysio.de/memberarea/weeklytask/weeklytask48/augen/" rel = "attachment wp-att-5989"></a> Die meisten inneren Vorgänge des Körpers werden vom vegetativen, nicht willentlich beeinflussbaren, Nervensystem gesteuert. Ursprünglich gepolt als Kampf - und Fluchtmuster reagiert der Körper blitzschnell auf wahrgenommene Bedrohungen durch Ausschüttung von Hormonen und bestimmten Körperreaktionen(vgl. Wochenaufgaben 41 - 43).
Man unterscheidet zwischen <strong>Sympathikus </strong>, dem Anspannungszustand  und <strong>Parasympathikus </strong>, dem Entspannungszustand, die als Gegenspieler fungieren. Auch das Sehen in Ferne und Nähe ist abhängig von den Zuständen des Nervensystems(vgl. kommende Einheit).
Normalerweise ist das Sehen in der Nähe mit Entspannung verbunden, die Atmung wird ruhiger, weniger Adrenalin wird produziert und die Tränenproduktion steigt. Wenn wir nun aber angespannt vor dem Computer sitzen wird der Sympathikus aktiviert und aus dem Ruhezustand wird ein Anspannungszustand: die Augen bewegen sich wenig, mehr Adrenalin wird freigesetzt und es werden kaum Tränen produziert. Das führt zu trockenen und müden Augen.
Folgende Tabelle zeigt eine Auswahl der Zusammenhänge:
<a href = "http://online-rueckenschule.de/wp-content/uploads/WA-48-Tabelle.png"><img src = "http://online-rueckenschule.de/wp-content/uploads/WA-48-Tabelle.png" alt = "WA 48 Tabelle" width = "509" height = "375" class="alignleft wp-image-2127 size-full" /></a>
<strong>
Bitte vergessen Sie den heutigen Reminder nicht und investieren Sie wenige Minuten in Ihre Augengesundheit. Vielen Dank!</strong> Um diesem Effekt entgegenzuwirken, empfiehlt es sich, zwischendurch eine Entspannungsübung durchzuführen, den starren Blick auf den Bildschirm zu unterbrechen und bewusst zu blinzeln.
<em> Wie geht es weiter ? Wir vertiefen die Thematik und stellen einen Zusammenhang zwischen Stress und Sehen her…</em>
EOT
        );
        $manager->persist($item2069);


        $item2071 = new Weeklytask();
        $item2071->setFormat("richhtml");
        $item2071->setWeekId(49);
        $item2071->setCountPoint(1);
        $item2071->setName("Wochenaufgabe 49");
        $item2071->setContent(<<<EOT
Herzlich Willkommen zur 49. Wochenaufgabe, die sich erneut mit dem Zusammenhang von Sehen und Stress beschäftigt und der Frage auf den Grund geht, warum man bei Stress schlechter sieht.
<span style = "color: #808080"> Eine kurze Wiederholung: Im vegetativen Nervensystem sprechen wir von zwei gegensätzlichen Funktionen:  </span>
<strong> 1. sympathisches Nervensystem für Aktivität und Leistung </strong>
<strong> 2. parasympathisches Nervensystem für Erholung, Entspannung und Energieaufbau. </strong>
Beide Systeme sind im Normalzustand in einer natürlichen Balance, d. h. der Sympathikus wird durch den Parasympathikus abgelöst und umgekehrt.
Bei Stress ist diese Balance gestört: So bewirkt das <strong>sympathische Nervensystem </strong> -neben vielen weiteren Auswirkungen wie Adrenalinausschüttung, Muskelanspannung, Steigerung des Herzschlages etc. -eine Erweiterung der Pupillen. Dadurch wird mehr Licht durchgelassen, die Augen sind lichtempfindlicher gleichzeitig schränkt sich aber das Gesichtsfeld ein.
Das <strong>sympathische </strong> <strong>  Nervensystem </strong> steuert<strong> </strong> die Scharfeinstellung der Augenlinse auf Entfernungen, dabei kommt es zu einer Abflachung der Augenlinsen in der Ferne. Vor allem Objekte ab 6 Meter Entfernung werden dann besonders gut wahrgenommen – also in der Entfernung, in der während der menschlichen Entwicklung akute Gefahr z. B. in Form eines Angreifers erschienen ist.
In einer Entspannungsphase bewirkt das <strong>parasympathische Nervensystem </strong> eine Krümmung der Augenlinsen, was eine verbesserte Nahsicht ermöglicht.
Das Problem ist, dass wir heutzutage visuellen Stress fast ausschließlich in der Nähe erleben, nämlich auf dem Bildschirm oder im Gesprächspartner gegenüber und kaum in einer Entfernung ab 6 Metern, so wie es unser vegetatives Nervensystem nach Jahrtausenden der Entwicklung vorsieht.
Um es noch deutlicher zu machen: In einer akuten Stresssituation können wir schlecht Lesen, was auf dem Bildschirm steht, da der Körper die Augen so einstellt, dass sie Dinge in der Entfernung scharf sehen. Wir schauen aber meist nicht in die Ferne sondern auf den Bildschirm.
Folglich müssen wir in Stresssituationen die Augen mit Entspannungsübungen entlasten und den Stresspegel senken, um entspannt am Bildschirm weiter arbeiten zu können.
<strong> Augenbewegung</strong>
<a href = "http://online-rueckenschule.de/wp-content/uploads/augenbewegung.jpg"><img src = "http://online-rueckenschule.de/wp-content/uploads/augenbewegung.jpg" alt = "augenbewegung" width = "229" height = "231" class="alignright wp-image-1004 size-full" /></a><a href = "http://www.officephysio.de/memberarea/weeklytask/weeklytask49/augenbewegung/" rel = "attachment wp-att-6014"></a> Eine praktische Übung, die zur Anspannung und Entspannung der Augenmuskulatur führt erreichen Sie über folgenden Link: <a href = "http://www.officephysio.de/memberarea/exercises/eye-relaxation/eye-8/" target = "_blank"> Übung</a>
Zudem wird auch hier die Körpermitte überschritten, was zu einem besseren Zusammenspiel der beiden Gehirnhälften führt(vgl. Wochenaufgabe 19 - 23).
<strong> Bitte vergessen Sie den heutigen Reminder nicht und investieren Sie einige Minuten in Ihre Augengesundheit. Vielen Dank!</strong>
EOT
        );
        $manager->persist($item2071);

        $manager->flush();
    }

}
