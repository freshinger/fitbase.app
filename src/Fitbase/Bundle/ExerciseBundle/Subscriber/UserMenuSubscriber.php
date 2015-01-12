<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserMenuSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_menu_main' => array('onUserMenuMain'),
        );
    }

    protected function getName($category)
    {
        $names = array(
            'ruecken' => 'Rücken Übungen',
            'stress' => 'Ihre Entspannungsübung',
            'ernaehrung' => 'Ihr Ernährungstagebuch',
        );

        if (in_array($category->getSlug(), array_keys($names))) {
            return $names[$category->getSlug()];
        }

        return $category->getName();
    }

    /**
     * Process menu event, to fill custom menu from this bundle
     * @param \Fitbase\Bundle\FitbaseBundle\Event\UserMenuEvent $event
     */
    public function onUserMenuMain(\Fitbase\Bundle\FitbaseBundle\Event\UserMenuEvent $event)
    {
        if (($menu = $event->getEntity())) {
            if (($user = $this->container->get('user')->current())) {
                if (($focus = $user->getFocus())) {
                    if (($categories = $focus->getParentCategories())) {

                        // Set a focus category
                        // as a first menu
                        if (($categoryFocus = $categories->first())) {
                            $categories->remove(0);
                            $menu->addChild($this->getName($categoryFocus->getCategory()), array(
                                'route' => 'category',
                                'routeParameters' => array(
                                    'slug' => $categoryFocus->getCategory()->getSlug()
                                )
                            ));
                        }

                        if (($category = $categories->first())) {

                            $subMenu = $menu->addChild('Weitere Uebungen', array(
                                'route' => 'category',
                                'routeParameters' => array(
                                    'slug' => $category->getCategory()->getSlug()
                                ),
                                'attributes' => array('class' => 'dropdown'),
                                'childrenAttributes' => array('class' => 'dropdown-menu'),
                                'linkAttributes' => array(
                                    'class' => 'dropdown-toggle',
                                    'data-toggle' => 'dropdown',
                                ),

                            ));

                            foreach ($categories as $category) {
                                // TODO: replace names for categories
                                $subMenu->addChild($this->getName($category->getCategory()), array(
                                    'route' => 'category',
                                    'routeParameters' => array(
                                        'slug' => $category->getCategory()->getSlug()
                                    ),
                                ));
                            }
                        }


                    }
                }
            }
        }
    }

}