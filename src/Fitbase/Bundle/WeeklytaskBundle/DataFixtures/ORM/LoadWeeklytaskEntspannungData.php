<?php

namespace Fitbase\Bundle\WeeklytaskBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class LoadWeeklytaskEntspannungData extends AbstractFixture implements OrderedFixtureInterface
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

        $item2039 = new Weeklytask();
        $item2039->setFormat("richhtml");
        $item2039->setTag("Entspannung");
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
        $item2043->setTag("Entspannung");
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

        $manager->flush();
    }

}
