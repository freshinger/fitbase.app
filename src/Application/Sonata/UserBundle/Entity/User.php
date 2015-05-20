<?php
/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;

use Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * This file has been generated by the Sonata EasyExtends bundle ( http://sonata-project.org/easy-extends )
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
class User extends BaseUser
{

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var integer $titel
     */
    protected $titel;

    /**
     * @var integer $companys
     */
    protected $company;

    /**
     * @var $site
     */
    protected $site;

    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Category
     */
    protected $focus;

    /**
     * @var string
     */
    protected $format;

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

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * @return int
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param int $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * Set focus
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserFocus $focus
     * @return User
     */
    public function setFocus(\Fitbase\Bundle\UserBundle\Entity\UserFocus $focus = null)
    {
        $this->focus = $focus;

        return $this;
    }

    /**
     * Get focus
     *
     * @return \Fitbase\Bundle\UserBundle\Entity\UserFocus
     */
    public function getFocus()
    {
        return $this->focus;
    }


    /**
     * @var \Fitbase\Bundle\UserBundle\Entity\UserActioncode
     */
    private $actioncode;

    /**
     * Set actioncode
     *
     * @param \Fitbase\Bundle\UserBundle\Entity\UserActioncode $actioncode
     * @return User
     */
    public function setActioncode(\Fitbase\Bundle\UserBundle\Entity\UserActioncode $actioncode = null)
    {
        $this->actioncode = $actioncode;

        return $this;
    }

    /**
     * Get actioncode
     *
     * @return \Fitbase\Bundle\UserBundle\Entity\UserActioncode
     */
    public function getActioncode()
    {
        return $this->actioncode;
    }


    /**
     * @var boolean
     */
    private $wizard;

    /**
     * Set wizard
     *
     * @param boolean $wizard
     * @return User
     */
    public function setWizard($wizard)
    {
        $this->wizard = $wizard;

        return $this;
    }

    /**
     * Get wizard
     *
     * @return boolean
     */
    public function getWizard()
    {
        return $this->wizard;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reminders;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->reminders = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Add reminders
     *
     * @param \Fitbase\Bundle\ReminderBundle\Entity\ReminderUser $reminders
     * @return User
     */
    public function addReminder(\Fitbase\Bundle\ReminderBundle\Entity\ReminderUser $reminders)
    {
        $this->reminders[] = $reminders;

        return $this;
    }

    /**
     * Remove reminders
     *
     * @param \Fitbase\Bundle\ReminderBundle\Entity\ReminderUser $reminders
     */
    public function removeReminder(\Fitbase\Bundle\ReminderBundle\Entity\ReminderUser $reminders)
    {
        $this->reminders->removeElement($reminders);
    }

    /**
     * Get reminders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReminders()
    {
        return $this->reminders;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaires;

    /**
     * Add questionnaires
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires
     * @return User
     */
    public function addQuestionnaire(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Remove questionnaires
     *
     * @param \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires
     */
    public function removeQuestionnaire(\Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser $questionnaires)
    {
        $this->questionnaires->removeElement($questionnaires);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * Get last slice
     * @param QuestionnaireCompany $questionnaireCompany
     * @return mixed|null
     */
    public function getQuestionnaireSlice(QuestionnaireCompany $questionnaireCompany)
    {
        // all questionnaires ordered by id desc
        // just try to found a first questionnaire in list
        // with required conditions
        if (($collection = $this->getQuestionnaires())) {
            foreach ($collection as $questionnaireUser) {
                if (($slice = $questionnaireUser->getSlice())) {
                    if ($questionnaireCompany->getId() == $slice->getId()) {
                        return $questionnaireUser;
                    }
                }
            }
        }
        return null;
    }


    /**
     * Get questionnaire assessment
     * @return mixed|null
     */
    public function getAssessment(CompanyQuestionnaire $questionnaire = null)
    {
        // all questionnaires ordered by id desc
        // just try to found a first questionnaire in list
        // with required conditions
        if (!empty($questionnaire)) {
            if (($collection = $this->getQuestionnaires())) {
                foreach ($collection as $questionnaireUser) {
                    // required conditions here ist a
                    // no slice object, slice means QuestionnaireCompany
                    if (!$questionnaireUser->getSlice()) {
                        if (($questionnaireParent = $questionnaireUser->getQuestionnaire())) {
                            if ($questionnaire->getId() == $questionnaireParent->getId()) {
                                return $questionnaireUser;
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $gamifications;

    /**
     * Add gamifications
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamifications
     * @return User
     */
    public function addGamification(\Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamifications)
    {
        $this->gamifications[] = $gamifications;

        return $this;
    }

    /**
     * Remove gamifications
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamifications
     */
    public function removeGamification(\Fitbase\Bundle\GamificationBundle\Entity\GamificationUser $gamifications)
    {
        $this->gamifications->removeElement($gamifications);
    }

    /**
     * Get gamifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGamifications()
    {
        return $this->gamifications;
    }

    /**
     * @var boolean
     */
    protected $removeRequest;


    /**
     * @var \DateTime
     */
    protected $removeRequestAt;

    /**
     * @return boolean
     */
    public function getRemoveRequest()
    {
        return $this->removeRequest;
    }

    /**
     * @param $removeRequest
     * @return $this
     */
    public function setRemoveRequest($removeRequest)
    {
        $this->removeRequest = $removeRequest;

        return $this;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ExerciseUser
     */
    public function setRemoveRequestAt($removeRequestAt)
    {
        $this->removeRequestAt = $removeRequestAt;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getRemoveRequestAt()
    {
        return $this->removeRequestAt;
    }
}
