<?php


namespace App\Storage;


use App\Entity\Panier;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * Class PanierSessionStorage
 * @package App\Storage
 */
class PanierSessionStorage
{
    /**
     * The session storage.
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * The panier repository.
     *
     * @var PanierRepository
     */
    private $panierRepository;

    /**
     * @var string
     */
    const PANIER_KEY_NAME = 'panier_id';

    /**
     * PanierSessionStorage constructor.
     *
     * @param SessionInterface $session
     * @param PanierRepository $panierRepository
     */
    public function __construct(SessionInterface $session, PanierRepository $panierRepository)
    {
        $this->session = $session;
        $this->panierRepository = $panierRepository;
    }

    /**
     * Gets the panier in session.
     *
     * @return Order|null
     */
    public function getPanier(): ?Panier
    {
        return $this->panierRepository->findOneBy([
            'id' => $this->getPanierId(),

        ]);
    }

    /**
     * Sets the panier in session.
     *
     * @param Panier $panier
     */
    public function setPanier(Panier $panier): void
    {
        $this->session->set(self::PANIER_KEY_NAME, $panier->getIdPanier());
    }

    /**
     * Returns the panier id.
     *
     * @return int|null
     */
    private function getPanierId(): ?int
    {
        return $this->session->get(self::PANIER_KEY_NAME);
    }
}