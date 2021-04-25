<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Evenements
 *
 * @ORM\Table(name="evenements")
 * @ORM\Entity
 */
class Evenements
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="date", nullable=false)
     */
    private $datefin;

    /**
     *
     * @ORM\Column(name="rate", type="float", nullable=true)
     */
    private $rate;

    /**
     *
     * @ORM\Column(name="vote", type="integer", nullable=true)
     */
    private $vote;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;

    /**
     * @var int
     * @Assert\Range(
     *      min = 10,
     *      max=100,
     *      minMessage = "Nombre de etoile doit etre entre a 2 et 5",
     * )
     * @ORM\Column(name="nbreplaces", type="integer", nullable=false)
     */
    private $nbreplaces;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=2555, nullable=false)
     */
    private $image;

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;


    public function getWebpath(){


        return null === $this->image ? null : $this->getUploadDir.'/'.$this->image;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../Artraction/public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->image = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->image = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }






    /**
     * @var int
     *
     * @ORM\Column(name="nbreparticipants", type="integer", nullable=false)
     */
    private $nbreparticipants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNbreplaces(): ?int
    {
        return $this->nbreplaces;
    }

    public function setNbreplaces(int $nbreplaces): self
    {
        $this->nbreplaces = $nbreplaces;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbreparticipants(): ?int
    {
        return $this->nbreparticipants;
    }

    public function setNbreparticipants(int $nbreparticipants): self
    {
        $this->nbreparticipants = $nbreparticipants;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getRate() :?float
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getVote() :?int
    {
        return $this->vote;
    }

    /**
     * @param mixed $vote
     */
    public function setVote($vote): void
    {
        $this->vote = $vote;
    }

}
