<?php

namespace Inamika\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * ProjectBlocks
 *
 * @ORM\Table(name="project_blocks")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\ProjectBlocksRepository")
 * @ExclusionPolicy("all")
 */
class ProjectBlocks
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
     * @ORM\ManyToOne(targetEntity="ProjectLevels")
     * @ORM\JoinColumn(name="level", referencedColumnName="id")
     * @Expose
     */
    private $level;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Maps")
     * @ORM\JoinColumn(name="map", referencedColumnName="id")
     * @Expose
     */
    private $map;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_x", type="smallint")
     */
    private $svgX;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_y", type="smallint")
     */
    private $svgY;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="SvgDefinitions")
     * @ORM\JoinColumn(name="svg", referencedColumnName="id")
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
    private $isDelete;


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
     * Set name.
     *
     * @param string $name
     *
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
     * @return ProjectBlocks
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
