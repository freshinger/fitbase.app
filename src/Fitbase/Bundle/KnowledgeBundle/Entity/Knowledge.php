<?php

namespace Fitbase\Bundle\KnowledgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Knowledge
 */
class Knowledge
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Knowledge
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getContentLength()
    {
        return mb_strlen($this->getContent());
    }

    /**
     * @var string
     */
    private $format;


    /**
     * Set format
     *
     * @param string $format
     * @return Knowledge
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
}
