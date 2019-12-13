<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 * @ApiResource(
 *     collectionOperations={"get","post"},
 *     itemOperations={"get","delete"},
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     )
 */
class Subject
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
     * @ORM\OneToMany(targetEntity="App\Entity\Mark", mappedBy="subject")
     * @Groups({"read"})
     */
    private $marks;

    /**
     * @ApiSubresource()
     * @ORM\ManyToMany(targetEntity="App\Entity\Student", mappedBy="subjects")
     * @Groups({"read", "write"})
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tutor", mappedBy="subject")
     * @Groups({"read"})
     */
    private $tutors;

    public function __construct()
    {
        $this->marks = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->tutors = new ArrayCollection();
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
            $mark->setSubject($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->contains($mark)) {
            $this->marks->removeElement($mark);
            // set the owning side to null (unless already changed)
            if ($mark->getSubject() === $this) {
                $mark->setSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addSubject($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeSubject($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tutor[]
     */
    public function getTutors(): Collection
    {
        return $this->tutors;
    }

    public function addTutor(Tutor $tutor): self
    {
        if (!$this->tutors->contains($tutor)) {
            $this->tutors[] = $tutor;
            $tutor->setSubject($this);
        }

        return $this;
    }

    public function removeTutor(Tutor $tutor): self
    {
        if ($this->tutors->contains($tutor)) {
            $this->tutors->removeElement($tutor);
            // set the owning side to null (unless already changed)
            if ($tutor->getSubject() === $this) {
                $tutor->setSubject(null);
            }
        }

        return $this;
    }
}
