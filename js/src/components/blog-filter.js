document.addEventListener('DOMContentLoaded', () => {
  const searchButton = document.querySelector('.blog-filter__search-icon');
  const searchInput = document.querySelector('.blog-filter__search-input');
  const searchForm = document.querySelector('.blog-filter__search');

  if (searchButton && searchInput && searchForm) {
    searchButton.addEventListener('click', () => {
      searchInput.focus();
      if (searchInput.value.trim() !== '') searchForm.submit();
    });
  }

  const normalizeString = (str) =>
    (str || '')
      .toString()
      .trim()
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '');

  const { href, pathname, search } = window.location;
  const searchParams = new URLSearchParams(search);
  const searchTerm = normalizeString(searchParams.get('s') || '');

  let hasActive = false;

  document.querySelectorAll('.blog-filter__label').forEach((labelEl) => {
    const labelText = normalizeString(labelEl.textContent || '');
    if (!labelText) return;

    const slug = labelText.replace(/\s+/g, '-');
    const matchesSearch = !!searchTerm && (searchTerm === labelText || searchTerm === slug);
    const matchesPath =
      pathname.toLowerCase().includes(`/category/${slug}/`) || href.toLowerCase().includes(`/${slug}/`);

    if (matchesSearch || matchesPath) {
      const linkEl = labelEl.closest('.blog-filter__link, a');
      if (linkEl) {
        linkEl.classList.add('blog-filter__link--active', 'active');
        hasActive = true;
      }
    }
  });

  if (!hasActive) {
    const allLabelEl = Array.from(document.querySelectorAll('.blog-filter__label')).find(
      (el) => normalizeString(el.textContent || '') === 'wszystko',
    );
    if (allLabelEl) {
      const allLinkEl = allLabelEl.closest('.blog-filter__link, a');
      if (allLinkEl) allLinkEl.classList.add('blog-filter__link--active', 'active');
    }
  }
});
