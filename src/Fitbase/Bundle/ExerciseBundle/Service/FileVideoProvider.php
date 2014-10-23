<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\FileProvider;

/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 23/10/14
 * Time: 13:12
 */
class FileVideoProvider extends FileProvider
{
    /**
     * {@inheritdoc}
     */
    public function generatePublicUrl(MediaInterface $media, $format)
    {
        if ($format == 'reference') {
            $path = $this->getReferenceImage($media);
        } else {
            $path = $this->getReferenceFile($media)->getName();
        }

        return $this->getCdn()->getPath($path, $media->getCdnIsFlushable());
    }
} 