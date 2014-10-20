<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskBandscheibenData extends AbstractFixture implements OrderedFixtureInterface
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

        $item2002 = new Weeklytask();
        $item2002->setFormat("richhtml");
        $item2002->setTag("Bandscheiben");
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
        $item2008->setTag("Bandscheiben");
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
        $item2013->setTag("Bandscheiben");
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
        $item2024->setTag("Bandscheiben");
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
        $item2034->setTag("Bandscheiben");
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
        $manager->flush();

    }

}
