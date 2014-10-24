<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskNeuraleVerbindungenData extends AbstractFixture implements OrderedFixtureInterface
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


        $item1911 = new Weeklytask();
        $item1911->setFormat("richhtml");
        $item1911->setTag("Neuronale Verbindungen");
        $item1911->setCategory($this->getReference('category_ruecken'));
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
        $item1920->setTag("Neuronale Verbindungen");
        $item1920->setCategory($this->getReference('category_ruecken'));
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
        $item1925->setTag("Neuronale Verbindungen");
        $item1925->setCategory($this->getReference('category_ruecken'));
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
        $item1936->setTag("Neuronale Verbindungen");
        $item1936->setCategory($this->getReference('category_ruecken'));
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
        $item1940->setTag("Neuronale Verbindungen");
        $item1940->setCategory($this->getReference('category_ruecken'));
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
        $item1944->setTag("Neuronale Verbindungen");
        $item1944->setCategory($this->getReference('category_ruecken'));
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
        $manager->flush();

    }

}
