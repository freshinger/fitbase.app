<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskSchmerzenData extends AbstractFixture implements OrderedFixtureInterface
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



        $item1952 = new Weeklytask();
        $item1952->setFormat("richhtml");
        $item1952->setTag("Schmerzen");
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
        $item1958->setTag("Schmerzen");
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
        $item1964->setTag("Schmerzen");
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
        $item1968->setTag("Schmerzen");
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
        $manager->flush();

    }

}
