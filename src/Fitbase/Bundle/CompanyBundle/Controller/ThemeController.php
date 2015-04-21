<?php

namespace Fitbase\Bundle\CompanyBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireCompanyEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends Controller
{
    /**
     *
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function themeAction(Request $request, $unique = null)
    {
        $content = $this->renderView('Theme/Company/theme.css.twig', array(
            'company' => $this->get('company')->current()
        ));

        return new Response($content, 200, array(
            'Content-Type' => 'text/css',
            'Content-Disposition' => 'inline; filename="theme.css"'
        ));

    }
}
