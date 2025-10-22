document.addEventListener('DOMContentLoaded', () => {
  const menuItems = document.querySelectorAll('.menu-item');
  const currentUrl = window.location.href;

  // 👉 Step 1: Restore previously open menu
  const savedOpenId = localStorage.getItem('openMenuId');
  if (savedOpenId) {
    const savedMenu = document.querySelector(`.menu-item[data-menu-id="${savedOpenId}"]`);
    if (savedMenu) savedMenu.classList.add('open');
  }

  // 👉 Step 2: Setup toggling of parent menus
  menuItems.forEach((item, index) => {
    const link = item.querySelector(':scope > a');
    const submenu = item.querySelector('.submenu');

    // assign unique ID if wala pa
    if (!item.hasAttribute('data-menu-id')) {
      item.setAttribute('data-menu-id', index);
    }

    if (submenu) {
      link.addEventListener('click', e => {
        e.preventDefault();

        // toggle open/close
        const isOpen = item.classList.contains('open');

        // Close other menus
        document.querySelectorAll('.menu-item.open').forEach(openItem => {
          if (openItem !== item) openItem.classList.remove('open');
        });

        if (!isOpen) {
          item.classList.add('open');
          localStorage.setItem('openMenuId', item.getAttribute('data-menu-id'));
        } else {
          item.classList.remove('open');
          localStorage.removeItem('openMenuId');
        }
      });
    }
  });

  // 👉 Step 3: Mark active submenu and keep parent open
  document.querySelectorAll('.submenu a').forEach(subLink => {
    if (subLink.href === currentUrl || currentUrl === subLink.href + '/') {
      subLink.classList.add('active');
      const parent = subLink.closest('.menu-item');
      if (parent) {
        parent.classList.add('open');
        localStorage.setItem('openMenuId', parent.getAttribute('data-menu-id'));
      }
    }
  });

  // 👉 Step 4: Highlight top level active links
  document.querySelectorAll('.sidebar > ul > li > a').forEach(link => {
    if (link.href === currentUrl || currentUrl === link.href + '/') {
      link.classList.add('active');
    }
  });
});
