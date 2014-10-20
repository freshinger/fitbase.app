<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskArbeitsplatzergonomieData extends AbstractFixture implements OrderedFixtureInterface
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
        $item1644->setTag("Arbeitsplatzergonomie");
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
        $item1662->setTag("Arbeitsplatzergonomie");
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
        $item1672->setTag("Arbeitsplatzergonomie");
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
        $item1679->setTag("Arbeitsplatzergonomie");
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
        $item1684->setTag("Arbeitsplatzergonomie");
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
        $item1694->setTag("Arbeitsplatzergonomie");
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

        $manager->flush();

    }

}
