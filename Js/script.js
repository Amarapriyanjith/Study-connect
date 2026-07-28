document.addEventListener("DOMContentLoaded", () => {
  // 1. Accordion Toggle (Expand/Collapse sections)
  const filterHeaders = document.querySelectorAll(".filter-header");

  filterHeaders.forEach((header) => {
    header.addEventListener("click", () => {
      const group = header.parentElement;
      // Toggle collapsed class (skips rating group if no arrow present)
      if (header.querySelector(".toggle-arrow")) {
        group.classList.toggle("collapsed");
      }
    });
  });

  // 2. Interactive Star Rating Slider
  const slider = document.getElementById("ratingRange");
  const stars = document.querySelectorAll(".stars-rating i");

  slider.addEventListener("input", (e) => {
    const val = parseInt(e.target.value);

    stars.forEach((star, index) => {
      if (index < val) {
        star.classList.add("yellow");
      } else {
        star.classList.remove("yellow");
      }
    });
  });
});