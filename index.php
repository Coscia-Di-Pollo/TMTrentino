<?php

require_once "app/Database.php";
require_once "app/Post.php";
require_once "app/PostRepository.php";

$db = new Database("localhost", "tmtrentino", "root", "", 3306, "utf8mb4");
$postRepository = new PostRepository($db);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="style/style.css">

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    media="print"
    onload="this.media = 'all'"
  >

  <script src="script/script.js" defer></script>

  <title> TM Trentino - News del calcio Trentino </title>
</head>
<body>
  <header>
    <div class="header">
      <nav class="nav__header">
        <ul class="menu__header">
          <li><a href="">Homepage</a></li>
          <li><a href="">Chi siamo</a></li>
          <li><a href="">Squadra</a></li>
          <li><a href="">Top 11</a></li>
          <li><a href="">Calciomercato</a></li>
          <li><a href="">Contatti</a></li>
        </ul>

        <div class="navbar__header">
          <div class="icon-bar__header"></div>
          <div class="icon-bar__header"></div>
          <div class="icon-bar__header"></div>
        </div>

        <div class="social__header">
          <a href=""><i class="fab fa-instagram"></i></a>
          <a href=""><i class="fab fa-facebook"></i></a>
          <a href=""><i class="fab fa-spotify"></i></a>
          <a href=""><i class="fab fa-tiktok"></i></a>
          <a href=""><i class="fab fa-twitter"></i></a>
        </div>
      </nav>
      
      <div class="search__header">
        <form action="app/search.php" method="get" class="form__search__header">
          <input type="text" name="search" id="search" placeholder="Scrivi qui la tua ricerca!" required>
          <div class="hidden">
            <div class="custom__select__search__header">
              <div class="select__trigger__search__header"><p> Filtra per Categoria</p><i class="fas fa-chevron-down"></i></div>
              <div class="select__option__search__header">
                <div class="close__option__search__header"><i class="fas fa-times"></i></div>
                <?php foreach($postRepository->getAllCategories() as $category):?>
                  <div class="option" data-value="<?php echo $category;?>"><p><?php echo $category;?></p></div>
                <?php endforeach;?>
              </div>
            </div>
            <div class="custom__select__search__header">
              <div class="select__trigger__search__header"><p> Filtra per Data</p><i class="fas fa-chevron-down"></i></div>
              <div class="select__option__search__header">
                <div class="close__option__search__header"><i class="fas fa-times"></i></div>
                <?php ?>
              </div>
            </div>
            <div class="custom__select__search__header">
              <div class="select__trigger__search__header"><p> Filtra per Ordine</p><i class="fas fa-chevron-down"></i></div>
              <div class="select__option__search__header">
                <div class="close__option__search__header"><i class="fas fa-times"></i></div>
                <?php ?>
              </div>
            </div>
            <div class="clear__filter__search__header">
              <i class="fas fa-times"></i>
            </div>
          </div>
          
          <button type="submit" aria-label="Cerca"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>

  </header>
</body>
</html>