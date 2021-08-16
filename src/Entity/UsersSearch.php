<?php

namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;


class UsersSearch
{
    /**
     * @var string|null
     */
    private $wilaya;

    /**
     * @var string|null
     */
    private $besoins;

    /**
     * @return string|null
     */
    public function getBesoins(): ?string
    {
        return $this->besoins;
    }

    /**
     * @param string|null $besoins
     */
    public function setBesoins(?string $besoins): void
    {
        $this->besoins = $besoins;
    }

    /**
     * @return string|null
     */
    public function getWilaya(): ?string
    {
        return $this->wilaya;
    }

    /**
     * @param string|null $wilaya
     */
    public function setWilaya(?string $wilaya): void
    {
        $this->wilaya = $wilaya;
    }


}
