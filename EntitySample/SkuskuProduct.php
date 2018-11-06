<?php

namespace GGGGino\SkuskuCartBundle\EntitySample;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Allyou\ManagementBundle\Model\ClonableInterface;
use Allyou\ManagementBundle\Annotation\ClonableProperty;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuSupplierInterface;

/**
 * SkuskuProduct
 *
 * @ORM\Table(name="productt")
 * @ORM\Entity
 */
class SkuskuProduct implements ClonableInterface, SkuskuProductInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50)
     * @ClonableProperty(type="prefix")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=70)
     * @ClonableProperty()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="description_short", type="text", nullable=true)
     */
    private $descriptionShort;

    /**
     * @var ?
     *
     * @ORM\Column(name="collection", type="text", nullable=true)
     */
    private $collection;

    /**
     * @var string
     *
     * @ORM\Column(name="departure_place", type="string", length=70, nullable=true)
     * @ClonableProperty(type="replace", value="Firenze S.M.N.")
     */
    private $departurePlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_time", type="datetime", nullable=true)
     */
    private $departureTime;

    /**
     * @var string
     *
     * @ORM\Column(name="return_place", type="string", length=70, nullable=true)
     */
    private $returnPlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_time", type="datetime", nullable=true)
     */
    private $returnTime;

    /**
     * @var string
     *
     * @ORM\Column(name="state_code", type="string", length=70, nullable=true)
     */
    private $stateCode;

    /**
     * @var string
     *
     * @ORM\Column(name="full_price", type="decimal", precision=6, scale=2)
     */
    private $fullPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=100, nullable=true)
     */
    private $web;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_time", type="datetime", nullable=true)
     */
    private $relaseTime;

    /**
     * @var string
     *
     * @ORM\Column(name="highlights", type="text", nullable=true)
     */
    private $highlights;

    /**
     * @var string
     *
     * @ORM\Column(name="inclusion", type="text", nullable=true)
     */
    private $inclusion;

    /**
     * @var string
     *
     * @ORM\Column(name="exclusion", type="text", nullable=true)
     */
    private $exclusion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_from", type="datetime")
     */
    private $availableFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_to", type="datetime")
     */
    private $availableTo;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @var int
     *
     * @ORM\Column(name="voucher", type="integer", nullable=true)
     */
    private $voucher;

    /**
     * @var string
     *
     * @ORM\Column(name="meeting_point", type="text", nullable=true)
     */
    private $meetingPoint;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->code : "";
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Product
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set descriptionShort
     *
     * @param string $descriptionShort
     *
     * @return Product
     */
    public function setDescriptionShort($descriptionShort)
    {
        $this->descriptionShort = $descriptionShort;

        return $this;
    }

    /**
     * Get descriptionShort
     *
     * @return string
     */
    public function getDescriptionShort()
    {
        return $this->descriptionShort;
    }

    /**
     * Set collection
     *
     * @param string $collection
     *
     * @return Product
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set departurePlace
     *
     * @param string $departurePlace
     *
     * @return Product
     */
    public function setDeparturePlace($departurePlace)
    {
        $this->departurePlace = $departurePlace;

        return $this;
    }

    /**
     * Get departurePlace
     *
     * @return string
     */
    public function getDeparturePlace()
    {
        return $this->departurePlace;
    }

    /**
     * Set departureTime
     *
     * @param \DateTime $departureTime
     *
     * @return Product
     */
    public function setDepartureTime($departureTime)
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    /**
     * Get departureTime
     *
     * @return \DateTime
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * Set returnPlace
     *
     * @param string $returnPlace
     *
     * @return Product
     */
    public function setReturnPlace($returnPlace)
    {
        $this->returnPlace = $returnPlace;

        return $this;
    }

    /**
     * Get returnPlace
     *
     * @return string
     */
    public function getReturnPlace()
    {
        return $this->returnPlace;
    }

    /**
     * Set returnTime
     *
     * @param \DateTime $returnTime
     *
     * @return Product
     */
    public function setReturnTime($returnTime)
    {
        $this->returnTime = $returnTime;

        return $this;
    }

    /**
     * Get returnTime
     *
     * @return \DateTime
     */
    public function getReturnTime()
    {
        return $this->returnTime;
    }

    /**
     * Set stateCode
     *
     * @param string $stateCode
     *
     * @return Product
     */
    public function setStateCode($stateCode)
    {
        $this->stateCode = $stateCode;

        return $this;
    }

    /**
     * Get stateCode
     *
     * @return string
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * Set fullPrice
     *
     * @param string $fullPrice
     *
     * @return Product
     */
    public function setFullPrice($fullPrice)
    {
        $this->fullPrice = $fullPrice;

        return $this;
    }

    /**
     * Get fullPrice
     *
     * @return string
     */
    public function getFullPrice()
    {
        return $this->fullPrice;
    }

    /**
     * Set web
     *
     * @param string $web
     *
     * @return Product
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set relaseTime
     *
     * @param \DateTime $relaseTime
     *
     * @return Product
     */
    public function setRelaseTime($relaseTime)
    {
        $this->relaseTime = $relaseTime;

        return $this;
    }

    /**
     * Get relaseTime
     *
     * @return \DateTime
     */
    public function getRelaseTime()
    {
        return $this->relaseTime;
    }

    /**
     * Set highlights
     *
     * @param string $highlights
     *
     * @return Product
     */
    public function setHighlights($highlights)
    {
        $this->highlights = $highlights;

        return $this;
    }

    /**
     * Get highlights
     *
     * @return string
     */
    public function getHighlights()
    {
        return $this->highlights;
    }

    /**
     * Set inclusion
     *
     * @param string $inclusion
     *
     * @return Product
     */
    public function setInclusion($inclusion)
    {
        $this->inclusion = $inclusion;

        return $this;
    }

    /**
     * Get inclusion
     *
     * @return string
     */
    public function getInclusion()
    {
        return $this->inclusion;
    }

    /**
     * Set exclusion
     *
     * @param string $exclusion
     *
     * @return Product
     */
    public function setExclusion($exclusion)
    {
        $this->exclusion = $exclusion;

        return $this;
    }

    /**
     * Get exclusion
     *
     * @return string
     */
    public function getExclusion()
    {
        return $this->exclusion;
    }

    /**
     * Set availableFrom
     *
     * @param \DateTime $availableFrom
     *
     * @return Product
     */
    public function setAvailableFrom($availableFrom)
    {
        $this->availableFrom = $availableFrom;

        return $this;
    }

    /**
     * Get availableFrom
     *
     * @return \DateTime
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * Set availableTo
     *
     * @param \DateTime $availableTo
     *
     * @return Product
     */
    public function setAvailableTo($availableTo)
    {
        $this->availableTo = $availableTo;

        return $this;
    }

    /**
     * Get availableTo
     *
     * @return \DateTime
     */
    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Product
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set voucher
     *
     * @param integer $voucher
     *
     * @return Product
     */
    public function setVoucher($voucher)
    {
        $this->voucher = $voucher;

        return $this;
    }

    /**
     * Get voucher
     *
     * @return integer
     */
    public function getVoucher()
    {
        return $this->voucher;
    }

    /**
     * Set meetingPoint
     *
     * @param string $meetingPoint
     *
     * @return Product
     */
    public function setMeetingPoint($meetingPoint)
    {
        $this->meetingPoint = $meetingPoint;

        return $this;
    }

    /**
     * Get meetingPoint
     *
     * @return string
     */
    public function getMeetingPoint()
    {
        return $this->meetingPoint;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->getFullPrice();
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->getAvailableFrom() < (new \DateTime()) && $this->getAvailableTo() > (new \DateTime());
    }

    /**
     * Permette di fare delle azioni al clonamento dell'entitÃ
     *
     * @return mixed
     */
    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @return SkuskuSupplierInterface
     */
    public function getSupplier()
    {
        return null;
    }
}
