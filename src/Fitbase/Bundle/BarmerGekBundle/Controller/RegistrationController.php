<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/06/15
 * Time: 12:41
 */

namespace Fitbase\Bundle\BarmerGekBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\BarmerGekBundle\Form\RegistrationUserForm;
use Fitbase\Bundle\BarmerGekBundle\Model\RegistrationUser;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     *
     * @todo: add validation on registration using barmer api
     *
     * @param Request $request
     * @param $unique
     * @param $session
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request, $unique, $session)
    {
        $entityManager = $this->get('entity_manager');
        $repository = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

        if (!($company = $repository->findOneBySlug('barmer_gek_private'))) {
            throw new \LogicException('Barmer GEK company not found in database');
        }

        $entity = new RegistrationUser();
        $entity->setUnique($unique);
        $entity->setSession($session);

        $form = $this->createForm(new RegistrationUserForm(), $entity, array(
            'action' => $this->get('router')->generate('barmer_gek_registration', [
                'unique' => $unique,
                'session' => $session,
            ])
        ));

        if ($request->get($form->getName())) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $serviceBarmerApi = $this->get('barmer_gek_api');
                if ($serviceBarmerApi->user($entity->getUnique())) {

                    $user = new User();
                    $user->setPrivatePerson(true);
                    $user->setExternalId($entity->getUnique());
                    $user->setEmail($entity->getEmail());
                    $user->setCompany($company);
                    $user->setFirstname($entity->getFirstName());
                    $user->setLastname($entity->getLastName());
                    $user->setPlainPassword($this->get('codegenerator')->password(10));

                    $this->get('event_dispatcher')->dispatch('fitbase.user_register', new UserEvent($user));

                    return $this->redirect($this->generateUrl('dashboard', array(
                        'userId' => $entity->getUnique(),
                        'sessionKey' => $entity->getSession(),
                    )));
                }

                $form->addError(new FormError('Es gibt keine Verbindung mit dem BarmerGEK Server.'));
            }
        }

        return $this->render('BarmerGek/Registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}