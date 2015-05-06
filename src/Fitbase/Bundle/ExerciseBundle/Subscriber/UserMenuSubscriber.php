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

                            if (($category = $categoryFocus->getCategory())) {
                                $menu->addChild($category->getLabel(), array(
                                    'route' => 'category',
                                    'routeParameters' => array(
                                        'slug' => $categoryFocus->getCategory()->getSlug()
                                    )
                                ));
                            }
                        }

                        if (($categoryFocus = $categories->first())) {
                            if (($category = $categoryFocus->getCategory())) {
                                $subMenu = $menu->addChild('Weitere Übungen', array(
//                                    'route' => 'category',
//                                    'routeParameters' => array(
//                                        'slug' => $category->getSlug()
//                                    ),
                                    'attributes' => array('class' => 'current'),
                                    'childrenAttributes' => array(
                                        'class' => 'sub-current',
                                    ),
                                    'linkAttributes' => array(
                                        'class' => 'sf-with-ul touch-button',
                                    ),
                                ));
                            }

                            foreach ($categories as $categoryFocus) {
                                if (($category = $categoryFocus->getCategory())) {
                                    $subMenu->addChild($category->getLabel(), array(
                                        'route' => 'category',
                                        'routeParameters' => array(
                                            'slug' => $category->getSlug()
                                        ),
                                    ));
                                }
                            }
                        }

                    }
                }
            }

            $menu->addChild('Lieblingsübungen', array(
                'route' => 'exercise_choice',
            ));

        }
    }

}