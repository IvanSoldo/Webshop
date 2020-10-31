<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity(fields={"name"}, message="There is already a product with this name")
 * @Vich\Uploadable()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="products", fileNameProperty="picture")
     * @Assert\File(maxSize="100k", mimeTypes = {"image/jpeg", "image/png", "image/jpg"}, mimeTypesMessage="Please upload valid Image.")
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $product_active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * @param mixed $pictureFile
     */
    public function setPictureFile($pictureFile): void
    {
        $this->pictureFile = $pictureFile;

        if (null !== $pictureFile) {
            $this->updatedAt = new \Datetime();
        }
    }

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     * @Assert\Count(min="1")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="product", orphanRemoval=true)
     */
    private $orderProducts;

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max = 999,
     * )
     * @Assert\NotBlank
     */
    private $quantity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $onDiscount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 60,
     * )
     */
    private $discountPercentage = 1;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;
        if ($picture) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getProductActive(): ?bool
    {
        return $this->product_active;
    }

    public function setProductActive(bool $product_active): self
    {
        $this->product_active = $product_active;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function getOnDiscount(): ?bool
    {
        return $this->onDiscount;
    }

    public function setOnDiscount(bool $onDiscount): self
    {
        $this->onDiscount = $onDiscount;

        return $this;
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?int $discountPercentage): self
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getDiscountedPrice()
    {
        return $this->price * ((100-$this->discountPercentage) / 100);
    }

}
