
    document.addEventListener("DOMContentLoaded", function () {
      const nextBtns = document.querySelectorAll(".next-tab");
      const prevBtns = document.querySelectorAll(".prev-tab");

      nextBtns.forEach(btn => {
        btn.addEventListener("click", function () {
          let activeTab = document.querySelector(".nav-tabs .nav-link.active");
          let nextTab = activeTab.parentElement.nextElementSibling?.querySelector(".nav-link");
          if (nextTab) nextTab.click();
        });
      });

      prevBtns.forEach(btn => {
        btn.addEventListener("click", function () {
          let activeTab = document.querySelector(".nav-tabs .nav-link.active");
          let prevTab = activeTab.parentElement.previousElementSibling?.querySelector(".nav-link");
          if (prevTab) prevTab.click();
        });
      });
    });