<?php
namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post {

    private $id;
    private $slug;
    private $name;
    private $content;
    private $created_at;
    private $categories = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getExcerpt()
    {
        if ($this->content === null)
        {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    public function getFormattedContent():? string
    {
        return nl2br(htmlentities($this->content));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;
        return $this;
    }

    public function getID(): ?int
    {
        return $this->id;
    }

    public function setId( int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function getCategoriesIds(): array
    {
        $ids = [];
        foreach($this->categories as $category)
        {
            $ids[] = $category->getID();
        }
        return $ids;
    }

    public function setName ( string $name ): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug ( string $slug ): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function setContent ( string $content ): self
    {
        $this->content = $content;
        return $this;
    }

    public function addCategory ( Category $category ): void 
    {
        $this->categories[] = $category;
    }
}