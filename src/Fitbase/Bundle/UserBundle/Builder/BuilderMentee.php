<?php
namespace Fitbase\Bundle\UserBundle\Builder;

use Symfony\Component\DependencyInjection\ContainerAware;

class BuilderMentee extends ContainerAware
{
    public function buildMentee(\Fitbase\Bundle\UserBundle\Entity\Mentee $mentee, \Ekino\WordpressBundle\Entity\User $user)
    {
        $mentee->setEmail($user->getEmail());
        $mentee->setNameFirst($user->getMetaValue('first_name'));
        $mentee->setNameLast($user->getMetaValue('last_name'));
        $mentee->setRegisteredAt($user->getRegistered());
        $mentee->setMentees(unserialize(unserialize($user->getMetaValue('mentees_ids'))));
        $mentee->setIsMentor($this->container->get('fitbase_manager.user')->getIserUserMentor($user));
        $mentee->setCountCredit($this->container->get('fitbase_manager.user')->getCountCredit($user));
        $mentee->setCompany($this->container->get('fitbase_manager.user')->getCompany($user));
        $mentee->setMentors($this->container->get('fitbase_manager.user')->getMentors($user));
        $mentee->setModules($this->container->get('fitbase_manager.user')->getModules($user));
        $mentee->setTextEmail('');

        return $mentee;
    }

    /**
     * Build a wordpress user from current mentee object
     * @param \Ekino\WordpressBundle\Entity\User $user
     * @param \Fitbase\Bundle\UserBundle\Entity\Mentee $mentee
     * @return \Ekino\WordpressBundle\Entity\User
     */
    public function buildUser(\Ekino\WordpressBundle\Entity\User $user, \Fitbase\Bundle\UserBundle\Entity\Mentee $mentee)
    {

        return $user;
    }

    /**
     * Persist user meta
     * @param $user
     * @param $key
     * @param $value
     */
    protected function buildUserMeta($user, $name, $value)
    {
        foreach ($user->getMetas() as $meta) {
            if ($name == $meta->getKey()) {
                $meta->setValue($value);
                break;
            }
        }
    }

}
