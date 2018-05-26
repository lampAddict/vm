<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 14:04
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity
 * @ORM\Table(name="vm_goods")
 * @ORM\Table(indexes={@ORM\Index(name="goods_id_idx", columns={"gid"})})
 */
class VMGoods
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $gid;

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
     * Set gid
     *
     * @param integer $gid
     *
     * @return VMGoods
     */
    public function setGid($gid)
    {
        $this->gid = $gid;

        return $this;
    }

    /**
     * Get gid
     *
     * @return integer
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * Set num
     *
     * @param string $num
     *
     * @return VMGoods
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
