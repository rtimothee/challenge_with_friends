<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="night_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Session", mappedBy="user")
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity="Challenge", mappedBy="user")
     */
    private $challenges;



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return User
     */
    public function addSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions[] = $session;

        return $this;
    }

    /**
     * Remove session
     *
     * @param \AppBundle\Entity\Session $session
     */
    public function removeSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions->removeElement($session);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }
    

    /**
     * Add challenge
     *
     * @param \AppBundle\Entity\Challenge $challenge
     *
     * @return User
     */
    public function addChallenge(\AppBundle\Entity\Challenge $challenge)
    {
        $this->challenges[] = $challenge;

        return $this;
    }

    /**
     * Remove challenge
     *
     * @param \AppBundle\Entity\Challenge $challenge
     */
    public function removeChallenge(\AppBundle\Entity\Challenge $challenge)
    {
        $this->challenges->removeElement($challenge);
    }

    /**
     * Get challenges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChallenges()
    {
        return $this->challenges;
    }
}
