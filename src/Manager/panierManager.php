<?php


namespace App\Manager;


use App\Entity\Panier;
use App\Factory\PanierFactory;
use App\Storage\PanierSessionStorage;
use Doctrine\ORM\EntityManagerInterface;


class panierManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PanierSessionStorage
     */
    private $panierSessionStorage;

    /**
     * @var PanierFactory
     */
    private $panierFactory;

    /**
     * PanierManager constructor.
     *
     * @param PanierSessionStorage $panierStorage
     * @param PanierFactory $panierFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        PanierSessionStorage $panierStorage,
        PanierFactory $panierFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->panierSessionStorage = $panierStorage;
        $this->panierFactory = $panierFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the current panier.
     *
     * @return Panier
     */
    public function getCurrentPanier(): Panier
    {
        $panier = $this->panierSessionStorage->getPanier();
            $etat=$panier->getEtat();
        if (!$panier && $etat!=1) {
            $panier = $this->panierFactory->create();
        }

        return $panier;
    }
    /**
     * Persists the cart in database and session.
     *
     * @param Panier $panier
     */
    public function save(Panier $panier): void
    {
        // Persist in database
        $this->entityManager->persist($panier);
        $this->entityManager->flush();
        // Persist in session
        $this->panierSessionStorage->setPanier($panier);
    }
}