document.addEventListener('DOMContentLoaded', function () {
  const footerColumn = document.querySelector('.footer__column.footer__column--first');
  if (!footerColumn) return;

  let ulCount = 0;
  for (let n = footerColumn.firstElementChild; n; n = n.nextElementSibling) {
    if (n.tagName === 'UL') ulCount++;
  }
  if (ulCount < 2) return;

  let node = footerColumn.firstElementChild;
  while (node) {
    if (node.tagName === 'H4' && node.nextElementSibling && node.nextElementSibling.tagName === 'UL') {
      const footerHeading = node;
      const footerList = node.nextElementSibling;
      const footerWrapper = document.createElement('div');
      footerColumn.insertBefore(footerWrapper, footerHeading);
      footerWrapper.appendChild(footerHeading);
      footerWrapper.appendChild(footerList);
      node = footerWrapper.nextElementSibling;
    } else {
      node = node.nextElementSibling;
    }
  }
});
