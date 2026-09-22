<?php
declare(strict_types=1);

class PostRepository {
  private Database $db;
  private const ALLOWED_COLUMNS = ['id', 'title', 'category', 'timestamp_created'];

  public function __construct(Database $db) {
    $this->db = $db;
  }

  public function getDb() : Database {
    return $this->db;
  }

  private function databaseConnection() : PDO {
    return $this->db->connect();
  }

  public function save(Post $post) : bool {
    $dbh = $this->databaseConnection();

    $sql = "INSERT INTO posts (title, content, timestamp_created, timestamp_updated, cover, slug, category) VALUES (:title, :content, :timestamp_created, :timestamp_updated, :cover, :slug, :category)";

    $stmt = $dbh->prepare($sql);

    $success = $stmt->execute([
      ":title" => $post->getTitle(),
      ":content" => $post->getContent(),
      ":timestamp_created" => $post->getTimestamp_created(),
      ":timestamp_updated" => $post->getTimestamp_updated(),
      ":cover" => $post->getCover(),
      ":slug" => $post->getSlug(),
      ":category" => $post->getCategory()
    ]);

    if ($success) {
      $post->setId((int)$dbh->lastInsertId());
    }

    return $success;
  }

  private function checkColumns(string $column) : void {
    if (!in_array($column, self::ALLOWED_COLUMNS, true)) {
      throw new InvalidArgumentException("La colonna '{$column}' non è valida");
    }
  }

  private function deleteBy(string $column, mixed $value) : bool {
    $this->checkColumns($column);

    $dbh = $this->databaseConnection();

    $sql = "DELETE FROM posts WHERE {$column} = :value";

    $stmt = $dbh->prepare($sql);

    return $stmt->execute([
      ":value" => $value
    ]);
  }

  public function deleteById(int $id) : bool {
    return $this->deleteBy("id", $id);
  }

  public function deleteByTitle(string $title) : bool {
    return $this->deleteBy("title", $title);
  }

  public function deleteByCategory(string $category) : bool {
    return $this->deleteBy("category", $category);
  }

  public function deleteByTimestamp_created(DateTimeImmutable $date) : bool {
    $date = $date->format('Y-m-d H:i:s');
    return $this->deleteBy("timestamp_created", $date);
  }

  private function selectBy(string $column, mixed $value) : array {
    $this->checkColumns($column);

    $posts = [];

    $dbh = $this->databaseConnection();

    $sql = "SELECT * FROM posts WHERE {$column} = :value";

    $stmt = $dbh->prepare($sql);
    $stmt->execute([
      ":value" => $value
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $post) {
      $posts[] = Post::fromDatabase($post);
    }

    return $posts;
  }

  public function selectById(int $id) : ?Post {
    return $this->selectBy("id", $id)[0] ?? null;
  }

  public function selectByTitle(string $title) : ?Post {
    return $this->selectBy("title", $title)[0] ?? null;
  }

  public function selectByCategory(string $category) : array {
    return $this->selectBy("category", $category);
  }

  public function selectByTimestamp_created(DateTimeImmutable $date) : array {
    $date = $date->format('Y-m-d H:i:s');
    return $this->selectBy("timestamp_created", $date);
  }

  private function selectOrderBy(string $column, string $order = '') : array {
    $this->checkColumns($column);

    $posts = [];

    $dbh = $this->databaseConnection();

    $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
    $sql = "SELECT * FROM posts ORDER BY {$column} {$order} ";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($data as $post) {
      $posts[] = Post::fromDatabase($post);
    }

    return $posts;
  }

  public function selectOrderById__asc() : array {
    return $this->selectOrderBy("id", "asc");
  }

  public function selectOrderById__desc() : array {
    return $this->selectOrderBy("id", "desc");
  }

  public function selectByTitle__asc() : array {
    return $this->selectOrderBy("title", "asc");
  }

  public function selectByTitle__desc() : array {
    return $this->selectOrderBy("title", "desc");
  }

  public function selectByCategory__asc() : array {
    return $this->selectOrderBy("category", "asc");
  }

  public function selectByCategory__desc() : array {
    return $this->selectOrderBy("category", "desc");
  }

  public function selectOrderByTimestamp_created__asc() : array {
    return $this->selectOrderBy("timestamp_created", "asc");
  }

  public function selectOrderByTimestamp_created__desc() : array {
    return $this->selectOrderBy("timestamp_created", "desc");
  }

  public function update(Post $post) : bool {
    $post->updateTimestamp();
    
    $dbh = $this->databaseConnection();

    $sql = "UPDATE posts SET title = :title, content = :content, timestamp_updated = :timestamp_updated, cover = :cover, slug = :slug, category = :category WHERE id = :id";
    

    $stmt = $dbh->prepare($sql);

    return $stmt->execute([
      ":id" => $post->getId(),
      ":title" => $post->getTitle(),
      ":content" => $post->getContent(),
      ":timestamp_updated" => $post->getTimestamp_updated(),
      ":cover" => $post->getCover(),
      ":slug" => $post->getSlug(),
      ":category" => $post->getCategory()
    ]);
  }



  public function __toString() : string {
    $txt = "Database: {$this->db}";

    return $txt;
  }
}

?>