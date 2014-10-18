<?php
namespace Boostit\WebBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Table(name="products_log")  
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Boostit\WebBundle\Repository\ProductLoggerRepository")
 */
class ProductLogger
{
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**     
    * @ORM\ManyToOne(targetEntity="Product")
    * @ORM\JoinColumn(name="product", referencedColumnName="id")
    * @Assert\Type(type="Boostit\WebBundle\Entity\Product")
    */
    protected $product;
    
    /**
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;
    
    /**
     * @var datetime $created
     *
     * @ORM\Column(name="selected_at", type="datetime")
     */
    private $selectedAt;


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
     * Set selectedAt
     *
     * @param \DateTime $selectedAt
     * @return ProductLogger
     * @ORM\PrePersist
     */
    public function setSelectedAt($selectedAt)
    {
        if(!$this->getSelectedAt()){            
            $this->selectedAt = new \DateTime();
            return $this;           
        }
        else return $this->getSelectedAt();
    }

    /**
     * Get selectedAt
     *
     * @return \DateTime 
     */
    public function getSelectedAt()
    {
        return $this->selectedAt;
    }

    /**
     * Set product
     *
     * @param \Boostit\WebBundle\Entity\Product $product
     * @return ProductLogger
     */
    public function setProduct(\Boostit\WebBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Boostit\WebBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return ProductLogger
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }
}
