<?php

namespace Inamika\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * ProjectLevels
 *
 * @ORM\Table(name="project_levels")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\ProjectLevelsRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 */
class ProjectLevels
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @Expose
     */
    private $id;

    /**
     * Many features have one ProjectType. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project", referencedColumnName="id")
     * @Expose
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Expose
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="map", type="string", length=64, nullable=true)
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/png","image/jpeg","image/jpg","image/gif"},
     *     mimeTypesMessage = "Seleccione un formato de imagen válido"
     * )
     * @Expose
     */
    private $map;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_x", type="smallint", nullable=true)
     * @Expose
     */
    private $svgX;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_y", type="smallint", nullable=true)
     * @Expose
     */
    private $svgY;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="SvgDefinitions")
     * @ORM\JoinColumn(name="svg", referencedColumnName="id", nullable=true)
     * @Expose
     */
    private $svg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_delete", type="boolean")
     */
    private $isDelete=false;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set project.
     *
     * @param int $project
     *
     * @return ProjectLevels
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return int
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProjectLevels
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return ProjectLevels
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set map.
     *
     * @param int $map
     *
     * @return ProjectLevels
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map.
     *
     * @return int
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set svgX.
     *
     * @param int $svgX
     *
     * @return ProjectLevels
     */
    public function setSvgX($svgX)
    {
        $this->svgX = $svgX;

        return $this;
    }

    /**
     * Get svgX.
     *
     * @return int
     */
    public function getSvgX()
    {
        return $this->svgX;
    }

    /**
     * Set svgY.
     *
     * @param int $svgY
     *
     * @return ProjectLevels
     */
    public function setSvgY($svgY)
    {
        $this->svgY = $svgY;

        return $this;
    }

    /**
     * Get svgY.
     *
     * @return int
     */
    public function getSvgY()
    {
        return $this->svgY;
    }

    /**
     * Set svg.
     *
     * @param int $svg
     *
     * @return ProjectLevels
     */
    public function setSvg($svg)
    {
        $this->svg = $svg;

        return $this;
    }

    /**
     * Get svg.
     *
     * @return int
     */
    public function getSvg()
    {
        return $this->svg;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ProjectLevels
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return ProjectLevels
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isDelete.
     *
     * @param bool $isDelete
     *
     * @return ProjectLevels
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete.
     *
     * @return bool
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt=new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt=new \DateTime();
    }
}
