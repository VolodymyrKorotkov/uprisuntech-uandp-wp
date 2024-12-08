document.addEventListener("DOMContentLoaded", function () {
  var select = document.querySelector(".options__select");
  var wrapper = document.querySelector(".options__wrapper");
  var arrow = document.querySelector(".arrow-down");

  select && select.addEventListener("click", function () {
    var isWrapperVisible = wrapper.style.display === "block";
    wrapper.style.display = isWrapperVisible ? "none" : "block";
    arrow.style.transform = isWrapperVisible
      ? "rotate(0deg)"
      : "rotate(-180deg)";
  });
});
