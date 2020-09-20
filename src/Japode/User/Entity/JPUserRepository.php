<?php

namespace Japode\User\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * JPUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JPUserRepository extends EntityRepository {

    /**
     * Finds a user with its email
     *
     * @param string $email
     * @return JPUser
     */
    public function findByEmail($email) {

        $qb = $this->createQueryBuilder('u');
        return $qb->where($qb->expr()->andx(
                                        $qb->expr()->eq('u.email', ':email'), $qb->expr()->eq('u.realm', ':realm')))
                        ->setParameter('email', $email)
                        ->setParameter('realm', 'default')
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    /**
     * Finds a user with its username
     *
     * @param string $username
     * @return JPUser
     */
    public function findByUsername($username) {

        $qb = $this->createQueryBuilder('u');

        return $qb
                        ->where($qb->expr()->andx(
                                        $qb->expr()->eq('u.username', ':username')
                        ))
                        ->setParameter('username', $username)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    /**
     * Finds a user with its recoverPassword
     *
     * @param string $recoverPassword
     * @return JPUser
     */
    public function findByRecoverPassword($recoverPassword) {

        $qb = $this->createQueryBuilder('u');

        return $qb
                        ->where($qb->expr()->andx(
                                        $qb->expr()->eq('u.recoverPassword', ':recoverPassword'), $qb->expr()->eq('u.realm', ':realm')))
                        ->setParameter('recoverPassword', $recoverPassword)
                        ->setParameter('realm', 'default')
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    /**
     * Finds a user with its confirmEmail
     *
     * @param string $confirmEmail
     * @return JPUser
     */
    public function findByConfirmEmail($confirmEmail) {

        $qb = $this->createQueryBuilder('u');

        return $qb
                        ->where($qb->expr()->andx(
                                        $qb->expr()->eq('u.confirmEmail', ':confirmEmail'), $qb->expr()->eq('u.realm', ':realm')))
                        ->setParameter('confirmEmail', $confirmEmail)
                        ->setParameter('realm', 'default')
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    /**
     * CheckPassword
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function checkPassword($email, $password) {
        $qb = $this->createQueryBuilder('u');

        $q = $qb
                ->where($qb->expr()->andx(
                                $qb->expr()->eq('u.email', ':email'), $qb->expr()->eq('u.password', ':password')))
                ->setParameter('email', $email)
                ->setParameter('password', md5($password))
                ->getQuery()
                ->getOneOrNullResult();

        return isset($q);
    }

    public function userExists($realm, $id) {

        $qb = $this->createQueryBuilder('u');

        $q = $qb
                ->where($qb->expr()->andx(
                                $qb->expr()->eq('u.id', ':id'), $qb->expr()->eq('u.realm', ':realm')))
                ->setParameter('id', $id)
                ->setParameter('realm', $realm)
                ->getQuery()
                ->getOneOrNullResult();

        return isset($q);
    }

    public function getCurrentUser() {
        if (isset($_SESSION ['userid']) && isset($_SESSION ['realm'])) {

            $id = $_SESSION ['userid'];
            $realm = $_SESSION ['realm'];
            error_log("id" . $id);
            error_log("realm" . $realm);
            $qb = $this->createQueryBuilder('u');

            return $qb
                            ->where($qb->expr()
                                    ->andx($qb->expr()
                                            ->eq('u.id', ':id'), $qb->expr()
                                            ->eq('u.realm', ':realm')))
                            ->setParameter('id', $id)
                            ->setParameter('realm', $realm)
                            ->getQuery()
                            ->getOneOrNullResult();
        } else {
            error_log("session empty");
            return NULL;
        }
    }

}
