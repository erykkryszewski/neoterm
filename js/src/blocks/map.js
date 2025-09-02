document.addEventListener('DOMContentLoaded', function () {
  const mediaQuery = window.matchMedia('(max-width: 1199px)');
  const mapElement = document.querySelector('.map');
  const contactLeftColumn = document.querySelector('.contact__column--left');

  if (!mapElement || !contactLeftColumn) {
    return; // stop if elements are missing
  }

  const originalParent = mapElement.parentElement;
  const originalNextSibling = mapElement.nextSibling;

  function moveMapElement() {
    if (mediaQuery.matches) {
      if (!contactLeftColumn.contains(mapElement)) {
        contactLeftColumn.appendChild(mapElement);
      }
    } else {
      if (originalParent && mapElement.parentElement !== originalParent) {
        originalParent.insertBefore(mapElement, originalNextSibling);
      }
    }
  }

  moveMapElement();

  if (mediaQuery.addEventListener) {
    mediaQuery.addEventListener('change', moveMapElement);
  } else {
    // fallback for older browsers
    mediaQuery.addListener(moveMapElement);
  }
});
