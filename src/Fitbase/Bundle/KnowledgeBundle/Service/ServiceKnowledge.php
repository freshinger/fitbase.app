<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 2:36 PM
 */

namespace Fitbase\Bundle\KnowledgeBundle\Service;


use Fitbase\Bundle\KnowledgeBundle\Entity\KnowledgeUser;
use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceKnowledge extends ContainerAware
{
    /**
     * Get current gamification object
     * TODO: add cycle
     * @return null
     */
    public function current()
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryKnowledge = $entityManager->getRepository('Fitbase\Bundle\KnowledgeBundle\Entity\Knowledge');
        $repositoryKnowledgeUser = $entityManager->getRepository('Fitbase\Bundle\KnowledgeBundle\Entity\KnowledgeUser');

        $datetime = $this->container->get('datetime')->getDateTime('now');
        $datetime->setTime(0, 0, 0);

        if (($user = $this->container->get('user')->current())) {

            if (($knowledgeUser = $repositoryKnowledgeUser->findLastByDate($user, $datetime))) {
                return $knowledgeUser->getKnowledge();
            }

            $knowledge = $repositoryKnowledge->findFirst();
            if (($knowledgeUser = $repositoryKnowledgeUser->findLast($user))) {
                if (($knowledgeLast = $knowledgeUser->getKnowledge())) {
                    if (!($knowledge = $repositoryKnowledge->findNext($knowledgeLast))) {
                        $knowledge = $repositoryKnowledge->findFirst();
                    }
                }
            }

            $knowledgeUser = new KnowledgeUser();
            $knowledgeUser->setUser($user);
            $knowledgeUser->setKnowledge($knowledge);
            $knowledgeUser->setDone(true);
            $knowledgeUser->setDoneDate($datetime);
            $entityManager->persist($knowledgeUser);
            $entityManager->flush($knowledgeUser);

            return $knowledge;
        }

        return null;
    }
}