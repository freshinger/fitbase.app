<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\TimelineBundle\Spread;


use FOS\UserBundle\Model\UserManagerInterface;
use Spy\Timeline\Model\ActionInterface;
use Spy\Timeline\Spread\Entry\EntryCollection;
use Spy\Timeline\Spread\SpreadInterface;
use Spy\Timeline\Spread\Entry\EntryUnaware;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AdminSpread implements SpreadInterface
{
    protected $supportedVerbs = array(
        'sonata.admin.create',
        'sonata.admin.update',
        'sonata.admin.delete',
    );

    protected $userClass;

    protected $serviceUser;

    public function __construct($userClass, $serviceUser)
    {
        $this->userClass = $userClass;
        $this->serviceUser = $serviceUser;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ActionInterface $action)
    {
        return in_array($action->getVerb(), $this->supportedVerbs);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ActionInterface $action, EntryCollection $coll)
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            $coll->add(new EntryUnaware($this->userClass, $user->getId()), 'SONATA_ADMIN');
        }
    }


    /**
     * Returns corresponding users
     *
     * @return \Doctrine\ORM\Internal\Hydration\IterableResult
     */
    protected function getUsers()
    {
        return $this->serviceUser->getAdmins();
    }
}