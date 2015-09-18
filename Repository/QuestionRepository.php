<?php

namespace UJM\ExoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{
    /**
     * Get user's Questions.
     *
     *
     * @param int $userId id User
     *
     * Return array[Question]
     */
    public function getQuestionsUser($userId)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->join('q.user', 'u')
            ->where($qb->expr()->in('u.id', $userId));

        return $qb->getQuery()->getResult();
    }

    /**
     * Allow to know if the User is the owner of this Question.
     *
     *
     * @param int $user     id User
     * @param int $question id Question
     *
     * Return array[Question]
     */
    public function getControlOwnerQuestion($user, $question)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->join('q.user', 'u')
            ->where($qb->expr()->in('q.id', $question))
            ->andWhere($qb->expr()->in('u.id', $user));

        return $qb->getQuery()->getResult();
    }

    /**
     * Search question by category.
     *
     *
     * @param int    $userId     id User
     * @param String $whatToFind string to find
     *
     * Return array[Question]
     */
    public function findByCategory($userId, $whatToFind)
    {
        $dql = 'SELECT q FROM UJM\ExoBundle\Entity\Question q JOIN q.category c
            WHERE c.value LIKE ?1
            AND q.user = ?2';

        $query = $this->_em->createQuery($dql)
                      ->setParameters(array(1 => "%{$whatToFind}%", 2 => $userId));

        return $query->getResult();
    }

    /**
     * Search question.
     *
     *
     * @param int    $userId     id User
     * @param String $whatToFind string to find
     *
     * Return array[Question]
     */
    public function findByTitle($userId, $whatToFind)
    {
        $dql = 'SELECT q FROM UJM\ExoBundle\Entity\Question q
            WHERE q.title LIKE ?1
            AND q.user = ?2';

        $query = $this->_em->createQuery($dql)
                      ->setParameters(array(1 => "%{$whatToFind}%", 2 => $userId));

        return $query->getResult();
    }
}
