<?php
namespace Application\Sonata\UserBundle\Tests\Entity;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function test_MethodGetAssessmentShouldReturnCorrectQuestionnaireUserObject()
    {
        $required = (new CompanyQuestionnaire())
            ->setId(3323333);

        $user = (new User())
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice(null)
                    ->setQuestionnaire(
                        (new CompanyQuestionnaire())
                            ->setId(323)
                    )
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice((new QuestionnaireCompany()))
                    ->setQuestionnaire($required)
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice(null)
                    ->setQuestionnaire($required)
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice(null)
                    ->setQuestionnaire(
                        (new CompanyQuestionnaire())
                            ->setId(33233)
                    )
            );

        $this->assertEquals($user->getAssessment($required)->getQuestionnaire()->getId(), $required->getId());
    }


    public function test_MethodGetAssessmentShouldReturnFirstSliceObject()
    {
        $required = (new CompanyQuestionnaire())
            ->setId(3323333);

        $user = (new User())
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(21)
                    ->setSlice(null)
                    ->setQuestionnaire($required)
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(24)
                    ->setSlice(null)
                    ->setQuestionnaire($required)
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(25)
                    ->setSlice(null)
                    ->setQuestionnaire($required)
            );

        $this->assertEquals($user->getAssessment($required)->getId(), 21);
    }


    public function test_getQuestionnaireSliceShouldNotReturnCorrectObject()
    {
        $required = (new QuestionnaireCompany())
            ->setId(999);

        $user = (new User())
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice(null)
                    ->setQuestionnaire(
                        (new CompanyQuestionnaire())
                            ->setId(323)
                    )
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(12)
                    ->setSlice($required)
                    ->setQuestionnaire((new CompanyQuestionnaire())
                        ->setId(123123))
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(14)
                    ->setSlice((new QuestionnaireCompany()))
                    ->setQuestionnaire((new CompanyQuestionnaire())
                        ->setId(3323333))
            );

        $this->assertTrue($user->getQuestionnaireSlice($required) instanceof QuestionnaireUser);
    }

    public function test_getQuestionnaireSliceShouldNotReturnFirstObject()
    {
        $required = (new QuestionnaireCompany())
            ->setId(999);

        $user = (new User())
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice(null)
                    ->setQuestionnaire(
                        (new CompanyQuestionnaire())
                            ->setId(323)
                    )
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(12)
                    ->setSlice($required)
                    ->setQuestionnaire((new CompanyQuestionnaire())
                        ->setId(3323333))
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(14)
                    ->setSlice($required)
                    ->setQuestionnaire((new CompanyQuestionnaire())
                        ->setId(455345))
            );

        $this->assertEquals($user->getQuestionnaireSlice($required)->getId(), 12);
    }

    public function test_getQuestionnaireSliceShouldNotReturnCorrectSlice()
    {
        $required = (new QuestionnaireCompany())
            ->setId(999);

        $user = (new User())
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setSlice(null)
                    ->setQuestionnaire(
                        (new CompanyQuestionnaire())
                            ->setId(323)
                    )
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(12)
                    ->setSlice($required)
                    ->setQuestionnaire((new CompanyQuestionnaire())
                        ->setId(3323333))
            )
            ->addQuestionnaire(
                (new QuestionnaireUser())
                    ->setId(14)
                    ->setSlice($required)
                    ->setQuestionnaire((new CompanyQuestionnaire())
                        ->setId(435345))
            );

        $this->assertEquals($user->getQuestionnaireSlice($required)->getSlice()->getId(), $required->getId());
    }
} 