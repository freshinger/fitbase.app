<?php
namespace Wellbeing\Bundle\ApiBundle\Service;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;
use Wellbeing\Bundle\ApiBundle\Entity\UserAuthenticationKey;

class ServiceUserAuthenticationKey extends ContainerAware
{
    /**
     * Datetime service
     *
     * @var
     */
    protected $datetime;

    /**
     * Entity manager object
     *
     * @var
     */
    protected $entityManager;

    /**
     * Class constructor
     *
     * @param $entityManager
     */
    public function __construct($entityManager, $datetime)
    {
        $this->datetime = $datetime;
        $this->entityManager = $entityManager;
    }

    /**
     * Start session
     * @param $user
     * @param $code
     * @return UserAuthenticationKey
     */
    public function start(User $user, $code)
    {
        $entity = (new UserAuthenticationKey())
            ->setUser($user)
            ->setCode($code)
            ->setStartDate($this->datetime->getDateTime('now'))
            ->setClose(null)
            ->setCloseDate(null);

        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
        $this->entityManager->refresh($entity);

        return $entity;
    }

    /**
     * Find a session by code
     * @param $code
     * @return mixed
     */
    public function find($code)
    {
        $repositoryUserAuthenticationKey = $this->entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserAuthenticationKey');
        return $repositoryUserAuthenticationKey->findOneByCode($code);
    }

    /**
     * Close session
     * @param $code
     * @return bool
     */
    public function close($code)
    {
        if (($entity = $this->find($code))) {

            $entity->setClose(true);
            $entity->setCloseDate($this->datetime->getDateTime('now'));

            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);
        }

        return true;
    }

} 