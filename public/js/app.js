const likeImgs = document.querySelectorAll("#like");

const heart = "http://localhost:8000/images/heart.svg";
const heartFull = "http://localhost:8000/images/heart-full.svg";

Array.from(likeImgs).map((likeImg) => {
  likeImg.addEventListener("click", () =>
    likeImg.src === heart ? (likeImg.src = heartFull) : (likeImg.src = heart)
  );
});
