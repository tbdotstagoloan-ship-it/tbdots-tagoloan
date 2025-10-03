
  document.addEventListener('DOMContentLoaded', function () {
      const topLevelLinks = document.querySelectorAll('.sidebar > ul > li > a');
      const currentUrl = window.location.href;

      topLevelLinks.forEach(link => {
        if (link.href === currentUrl || currentUrl === link.href + "/") {
          link.classList.add('active');
        } else {
          link.classList.remove('active');
        }

        link.addEventListener('click', function () {
          topLevelLinks.forEach(l => l.classList.remove('active'));
          this.classList.add('active');
        });
      });
    });