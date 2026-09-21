<?php
declare(strict_types=1);

class Post {
  private string $title;
  private string $content;
  private DateTimeImmutable $timestamp_created;
  private ?DateTimeImmutable $timestamp_updated;
  private string $cover;
  private string $slug;
  private string $category;

  public function __construct(string $title, string $content, string $cover, string $category) {
    $this->setTitle($title);
    $this->setContent($content);
    $this->timestamp_created = new DateTimeImmutable();
    $this->timestamp_updated = null;
    $this->setCover($cover);
    $this->setCategory($category);
    $this->setSlug($this->title);
  }

  public function getTitle() : string {
    return $this->title;
  }

  public function setTitle(string $title) : void {
    $this->title = trim($title);
  }

  public function getContent() : string {
    return $this->content;
  }

  public function setContent(string $content) : void {
    $this->content = trim($content);
  }

  public function getTimestamp_created(string $format = 'Y-m-d H:i:s'): string {
    return $this->timestamp_created->format($format);
  }

  public function getTimestamp_updated(string $format = 'Y-m-d H:i:s'): ?string {
    return $this->timestamp_updated ? $this->timestamp_updated->format($format) : null;
  }

  public function updateTimestamp(): void {
    $this->timestamp_updated = new DateTimeImmutable();
  }

  public function getCover() : string {
    return $this->cover;
  }

  public function setCover(string $cover) : void {
    $this->cover = trim($cover);
  }

  public function getCategory() : string {
    return $this->category;
  }

  public function setCategory(string $category) : void {
    $this->category = trim($category);
  }

  public function getSlug() : string {
    return $this->slug;
  }

  private function setSlug(string $title) : void {
    $title = strtolower(trim($title));
    $title = preg_replace('/[^a-z0-9-]+/', '-', $title);

    $this->slug = trim($title);
  }

  public static function validate(array $data) : array {
    $errors = [];

    $title = trim($data['title'] ?? '');
    if ($title === '') {
      $errors['title'] = "Inserisci il titolo del post!";
    }

    $content = trim($data['content'] ?? '');
    if ($content === '') {
      $errors['content'] = "Inserisci il contenuto del post!";
    }

    $cover = trim($data['cover'] ?? '');
    if ($cover === '') {
      $errors['cover'] = "Inserisci la cover del post!";
    }

    $category = trim($data['category'] ?? '');
    if ($category === '') {
      $errors['category'] = "Inserisci la categoria del post!";
    }

    return $errors;
  }
  public function __toString() : string {
    $txt = "Titolo: {$this->title}<br />Content: {$this->content}<br />Cover: {$this->cover}<br />Slug: {$this->slug}<br />Category: {$this->category}";

    return $txt;
  }
}


?>