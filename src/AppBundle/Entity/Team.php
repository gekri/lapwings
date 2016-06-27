<?php
/**
 * Created by PhpStorm.
 * User: Geert
 * Date: 24/06/2016
 * Time: 9:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class Team
 * @package AppBundle\Entity*
 * @ORM\Table(name="lw_teams")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TeamRepository")
 * @ORM\HasLifecycleCallbacks()
 */


class Team
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="naam")
     * @Assert\NotBlank
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255, name="afkorting")
     * @Assert\NotBlank
     */
    private $afkorting;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set naam
     *
     * @param string $naam
     *
     * @return Team
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * Get naam
     *
     * @return string
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * Set afkorting
     *
     * @param string $afkorting
     *
     * @return Team
     */
    public function setAfkorting($afkorting)
    {
        $this->afkorting = $afkorting;

        return $this;
    }

    /**
     * Get afkorting
     *
     * @return string
     */
    public function getAfkorting()
    {
        return $this->afkorting;
    }
}
