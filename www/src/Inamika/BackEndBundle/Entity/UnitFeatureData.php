<?php

namespace Inamika\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * UnitFeatureData
 *
 * @ORM\Table(name="unit_feature_data")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\UnitFeatureDataRepository")
 * @ExclusionPolicy("all")
 */
class UnitFeatureData
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
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project", referencedColumnName="id")
     * @Expose
     */
    private $project;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="ProjectType")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     * @Expose
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="unit", type="integer")
     * @Expose
     */
    private $unit;

    /**
     * @var int
     *
     * @ORM\Column(name="feature", type="integer")
     * @Expose
     */
    private $feature;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     * @Expose
     */
    private $value;

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
     * Set project.
     *
     * @param int $project
     *
     * @return UnitFeatureData
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
     * Set type.
     *
     * @param int $type
     *
     * @return UnitFeatureData
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set unit.
     *
     * @param int $unit
     *
     * @return UnitFeatureData
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
     * Set feature.
     *
     * @param int $feature
     *
     * @return UnitFeatureData
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature.
     *
     * @return int
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return UnitFeatureData
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return UnitFeatureData
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
     * @return UnitFeatureData
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
     * @return UnitFeatureData
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
