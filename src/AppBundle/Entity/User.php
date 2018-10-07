<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="use_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
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
     * @ORM\Column(name="use_lastname", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     * 
     * @ORM\Column(name="use_adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     * 
     * @ORM\Column(name="use_city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     * 
     * @ORM\Column(name="use_country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     * 
     * @ORM\Column(name="use_phone", type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="use_age", type="date", nullable=true)
     */
    private $age;

    /**
     * @var boolean
     * @ORM\Column(name="use_permis", type="boolean", nullable=true)
     */
    private $permis;

    /**
     * @var boolean
     * @ORM\Column(name="use_vehicule", type="boolean", nullable=true)
     */
    private $vehicule;

    /**
     * @var string
     * 
     * @ORM\Column(name="use_job", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="use_facebook", type="string", length=255, nullable=true, unique=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="use_linkedin", type="string", length=255, nullable=true, unique=true)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="use_instagram", type="string", length=255, nullable=true, unique=true)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="use_twitter", type="string", length=255, nullable=true, unique=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="use_pinterest", type="string", length=255, nullable=true, unique=true)
     */
    private $pinterest;

    /**
     * @var string
     *
     * @ORM\Column(name="use_youtube", type="string", length=255, nullable=true, unique=true)
     */
    private $youtube;

    /**
     * @ORM\Column(name="use_photo", type="string", nullable=true)
     * 
     *
     */
    private $photo;

    public function __toString()
    {
        return $this->photo;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }


    /**
     * Get the string of user in youtube
     *
     * @return string
     */
    public function getUserYoutube()
    {
        if ($this->getYoutube()) {
            $lien = explode('/user/', $this->getYoutube());
            return $lien[1];
        }
    }

    /**
     * Get the string of user in linkedin
     *
     * @return string
     */
    public function getUserLinkedin()
    {
        if ($this->getLinkedin()) {
            $link = explode('in/', $this->getLinkedin());
            return $link[1];
        }
    }

    /**
     * Get the string of user in Facebook
     *
     * @return string
     */
    public function getUserFacebook()
    {
        if ($this->getFacebook()) {
            $link = explode("https://www.facebook.com/", $this->getFacebook());
            return $link[1];
        }
    }

    /**
     * Get the string of user in instagram
     *
     * @return string
     */
    public function getUserInstagram()
    {
        if ($this->getInstagram()) {
            $link = explode('/', $this->getInstagram());
            return $link[3];
        }
    }


    /**
     * Get the string of user in twitter
     *
     * @return string
     */
    public function getUserTwitter()
    {
        if ($this->getTwitter()) {
            $link = explode("/", $this->getTwitter());
            return $link[3];
        }
    }

    /**
     * Get the string of user in pinterest
     *
     * @return string
     */
    public function getUserPinterest()
    {
        if($this->getPinterest()){
            $link = explode('/', $this->getPinterest());
            return $link[3];
        }
    }

    public function getPhoneSeparate()
    {
        if ($this->getPhone()) {
            $str = str_split($this->getPhone(), 2);
            $phone = implode('/', $str);
            return $phone;
        }
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return User
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set permis
     *
     * @param boolean $permis
     *
     * @return User
     */
    public function setPermis($permis)
    {
        $this->permis = $permis;

        return $this;
    }

    /**
     * Get permis
     *
     * @return boolean
     */
    public function getPermis()
    {
        return $this->permis;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return User
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return User
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     *
     * @return User
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set pinterest
     *
     * @param string $pinterest
     *
     * @return User
     */
    public function setPinterest($pinterest)
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * Get pinterest
     *
     * @return string
     */
    public function getPinterest()
    {
        return $this->pinterest;
    }

    /**
     * Set youtube
     *
     * @param string $youtube
     *
     * @return User
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube
     *
     * @return string
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Set vehicule
     *
     * @param boolean $vehicule
     *
     * @return User
     */
    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return boolean
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }
}
