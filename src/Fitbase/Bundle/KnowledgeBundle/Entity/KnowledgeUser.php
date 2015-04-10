<?php

namespace Fitbase\Bundle\KnowledgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Knowledge
 */
class KnowledgeUser
{

    /**
     * @var boolean
     */
    private $done;

    /**
     * @var \DateTime
     */
    private $doneDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Fitbase\Bundle\KnowledgeBundle\Entity\Knowledge
     */
    private $knowledge;


    /**
     * Set done
     *
     * @param boolean $done
     * @return KnowledgeUser
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean 
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set doneDate
     *
     * @param \DateTime $doneDate
     * @return KnowledgeUser
     */
    public function setDoneDate($doneDate)
    {
        $this->doneDate = $doneDate;

        return $this;
    }

    /**
     * Get doneDate
     *
     * @return \DateTime 
     */
    public function getDoneDate()
    {
        return $this->doneDate;
    }

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
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return KnowledgeUser
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set knowledge
     *
     * @param \Fitbase\Bundle\KnowledgeBundle\Entity\Knowledge $knowledge
     * @return KnowledgeUser
     */
    public function setKnowledge(\Fitbase\Bundle\KnowledgeBundle\Entity\Knowledge $knowledge = null)
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    /**
     * Get knowledge
     *
     * @return \Fitbase\Bundle\KnowledgeBundle\Entity\Knowledge 
     */
    public function getKnowledge()
    {
        return $this->knowledge;
    }
}
