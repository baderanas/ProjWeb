const navigationHeight = document.querySelector(".navbar").offsetHeight;
console.log(navigationHeight);
document.documentElement.style.setProperty(
  "scroll-padding-top",
  navigationHeight + "px"
);

loadMoreBtn = document.querySelector(".car-packages .load-more");
let currentItem = 2;

loadMoreBtn.onclick = () => {
  let boxes = [
    ...document.querySelectorAll(".car-packages .box-container .box"),
  ];
  for (var i = currentItem; i < currentItem + 5; i++) {
    boxes[i].style.display = "inline-block";
  }
  currentItem += 5;
  if (currentItem >= boxes.length) {
    loadMoreBtn.style.display = "none";
  }
};
