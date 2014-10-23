<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\ExerciseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class LoadMediaGalleryData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get gallery name
     * @param $string
     * @return string
     */
    protected function getGalleryName($string)
    {
        return substr($string, 0, strrpos($string, "_"));
    }

    protected $galleries = array();


    /**
     * Get collection with current galleries
     * @return array
     */
    protected function getGalleries()
    {
        return $this->galleries;
    }

    /**
     * Get gallery by name
     * @param $name
     * @return null
     */
    protected function getGallery($name)
    {
        if (isset($this->galleries[$name])) {
            return $this->galleries[$name];
        }
        return null;
    }

    /**
     * Add gallery to collection
     * @param $name
     * @param $gallery
     * @return mixed
     */
    protected function addGallery($name, $gallery)
    {
        if (!isset($this->galleries[$name])) {
            return $this->galleries[$name] = $gallery;
        }
    }

    /**
     * Load objects into database
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        $manager = $this->getMediaManager();
        $faker = $this->getFaker();

        $canada = Finder::create()->name('*.jpeg')->in(__DIR__ . '/../Gallery');

        $i = 0;
        foreach ($canada as $file) {

            $media = $manager->create();
            $media->setBinaryContent($file);
            $media->setEnabled(true);
            $media->setName($file->getFilename());
            $media->setDescription($file->getFilename());
            $media->setAuthorName('Fitbase');
            $media->setCopyright('Fitbase');

            $this->addReference($file->getFilename(), $media);

            $manager->save($media, 'exercise', 'sonata.media.provider.image');

            $galleryName = $this->getGalleryName($file->getFilename());
            if (!($gallery = $this->getGallery($galleryName))) {

                $gallery = $this->getGalleryManager()->create();
                $gallery->setEnabled(true);
                $gallery->setName($galleryName);
                $gallery->setDefaultFormat('small');
                $gallery->setContext('exercise');

                $this->addGallery($galleryName, $gallery);
            }

            $this->addMedia($gallery, $media);

        }

        foreach ($this->getGalleries() as $name => $gallery) {
            $this->getGalleryManager()->update($gallery);
            // Name: gallery_picture_500
            $this->addReference($name, $gallery);
        }
    }

    /**
     * @param \Sonata\MediaBundle\Model\GalleryInterface $gallery
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     * @return void
     */
    public function addMedia(GalleryInterface $gallery, MediaInterface $media)
    {
        $galleryHasMedia = new \Application\Sonata\MediaBundle\Entity\GalleryHasMedia();
        $galleryHasMedia->setMedia($media);
        $galleryHasMedia->setPosition(count($gallery->getGalleryHasMedias()) + 1);
        $galleryHasMedia->setEnabled(true);

        $gallery->addGalleryHasMedias($galleryHasMedia);
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getGalleryManager()
    {
        return $this->container->get('sonata.media.manager.gallery');
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }
}