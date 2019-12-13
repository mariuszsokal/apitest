<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 * @ApiResource(
 *     collectionOperations={"get","post"},
 *     itemOperations={"get","patch","delete"},
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     )
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mark", mappedBy="student")
     * @Groups({"read"})
     */
    private $marks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grade", inversedBy="students")
     * @Groups({"read", "write"})
     */
    private $grade;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject", inversedBy="students")
     * @Groups({"read", "write"})
     */
    private $subjects;

    public function __construct()
    {
        $this->marks = new ArrayCollection();
        $this->subjects = new ArrayCollection();
    }

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Mark[]
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): self
    {
        if (!$this->marks->contains($mark)) {
            $this->marks[] = $mark;
            $mark->setStudent($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->contains($mark)) {
            $this->marks->removeElement($mark);
            // set the owning side to null (unless already changed)
            if ($mark->getStudent() === $this) {
                $mark->setStudent(null);
            }
        }

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
        }

        return $this;
    }
}
