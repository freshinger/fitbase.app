<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskGewohnheitenData extends AbstractFixture implements OrderedFixtureInterface
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

        $item1894 = new Weeklytask();
        $item1894->setFormat("richhtml");
        $item1894->setTag("Gewohnheiten");
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
        $item1897->setTag("Gewohnheiten");
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
        $item1906->setTag("Gewohnheiten");
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
        $manager->flush();

    }

}
