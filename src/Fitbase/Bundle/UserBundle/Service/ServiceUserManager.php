<?php

namespace Fitbase\Bundle\UserBundle\Service;

use Fitbase\Bundle\UserBundle\Entity\UserInterface;
use Fitbase\Bundle\UserBundle\Entity\UserMedimouse;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ServiceUserManager extends \Ekino\WordpressBundle\Manager\UserManager implements ContainerAwareInterface
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
     * Get current user company
     * @param $user
     * @return null
     */
    public function getCompany($user)
    {
        if (($company = $user->getMetaValue('user_company_id'))) {

            $repositoryCompany = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

            return $repositoryCompany->find($company);
        }
        return null;
    }

    /**
     * Set company to user
     * @param $user
     * @param null $company
     * @return bool
     */
    public function setUserCompany($user, $company = null)
    {
        if (!empty($company)) {
            $this->updateUserMeta($user, 'user_company_id', $company->getId());
            return true;
        } else {
            $this->removeUserMeta($user, 'user_company_id');
            return true;
        }
        return false;
    }

    /**
     * Check is user has questionnaire completed
     * TODO: this is a company feature, needs to create user_company table
     * TODO: to save all company features here
     * @param null $user
     * @return null
     */
    public function getIsQuestionnaireCompleted($user = null)
    {
        if ($user != null) {
            return $user->getMetaValue('user_questionnaire_completed');
        }
        return null;
    }

    /**
     * Generate login from first- and last-name
     * @param $nameFirst
     * @param $nameLast
     * @return string
     */
    public function getLogin($nameFirst, $nameLast)
    {
        $first_name_clean = preg_replace("[^a-z0-0]", "", strtolower(trim($nameFirst)));
        $last_name_clean = preg_replace("[^a-z0-0]", "", strtolower(trim($nameLast)));

        $login = "$first_name_clean.$last_name_clean";

        $index = 1;
        $login_check = $login;
        while (($user = $this->findOneBy(array('login' => $login_check)))) {
            $login_check = "{$login}_{$index}";
            $index++;
        }
        return $login_check;

    }


    /**
     * Generate login
     * @deprecated
     * @param UserInterface $user
     * @return string
     */
    public function generateLogin(UserInterface $user)
    {
        $first_name_clean = preg_replace("[^a-z0-0]", "", strtolower(trim($user->getNameFirst())));
        $last_name_clean = preg_replace("[^a-z0-0]", "", strtolower(trim($user->getNameLast())));

        $login = "$first_name_clean.$last_name_clean";

        $index = 1;
        $login_check = $login;
        while (($user = $this->findOneBy(array('login' => $login_check)))) {
            $login_check = "{$login}_{$index}";
            $index++;
        }
        return $login_check;

    }

    /**
     * Generate password string
     * @param int $length
     * @return string
     */
    public function generatePassword($length = 10)
    {
        $password = '';
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?=-_+@<>';
        for ($i = 0; $i < $length; $i++) {
            $password .= $string{rand(0, strlen($string) - 1)};
        }
        return $password;
    }

    /**
     * Generate user name from parts
     * @param UserInterface $user
     * @return string
     */
    public function generateName(UserInterface $user)
    {
        return sanitize_user($user->getNameFirst()) . ' ' . sanitize_user($user->getNameLast());
    }

    /**
     * Generate Medimouse Profile
     * @param UserMedimouse $entity
     * @return array
     */
    public function generateMedimouseProfile(UserMedimouse $entity)
    {
        return array(
            'bereich' => $entity->getBereich(),
            'type' => $entity->getType(),
            'extra' => $entity->getExtra(),
        );
    }

    /**
     * Calculate training schema for user for day one
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaOne($bereich, $extras)
    {
        switch ($bereich) {
            case 'SN':
                return 'SN';
            case 'MR':
                return 'MR';
            case 'UR':
                return 'UR';
        }
    }

    /**
     * Calculate training schema for user for day two
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaTwo($bereich, $extras)
    {
        $isThree = count($extras) == 3;

        switch ($bereich) {
            case 'SN':
                if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'MR';
                }
            case 'MR':
                if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'SN';
                }
            case 'UR':
                if ($isThree) {
                    return 'TH';
                } else {
                    return 'MR';
                }
        }
    }

    /**
     * Calculate training schema for user for day three
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaThree($bereich, $extras)
    {
        $isOne = count($extras) == 1;
        $isTwo = count($extras) == 2;
        $isThree = count($extras) == 3;

        switch ($bereich) {
            case 'SN':
                if ($isOne) {
                    return 'RS';
                } else if ($isTwo) {
                    return $extras[rand(0, 1)];
                } else if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'UR';
                }
            case 'MR':
                if ($isOne) {
                    return 'AU';
                } else if ($isTwo) {
                    return $extras[rand(0, 1)];
                } else if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'UR';
                }
            case 'UR':
                if ($isOne) {
                    return 'TH';
                } else if ($isTwo) {
                    return $extras[rand(0, 1)];
                } else if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'SN';
                }

        }
    }

    /**
     * Calculate training schema for user for day four
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaFour($bereich, $extras)
    {
        switch ($bereich) {
            case 'SN':
                return 'SN';
            case 'MR':
                return 'SN';
            case 'UR':
                return 'UR';
        }
    }

    /**
     * Calculate training schema for user for day five
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaFive($bereich, $extras)
    {
        $isTwo = count($extras) == 2;
        $isThree = count($extras) == 3;

        switch ($bereich) {
            case 'SN':
                if ($isTwo) {
                    return $extras[rand(0, 1)];
                } else if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'MR';
                }
            case 'MR':
                if ($isTwo) {
                    return $extras[rand(0, 1)];
                } else if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'MR';
                }

            case 'UR':
                if ($isTwo) {
                    return $extras[rand(0, 1)];
                } else if ($isThree) {
                    return $extras[rand(0, 2)];
                } else {
                    return 'MR';
                }
        }
    }

    /**
     * Calculate training schema for user for day six
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaSix($bereich, $extras)
    {
        switch ($bereich) {
            case 'SN':
                return 'UR';
            case 'MR':
                return 'UR';
            case 'UR':
                return 'SN';
        }

    }

    /**
     * Calculate training schema for user for day seven
     * @param $bereich
     * @param $extras
     * @return string
     */
    public function generateMedimouseTrainingSchemaSeven($bereich, $extras)
    {
        switch ($bereich) {
            case 'SN':
                return 'SN';
            case 'MR':
                return 'MR';
            case 'UR':
                return 'UR';
        }
    }

    /**
     * Generate training schema based on user medimouse profile
     * Codes Bereich: SN, MR, UR, OR, OU,
     * Codes Typ: FT, ST, LT
     * Codes Extra: RS, TH, AU
     * @param UserMedimouse $entity
     * @return array
     */
    public function generateMedimouseTrainingSchema(UserMedimouse $entity)
    {
        return array(
            1 => $this->generateMedimouseTrainingSchemaOne($entity->getBereich(), $entity->getExtra()),
            2 => $this->generateMedimouseTrainingSchemaTwo($entity->getBereich(), $entity->getExtra()),
            3 => $this->generateMedimouseTrainingSchemaThree($entity->getBereich(), $entity->getExtra()),
            4 => $this->generateMedimouseTrainingSchemaFour($entity->getBereich(), $entity->getExtra()),
            5 => $this->generateMedimouseTrainingSchemaFive($entity->getBereich(), $entity->getExtra()),
            6 => $this->generateMedimouseTrainingSchemaSix($entity->getBereich(), $entity->getExtra()),
            7 => $this->generateMedimouseTrainingSchemaSeven($entity->getBereich(), $entity->getExtra()),
        );
    }


    /**
     * Get current daily focus from user
     * @param $association
     * @return null
     */
    public function getUserDailyFocusMedimouse($association)
    {
        assert(($user = $this->getCurrentUser()), 'User can not be empty');
        $this->container->get('logger')->info('User Exercise, get current by rules', array((string)$user));

        if (($profile = $user->getMetaValue('medimouseTrainingsSchema'))) {
            $profile = unserialize($profile);
            $this->container->get('logger')->info('User Exercise, profile settings found', array($profile));

            $day = date('N');

            if (!isset($profile[$day])) {
                $this->container->get('logger')->info('User Exercise, profile setting day empty', array($user));
                return null;
            }

            $this->container->get('logger')->info('User Exercise, daily focus', array($profile[$day]));
            return $profile[$day];
        }
        return null;
    }


    /**
     * Get current user from wordpres service
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->container
            ->get('fitbase_service.wordpress')
            ->getCurrentUser();
    }

    /**
     * Update user meta, if not exists create new user meta
     * @param $user
     * @param $name
     * @param $value
     */
    public function saveUserMeta($user, $name, $value)
    {
        foreach ($user->getMetas() as $meta) {
            if ($name == $meta->getKey()) {
                $this->container->get('ekino.wordpress.manager.user_meta')
                    ->save($meta->setValue($value), true);
                return;
            }
        }

        $valueString = null;
        if (is_object($value) or is_array($value)) {
            $valueString = serialize($value);
        } else {
            $valueString = $value;
        }

        $meta = new \Ekino\WordpressBundle\Entity\UserMeta();
        $meta->setKey($name)
            ->setValue($valueString)
            ->setUser($user);

        $this->container->get('ekino.wordpress.manager.user_meta')
            ->save($meta, true);
    }

    /**
     * Get list with mentee id
     * @param $user
     * @return array
     */
    public function getListeMenteeId($user)
    {
        if (is_object($user)) {
            return unserialize(
                unserialize(
                    $user->getMetaValue('mentees_ids')
                )
            );
        }
        return array();
    }


    /**
     * Get list of mentee
     * @param $array
     * @return array
     */
    public function getListMentee($array)
    {
        if (!empty($array) and count($array)) {
            $queryBuilder = $this->repository->createQueryBuilder("mentees");
            $queryBuilder->where($queryBuilder->expr()->in('mentees.id', $array));
            return $queryBuilder->getQuery()->getResult();
        }
        return array();
    }

    /**
     * Get list of mentors
     * @return array
     */
    public function getListMentor()
    {
        $queryBuilder = $this->repository->createQueryBuilder("Mentor");

        $queryBuilder->setParameter('key', 'fb_capabilities');
        $queryBuilder->setParameter(':value', '%mentor%');

        $queryBuilder->leftJoin('Mentor.metas', 'UserMeta', \Doctrine\ORM\Query\Expr\Join::WITH, 'UserMeta.user = Mentor.id');
        $queryBuilder->where($queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq('UserMeta.key', ':key'),
            $queryBuilder->expr()->like('UserMeta.value', ':value')
        ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get mentee object for current user
     * @return User|null
     */
    public function getUserMentee($user, $unique)
    {
        if (in_array($unique, $this->getListeMenteeId($user))) {
            return $this->find($unique);
        }
        return null;
    }

    /**
     * Get list of user modules
     * @return array
     */
    public function getModules($user)
    {
        if (($modules = $user->getMetaValue('booked_modules'))) {
            if (!empty($modules) and ($modules = unserialize($modules))) {
                return $this->container->get('fitbase_entity_manager')
                    ->getRepository('\Ekino\WordpressBundle\Entity\Post')
                    ->findBy(array('id' => array_keys($modules)));
            }
        }
        return array();
    }

    /**
     * Get list of user mentors
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @return array
     */
    public function getMentors($user)
    {
        if (($mentor_id = fbum_plugin_get_mentor_id($user->getId()))) {
            return $this->find($mentor_id);
        }
        return null;
    }

    /**
     * Set user mentor
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @return boolean
     */
    public function setUserMentor($user, $mentor)
    {
        return fbum_plugin_mentor_add_mentee($mentor->getId(), $user->getId());
    }

    /**
     * Get credit count for module
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @return int
     */
    public function getModuleRequiredCredits($module)
    {
        return module_plugin_get_module_required_credits($module->getId());
    }

    /**
     * Get credit counts
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @return int
     */
    public function getCountCredit(\Ekino\WordpressBundle\Entity\User $user)
    {
        return fbum_plugin_user_credits($user->getId());
    }

    /**
     * Get user first name
     * @return string
     */
    public function getUserFirstName(\Ekino\WordpressBundle\Entity\User $user)
    {
        return $user->getMetaValue('first_name');
    }

    /**
     * Get user last name
     * @return string
     */
    public function getUserLastName(\Ekino\WordpressBundle\Entity\User $user)
    {
        return $user->getMetaValue('last_name');
    }


    /**
     * Get company name for current user
     * @deprecated
     * @return string
     */
    public function getUserCompanyName(\Ekino\WordpressBundle\Entity\User $user)
    {
        if (($company = $this->getCompany($user))) {
            return $company->getName();
        }
        return 'Kein Unternehmen';
    }

    /**
     * Is user a mentor
     * @return boolean
     */
    public function getIserUserMentor($user)
    {
        if (($metas = $user->getMetas())) {
            foreach ($metas as $meta) {
                if ('fb_capabilities' == $meta->getKey()) {
                    if (($roles = unserialize($meta->getValue()))) {
                        return isset($roles['mentor']);
                    }
                }
            }

        }
        return false;
    }

    /**
     * Set user role
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @param $user
     * @param $role
     * @return void
     */
    public function setUserRole($user, $role)
    {
        $wp_user = new \WP_User($user->getId());
        $wp_user->set_role($role);
    }

    /**
     * Set user meta
     * @param $user
     * @param $name
     * @param $value
     * @return void
     */
    public function updateUserMeta($user, $name, $value)
    {
        if (($user_meta = $this->setUserMeta($user, $name, $value))) {
            $this->container->get('ekino.wordpress.manager.user_meta')->save($user_meta, true);
        }
    }

    /**
     * Remove user meta
     * @return void
     */
    public function removeUserMeta($user, $name)
    {
        if (($user_meta = $this->getUserMeta($user, $name))) {
            $this->container->get('ekino.wordpress.manager.user_meta')->remove($user_meta);
        }
    }

    /**
     * Get user meta object
     * @param $user
     * @param $name
     * @return UserMeta
     */
    protected function getUserMeta($user, $name)
    {
        foreach ($user->getMetas() as $meta) {
            if ($name == $meta->getKey()) {
                return $meta;
            }
        }
        return null;
    }

    /**
     * Update or create a user meta
     * @param $user
     * @param $name
     * @param $value
     * @return \Ekino\WordpressBundle\Entity\UserMeta
     */
    protected function setUserMeta($user, $name, $value)
    {
        foreach ($user->getMetas() as $meta) {
            if ($name == $meta->getKey()) {
                return $meta->setValue($value);
            }
        }

        $meta = new \Ekino\WordpressBundle\Entity\UserMeta();
        $meta->setKey($name);
        $meta->setValue($value);
        $meta->setUser($user);
        return $meta;
    }

    /**
     * Create new user from array
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @param $array
     * @throws \Symfony\Component\DependencyInjection\Exception\LogicException
     * @return User object
     */
    public function createUserFromArray($array)
    {
        if (($result = wp_insert_user($array))) {
            if ($result instanceof \WP_Error) {
                throw new LogicException($result->get_error_data());
            }
            return $this->find($result);
        }
    }

    /**
     * Add credits to user account
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @return void
     */
    public function addUserCredits($user, $count)
    {
        if (!empty($count)) {
            fbum_plugin_user_add_credits($user->getId(), 0, abs($count));
            return true;
        }
        return false;
    }

    /**
     * Add modules to user
     * @api wordpress bridge
     * @return boolean
     */
    public function addUserModules($user, $collection = null)
    {

        if (!empty($collection) and count($collection)) {
            foreach ($collection as $index => $module) {
                if (!$this->addUserModule($user, $module)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Add module to user
     * @api wordpress bridge
     * @todo remove binding with wordpress method
     * @return boolean
     */
    public function addUserModule($user, $module)
    {
        if (!empty($module)) {
//            $this->container->get('logger')->debug('MODULE: book ', array($user, $module));
            module_plugin_book_module($module->getId(), $user->getId());
            return true;
        }
        return false;
    }

}