<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * SkuskuOrder
 *
 * @ORM\Table(name="skusku_order")
 * @ORM\Entity(repositoryClass="GGGGino\SkuskuCartBundle\Repository\OrderRepository")
 */
class SkuskuOrder
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
     * @ORM\OneToOne(targetEntity="SkuskuCart", inversedBy="order")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cart;

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
     * @ORM\Column(name="date_add", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateUpd;

    /**
     * @var string
     *
     * @ORM\Column(name="total_paid", type="decimal", precision=10, scale=2)
     */
    protected $totalPaid;

    /**
     * @var string
     *
     * @ORM\Column(name="total_paid_real", type="decimal", precision=10, scale=2)
     */
    protected $totalPaidReal;

    /**
     * @var string
     *
     * @ORM\Column(name="total_products", type="decimal", precision=10, scale=2)
     */
    protected $totalProducts;

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
     * @return SkuskuOrder
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
     * @return SkuskuOrder
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
     * @return SkuskuCurrencyInterface
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param SkuskuCurrencyInterface $currency
     * @return SkuskuOrder
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
     * @return SkuskuOrder
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @param SkuskuCustomerInterface $customer
     * @return SkuskuOrder
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     * @return SkuskuOrder
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * @param string $totalPaid
     * @return SkuskuOrder
     */
    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalPaidReal()
    {
        return $this->totalPaidReal;
    }

    /**
     * @param string $totalPaidReal
     * @return SkuskuOrder
     */
    public function setTotalPaidReal($totalPaidReal)
    {
        $this->totalPaidReal = $totalPaidReal;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalProducts()
    {
        return $this->totalProducts;
    }

    /**
     * @param string $totalProducts
     * @return SkuskuOrder
     */
    public function setTotalProducts($totalProducts)
    {
        $this->totalProducts = $totalProducts;
        return $this;
    }
}
