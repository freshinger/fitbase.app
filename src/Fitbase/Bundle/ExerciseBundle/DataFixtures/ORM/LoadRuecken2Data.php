<?php

namespace Fitbase\Bundle\ExerciseBundle\DataFixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 *
 */
class LoadRuecken2Data extends AbstractFixture implements OrderedFixtureInterface
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

        $item630 = new Exercise();
        $item630->setName("1. Mobilisation – Becken kippen");
        $item630->setFormat("richhtml");
        $item630->setTag("Rücken");
        $item630->setImage($this->getReference('picture_630.jpeg'));
        $item630->setMp4($this->getReference('video_630.mp4'));
        $item630->setWebm($this->getReference('video_630.webm'));
        $item630->setGallery($this->getReference('picture_630'));
        $item630->setCategory($this->getReference('category_ruecken'));
        $item630->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Becken kippen</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
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
	<li>Bitte umfassen Sie mit beiden Händen den jeweiligen Beckenkamm</li>
	<li>Kippen Sie nun mit langsamen und bewussten Bewegungen das Becken nach vorne und hinten</li>
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
<ul class="list-unstyled">
	<li>Unterer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item630);

        $item631 = new Exercise();
        $item631->setName("1. Mobilisation – Lendenwirbelsäule");
        $item631->setFormat("richhtml");
        $item631->setTag("Rücken");
        $item631->setImage($this->getReference('picture_631.jpeg'));
        $item631->setMp4($this->getReference('video_631.mp4'));
        $item631->setWebm($this->getReference('video_631.webm'));
        $item631->setGallery($this->getReference('picture_631'));
        $item631->setCategory($this->getReference('category_ruecken'));
        $item631->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Lendenwirbelsäule</h4>
Bitte führen Sie diese Übung im Stehen durch
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
	<li>Bitte mit leicht gebeugten Knien stehen und mit den Händen auf den Knien abstützen (Torwartstellung)</li>
	<li>Dann die Lendenwirbelsäule maximal durchstrecken (Hohlkreuz), wobei Sie versuchen sollten, den Abstand zwischen Ihrem Bauchnabel und dem Schambein so groß wie möglich werden zu lassen</li>
	<li>Jetzt die Lendenwirbelsäule maximal beugen, wobei nun der Abstand zwischen Bauchnabel und Schambein möglichst gering wird</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">15 Wiederholungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul class="list-unstyled">
	<li>Unterer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item631);

        $item632 = new Exercise();
        $item632->setName("1. Mobilisation – LWS Kreisen");
        $item632->setFormat("richhtml");
        $item632->setTag("Rücken");
        $item632->setImage($this->getReference('picture_632.jpeg'));
        $item632->setMp4($this->getReference('video_632.mp4'));
        $item632->setWebm($this->getReference('video_632.webm'));
        $item632->setGallery($this->getReference('picture_632'));
        $item632->setCategory($this->getReference('category_ruecken'));
        $item632->setDescription(<<<EOT
<h4 style="margin-bottom: 4px">LWS Kreisen</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
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
	<li>Bitte umfassen Sie mit beiden Händen den jeweiligen Beckenkamm</li>
	<li>Kreisen Sie nun mit langsamen und bewussten Bewegungen das Becken</li>
	<li>10x links herum, 10x rechts herum</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">10x links herum, 10x rechts herum</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul class="list-unstyled">
	<li>Unterer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item632);

        $item633 = new Exercise();
        $item633->setName("2. Kräftigung – Bauchmuskel");
        $item633->setFormat("richhtml");
        $item633->setTag("Rücken");
        $item633->setImage($this->getReference('picture_633.jpeg'));
        $item633->setMp4($this->getReference('video_633.mp4'));
        $item633->setWebm($this->getReference('video_633.webm'));
        $item633->setGallery($this->getReference('picture_633'));
        $item633->setCategory($this->getReference('category_ruecken'));
        $item633->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Bauchmuskel</h4>
Bitte führen Sie diese Übung tim Sitzen durch
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Kräftigung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Oberkörper leicht nach hinten neigen, aber nicht anlehnen</li>
	<li>Die Hände auf den Knien abstützen und die Ellenbogen leicht abspreizen</li>
	<li>Abwechselnd links und rechts Druck mit der Hand auf das Knie aufbauen</li>
	<li>Dann mit gehaltenem Druck das Bein anheben und langsam wieder absetzen</li>
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
<ul class="list-unstyled">
	<li>Bauchmuskulatur</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg"><img src="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item633);

        $item634 = new Exercise();
        $item634->setName("2. Kräftigung – Bauchmuskeln gerade");
        $item634->setFormat("richhtml");
        $item634->setTag("Rücken");
        $item634->setImage($this->getReference('picture_634.jpeg'));
        $item634->setMp4($this->getReference('video_634.mp4'));
        $item634->setWebm($this->getReference('video_634.webm'));
        $item634->setGallery($this->getReference('picture_634'));
        $item634->setCategory($this->getReference('category_ruecken'));
        $item634->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">2. Kräftigung – Bauchmuskeln gerade</h4>
Bitte stellen Sie die Lehne Ihres Stuhls maximal nach hinten und nehmen Sie die Grundhaltung ein
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Kräftigung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Verschränken Sie die Hände hinter dem Kopf</li>
	<li>Die Ellenbogen zeigen gerade nach außen</li>
	<li>Halten Sie den Kopf gerade</li>
	<li>Drücken Sie dann die Knie abwechselnd gegen die Tischplatte und führen Sie Ihren Oberkörper dabei gerade nach vorne bis in die Vertikale</li>
	<li>Langsam zurück in die Ausgangsstellung</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">15 Wiederholungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul class="list-unstyled">
	<li>Bauchmuskulatur</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg"><img src="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item634);

        $item635 = new Exercise();
        $item635->setName("2. Kräftigung – Bauchmuskeln schräge");
        $item635->setFormat("richhtml");
        $item635->setTag("Rücken");
        $item635->setImage($this->getReference('picture_635.jpeg'));
        $item635->setMp4($this->getReference('video_635.mp4'));
        $item635->setWebm($this->getReference('video_635.webm'));
        $item635->setGallery($this->getReference('picture_635'));
        $item635->setCategory($this->getReference('category_ruecken'));
        $item635->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Bauchmuskeln schräge</h4>
Bitte führen Sie diese Übung im Sitzen durch
<p style="margin-top: -15px;">[back_to_parent]</p>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Kräftigung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Verschränken Sie die Hände hinter dem Kopf</li>
	<li>Neigen Sie den Oberkörper ca. 30°- 40° nach hinten</li>
	<li>Dann für die schrägen Bauchmuskeln der rechten Seite das linke Knie von unten gegen die Tischplatte drücken</li>
	<li>Dann den rechten Ellbogen in Richtung des linken Knies bewegen</li>
	<li>Nur so weit bewegen bis der Oberkörper vertikal steht</li>
	<li>Jetzt wieder zurück in die 30°- 40° Rücklage</li>
	<li>Entsprechend mit der anderen Seite</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">10 Wiederholungen je Seite</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul class="list-unstyled">
	<li>Bauchmuskulatur</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg"><img src="/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item635);

        $item636 = new Exercise();
        $item636->setName("2. Kräftigung – Rotation vorgebeugt");
        $item636->setFormat("richhtml");
        $item636->setTag("Rücken");
        $item636->setImage($this->getReference('picture_636.jpeg'));
        $item636->setMp4($this->getReference('video_636.mp4'));
        $item636->setWebm($this->getReference('video_636.webm'));
        $item636->setGallery($this->getReference('picture_636'));
        $item636->setCategory($this->getReference('category_ruecken'));
        $item636->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Rotation vorgebeugt</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Kräftigung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Verschränken Sie die Hände hinter dem Kopf</li>
	<li>Die Ellenbogen zeigen gerade nach außen</li>
	<li>Halten Sie den Kopf gerade</li>
	<li>Neigen Sie den Oberkörper ca. 60° nach vorne</li>
	<li>Führen Sie den linken Ellenbogen in Richtung Decke und den rechten Ellenbogen in Richtung Boden</li>
	<li>Dann zurück in die Ausgangsposition</li>
	<li>Entsprechend mit der anderen Seite</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">20 Wiederholungen je Seite</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul>
	<li>Unterer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item636);

        $item637 = new Exercise();
        $item637->setName("2. Kräftigung – Schreibtisch Lendenwirbel");
        $item637->setFormat("richhtml");
        $item637->setTag("Rücken");
        $item637->setImage($this->getReference('picture_637.jpeg'));
        $item637->setMp4($this->getReference('video_637.mp4'));
        $item637->setWebm($this->getReference('video_637.webm'));
        $item637->setGallery($this->getReference('picture_637'));
        $item637->setCategory($this->getReference('category_ruecken'));
        $item637->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">2. Kräftigung – Schreibtisch Lendenwirbel</h4>
Bitte die Knie leicht gebeugt, mit einem geraden Rücken leicht nach vorne geneigt hinstellen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Mobilisation, Kräftigung, Dehnung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Die Hände in etwa schulterbreit über dem Tisch schweben lassen</li>
	<li>Spannung zwischen den Schulterblättern aufbauen und den Oberkörper ca. 45°-60° nach vorne neigen</li>
	<li>Dann zurück in die Ausgangsposition, Rücken weiterhin leicht nach vorne geneigt</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">2 mal 15 Wiederholungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
Unterer Rücken</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item637);

        $item638 = new Exercise();
        $item638->setName("2. Kräftigung – Squats");
        $item638->setFormat("richhtml");
        $item638->setTag("Rücken");
        $item638->setImage($this->getReference('picture_638.jpeg'));
        $item638->setMp4($this->getReference('video_638.mp4'));
        $item638->setWebm($this->getReference('video_638.webm'));
        $item638->setGallery($this->getReference('picture_638'));
        $item638->setCategory($this->getReference('category_ruecken'));
        $item638->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Squats</h4>
Bitte führen Sie diese Übung im Stehen durch
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Kräftigung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Mit geradem Rücken hinstellen und den Bauch leicht anspannen</li>
	<li>Hände hinter dem Kopf verschränken und Ellenbogen auf Kopfhöhe seitlich abspreizen</li>
	<li>Oberkörper ca. 45° nach vorne neigen, dabei das Gesäß nach hinten schieben und in die Knie gehen wobei die Kniescheibe nicht über die Fußspitze hinaus geht</li>
	<li>Dann wieder hoch kommen bis die Knie fast gestreckt sind</li>
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
	<li>Oberschenkel</li>
	<li>Unterer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/11_oberschenkel.jpg">
<img src="/wp-content/uploads/muskelgruppen/11_oberschenkel.jpg" alt="" /></a>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg">
<img src="/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg" alt="" />
</a>
EOT
        );
        $manager->persist($item638);

        $item639 = new Exercise();
        $item639->setName("2. Kräftigung – Tiefe Rückenmuskulatur");
        $item639->setFormat("richhtml");
        $item639->setTag("Rücken");
        $item639->setImage($this->getReference('picture_639.jpeg'));
        $item639->setMp4($this->getReference('video_639.mp4'));
        $item639->setWebm($this->getReference('video_639.webm'));
        $item639->setGallery($this->getReference('picture_639'));
        $item639->setCategory($this->getReference('category_ruecken'));
        $item639->setDescription(<<<EOT
<h4 style="margin-bottom: 4px;">Tiefe Rückenmuskulatur</h4>
Bitte führen Sie diese Übung im Sitzen durch
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Kräftigung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Halten Sie die Arme leicht gebeugt in Höhe des Brustbeins vor den Körper</li>
	<li>Bauen Sie Spannung zwischen den Schulterblättern auf</li>
	<li>Dann die Arme anspannen und mit kleinen „hackenden“ Bewegungen die Arme hoch und runter bewegen</li>
	<li>Die Übung sollte etwas anstrengend sein. Kriterium: Leicht außer Atem geraten und etwas schwitzen. Sollten Ihre Muskeln anfangen zu zittern, ist das ein normales Zeichen dafür, dass die Muskulatur arbeitet.</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">60 Sekunden</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Beanspruchte Muskelbereiche</h4>
<ul class="list-unstyled">
	<li>Mittlerer Rücken</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/07_mittlerer_ruecken.jpg"><img src="/wp-content/uploads/muskelgruppen/07_mittlerer_ruecken.jpg" alt="" /></a>
EOT
        );
        $manager->persist($item639);


        $manager->flush();
    }

}
