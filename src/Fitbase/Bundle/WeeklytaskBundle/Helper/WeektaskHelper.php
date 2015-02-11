<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Helper;

use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class WeektaskHelper extends \Twig_Extension implements ContainerAwareInterface
{
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get functions from a helper
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('icon', array($this, 'getWeeklytaskIcon')),
            new \Twig_SimpleFunction('get_weeklyquiz_user_answer_points', array($this, 'getWeeklyquizUserAnswerPoints')),
        );
    }

    /**
     * Calculate weeklytask image preview
     * try to find first image, use as icon
     * todo: resize and crop
     *
     * @param Weeklytask $weeklytask
     * @return null|string
     */
    public function getWeeklytaskIcon(Weeklytask $weeklytask)
    {
        if (($content = $weeklytask->getContent())) {
            \phpQuery::newDocumentHTML($content);
            if (($images = pq('img'))) {
                if (($image = (isset($images[0])) ? $images[0] : null)) {
                    return "<img src='{$image->attr('src')}' height='112px;'>";
                }
            }
        }
        // TODO: return default empty image
        return null;
    }

    public function getWeeklyquizUserAnswerPoints($weeklyquiz = null)
    {
        $points = 0;

        if (($user = $this->container->get('user')->current())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
            if (($weeklyquizUser = $repositoryWeeklyquiz->findOneByUserAndQuiz($user, $weeklyquiz))) {
                $repositoryWeeklyquizUserAnswer = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer');
                if (($answersUser = $repositoryWeeklyquizUserAnswer->findAllByUserAndUserQuiz($user, $weeklyquizUser))) {
                    foreach ($answersUser as $answerUser) {
                        $points += $answerUser->getCountPoint();
                    }
                }
            }
        }

        return $points;
    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('post', array($this, 'getPostName')),
            new \Twig_SimpleFilter('quiz', array($this, 'getQuizName')),
            new \Twig_SimpleFilter('quizName', array($this, 'getQuizNameByWeeklytaskId')),
            new \Twig_SimpleFilter('quizCode', array($this, 'getQuizCodeByWeeklytaskId')),

            new \Twig_SimpleFilter('boolean', array($this, 'getBooleanAsString')),
            new \Twig_SimpleFilter('category', array($this, 'getCategoryByWeeklytaskId')),
            new \Twig_SimpleFilter('weeklytask', array($this, 'getWeeklytaskName')),
            new \Twig_SimpleFilter('weeklytaskPointQuiz', array($this, 'getWeeklytaskCountPointQuiz')),
            new \Twig_SimpleFilter('weeklytaskPointAnswer', array($this, 'getWeeklytaskCountPointAnswer')),
            new \Twig_SimpleFilter('weeklytaskPointTotal', array($this, 'getWeeklytaskCountPointTotal')),

            new \Twig_SimpleFilter('postTitle', array($this, 'getPostTaskTitleById')),
            new \Twig_SimpleFilter('postTaskPermalink', array($this, 'getPostTaskPermalinkById')),
            new \Twig_SimpleFilter('postTaskCategory', array($this, 'getPostTaskCategoryById')),
            new \Twig_SimpleFilter('statusIcon', array($this, 'getStatusIcon')),
            new \Twig_SimpleFilter('weeklytask_count', array($this, 'getWeeklytaskCountByCategory')),


        );
    }

    /**
     * @param WeeklytaskUser $weeklytaskUser
     * @return int
     */
    public function getWeeklytaskCountPointAnswer(WeeklytaskUser $weeklytaskUser)
    {
        $managerEntity = $this->container->get('entity_manager');

        $user = $this->container->get('user')->current();

        $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        $weeklytaskUserQuiz = $repositoryWeeklyquizUser->findOneByUserAndWeeklytaskId($user, $weeklytaskUser->getWeeklytaskId());
        $countPointTotal = 0;
        if (!empty($weeklytaskUserQuiz)) {
            $repositoryWeeklyquizUserAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer');
            $collectionWeeklyquizUserAnswer = $repositoryWeeklyquizUserAnswer->findAllByWeeklyquizUser($weeklytaskUserQuiz);
            foreach ($collectionWeeklyquizUserAnswer as $weeklytaskUserAnswer) {
                if ($weeklytaskUserAnswer->getCorrect()) {
                    $countPointTotal += $weeklytaskUserAnswer->getCountPoint();
                }
            }
        }

        return $countPointTotal;
    }

    /**
     *
     * @param WeeklytaskUser $weeklytaskUser
     * @return int
     */
    public function getWeeklytaskCountPointQuiz(WeeklytaskUser $weeklytaskUser)
    {
        $managerEntity = $this->container->get('entity_manager');

        $user = $this->container->get('user')->current();

        $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        $weeklytaskUserQuiz = $repositoryWeeklyquizUser->findOneByUserAndWeeklytaskId($user, $weeklytaskUser->getWeeklytaskId());
        if (!empty($weeklytaskUserQuiz)) {
            return $weeklytaskUserQuiz->getCountPoint();
        }
        return 0;
    }


    /**
     * Return total weeklytask points count
     * @param WeeklytaskUser $weeklytaskUser
     * @return mixed
     */
    public function getWeeklytaskCountPointTotal(WeeklytaskUser $weeklytaskUser)
    {
        $managerEntity = $this->container->get('entity_manager');

        $user = $this->container->get('user')->current();

        $repositoryWeeklyquizUser = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        $weeklytaskUserQuiz = $repositoryWeeklyquizUser->findOneByUserAndWeeklytaskId($user, $weeklytaskUser->getWeeklytaskId());

        $countPointTotal = $weeklytaskUser->getCountPoint();
        if (!empty($weeklytaskUserQuiz)) {
            $countPointTotal += $weeklytaskUserQuiz->getCountPoint();
            $repositoryWeeklyquizUserAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer');
            $collectionWeeklyquizUserAnswer = $repositoryWeeklyquizUserAnswer->findAllByWeeklyquizUser($weeklytaskUserQuiz);
            foreach ($collectionWeeklyquizUserAnswer as $weeklytaskUserAnswer) {
                if ($weeklytaskUserAnswer->getCorrect()) {
                    $countPointTotal += $weeklytaskUserAnswer->getCountPoint();
                }
            }
        }

        return $countPointTotal;
    }

    /**
     * Find weekly task code
     * @param $weeklytaskId
     * @return null
     */
    public function getQuizCodeByWeeklytaskId($weeklytaskId)
    {
        $user = $this->container->get('user')->current();

        $repositoryWeeklyquiz = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

        if (($weeklytaskUserQuiz = $repositoryWeeklyquiz->findOneByUserAndWeeklytaskId($user, $weeklytaskId))) {
            return $weeklytaskUserQuiz->getCode();
        }

        return null;
    }

    /**
     * Get quiz name by weeklytask id
     * @param $weeklytaskId
     * @return null
     */
    public function getQuizNameByWeeklytaskId($weeklytaskId)
    {
        $repositoryWeeklyquiz = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

        if (($weeklytaskQuiz = $repositoryWeeklyquiz->findOneByWeeklytaskId($weeklytaskId))) {
            return $weeklytaskQuiz->getName();
        }
        return null;
    }

    /**
     * Get weeklytask category name
     * @param $weeklytaskId
     * @return null
     */
    public function getCategoryByWeeklytaskId($weeklytaskId)
    {
        $repositoryWeeklytask = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        if (($weeklytask = $repositoryWeeklytask->find($weeklytaskId))) {
            return $weeklytask->getCategory();
        }

        return null;
    }

    /**
     * Get string for boolean
     * @param $boolean
     * @return string
     */
    public function getBooleanAsString($boolean)
    {
        return $boolean ? 'Richtig' : 'Falsch';
    }

    /**
     * Get weeklytask count by category
     * @param null $string
     * @return mixed
     */
    public function getWeeklytaskCountByCategory($string = null)
    {
        $repositoryWeeklytask = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        return $repositoryWeeklytask->findCountByCategory($string);
    }

    /**
     * Get weeklytask name
     * @param null $weeklytaskId
     * @return null
     */
    public function getWeeklytaskName($weeklytaskId = null)
    {
        if ($weeklytaskId != null) {

            $repositoryWeeklytask = $this->container->get('entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

            if (($weeklytaskQuiz = $repositoryWeeklytask->find($weeklytaskId))) {
                return $weeklytaskQuiz->getName();
            }
        }
        return null;
    }

    /**
     * Get post name
     * @param null $postId
     * @return null
     */
    public function getPostName($postId = null)
    {
        if ($postId != null) {

            $entityManager = $this->container->get('entity_manager');
            if (($post = $entityManager->find('Ekino\WordpressBundle\Entity\Post', $postId))) {
                return $post->getTitle();
            }
        }
        return null;
    }

    /**
     * Get quiz name
     * @param null $quizId
     * @return null
     */
    public function getQuizName($quizId = null)
    {
        if ($quizId !== null) {

            $repositoryWeeklyquiz = $this->container->get('entity_manager')
                ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

            if (($weeklytaskQuiz = $repositoryWeeklyquiz->find($quizId))) {
                return $weeklytaskQuiz->getName();
            }
        }

        return null;
    }


    /**
     * Get custom link for page
     * @param $unique
     * @return mixed
     */
    public function getPostTaskPermalinkById($unique)
    {
        $post = $this->container->get('entity_manager')
            ->find('Ekino\WordpressBundle\Entity\Post', $unique);

        return $this->container
            ->get('fitbase_service.wordpress')
            ->getPostLink($post);
    }

    /**
     * Get icon link
     * @param $done
     * @return string
     */
    public function getStatusIcon($done = null)
    {
        if ($done !== null and $done) {
            return "/wp-content/uploads/icon_check_green.png";
        }
        return "/wp-content/uploads/icon_no_red.png";
    }

    /**
     * Get post next date
     * @param $post
     * @return mixed
     */
    public function getPostDateNext($post)
    {
        if (($user = $this->container->get('user')->current())) {
            if (($date = $this->container->get('weeklytask')->getPostNextDate($user, $post))) {
                return $date->format('d.m.Y');
            }
        }
        return null;
    }

    /**
     * Get post Category
     * @param $unique
     * @return null
     */
    public function getPostTaskCategoryById($unique)
    {
        $post = $this->container->get('entity_manager')
            ->find('Ekino\WordpressBundle\Entity\Post', $unique);

        if ($post !== null) {
            return $post->getMetaValue('category');
        }
        return null;
    }


    public function getPostTaskTitleById($unique)
    {
        $post = $this->container->get('entity_manager')
            ->find('Ekino\WordpressBundle\Entity\Post', $unique);

        if (!empty($post)) {
            return $post->getTitle();
        }
        return null;
    }

    /**
     * Get post week
     * @param $unique
     * @return int|null
     */
    public function getPostTaskWeekById($unique)
    {
        $post = $this->container->get('entity_manager')
            ->find('Ekino\WordpressBundle\Entity\Post', $unique);

        if ($post !== null) {
            return (int)$post->getMetaValue('week');
        }
        return null;
    }

    /**
     * @param $unique
     * @return int|null
     */
    public function getPostTaskPointsById($unique)
    {
        $post = $this->container->get('entity_manager')
            ->find('Ekino\WordpressBundle\Entity\Post', $unique);

        if ($post !== null) {
            return (int)$post->getMetaValue('points');
        }
        return null;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_task_extension';
    }
}