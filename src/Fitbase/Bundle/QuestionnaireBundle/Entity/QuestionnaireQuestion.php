<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/29/14
 * Time: 10:43 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class QuestionnaireQuestion
{
    protected $id;
    protected $name;
    protected $format;
    protected $type;
    protected $description;
    protected $questionnaire;
    protected $answers;

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }


    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $questionnaire
     */
    public function setQuestionnaire($questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;


    /**
     * Add answers
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer $answers
     * @return QuestionnaireQuestion
     */
    public function addAnswer(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer $answers
     */
    public function removeAnswer(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Add categories
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     * @return QuestionnaireQuestion
     */
    public function addCategory(\Application\Sonata\ClassificationBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categories
     */
    public function removeCategory(\Application\Sonata\ClassificationBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
