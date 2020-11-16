<?php

namespace Inamika\BackEndBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity(repositoryClass="Inamika\BackEndBundle\Repository\UnitRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"code"}, repositoryMethod="getUniqueNotDeleted")
 * @ExclusionPolicy("all")
 */
class Unit
{
    const IS_OPPORTUNITY_TRUE='SI';
    const IS_OPPORTUNITY_FALSE='NO';

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
     * Many features have one Project. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Expose
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="UnitStatus")
     * @ORM\JoinColumn(name="unitType", referencedColumnName="id",nullable=true)
     * @Expose
     */
    private $unitType;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     * @Assert\NotBlank()
     * @Expose
     */
    private $name;
    
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     * @Expose
     */
    private $price;

    /**
     * Many features have one Currency. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Currency")
     * @Expose
     * @ORM\JoinColumn(name="currency_price_id", referencedColumnName="id")
     */
    private $currencyPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=45,nullable=true)
     * @Expose
     */
    private $number;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45)
     * @Assert\NotBlank()
     * @Expose
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     * @Expose
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="catchment", type="string", length=45,nullable=true)
     * @Expose
     */
    private $catchment;

    /**
     * Many features have one UnitStatus. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="UnitStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * @Expose
     */
    private $status;
    
    /**
     * Many features have one UnitType. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="UnitType")
     * @ORM\JoinColumn(name="unit_type_id", referencedColumnName="id")
     * @Expose
     */
    private $type;
   
    /**
     * Many features have one Customer. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id",nullable=true)
     * @Expose
     */
    private $customer;

    /**
     * One entity has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="unit")
     * @Expose
     */
    private $gallery;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_x", type="smallint",nullable=true)
     * @Expose
     */
    private $svgX=null;

    /**
     * @var int
     *
     * @ORM\Column(name="svg_y", type="smallint",nullable=true)
     * @Expose
     */
    private $svgY=null;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @Expose
     */
    private $isActive=true;

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
     * @var float
     *
     * @ORM\Column(name="area_ground", type="float", nullable=true)
     * @Expose
     */
    private $areaGround;
    
    /**
     * @var float
     *
     * @ORM\Column(name="area_covered", type="float", nullable=true)
     * @Expose
     */
    private $areaCovered;
    
    /**
     * @var float
     *
     * @ORM\Column(name="area_semi_covered", type="float", nullable=true)
     * @Expose
     */
    private $areaSemiCovered;
    
    /**
     * @var float
     *
     * @ORM\Column(name="rooms", type="integer", nullable=true)
     * @Expose
     */
    private $rooms;

    /**
     * @var string
     *
     * @ORM\Column(name="orientation", type="string", length=255,nullable=true)
     * @Expose
     */
    private $orientation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="floors", type="string", length=45,nullable=true)
     * @Expose
     */
    private $floors;

    /**
     * @var float
     *
     * @ORM\Column(name="expenses", type="float", nullable=true)
     * @Expose
     */
    private $expenses;

    /**
     * Many features have one Currency. This is the owning side.
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Currency")
     * @Expose
     * @ORM\JoinColumn(name="currency_expenses_id", referencedColumnName="id")
     */
    private $currencyExpenses;

    
    /**
     * @var date
     *
     * @ORM\Column(name="last_contact", type="date", nullable=true)
     * @Expose
     */
    private $lastContact;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text",nullable=true)
     * @Expose
     */
    private $comments;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_opportunity", type="boolean")
     */
    private $isOpportunity=false;

    public function __construct() {
        $this->gallery = new ArrayCollection();
    }

    /**
     * Set currencyPrice.
     *
     * @param string $currencyPrice
     *
     * @return Product
     */
    public function setCurrencyPrice($currencyPrice)
    {
        $this->currencyPrice = $currencyPrice;

        return $this;
    }

    /**
     * Get currencyPrice.
     *
     * @return string
     */
    public function getCurrencyPrice()
    {
        return $this->currencyPrice;
    }
    
    /**
     * Set currencyExpenses.
     *
     * @param string $currencyExpenses
     *
     * @return Product
     */
    public function setCurrencyExpenses($currencyExpenses)
    {
        $this->currencyExpenses = $currencyExpenses;

        return $this;
    }

    /**
     * Get currencyExpenses.
     *
     * @return string
     */
    public function getCurrencyExpenses()
    {
        return $this->currencyExpenses;
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
     * Get gallery.
     *
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set unitType.
     *
     * @param int $unitType
     *
     * @return Unit
     */
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;

        return $this;
    }

    /**
     * Set project.
     *
     * @param string $project
     *
     * @return Unit
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Get unitType.
     *
     * @return int
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Unit
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
     * Set price.
     *
     * @param float $price
     *
     * @return Unit
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set number.
     *
     * @param string $number
     *
     * @return Unit
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Unit
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Unit
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
     * Set catchment.
     *
     * @param string $catchment
     *
     * @return Unit
     */
    public function setCatchment($catchment)
    {
        $this->catchment = $catchment;

        return $this;
    }

    /**
     * Get catchment.
     *
     * @return string
     */
    public function getCatchment()
    {
        return $this->catchment;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Unit
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set type.
     *
     * @param int $type
     *
     * @return Unit
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
     * Set customer.
     *
     * @param int $customer
     *
     * @return Unit
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return int
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Unit
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
     * Set svgX.
     *
     * @param int $svgX
     *
     * @return Unit
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
     * @return Unit
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
     * @return Unit
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
     * @return Unit
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
     * @return Unit
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
     * Set isOpportunity.
     *
     * @param bool $isOpportunity
     *
     * @return Unit
     */
    public function setIsOpportunity($isOpportunity)
    {
        $this->isOpportunity = $isOpportunity;

        return $this;
    }

    /**
     * Get isOpportunity.
     *
     * @return bool
     */
    public function getIsOpportunity()
    {
        return $this->isOpportunity;
    }

    /**
     * Set areaGround.
     *
     * @param float $areaGround
     *
     * @return Unit
     */
    public function setAreaGround($areaGround)
    {
        $this->areaGround = $areaGround;

        return $this;
    }

    /**
     * Get areaGround.
     *
     * @return float
     */
    public function getAreaGround()
    {
        return $this->areaGround;
    }
    
    /**
     * Set areaCovered.
     *
     * @param float $areaCovered
     *
     * @return Unit
     */
    public function setAreaCovered($areaCovered)
    {
        $this->areaCovered = $areaCovered;

        return $this;
    }

    /**
     * Get areaCovered.
     *
     * @return float
     */
    public function getAreaCovered()
    {
        return $this->areaCovered;
    }
    
    /**
     * Set areaSemiCovered.
     *
     * @param float $areaSemiCovered
     *
     * @return Unit
     */
    public function setAreaSemiCovered($areaSemiCovered)
    {
        $this->areaSemiCovered = $areaSemiCovered;

        return $this;
    }

    /**
     * Get areaSemiCovered.
     *
     * @return float
     */
    public function getAreaSemiCovered()
    {
        return $this->areaSemiCovered;
    }
    
    /**
     * Set rooms.
     *
     * @param integer $rooms
     *
     * @return Unit
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms.
     *
     * @return integer
     */
    public function getRooms()
    {
        return $this->rooms;
    }
    
    /**
     * Set orientation.
     *
     * @param integer $orientation
     *
     * @return Unit
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation.
     *
     * @return integer
     */
    public function getOrientation()
    {
        return $this->orientation;
    }
    
    /**
     * Set floors.
     *
     * @param integer $floors
     *
     * @return Unit
     */
    public function setFloors($floors)
    {
        $this->floors = $floors;

        return $this;
    }

    /**
     * Get floors.
     *
     * @return integer
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * Set expenses.
     *
     * @param float $expenses
     *
     * @return Unit
     */
    public function setExpenses($expenses)
    {
        $this->expenses = $expenses;

        return $this;
    }

    /**
     * Get expenses.
     *
     * @return float
     */
    public function getExpenses()
    {
        return $this->expenses;
    }
    
    /**
     * Set lastContact.
     *
     * @param date $lastContact
     *
     * @return Unit
     */
    public function setLastContact($lastContact)
    {
        $this->lastContact = $lastContact;

        return $this;
    }

    /**
     * Get lastContact.
     *
     * @return date
     */
    public function getLastContact()
    {
        return $this->lastContact;
    }

    /**
     * Set comments.
     *
     * @param string $comments
     *
     * @return Unit
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments.
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
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
