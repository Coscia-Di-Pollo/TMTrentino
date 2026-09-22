<?php

declare(strict_types=1);

class Database {
  private string $host;
  private string $dbname;
  private string $user;
  private string $pass;
  private int $port;
  private string $charset;
  private ?PDO $connection;

  public function __construct(string $host, string $dbname, string $user, string $pass, int $port, string $charset) {
    $this->setHost($host);
    $this->setDbname($dbname);
    $this->setUser($user);
    $this->setPass($pass);
    $this->setPort($port);
    $this->setCharset($charset);
    $this->connection = null;
  }

  public function getHost(): string {
    return $this->host;
  }

  public function setHost(string $host): void {
    $host = trim($host);
    if ($host === '') {
      throw new Exception("Inserisci l'host del Database!");
    }
    $this->host = $host;
  }

  public function getDbname(): string {
    return $this->dbname;
  }

  public function setDbname(string $dbname): void {
    $dbname = trim($dbname);
    if ($dbname === '') {
      throw new Exception("Inserisci il nome del Database!");
    }
    $this->dbname = $dbname;
  }

  public function getUser(): string {
    return $this->user;
  }

  public function setUser(string $user): void {
    $user = trim($user);
    if ($user === '') {
      throw new Exception("Inserisci lo username del Database!");
    }
    $this->user = $user;
  }

  public function getPass(): string {
    return $this->pass;
  }

  public function setPass(string $pass): void {
    $this->pass = $pass;
  }

  public function getPort(): int {
    return $this->port;
  }

  public function setPort(int $port): void {
    if ($port <= 0 || $port > 65535) {
      throw new Exception("La porta del database non è valida.");
    }
    $this->port = $port;
  }

  public function getCharset(): string {
    return $this->charset;
  }

  public function setCharset(string $charset): void {
    $charset = trim($charset);
    if ($charset === '') {
      throw new Exception('Inserisci il charset del Database');
    }
    $this->charset = $charset;
  }

  public function getConnection(): ?PDO {
    return $this->connection;
  }

  public function connect(): PDO {
    if ($this->connection === null) {
      try {
        $dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=$this->charset", $this->user, $this->pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connection = $dbh;
      } catch (PDOException $e) {
        throw new Exception("Errore di connessione al database: " . $e->getMessage());
      }
    }


    return $this->connection;
  }

  public function disconnect(): void {
    $this->connection = null;
  }

  public function __toString(): string {
    $txt = "Host: {$this->host}<br />DBName: {$this->dbname}<br />User: {$this->user}<br />Password: {$this->pass}<br />Port: {$this->port}<br />Charset: {$this->charset}";

    return $txt;
  }
}
