<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkuskuCustomerBase
 * @ORM\MappedSuperclass()
 */
abstract class SkuskuCustomerBase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="secure_key", type="string", length=32)
     */
    protected $secureKey;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="passwd", type="string", length=32)
     */
    protected $passwd;

    /**
     * @var time_immutable
     *
     * @ORM\Column(name="last_passwd_gen", type="time_immutable")
     */
    protected $lastPasswdGen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    protected $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=32)
     */
    protected $lastname;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    protected $newsletter;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_registration_newsletter", type="string", length=15)
     */
    protected $ipRegistrationNewsletter;

    /**
     * @var bool
     *
     * @ORM\Column(name="optin", type="boolean")
     */
    protected $optin;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=32)
     */
    protected $firstname;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    protected $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    protected $dateUpd;


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
     * Set secureKey.
     *
     * @param string $secureKey
     *
     * @return SkuskuCustomerBase
     */
    public function setSecureKey($secureKey)
    {
        $this->secureKey = $secureKey;

        return $this;
    }

    /**
     * Get secureKey.
     *
     * @return string
     */
    public function getSecureKey()
    {
        return $this->secureKey;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return SkuskuCustomerBase
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwd.
     *
     * @param string $passwd
     *
     * @return SkuskuCustomerBase
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;

        return $this;
    }

    /**
     * Get passwd.
     *
     * @return string
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set lastPasswdGen.
     *
     * @param time_immutable $lastPasswdGen
     *
     * @return SkuskuCustomerBase
     */
    public function setLastPasswdGen($lastPasswdGen)
    {
        $this->lastPasswdGen = $lastPasswdGen;

        return $this;
    }

    /**
     * Get lastPasswdGen.
     *
     * @return time_immutable
     */
    public function getLastPasswdGen()
    {
        return $this->lastPasswdGen;
    }

    /**
     * Set birthday.
     *
     * @param \DateTime $birthday
     *
     * @return SkuskuCustomerBase
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday.
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return SkuskuCustomerBase
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set newsletter.
     *
     * @param bool $newsletter
     *
     * @return SkuskuCustomerBase
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter.
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set ipRegistrationNewsletter.
     *
     * @param string $ipRegistrationNewsletter
     *
     * @return SkuskuCustomerBase
     */
    public function setIpRegistrationNewsletter($ipRegistrationNewsletter)
    {
        $this->ipRegistrationNewsletter = $ipRegistrationNewsletter;

        return $this;
    }

    /**
     * Get ipRegistrationNewsletter.
     *
     * @return string
     */
    public function getIpRegistrationNewsletter()
    {
        return $this->ipRegistrationNewsletter;
    }

    /**
     * Set optin.
     *
     * @param bool $optin
     *
     * @return SkuskuCustomerBase
     */
    public function setOptin($optin)
    {
        $this->optin = $optin;

        return $this;
    }

    /**
     * Get optin.
     *
     * @return bool
     */
    public function getOptin()
    {
        return $this->optin;
    }

    /**
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return SkuskuCustomerBase
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return SkuskuCustomerBase
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return SkuskuCustomerBase
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
     * @return SkuskuCustomerBase
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
}
