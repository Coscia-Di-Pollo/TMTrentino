const selectTables = document.querySelectorAll('.select__trigger__search__header');

selectTables.forEach(table => {
  table.addEventListener('click', (target) => {
    openOptionTable(target.currentTarget);
  });
});

function openOptionTable(element) {
  

  const optionTable = element.nextElementSibling;
  const arrow = element.querySelector('.fa-chevron-down');
  
  if (document.querySelector('.select__option__search__header.open') && document.querySelector('.select__option__search__header.open') != optionTable) {
    closeOptionTable();
  }

  if (optionTable) {
    optionTable.classList.toggle('open');
    if(arrow) arrow.classList.toggle('rotate');
  }
}

const closeOptionMenu = document.querySelectorAll('.close__option__search__header');

closeOptionMenu.forEach(table => {
  table.addEventListener('click', closeOptionTable)
})

function closeOptionTable() {
  document.querySelector('.select__option__search__header.open').classList.remove('open');
  document.querySelector('.fa-chevron-down.rotate').classList.remove('rotate');
}

const searchHeader = document.querySelector('.search__header');
const searchInput = document.getElementById('search');

searchInput.addEventListener('focus', () => {
  searchHeader.classList.add('is_active'); 
});

document.addEventListener('click', (event) => {
  // Se il click NON è dentro searchHeader, rimuoviamo la classe
  if (!searchHeader.contains(event.target)) {
    searchHeader.classList.remove('is_active');
    closeOptionTable();
  }
});

// 3. Chiudi se l'utente preme il tasto ESC sulla tastiera
document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    searchHeader.classList.remove('is_active');
    searchInput.blur();
    closeOptionTable();
  }
});