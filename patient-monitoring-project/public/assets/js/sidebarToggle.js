
document.addEventListener('DOMContentLoaded', function () {
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const header = document.getElementById('header');

  function toggleSidebar() {
    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
      sidebar.classList.toggle('show');
    } else {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('sidebar-collapsed');
      header.classList.toggle('sidebar-collapsed');

      // ✅ Auto-close all open submenus when collapsing
      if (sidebar.classList.contains('collapsed')) {
        document.querySelectorAll('.menu-item.open').forEach(item => {
          item.classList.remove('open');
        });
      }
    }
  }

  function closeSidebar() {
    sidebar.classList.remove('show');
  }

  // Only add event listeners if the elements exist
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', toggleSidebar);
  }

 

  window.addEventListener('resize', function () {
    const isMobile = window.innerWidth <= 768;

    if (!isMobile) {
      sidebar.classList.remove('show');
      if (sidebar.classList.contains('collapsed')) {
        mainContent.classList.add('sidebar-collapsed');
        header.classList.add('sidebar-collapsed');
      } else {
        mainContent.classList.remove('sidebar-collapsed');
        header.classList.remove('sidebar-collapsed');
      }
    } else {
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('sidebar-collapsed');
      header.classList.remove('sidebar-collapsed');
    }
  });
});
