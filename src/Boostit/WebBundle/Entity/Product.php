<?php
namespace Boostit\WebBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="products")  
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Boostit\WebBundle\Repository\ProductRepository")
 */
class Product
{
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var datetime $created
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable = true)
     */
    private $updatedAt;
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ScheduleProgram
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        if(!$this->getCreatedAt()){            
            $this->createdAt = new \DateTime();
            return $this;           
        }
        else return $this->getCreatedAt();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

   /**
     * Set updatedAt
     * @ORM\PreUpdate
     * @param \DateTime $updatedAt
     * @return ScheduleProgram
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

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
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
