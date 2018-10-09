<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * Skusku
 *
 * @ORM\Table(name="skusku_cart")
 * @ORM\Entity(repositoryClass="GGGGino\SkuskuCartBundle\Repository\CartRepository")
 */
class SkuskuCart
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="SkuskuCartProduct", mappedBy="cart", fetch="EXTRA_LAZY")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="SkuskuCustomerInterface")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * @var SkuskuCustomerInterface
     */
    protected $customer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return SkuskuCart
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd.
     *
     * @param \DateTime $dateUpd
     *
     * @return SkuskuCart
     */
    public function setDateUpd($dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     *
     * @return \DateTime
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }

    /**
     * @return SkuskuCustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param SkuskuProductInterface $product
     * @return mixed
     */
    public function getProduct(SkuskuProductInterface $product)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq("product", $product));

        return $this->products->matching($criteria);
    }

    /**
     * @param mixed $products
     * @return SkuskuCart
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return array_reduce($this->getProducts()->toArray(), function($carry, SkuskuCartProduct $product) {
            return $carry + ($product->getSubtotal());
        }, 0);
    }
}
