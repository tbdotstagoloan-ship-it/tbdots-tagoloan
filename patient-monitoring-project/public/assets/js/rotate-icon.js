document.querySelectorAll('.menu-item').forEach(item => {
  const link = item.querySelector(':scope > a');
  const submenu = item.querySelector('.submenu');

  if (submenu) {
    link.addEventListener('click', e => {
      e.preventDefault();

      // Close other open menus
      document.querySelectorAll('.menu-item.open').forEach(openItem => {
        if (openItem !== item) {
          openItem.classList.remove('open');
        }
      });

      // Toggle the clicked one
      item.classList.toggle('open');
    });
  }
});
