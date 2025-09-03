document.addEventListener('DOMContentLoaded', function () {
  const searchIconButton = document.querySelector('.blog-filter__search-icon');
  const searchInput = document.querySelector('.blog-filter__search-input');
  const searchForm = document.querySelector('.blog-filter__search');

  if (searchIconButton && searchInput && searchForm) {
    searchIconButton.addEventListener('click', function () {
      searchInput.focus();
      if (searchInput.value.trim() !== '') {
        searchForm.submit();
      }
    });
  }
});
