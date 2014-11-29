<?php
namespace Fitbase\Bundle\UserBundle\Listener;

use Fitbase\Bundle\UserBundle\Entity\UserPause;

use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Event\MenteeEvent;
use Fitbase\Bundle\UserBundle\Event\UserPauseEvent;
use Fitbase\Bundle\UserBundle\Event\RegisteredEvent;
use Fitbase\Bundle\UserBundle\Event\UserImportEvent;
use Fitbase\Bundle\UserBundle\Event\UserMedimouseEvent;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\Exception\LogicException;

class UserListener extends ContainerAware
{
    /**
     * Process user import
     * @param UserImportEvent $event
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function onUserImportEvent(UserImportEvent $event)
    {
        assert(is_object(($userImport = $event->getEntity())));

        $logger = $this->container->get('logger');
        $apiWordpress = $this->container->get('fitbase_wordpress.api');
        $userId = $apiWordpress->wpInsertUser(array(
            'role' => $userImport->getRole(),
            'user_email' => $userImport->getEmail(),
            'first_name' => $userImport->getNameFirst(),
            'last_name' => $userImport->getNameLast(),
            'user_login' => $userImport->getLogin(),
            'user_pass' => $userImport->getPassword(),
            'display_name' => $userImport->getNameDisplay(),
            'user_registered' => $userImport->getRegisteredAt()->format('Y-m-d H:i:s'),
        ));

        if ($userId instanceof \WP_Error) {
            $logger->info('User import, user does not created', array($userId));
            foreach ($userId->get_error_messages() as $message) {
                throw new LogicException($message);
            }
        }

        // Set Id  to imported object
        $userImport->setId($userId);

        // Notify system about imported user
        $userImportEvent = new UserImportEvent($userImport);
        $this->container->get('event_dispatcher')
            ->dispatch('fitbaseuser_imported', $userImportEvent);
    }

    /**
     * Create new user from medimouse page
     * @param UserMedimouseEvent $event
     * @throws \Exception
     */
    public function onUserMedimouseCreateEvent(UserMedimouseEvent $event)
    {
        assert(is_object(($medimouse = $event->getEntity())), "Event Entity Object can not be empty");
        assert(is_object(($managerUser = $this->container->get('user'))), "User Manager service can not be empty");

        $this->container->get('logger')->info('Medimouse task', array($medimouse));

        $result = $this->container->get('fitbase_wordpress.api')
            ->wpInsertUser(array(
                'role' => $medimouse->getRole(),
                'user_email' => $medimouse->getEmail(),
                'first_name' => $medimouse->getNameFirst(),
                'last_name' => $medimouse->getNameLast(),
                'user_login' => $medimouse->getLogin(),
                'user_pass' => $medimouse->getPassword(),
                'display_name' => $medimouse->getDisplayName(),
                'user_registered' => $medimouse->getRegistered(),
            ));

        if ($result instanceof \WP_Error) {
            throw new \Exception($result->get_error_data());
        }

        $user = $managerUser->find($result);
        $user->setRegistered(new \DateTime());
        $managerUser->save($user);

        $this->container->get('logger')->info('Medimouse task, user created', array((string)$user));

        if (($profile = $managerUser->generateMedimouseProfile($medimouse))) {
            $managerUser->saveUserMeta($user, 'medimouseProfile', $profile);
            $this->container->get('logger')->info('Medimouse task, user profile', array($profile));
        }

        if (($schema = $managerUser->generateMedimouseTrainingSchema($medimouse))) {
            $managerUser->saveUserMeta($user, 'medimouseTrainingsSchema', $schema);
            $this->container->get('logger')->info('Medimouse task, user schema', array($schema));
        }

        if (($focus = $medimouse->getBereich())) {
            $focus = str_replace(array('SN', 'MR', 'UR'), array('sn', 'ub', 'lb'), $medimouse->getBereich());
            $managerUser->saveUserMeta($user, 'user_exercise_focus', $focus);
            $this->container->get('logger')->info('Medimouse task, user focus', array($focus));
        }

        if (($isAugen = in_array('AU', $medimouse->getExtra()))) {
            $managerUser->saveUserMeta($user, 'user_exercise_eye', $isAugen);
            $this->container->get('logger')->info('Medimouse task, user eye', array($isAugen));
        }

        if (($isRSI = in_array('RS', $medimouse->getExtra()))) {
            $managerUser->saveUserMeta($user, 'user_exercise_rsi', $isRSI);
            $this->container->get('logger')->info('Medimouse task, user RSI', array($isRSI));
        }

        if (($isThera = in_array('TH', $medimouse->getExtra()))) {
            $managerUser->saveUserMeta($user, 'user_exercise_thera', $isThera);
            $this->container->get('logger')->info('Medimouse task, user thera band', array($isThera));
        }

        $eventUserMedimouse = new UserMedimouseEvent($medimouse);
        $this->container->get('event_dispatcher')
            ->dispatch('fitbaseuser_medimouse_created', $eventUserMedimouse);
    }

    /**
     * Change user password
     * @param UserPasswordEvent $event
     */
    public function onUserPasswordUpdateEvent(UserPasswordEvent $event)
    {
        assert(is_object(($password = $event->getEntity())), "Password Object can not be empty");

        $user = $this->container->get('user')->current();

        $wordpress = $this->container->get('fitbase_wordpress.api');

        $wordpress->wpSetPassword($password->getPassword(), $user->getId());
        $wordpress->wpSetCurrentUser($user->getId());
        $wordpress->wpSetAuthCookie($user->getId());


        $event = new RegisteredEvent($user);
        $event->setFirstName($user->getMetaValue('first_name'));
        $event->setLastName($user->getMetaValue('last_name'));
        $event->setEmail($user->getEmail());
        $event->setDisplayName($user->getDisplayName());
        $event->setPassword($password->getPassword());

        $this->container->get('event_dispatcher')->dispatch('fitbaseuser_password_updated', $event);
    }

    /**
     * Save user profile data
     * @param UserProfileEvent $event
     */
    public function onUserProfileUpdateEvent(UserProfileEvent $event)
    {
        assert(is_object(($profile = $event->getEntity())), "Profile Object can not be empty");

        $wordpress = $this->container->get('fitbase_wordpress.api');

        $user = $this->container->get('user')->current();

        $wordpress->wpUpdateUserMeta($user->getId(), 'user_form_of_address', $profile->getAnrede());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_title', $profile->getTitel());
        $wordpress->wpUpdateUserMeta($user->getId(), 'first_name', $profile->getVorname());
        $wordpress->wpUpdateUserMeta($user->getId(), 'last_name', $profile->getNachname());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_street', $profile->getStrasse());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_house_number', $profile->getHausnummer());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_zipcode', $profile->getPostzahl());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_city', $profile->getOrt());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_phone_number', $profile->getPhone());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_cell_phone_number', $profile->getHandy());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_birthday', $profile->getGeburtsdatum());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_privacy', $profile->getShowInStatistic());

        $user->setEmail($user->getEmail());
        $this->container->get('user')->save($user, true);
    }

}