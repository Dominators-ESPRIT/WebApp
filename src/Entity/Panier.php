<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_codepromo;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;



    public function getIdPanier(): ?int
    {
        return $this->id;
    }



    public function getIdCodepromo(): ?int
    {
        return $this->id_codepromo;
    }

    public function setIdCodepromo(?int $id_codepromo): self
    {
        $this->id_codepromo = $id_codepromo;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

}
