<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskNervenData extends AbstractFixture implements OrderedFixtureInterface
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


        $item1985 = new Weeklytask();
        $item1985->setFormat("richhtml");
        $item1985->setTag("Nerven");
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
        $item1990->setTag("Nerven");
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
        $item1996->setTag("Nerven");
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
        $item1999->setTag("Nerven");
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

    }

}
