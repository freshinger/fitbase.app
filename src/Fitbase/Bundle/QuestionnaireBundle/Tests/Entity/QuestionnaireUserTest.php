<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Tests\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionnaireUserTest extends FitbaseTestAbstract
{
    public function test_MethodGetAnswersShouldReturnArrayCollection()
    {

        $question1 = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion();
        $question1->setId(34);

        $question2 = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion();
        $question2->setId(12);

        $questionnaireUser = (new QuestionnaireUser())
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question2))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1));


        $this->assertTrue($questionnaireUser->getAnswers($question2) instanceof ArrayCollection);
    }

    public function test_MethodGetAnswersShouldReturnCorrectAnswersCount()
    {

        $question1 = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion();
        $question1->setId(34);

        $question2 = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion();
        $question2->setId(12);

        $questionnaireUser = (new QuestionnaireUser())
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question2))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question2))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1));

        $this->assertTrue(count($questionnaireUser->getAnswers($question2)) == 2);
    }

    public function test_MethodGetAnswersShouldReturnCorrectAnswers()
    {
        $question1 = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion();
        $question1->setId(34);

        $question2 = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion();
        $question2->setId(12);

        $questionnaireUser = (new QuestionnaireUser())
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question2))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question2))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1))
            ->addAnswer((new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer())->setQuestion($question1));

        foreach ($questionnaireUser->getAnswers($question2) as $userAnswer) {
            $this->assertEquals($userAnswer->getQuestion()->getId(), $question2->getId());
        }
    }
} 