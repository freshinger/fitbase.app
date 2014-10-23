<?php

namespace Fitbase\Bundle\ExerciseBundle\DataFixture\ORM;
;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 *
 */
class LoadRuecken4Data extends AbstractFixture implements OrderedFixtureInterface
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
        $manager->getClassMetaData(get_class(new Exercise()))->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $item556 = new Exercise();
        $item556->setName("Abduktion beidseits");
        $item556->setFormat("richhtml");
        $item556->setTag("Rücken");
        $item556->setImage($this->getReference('picture_556.jpeg'));
        $item556->setVideo($this->getReference('video_556.webm'));
        $item556->setGallery($this->getReference('picture_556'));
        $item556->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Abduktion beidseits</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie die Füße schulterbreit auf die Mitte des Thera-Bandes®</li>
	<li>Halten Sie mit jeder Hand ein Thera-Band® Ende seitlich am Körper, so dass es unter leichter Spannung steht</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Führen Sie die Arme seitlich nach oben bis zur Höhe des Halses</li>
	<li>Lassen Sie die Arme dabei gestreckt</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Oberarme</li>
	<li>Oberer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/04_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/04_oberarm.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item556);

        $item557 = new Exercise();
        $item557->setName("Außenrotation beidseits im Sitz");
        $item557->setFormat("richhtml");
        $item557->setTag("Rücken");
        $item557->setImage($this->getReference('picture_557.jpeg'));
        $item557->setVideo($this->getReference('video_557.webm'));
        $item557->setGallery($this->getReference('picture_557'));
        $item557->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Außenrotation beidseits im Sitz</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie die Füße schulterbreit auf</li>
	<li>Halten Sie die Ellbogen in einem 90° Winkel</li>
	<li>Fassen Sie das Thera-Band® schulterbreit unter leichter Spannung</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Öffnen Sie dann die Unterarme seitlich</li>
	<li>Die Ellbogen bleiben am Körper</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Oberarme</li>
	<li>Oberer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/04_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/04_oberarm.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item557);

        $item558 = new Exercise();
        $item558->setName("Außenrotation im Stand");
        $item558->setFormat("richhtml");
        $item558->setTag("Rücken");
        $item558->setImage($this->getReference('picture_558.jpeg'));
        $item558->setVideo($this->getReference('video_558.webm'));
        $item558->setGallery($this->getReference('picture_558'));
        $item558->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Außenrotation im Stand</h4>
Bitten führen Sie diese Übung im Stehen durch. Bitte legen Sie das Thera-Band® z.B. um ein Tischbein.
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Fassen Sie jeweils ein Ende des Thera-Bandes® und halten Sie die Arme leicht vor dem Körper</li>
	<li>Stehen Sie aufrecht und stellen Sie einen Fuß einen halben Schritt vor</li>
	<li>Das Thera-Band® ist leicht unter Spannung</li>
	<li>Führen Sie die Hände nun hinter Ihr Gesäß und drehen Sie dabei die Handflächen nach außen</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Oberer Rücken</li>
	<li>Mittlerer Rücken</li>
	<li>Oberarme</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/12_oberer_und_mittlerer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/12_oberer_und_mittlerer_ruecken.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/04_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/04_oberarm.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item558);

        $item559 = new Exercise();
        $item559->setName("Bizeps-Schultern");
        $item559->setFormat("richhtml");
        $item559->setTag("Rücken");
        $item559->setImage($this->getReference('picture_559.jpeg'));
        $item559->setVideo($this->getReference('video_559.webm'));
        $item559->setGallery($this->getReference('picture_559'));
        $item559->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Bizeps-Schultern</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stehen Sie schulterbreit auf der Mitte des Thera-Bandes®</li>
	<li>Fassen Sie die Enden des Thera-Bandes®, so dass es leicht gespannt ist, wenn Sie die Arme locker neben der Hüfte hängen lassen</li>
	<li>Führen Sie jetzt die Unterarme in eine 90° Beugung</li>
	<li>Anschließend den gesamten Arm bis zur Höhe des Scheitels heben</li>
	<li>langsam in umgekehrter Reihenfolge wieder zurück</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Oberarme</li>
	<li>Oberer Rücken</li>
	<li>Schultern</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/04_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/04_oberarm.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg" alt="" /></a>

</div>
</div>

CONTENT
        );
        $manager->persist($item559);

        $item560 = new Exercise();
        $item560->setName("Butterfly reverse");
        $item560->setFormat("richhtml");
        $item560->setTag("Rücken");
        $item560->setImage($this->getReference('picture_560.jpeg'));
        $item560->setVideo($this->getReference('video_560.webm'));
        $item560->setGallery($this->getReference('picture_560'));
        $item560->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Butterfly reverse</h4>
Bitte führen Sie diese Übung im Sitzen oder im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Fassen Sie das Thera-Band® schulterbreit mit fast ganz ausgestreckten Armen</li>
	<li>Das Thera-Band® ist unter leichter Spannung</li>
	<li>Ziehen Sie das Thera-Band® nun auseinander</li>
	<li>Anschließend langsam unter Spannung wieder zurück</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Oberarme</li>
	<li>Oberer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/04_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/04_oberarm.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item560);

        $item561 = new Exercise();
        $item561->setName("Crosstrainer Oberkörper");
        $item561->setFormat("richhtml");
        $item561->setTag("Rücken");
        $item561->setImage($this->getReference('picture_561.jpeg'));
        $item561->setVideo($this->getReference('video_561.webm'));
        $item561->setGallery($this->getReference('picture_561'));
        $item561->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Crosstrainer Oberkörper</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie ein Bein etwa einen halben Meter nach vorne auf die Mitte des Thera-Bandes®</li>
	<li>Halten Sie mit jeder Hand ein Thera-Band® Ende seitlich am Körper, so dass es unter leichter Spannung steht</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Führen Sie die Arme abwechselnd gerade nach vorne oben bis zur Höhe des Kopfes und wieder nach hinten unten</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">30 Sekunden</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Gesamter Rücken</li>
	<li>Ober- und Unterarme</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg"><img src="/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item561);

        $item562 = new Exercise();
        $item562->setName("Crosstrainer schnell");
        $item562->setFormat("richhtml");
        $item562->setTag("Rücken");
        $item562->setImage($this->getReference('picture_562.jpeg'));
        $item562->setVideo($this->getReference('video_562.webm'));
        $item562->setGallery($this->getReference('picture_562'));
        $item562->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Crosstrainer schnell</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie ein Bein etwa einen halben Meter nach hinten auf die Mitte des Thera-Bandes®</li>
	<li>Halten Sie mit jeder Hand ein Thera-Band® Ende seitlich am Körper, so dass es unter leichter Spannung steht</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Führen Sie die Arme abwechselnd mit kurzen schnellen Bewegungen gerade nach vorne ohne dass die Hände über die Höhe des Bauchnabels hinaus gehen</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">30 Sekunden</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Gesamter Rücken</li>
	<li>Ober- und Unterarme</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg"><img src="/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item562);

        $item563 = new Exercise();
        $item563->setName("Innenrotation im Stand");
        $item563->setFormat("richhtml");
        $item563->setTag("Rücken");
        $item563->setImage($this->getReference('picture_563.jpeg'));
        $item563->setVideo($this->getReference('video_563.webm'));
        $item563->setGallery($this->getReference('picture_563'));
        $item563->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Innenrotation im Stand</h4>
Bitten führen Sie diese Übung im Stehen durch. Bitte legen Sie das Thera-Band® z.B. um ein Tischbein.
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte befestigen Sie das Thera-Band® an einem geeigneten Gegenstand, z.B. einem Tischbein</li>
	<li>Für die rechte Seite: Fassen Sie das andere Ende mit der rechten Hand, so dass das Band leicht unter Spannung ist</li>
	<li>Stellen Sie sich seitlich zur Befestigung und bilden Sie nun einen rechten Winkel im Ellenbogen</li>
	<li>Stabilisieren Sie den Oberarm mit der linken Hand, so dass er am Oberkörper anliegt</li>
	<li>Führen Sie nun die Hand zum Bauch und langsam unter Spannung wieder zurück</li>
	<li>Entsprechend die andere Seite</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen je Seite</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Oberarme</li>
	<li>Brustmuskulatur</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/09_brust_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/09_brust_oberarm.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item563);

        $item564 = new Exercise();
        $item564->setName("Kleiner Ball – großer Ball");
        $item564->setFormat("richhtml");
        $item564->setTag("Rücken");
        $item564->setImage($this->getReference('picture_564.jpeg'));
        $item564->setVideo($this->getReference('video_564.webm'));
        $item564->setGallery($this->getReference('picture_564'));
        $item564->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Kleiner Ball – großer Ball</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie die Füße schulterbreit auf die Mitte des Thera-Bandes®</li>
	<li>Halten Sie mit jeder Hand ein Thera-Band® Ende vor dem Körper, so dass es unter leichter Spannung steht</li>
	<li>Die Ellbogen bilden einen 90° Winkel</li>
	<li>Stellen Sie sich vor, als würden Sie einen Fußball in der Hand halten</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Führen Sie die Arme diagonal nach oben bis zur Höhe des Kopfes</li>
	<li>Lassen Sie die Arme dabei gestreckt</li>
	<li>Stellen Sie sich vor, als würden Sie einen Gymnastikball über den Kopf halten</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Gesamter Rücken</li>
	<li>Oberarme</li>
	<li>Unterarme</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg"><img src="/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item564);

        $item565 = new Exercise();
        $item565->setName("Kopf hinten");
        $item565->setFormat("richhtml");
        $item565->setTag("Rücken");
        $item565->setImage($this->getReference('picture_565.jpeg'));
        $item565->setVideo($this->getReference('video_565.webm'));
        $item565->setGallery($this->getReference('picture_565'));
        $item565->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Kopf hinten</h4>
Sie können diese Übung im Sitzen oder im Stehen durchführen
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte legen Sie das Thera-Band® mittig um Ihren Hinterkopf und fassen es so, dass es unter leichter Spannung steht</li>
	<li>Schieben Sie nun den Kopf parallel zum Boden nach hinten ohne abzuknicken</li>
	<li>Anschließend langsam unter Spannung wieder nach vorne kommen</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">10 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
Nackenmuskulatur</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/01_nackenmuskeln.jpg"><img src="/wp-content/uploads/muskelgruppen/01_nackenmuskeln.jpg" alt="" /></a>

</div>
</div>
CONTENT
        );
        $manager->persist($item565);

        $item566 = new Exercise();
        $item566->setName("Rumpfrotation im Sitz");
        $item566->setFormat("richhtml");
        $item566->setTag("Rücken");
        $item566->setImage($this->getReference('picture_566.jpeg'));
        $item566->setVideo($this->getReference('video_566.webm'));
        $item566->setGallery($this->getReference('picture_566'));
        $item566->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Rumpfrotation im Sitz</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie Ihren rechten Fuß auf das Ende des Thera-Bandes® und greifen Sie das andere Ende mit beiden Händen</li>
	<li>Halten Sie die Ellbogen in einem 90° Winkel</li>
	<li>Das Thera-Band® ist leicht gespannt</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Ziehen Sie das Thera-Band® seitlich vom Fuß weg</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen je Seite</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
Rumpfmuskulatur</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg">
<img src="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg" alt="" />
</a>

</div>
</div>
CONTENT
        );
        $manager->persist($item566);

        $item567 = new Exercise();
        $item567->setName("Rumpfrotation im Stand");
        $item567->setFormat("richhtml");
        $item567->setTag("Rücken");
        $item567->setImage($this->getReference('picture_567.jpeg'));
        $item567->setVideo($this->getReference('video_567.webm'));
        $item567->setGallery($this->getReference('picture_567'));
        $item567->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Rumpfrotation im Stand</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -5px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie Ihren rechten Fuß auf das Ende des Thera-Bandes® und greifen Sie das andere Ende mit beiden Händen</li>
	<li>Halten Sie die Ellbogen in einem 90° Winkel</li>
	<li>Das Thera-Band® ist leicht gespannt</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Ziehen Sie das Thera-Band® diagonal vom Fuß weg nach oben</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen je Seite</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
Rumpfmuskulatur</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg">
<img src="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg" alt="" />
</a>

</div>
</div>
CONTENT
        );
        $manager->persist($item567);

        $item568 = new Exercise();
        $item568->setName("Spreizer");
        $item568->setFormat("richhtml");
        $item568->setTag("Rücken");
        $item568->setImage($this->getReference('picture_568.jpeg'));
        $item568->setVideo($this->getReference('video_568.webm'));
        $item568->setGallery($this->getReference('picture_568'));
        $item568->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Spreizer</h4>
Bitte führen Sie diese Übung im Sitzen oder im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Mobilisation</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte fassen Sie das Thera-Band® mit ausgestreckten Armen über dem Kopf, so dass es unter leichter Spannung ist</li>
	<li>Ziehen Sie nun das Thera-Band mit leicht angewinkelten Armen auseinander, bis Ihre Oberarme waagerecht stehen</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen je Seite</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Schultermuskulatur</li>
	<li>Oberer Rücken</li>
	<li>Oberarme</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/04_oberarm.jpg"><img src="/wp-content/uploads/muskelgruppen/04_oberarm.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg" alt="" /></a>
</div>
</div>
CONTENT
        );
        $manager->persist($item568);

        $item569 = new Exercise();
        $item569->setName("Squats mit Lang-Hantel");
        $item569->setFormat("richhtml");
        $item569->setTag("Rücken");
        $item569->setImage($this->getReference('picture_569.jpeg'));
        $item569->setVideo($this->getReference('video_569.webm'));
        $item569->setGallery($this->getReference('picture_569'));
        $item569->setDescription(<<<CONTENT
<div class="row">

[display_exercise]
<div class="span4 col-md-4 column_last">
<h4 style="margin-bottom: 4px;">Squats mit Lang-Hantel</h4>
Bitte führen Sie diese Übung im Stehen durch
<p style="margin-top: -15px;">[back_to_parent]</p>

<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Thera-Band®</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Stellen Sie die Füße schulterbreit auf die Mitte des Thera-Bandes®</li>
	<li>Halten Sie mit jeder Hand ein Thera-Band® Ende seitlich vom Körper, so dass es unter leichter Spannung steht</li>
	<li>Die Arme sind gestreckt</li>
	<li>Spannen Sie die Bauchmuskeln leicht an</li>
	<li>Neigen Sie den Oberkörper leicht nach vorn (ca. 30°). Der Rücken bleibt gerade</li>
	<li>Gehen Sie leicht in die Knie (ca. 30°), wobei Sie das Gesäß nach hinten schieben und die Knie auf Höhe der Füße bleiben</li>
	<li>Ziehen Sie nun die Ellbogen seitlich am Körper vorbei nach hinten</li>
	<li>Anschließend richten Sie sich wieder gerade auf</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">12 Wiederholungen</p>

</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Gesamter Rücken</li>
	<li>Oberarme</li>
	<li>Oberschenkel</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg">
<img src="/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg" alt="" />
</a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/15_oberarm_oberschenkel.jpg">
<img src="/wp-content/uploads/muskelgruppen/15_oberarm_oberschenkel.jpg" alt="" />
</a>

</div>
</div>
CONTENT
        );
        $manager->persist($item569);


        $manager->flush();
    }

}
