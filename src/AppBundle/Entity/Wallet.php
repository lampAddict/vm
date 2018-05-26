<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 13:56
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallet")
 */
class Wallet
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $wtype;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Table(indexes={@ORM\Index(name="coin_id_idx", columns={"cid"})})
     */
    private $cid;

    /**
     * @ORM\Column(type="integer")
     */
    private $num;

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
     * Set wtype
     *
     * @param boolean $wtype
     *
     * @return Wallet
     */
    public function setWtype($wtype)
    {
        $this->wtype = $wtype;

        return $this;
    }

    /**
     * Get wtype
     *
     * @return boolean
     */
    public function getWtype()
    {
        return $this->wtype;
    }

    /**
     * Set cid
     *
     * @param string $cid
     *
     * @return Wallet
     */
    public function setCid($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    /**
     * Get cid
     *
     * @return string
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Set num
     *
     * @param string $num
     *
     * @return Wallet
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }
}
