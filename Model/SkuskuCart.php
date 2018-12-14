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
    const STATUS_INITIAL = 0;
    const STATUS_ORDERED = 1;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="SkuskuCartProduct", mappedBy="cart", fetch="EXTRA_LAZY", cascade={"remove"}, orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity="SkuskuPayment", inversedBy="cart")
     * @ORM\JoinColumn(name="payment", referencedColumnName="id")
     */
    private $payment;

    /**
     * @ORM\OneToOne(targetEntity="SkuskuOrder", mappedBy="cart")
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="SkuskuLangInterface")
     * @ORM\JoinColumn(name="lang_id", referencedColumnName="id")
     * @var SkuskuLangInterface
     */
    protected $lang;

    /**
     * @ORM\ManyToOne(targetEntity="SkuskuCurrencyInterface")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * @var SkuskuCurrencyInterface
     */
    protected $currency;

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
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = self::STATUS_INITIAL;


    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->dateAdd = new \DateTime();
        $this->dateUpd = new \DateTime();
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
     * @return SkuskuCart
     */
    public function emptyProducts()
    {
        $this->products->clear();
        return $this;
    }

    /**
     * @param SkuskuCartProductInterface $product
     * @return SkuskuCart
     */
    public function addProduct(SkuskuCartProductInterface $product)
    {
        $product->setCart($this);

        $this->products[] = $product;
        return $this;
    }

    /**
     * Get the total amount of the cart
     *
     * @return mixed
     */
    public function getTotalPrice()
    {
        return array_reduce($this->getProducts()->toArray(), function($carry, SkuskuCartProduct $product) {
            return $carry + ($product->getSubtotal());
        }, 0);
    }

    /**
     * Get the number of products added to the cart.
     * Useful for cart preview
     *
     * @return integer
     */
    public function getTotalQuantity()
    {
        return array_reduce($this->getProducts()->toArray(), function($carry, SkuskuCartProduct $product) {
            return $carry + ($product->getQuantity());
        }, 0);
    }

    /**
     * @return SkuskuCurrencyInterface
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param SkuskuCurrencyInterface $currency
     * @return SkuskuCart
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return SkuskuLangInterface
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param SkuskuLangInterface $lang
     * @return SkuskuCart
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @param SkuskuCustomerInterface $customer
     * @return SkuskuCart
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     * @return SkuskuCart
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return SkuskuCart
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
