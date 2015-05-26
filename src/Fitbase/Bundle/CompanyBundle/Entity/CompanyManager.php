<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\CompanyBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;


class CompanyManager implements CompanyManagerInterface
{
    protected $class;
    protected $objectManager;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Find company by user
     *
     * @param $user
     * @return mixed
     */
    public function findOneByUser($user)
    {
        return $user->getCompany();
    }

    /**
     * Find company by slug
     *
     * @param $slug
     * @return mixed
     */
    public function findOneBySlug($slug)
    {
        return $this->repository->findOneBySlug($slug);
    }

    /**
     * Find company by site
     * @param $site
     * @return mixed
     */
    public function findOneBySite($site)
    {
        return $this->repository->findOneBySite($site);
    }
}