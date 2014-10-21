<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/12/14
 * Time: 12:40 PM
 */

namespace Fitbase\Bundle\GamificationBundle\Helper;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class GamificationHelper extends \Twig_Extension implements ContainerAwareInterface
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

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('color', array($this, 'getTreeColor')),
            new \Twig_SimpleFunction('emotion', array($this, 'getEmotion')),
        );
    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('feedback', array($this, 'getUserFeedbackCache')),
            new \Twig_SimpleFilter('tree', array($this, 'getUserTree')),
            new \Twig_SimpleFilter('forest', array($this, 'getCompanyForest')),
            new \Twig_SimpleFilter('forestPercent', array($this, 'getCompanyPercent')),

            new \Twig_SimpleFilter('emotion', array($this, 'getEmotion')),
        );
    }

    /**
     * Try to get emotion short-code
     * @param $int
     * @return null
     */
    public function getEmotion($int)
    {
        $association = array(
            -2 => 'anger',
            -1 => 'sad',
            0 => 'normal',
            1 => 'gut',
            2 => 'happy'
        );

        if (isset($association[$int])) {
            return $association[$int];
        }

        return null;
    }

    /**
     * Get user feedback from cache
     * @param $answer
     * @return null
     */
    public function getUserFeedbackCache($answer)
    {
        if (($unique = $answer->getId())) {
            $cache = $this->container->get('gamification_cache');
            if ($cache->has($unique)) {
                return $cache->get($unique);
            } else {
                if (($question = $answer->getQuestion())) {
                    if ($question->getType() == 'boolean') {
                        return $answer->getValue() ? 'Ja' : 'Nein';
                    }
                }
            }
        }
        return null;
    }

    /**
     * Calculate a color
     * @param $percent
     * @param $color1
     * @param $color2
     * @return mixed
     */
    public function getTreeColor($percent, $color1, $color2)
    {
        return (rand(1, 80) < (100 - $percent)) ? $color1 : $color2;
    }

    /**
     * Return user tree
     * @param $user
     * @return null
     */
    public function getUserTree($user)
    {
        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');
        if (($GamificationUserPointlog = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
            return $GamificationUserPointlog->getImage();
        }
        return $this->container->get('gamification')->tree(1300);
    }

    /**
     * Display company percent
     * @param null $company
     * @return float|int
     */
    public function getCompanyPercent($company = null)
    {
        if (!empty($company)) {

            $managerEntity = $this->container->get('fitbase_entity_manager');
            $repositoryUserMeta = $managerEntity->getRepository('Ekino\WordpressBundle\Entity\UserMeta');
            $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

            $collectionUserMeta = $repositoryUserMeta->findBy(array(
                'key' => 'user_company_id',
                'value' => $company->getId(),
            ));

            if (!empty($collectionUserMeta)) {

                $collectionUser = array();
                foreach ($collectionUserMeta as $userMeta) {
                    array_push($collectionUser, $userMeta->getUser());
                }


                $countPointlog = 0;
                $countPointlogPoint = 0;
                $collectionGamificationUserPointlog = $repositoryGamificationUserPointlog->findAllByUserIdArray($collectionUser);
                foreach ($collectionGamificationUserPointlog as $pointlog) {
                    $countPointlog += 1;
                    $countPointlogPoint += $pointlog->getCountPointTotal();
                }
                return $countPointlogPoint / $countPointlog;
            }
        }

        return 0;
    }

    /**
     * @param $company
     * @return mixed
     */
    public function getCompanyForest($company)
    {
        if (!$company instanceof \Fitbase\Bundle\CompanyBundle\Entity\Company) {
            return $this->container->get('gamification')->forest(2600);
        }

        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryUserMeta = $managerEntity->getRepository('Ekino\WordpressBundle\Entity\UserMeta');
        $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

        $collectionUserMeta = $repositoryUserMeta->findBy(array(
            'key' => 'user_company_id',
            'value' => $company->getId(),
        ));

        $collectionUser = array();
        foreach ($collectionUserMeta as $userMeta) {
            array_push($collectionUser, $userMeta->getUser());
        }

        $countPointlog = 0;
        $countPointlogPoint = 0;
        $collectionGamificationUserPointlog = $repositoryGamificationUserPointlog->findAllByUserIdArray($collectionUser);
        foreach ($collectionGamificationUserPointlog as $pointlog) {
            $countPointlog += 1;
            $countPointlogPoint += $pointlog->getCountPointTotal();
        }

        return $this->container->get('gamification')->forest($countPointlogPoint / $countPointlog);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_gamification_extension';
    }
} 