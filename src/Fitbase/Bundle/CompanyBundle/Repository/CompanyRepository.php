<?php

namespace Fitbase\Bundle\CompanyBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{
    /**
     * Find company by user
     * @param $user
     * @return mixed
     */
    public function findOneByUser($user = null)
    {
        if ($user != null) {
            if (($id = $user->getMetaValue('user_company_id'))) {
                return $this->findOneById($id);
            }
        }
        return null;
    }
}
