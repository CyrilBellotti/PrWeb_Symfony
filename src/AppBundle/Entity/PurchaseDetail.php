<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseDetail
 *
 * @ORM\Table(name="order_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseDetailRepository")
 */
class PurchaseDetail
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
     * @var float
     *
     * @ORM\Column(name="unitPrice", type="float")
     */
    private $unitPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Purchase")
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id")
     */
    private $purchase;

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
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return PurchaseDetail
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return PurchaseDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product) {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getPurchase() {
        return $this->purchase;
    }

    /**
     * @param mixed $purchase
     */
    public function setPurchase($purchase) {
        $this->purchase = $purchase;
    }



}

