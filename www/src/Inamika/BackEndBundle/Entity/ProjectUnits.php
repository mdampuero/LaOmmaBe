<?php

namespace Inamika\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * ProjectUnits
 *
 * @ORM\Table(name="project_units")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\ProjectUnitsRepository")
 * @ExclusionPolicy("all")
 */
class ProjectUnits
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
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="ProjectBlocks")
     * @ORM\JoinColumn(name="block", referencedColumnName="id")
     * @Expose
     */
    private $block;

    /**
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="unit", referencedColumnName="id")
     * @Expose
     */
    private $unit;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_x", type="smallint")
     * @Expose
     */
    private $svgX;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_y", type="smallint")
     * @Expose
     */
    private $svgY;

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
     * Set block.
     *
     * @param int $block
     *
     * @return ProjectUnits
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block.
     *
     * @return int
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set unit.
     *
     * @param int $unit
     *
     * @return ProjectUnits
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit.
     *
     * @return int
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set svgX.
     *
     * @param int $svgX
     *
     * @return ProjectUnits
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
     * @return ProjectUnits
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
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ProjectUnits
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
     * @return ProjectUnits
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
     * @return ProjectUnits
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
