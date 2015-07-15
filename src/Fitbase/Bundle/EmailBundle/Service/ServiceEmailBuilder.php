<?php
namespace Fitbase\Bundle\EmailBundle\Service;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceEmailBuilder extends ContainerAware
{
    /**
     * Render exercise user reminder email
     * @param User $user
     * @param Company $company
     * @param $category
     * @param $categories
     * @return mixed
     */
    public function getExerciseUserReminderEmail(User $user, Company $company, $category, $categories)
    {
        $templating = $this->container->get('templating');
        return $templating->render('Email/Subscriber/UserExercise.html.twig', [
            'user' => $user,
            'company' => $company,
            'categoryFocus' => $category,
            'categories' => $categories
        ]);
    }

} 