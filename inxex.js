const slider = document.querySelector(".slider");
const slides = document.querySelectorAll(".slide");
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");

const events = [
  {
    name: "Serene Soundscape Soiree",
    description:
      "Experience the harmony of serene melodies and vibrant vibes in our Soundscape Soiree.",
    image: "uploads/serene-soundscape.jpg",
  },
  {
    name: "FutureTech Expo Hub",
    description:
      "Dive into the future with cutting-edge innovations and interactive exhibits.",
    image: "uploads/futuretech-expo.jpg",
  },
  {
    name: "Nature's Palette Showcase",
    description:
      "Celebrate the beauty of nature with colors, flavors, and captivating moments.",
    image: "uploads/nature-palette.jpg",
  },
  {
    name: "World Flavors Adventure",
    description:
      "Embark on a culinary journey that spans cultures and continents.",
    image: "uploads/world-flavors.jpg",
  },
];

let currentIndex = 0;

function updateSlider() {
  const currentEvent = events[currentIndex];

  const currentSlide = slides[currentIndex];
  const imgElement = currentSlide.querySelector("img");
  const nameElement = currentSlide.querySelector(".event-name");
  const descriptionElement = currentSlide.querySelector(".event-description");

  imgElement.src = currentEvent.image;
  nameElement.textContent = currentEvent.name;
  descriptionElement.textContent = currentEvent.description;

  slider.style.transform = `translateX(-${currentIndex * 100}%)`;
}

prevBtn.addEventListener("click", () => {
  currentIndex = currentIndex > 0 ? currentIndex - 1 : slides.length - 1;
  updateSlider();
});

nextBtn.addEventListener("click", () => {
  currentIndex = currentIndex < slides.length - 1 ? currentIndex + 1 : 0;
  updateSlider();
});

setInterval(() => {
  currentIndex = currentIndex < slides.length - 1 ? currentIndex + 1 : 0;
  updateSlider();
}, 4000);

updateSlider();

bookEventBtn.addEventListener('click', () => {
  window.location.href = "/book-your-event"; 
});

watchVideoBtn.addEventListener('click', () => {
  
  const videoUrl = "https://www.youtube.com/watch?v=N8tnM9KyLos&ab_channel=TNW";
  window.open(videoUrl, "_blank"); 
});

const galleryItems = document.querySelectorAll('.gallery-item img');
const seeAllBtn = document.querySelector('.see-all-btn');

galleryItems.forEach(item => {
    item.addEventListener('click', () => {
        const fullImageSrc = item.src;
        const modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <div class="modal-content">
                <img src="${fullImageSrc}" alt="Full view">
                <span class="close-modal">&times;</span>
            </div>
        `;
        document.body.appendChild(modal);

        const closeModal = modal.querySelector('.close-modal');
        closeModal.addEventListener('click', () => {
            modal.remove();
        });
    });
});

