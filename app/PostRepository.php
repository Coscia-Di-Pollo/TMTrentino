<?php
declare(strict_types=1);

class PostRepository {
  private Database $db;

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function getDb() : Database {
    return $this->db;
  }

  public function save(Post $post) : bool {
    $dbh = $this->db->connect();

    $sql = "INSERT INTO posts (title, content, timestamp_created, timestamp_updated, cover, slug, category) VALUES (:title, :content, :timestamp_created, :timestamp_updated, :cover, :slug, :category)";

    $stmt = $dbh->prepare($sql);

    return $stmt->execute([
      ":title" => $post->getTitle(),
      ":content" => $post->getContent(),
      ":timestamp_created" => $post->getTimestamp_created(),
      ":timestamp_updated" => $post->getTimestamp_updated(),
      ":cover" => $post->getCover(),
      ":slug" => $post->getSlug(),
      ":category" => $post->getCategory()
    ]);
  }

  public function removeById(int $postId) : bool {
    
  }

  public function __toString() : string {
    $txt = "Database: {$this->db}";

    return $txt;
  }
}

?>