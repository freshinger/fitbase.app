<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/29/14
 * Time: 10:43 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Entity;


use Application\Sonata\ClassificationBundle\Entity\Category;
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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Calculate color for answer
     * @param $count
     * @param $answer
     * @return string
     */
    public function getAnswerColor($answer)
    {
        //        var colors = ["#a2d049", "#d1de3f", "#fce14b", "#f08e3e", "#e65a3b", "#d7ecaf", "#397bc9", "#7eaae0", "#bfd6f3", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"];
        if (count($this->getAnswers()) == 2) {
            if ($answer->getCountPoint() == $this->getCountPointMax()) {
                return '#e65a3b';
            }
            return '#a2d049';
        }

        if (count($this->getAnswers()) == 5) {
            $colors = array("#a2d049", "#d1de3f", "#fce14b", "#f08e3e", "#e65a3b");
            if (array_key_exists($answer->getCountPoint(), $colors)) {
                return $colors[$answer->getCountPoint()];
            }
        }

        if (count($this->getAnswers()) == 6) {
            $colors = array("#a2d049", "#d1de3f", "#fce14b", "#d7ecaf", "#f08e3e", "#e65a3b");
            if (array_key_exists($answer->getCountPoint(), $colors)) {
                return $colors[$answer->getCountPoint()];
            }
        }

        if (count($this->getAnswers()) >= 10) {
            $colors = array("#a2d049", "#d1de3f", "#fce14b", "#d7ecaf", "#397bc9", "#7eaae0", "#bfd6f3", "#f08e3e", "#a05d56", "#6b486b", "#e65a3b");
            if (array_key_exists($answer->getCountPoint(), $colors)) {
                return $colors[$answer->getCountPoint()];
            }
        }


        return '#FFFFFF';
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
     * @param $category
     * @return bool
     */
    public function hasCategory(Category $category)
    {
        if (($collection = $this->getCategories())) {
            foreach ($collection as $categoryQuestion) {
                if ($categoryQuestion->getId() == $category->getId()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $companyCategory
     * @return bool
     */
    public function hasCompanyCategory($companyCategory)
    {
        if (($collection = $this->getCategories())) {
            foreach ($collection as $category) {
                if ($category->getId() == $companyCategory->getCategory()->getId()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $points
     * @return bool
     */
    public function hasProblem($points)
    {
        $pointsTotal = 0;
        if (($answers = $this->getAnswers())) {
            foreach ($answers as $answer) {
                $pointsTotal += $answer->getCountPoint();
            }
        }

        if ($pointsTotal > 0) {
            if ($points > ((55 * $pointsTotal) / 100)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get max count point for question
     * @return int
     */
    public function getCountPointMax()
    {
        $result = 0;
        if (($answers = $this->getAnswers())) {
            foreach ($answers as $answer) {
                if ($answer->getCountPoint() > $result) {
                    $result = $answer->getCountPoint();
                }
            }
        }
        return $result;
    }

    /**
     * Get common count point for question
     * @return int
     */
    public function getCountPoint()
    {
        $result = 0;
        if (($answers = $this->getAnswers())) {
            foreach ($answers as $answer) {
                $result += $answer->getCountPoint();
            }
        }
        return $result;
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
