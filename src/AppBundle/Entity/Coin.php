<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 13:53
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coin")
 */
class Coin
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $worth;

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
     * Set worth
     *
     * @param string $worth
     *
     * @return Coin
     */
    public function setWorth($worth)
    {
        $this->worth = $worth;

        return $this;
    }

    /**
     * Get worth
     *
     * @return string
     */
    public function getWorth()
    {
        return $this->worth;
    }
}
