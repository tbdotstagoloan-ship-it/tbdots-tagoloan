
document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.nav-item > .nav-link');

    toggleButtons.forEach(button => {
        const targetSelector = button.getAttribute('href');
        const targetMenu = document.querySelector(targetSelector);
        const arrowIcon = button.querySelector('.toggle-arrow');

        // When a menu is about to be shown
        targetMenu.addEventListener('show.bs.collapse', () => {
            // Close other open menus (smooth!)
            document.querySelectorAll('.collapse.show').forEach(openMenu => {
                if (openMenu !== targetMenu) {
                    const relatedButton = document.querySelector(`a[href="#${openMenu.id}"]`);
                    const relatedArrow = relatedButton?.querySelector('.toggle-arrow');

                    // Collapse smoothly
                    const collapseInstance = bootstrap.Collapse.getOrCreateInstance(openMenu);
                    collapseInstance.hide();

                    // Rotate back the arrow
                    relatedArrow?.classList.remove('rotated');
                }
            });

            // Rotate this arrow
            arrowIcon.classList.add('rotated');
        });

        // When a menu is hidden
        targetMenu.addEventListener('hide.bs.collapse', () => {
            arrowIcon.classList.remove('rotated');
        });
    });
});
