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
class LoadAugenData extends AbstractFixture implements OrderedFixtureInterface
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

        $item500 = new Exercise();
        $item500->setName("Akupressur Hinterkopf");
        $item500->setFormat("richhtml");
        $item500->setTag("Augen");
        $item500->setImage($this->getReference('picture_500.jpeg'));
        $item500->setMp4($this->getReference('video_500.mp4'));
        $item500->setWebm($this->getReference('video_500.webm'));
        $item500->setGallery($this->getReference('picture_500'));
        $item500->setCategory($this->getReference('category_augen'));
        $item500->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Akupressur Hinterkopf</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Dort, wo die Nackenmuskulatur am Schädel ansetzt gibt es zwei Vertiefungen</li>
	<li>Massieren Sie diese Punkte sanft mit mehreren kreisenden Bewegungen</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholung</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Kopfschmerzen</li>
	<li>Nackenschmerzen</li>
	<li>Augenprobleme</li>
</ul>
</div>
<div class="clear"></div>
</div>
CONTENT
        );
        $manager->persist($item500);

        $item535 = new Exercise();
        $item535->setName("Akupressur Nasenwurzel");
        $item535->setFormat("richhtml");
        $item535->setTag("Augen");
        $item535->setImage($this->getReference('picture_535.jpeg'));
        $item535->setMp4($this->getReference('video_535.mp4'));
        $item535->setWebm($this->getReference('video_535.webm'));
        $item535->setGallery($this->getReference('picture_535'));
        $item535->setCategory($this->getReference('category_augen'));
        $item535->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Akupressur Nasenwurzel</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Massieren Sie nun mit leichtem Druck links und rechts neben der Nasenwurzel, so wie Sie es als angenehmen empfinden</li>
	<li>Führen Sie mehrere kreisende Bewegungen durch</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Augenprobleme</li>
	<li>Müdigkeit</li>
</ul>
</div>
<div class="clear"></div>
</div>
CONTENT
        );
        $manager->persist($item535);

        $item536 = new Exercise();
        $item536->setName("Akupressur obere Augenbraue");
        $item536->setFormat("richhtml");
        $item536->setTag("Augen");
        $item536->setImage($this->getReference('picture_536.jpeg'));
        $item536->setMp4($this->getReference('video_536.mp4'));
        $item536->setWebm($this->getReference('video_536.webm'));
        $item536->setGallery($this->getReference('picture_536'));
        $item536->setCategory($this->getReference('category_augen'));
        $item536->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Akupressur obere Augenbraue</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Massieren Sie mit leichtem Druck mittig oberhalb der Augenbrauen, so wie Sie es als angenehmen empfinden</li>
	<li>Führen Sie mehrere kreisende Bewegungen durch</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Augenschmerzen</li>
	<li>schwankende Sehschärfe</li>
	<li>eingschränktes Blickfeld</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/1.png"></a>
CONTENT
        );
        $manager->persist($item536);

        $item537 = new Exercise();
        $item537->setName("Akupressur untere Augenbraue");
        $item537->setFormat("richhtml");
        $item537->setTag("Augen");
        $item537->setImage($this->getReference('picture_537.jpeg'));
        $item537->setMp4($this->getReference('video_537.mp4'));
        $item537->setWebm($this->getReference('video_537.webm'));
        $item537->setGallery($this->getReference('picture_537'));
        $item537->setCategory($this->getReference('category_augen'));
        $item537->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Akupressur untere Augenbraue</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>In der Mitte der inneren Augenwinkel gibt es einen Punkt, der besonders empfindlich ist</li>
	<li>Massieren Sie diesen Punkt sanft mit mehreren kreisenden Bewegungen</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Kopfschmerzen</li>
	<li>Augenbeschwerden</li>
</ul>
</div>
<div class="clear"></div>
</div>
CONTENT
        );
        $manager->persist($item537);

        $item538 = new Exercise();
        $item538->setName("Akupressur Schläfen");
        $item538->setFormat("richhtml");
        $item538->setTag("Augen");
        $item538->setImage($this->getReference('picture_538.jpeg'));
        $item538->setMp4($this->getReference('video_538.mp4'));
        $item538->setWebm($this->getReference('video_538.webm'));
        $item538->setGallery($this->getReference('picture_538'));
        $item538->setCategory($this->getReference('category_augen'));
        $item538->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Akupressur Schläfen</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Massieren Sie nun mit leichtem Druck Ihre Schläfen, so wie Sie es als angenehmen empfinden</li>
	<li>Führen Sie mehrere kreisende Bewegungen durch</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Kopfschmerzen</li>
	<li>Sehstörung</li>
</ul>
</div>
<div class="clear"></div>
</div>
CONTENT
        );
        $manager->persist($item538);

        $item539 = new Exercise();
        $item539->setName("Akupressur Stirnmitte");
        $item539->setFormat("richhtml");
        $item539->setTag("Augen");
        $item539->setImage($this->getReference('picture_539.jpeg'));
        $item539->setMp4($this->getReference('video_539.mp4'));
        $item539->setWebm($this->getReference('video_539.webm'));
        $item539->setGallery($this->getReference('picture_539'));
        $item539->setCategory($this->getReference('category_augen'));
        $item539->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Akupressur Stirnmitte</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Massieren Sie mit leichtem Druck die Stirnmitte oberhalb zwischen den Augenbrauen, so wie Sie es als angenehmen empfinden</li>
	<li>Führen Sie mehrere kreisende Bewegungen durch</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Allgemeine Vitalisierung</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/1.png"></a>
CONTENT
        );
        $manager->persist($item539);

        $item540 = new Exercise();
        $item540->setName("Augenbewegung");
        $item540->setFormat("richhtml");
        $item540->setTag("Augen");
        $item540->setImage($this->getReference('picture_540.jpeg'));
        $item540->setMp4($this->getReference('video_540.mp4'));
        $item540->setWebm($this->getReference('video_540.webm'));
        $item540->setGallery($this->getReference('picture_540'));
        $item540->setCategory($this->getReference('category_augen'));
        $item540->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Augenbewegung</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Strecken Sie den rechten Arm aus und führen den Daumen dann zur Nasenspitze, bis Sie leicht schielen</li>
	<li>Folgen Sie dem Daumen mit den Augen, ohne den Kopf zu bewegen</li>
	<li>Führen Sie den Daumen mit ausgestrecktem Arm anschließend nach oben, unten, rechts und links</li>
	<li>Anschließend den Daumen am ausgestreckten Arm in zwei großen Kreisen führen</li>
	<li>Dann in einer spiralförmigen Bewegung den Daumen von der ausgestreckten Hand in kreisenden Bewegungen zur Nasenspitze führen, bis Sie leicht schielen</li>
	<li>Den Arm zum Abschluss wieder ausstrecken und mit den Augen verfolgen</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">Mehrere kreisende Bewegungen</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Sehstörungen</li>
	<li>Verbesserung der Augenbeweglichkeit</li>
</ul>
</div>
<div class="clear"></div>
</div>
<a class="exercise-picture-zoom area" href="/wp-content/uploads/muskelgruppen/1.png"></a>
CONTENT
        );
        $manager->persist($item540);

        $item544 = new Exercise();
        $item544->setName("Palmieren");
        $item544->setFormat("richhtml");
        $item544->setTag("Augen");
        $item544->setImage($this->getReference('picture_544.jpeg'));
        $item544->setMp4($this->getReference('video_544.mp4'));
        $item544->setWebm($this->getReference('video_544.webm'));
        $item544->setGallery($this->getReference('picture_544'));
        $item544->setCategory($this->getReference('category_augen'));
        $item544->setDescription(<<<CONTENT
<h4 style="margin-bottom: 4px;">Palmieren</h4>
Sie können diese Übung im Stehen oder im Sitzen durchführen
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-info"><span>Art der Übung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Art der Übung</h4>
<p class="tall">Entspannung</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-tasks"><span>Durchführungsanleitung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Durchführungsanleitung</h4>
<ol class="numbered-list">
	<li>Bitte stehen/sitzen Sie aufrecht</li>
	<li>Wärmen Sie die Hände z.B. durch aneinander reiben auf</li>
	<li>Schließen Sie die Augen und legen Sie die Hände auf die Augen</li>
	<li>Nehmen Sie bewusst die Dunkelheit wahr und entspannen Sie sich</li>
	<li>Machen Sie diese Übung immer wieder zwischendurch</li>
</ol>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-clock-o"><span>Anzahl der Wiederholung</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Anzahl der Wiederholungen</h4>
<p class="tall">25 Sekunden</p>
</div>
</div>
<div class="feature-box">
<div class="feature-box-icon"><i class="icon icon-male"><span>Beanspruchte Muskelbereiche</span></i></div>
<div class="feature-box-info">
<h4 class="shorter">Hilfe bei</h4>
<ul>
	<li>Sehstörungen</li>
	<li>Entspannung</li>
</ul>
</div>
<div class="clear"></div>
</div>
CONTENT
        );
        $manager->persist($item544);


        $manager->flush();
    }

}