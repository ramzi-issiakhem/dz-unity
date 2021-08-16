<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
     const WILAYAS = [
         "01- Alger" => "01- Alger"
     ];

    const DPT = [
        "Paris" => "Paris"
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wilaya;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;
    /**
     * @ORM\Column (type="boolean")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contacts;

    /**
     * @ORM\Column(type="json")
     */
    private $besoins = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWilaya(): ?string
    {
        return $this->wilaya;
    }

    public function setWilaya(string $wilaya): self
    {
        $this->wilaya = $wilaya;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setContacts(string $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function getBesoins(): ?array
    {
        return $this->besoins;
    }

    public function setBesoins(array $besoins): self
    {
        $this->besoins = $besoins;

        return $this;
    }

    public function getBesoinsFromJson(bool $create = false) : array {
        $package = new Package(new EmptyVersionStrategy());

        $url =  $package->getUrl('json/besoins.json');

        $json_data = file_get_contents($url);
        dump($json_data);
        $json = json_decode($json_data,true);

        if (!$create) {
            $return_array = ["Tous" => "Tous"];
        }

        $array = $json["besoins"];

        foreach ($array as $element) {
            $return_array[$element] = $element;
        }
        return $return_array;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }
}
