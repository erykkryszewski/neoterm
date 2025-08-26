document.addEventListener('DOMContentLoaded', function () {
  if (window.innerWidth <= 991) {
    const column = document.querySelector('.footer__column.footer__column--first');
    if (!column) return;

    const pairs = [];
    const children = Array.from(column.children);

    for (let i = 0; i < children.length; i++) {
      if (children[i].tagName === 'H4' && children[i + 1] && children[i + 1].tagName === 'UL') {
        pairs.push([children[i], children[i + 1]]);
        i++;
      }
    }

    pairs.forEach((pair) => {
      const wrapper = document.createElement('div');
      column.insertBefore(wrapper, pair[0]);
      wrapper.appendChild(pair[0]);
      wrapper.appendChild(pair[1]);
    });
  }
});
