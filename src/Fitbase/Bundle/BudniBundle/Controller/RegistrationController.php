<?php

namespace Fitbase\Bundle\BudniBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\BudniBundle\Form\RegistrationUserForm;
use Fitbase\Bundle\BudniBundle\Model\RegistrationUser;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @param null $code
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request, $code = null)
    {
        $entityManager = $this->get('entity_manager');
        $repository = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

        if (!($company = $repository->findOneBySlug('budni'))) {
            throw new \LogicException('Budni company not found in database');
        }

        $entity = new RegistrationUser();
        $form = $this->createForm(new RegistrationUserForm(), $entity, array(
            'action' => $this->get('router')->generate('budni_registration', [
                'code' => $code
            ])
        ));

        if ($request->get($form->getName())) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $user = new User();
                $user->setEmail($entity->getEmail());
                $user->setCompany($company);
                $user->setFirstname($entity->getFirstName());
                $user->setLastname($entity->getLastName());
                $user->setPlainPassword($this->get('codegenerator')->password(10));

                $this->get('event_dispatcher')->dispatch('fitbase.user_register', new UserEvent($user));

                return $this->redirect($this->get('fitbase_helper.user')->getSign(
                    $user, $this->generateUrl('dashboard', [], true)
                ));
            }
        }

        return $this->render('Budni/Registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
