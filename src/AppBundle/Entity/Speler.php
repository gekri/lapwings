<?php
/**
 * Created by PhpStorm.
 * User: Geert
 * Date: 18/06/2016
 * Time: 20:58
 */

/**
 * http://symfony.com/doc/current/cookbook/doctrine/file_uploads.html
 * http://symfony.com/doc/2.6/cookbook/doctrine/file_uploads.html
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class Speler
 * @package AppBundle\Entity*
 * @ORM\Table(name="lw_spelers")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SpelerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Speler
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="voornaam")
     * @Assert\NotBlank
     */
    private $voornaam;

    /**
     * @ORM\Column(type="string", length=255, name="achternaam")
     * @Assert\NotBlank
     */
    private $achternaam;

    /**
     * @ORM\Column(type="date", name="geboortedatum")
     * @Assert\NotBlank
     */
    private $geboortedatum;

    /**
     * @ORM\Column(type="date", name="aansluitingsdatum", nullable=true)
     * @Assert\NotBlank
     */
    private $aansluitingsdatum;

    /**
     * @ORM\Column(type="string", length=255, name="aansluitingsnummer", nullable=true)
     * @Assert\NotBlank
     */
    private $aansluitingsnummer;

    /**
     * @ORM\Column(type="date", name="einde_aansluiting", nullable=true)
     * 
     */

    private $eindeAansluiting;

    /**
     * The path property stores the relative path to the file
     * and is persisted to the database.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    private $temp;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            //$filename = $this->getAchternaam() . '_' . $this->getVoornaam();
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * The getAbsolutePath() is a convenience method that
     * returns the absolute path to the file
     *
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * The getWebPath() is a convenience method that returns
     * the web path, which can be used in a template to link
     * to the uploaded file
     *
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * The absolute directory path where uploaded documents should be saved
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/'.$this->getUploadDir();
    }

    /**
     * get rid of the __DIR__ so it doesn't screw up when
     * displaying uploaded doc/image in the view.
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/spelers';
    }


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
     * Set voornaam
     *
     * @param string $voornaam
     *
     * @return Speler
     */
    public function setVoornaam($voornaam)
    {
        $this->voornaam = $voornaam;

        return $this;
    }

    /**
     * Get voornaam
     *
     * @return string
     */
    public function getVoornaam()
    {
        return $this->voornaam;
    }

    /**
     * Set achternaam
     *
     * @param string $achternaam
     *
     * @return Speler
     */
    public function setAchternaam($achternaam)
    {
        $this->achternaam = $achternaam;

        return $this;
    }

    /**
     * Get achternaam
     *
     * @return string
     */
    public function getAchternaam()
    {
        return $this->achternaam;
    }

    /**
     * Set geboortedatum
     *
     * @param \DateTime $geboortedatum
     *
     * @return Speler
     */
    public function setGeboortedatum($geboortedatum)
    {
        $this->geboortedatum = $geboortedatum;

        return $this;
    }

    /**
     * Get geboortedatum
     *
     * @return \DateTime
     */
    public function getGeboortedatum()
    {
        return $this->geboortedatum;
    }

    /**
     * Set aansluitingsdatum
     *
     * @param \DateTime $aansluitingsdatum
     *
     * @return Speler
     */
    public function setAansluitingsdatum($aansluitingsdatum)
    {
        $this->aansluitingsdatum = $aansluitingsdatum;

        return $this;
    }

    /**
     * Get aansluitingsdatum
     *
     * @return \DateTime
     */
    public function getAansluitingsdatum()
    {
        return $this->aansluitingsdatum;
    }

    /**
     * Set aansluitingsnummer
     *
     * @param string $aansluitingsnummer
     *
     * @return Speler
     */
    public function setAansluitingsnummer($aansluitingsnummer)
    {
        $this->aansluitingsnummer = $aansluitingsnummer;

        return $this;
    }

    /**
     * Get aansluitingsnummer
     *
     * @return string
     */
    public function getAansluitingsnummer()
    {
        return $this->aansluitingsnummer;
    }

    /**
     * Set eindeAansluiting
     *
     * @param \DateTime $eindeAansluiting
     *
     * @return Speler
     */
    public function setEindeAansluiting($eindeAansluiting)
    {
        $this->eindeAansluiting = $eindeAansluiting;

        return $this;
    }

    /**
     * Get eindeAansluiting
     *
     * @return \DateTime
     */
    public function getEindeAansluiting()
    {
        return $this->eindeAansluiting;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Speler
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
