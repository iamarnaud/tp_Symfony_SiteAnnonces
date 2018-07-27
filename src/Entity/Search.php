<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
{
    /*
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /*
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $search;

    /*
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $searchbyarea;

    /*
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $searchbycategory;

    public function getId()
    {
        return $this->id;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function getSearchbyarea(): ?string
    {
        return $this->searchbyarea;
    }

    public function setSearchbyarea(?string $searchbyarea): self
    {
        $this->searchbyarea = $searchbyarea;

        return $this;
    }

    public function getSearchbycategory(): ?string
    {
        return $this->searchbycategory;
    }

    public function setSearchbycategory(?string $searchbycategory): self
    {
        $this->searchbycategory = $searchbycategory;

        return $this;
    }
}
