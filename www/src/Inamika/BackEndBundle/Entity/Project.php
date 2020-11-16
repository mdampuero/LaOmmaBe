<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackEndBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\ProjectRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"name"}, repositoryMethod="getUniqueNotDeleted")
 * @ExclusionPolicy("all")
 */

class Project
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 64
     * )
     * @Expose
     */
    private $name;

    /**
     * Many features have one ProjectType. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="ProjectType")
     * @ORM\JoinColumn(name="project_type_id", referencedColumnName="id")
     * @Expose
     */
    private $projectType;

    /**
     * One entity has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="project")
     * @Expose
     */
    private $gallery;
    
    /**
     * One entity has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="ProjectLevels", mappedBy="project")
     * @Expose
     */
    private $levels;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Expose
     */
    private $description;

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
     * @ORM\Column(name="is_active", type="boolean")
     * @Expose
     */
    private $isActive=true;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="is_delete", type="boolean")
     * @Expose
     */
    private $isDelete=false;

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

    public function __construct() {
        $this->gallery = new ArrayCollection();
        $this->levels = new ArrayCollection();
    }

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
     * Set map
     *
     * @param string $map
     *
     * @return User
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return string
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set projectType.
     *
     * @param string $projectType
     *
     * @return Project
     */
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;

        return $this;
    }

    /**
     * Get projectType.
     *
     * @return string
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Project
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
     * Get gallery.
     *
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }
   
    /**
     * Get levels.
     *
     * @return string
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Project
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Project
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
     * @return Project
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
     * @return Project
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
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Project
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
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
