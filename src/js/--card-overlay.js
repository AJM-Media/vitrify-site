// console.clear();

// const cardsContainer = document.querySelector(".cards");
// const cardsContainerInner = document.querySelector(".cards__inner");
// const cards = Array.from(document.querySelectorAll(".card"));
// const overlay = document.querySelector(".overlay");

// // Update the radial mask position & opacity as the mouse moves
// const applyOverlayMask = (e) => {
//   const overlayEl = e.currentTarget;
//   const x = e.pageX - cardsContainer.offsetLeft;
//   const y = e.pageY - cardsContainer.offsetTop;

//   overlayEl.style = `--opacity: 1; --x: ${x}px; --y:${y}px;`;
// };

// // Clone the CTA text into the overlay card (just for matching visuals)
// const createOverlayCta = (overlayCard, ctaEl) => {
//   const overlayCta = document.createElement("div");
//   overlayCta.classList.add("cta");
//   overlayCta.textContent = ctaEl.textContent;
//   overlayCta.setAttribute("aria-hidden", "true");

//   overlayCard.append(overlayCta);
// };

// // Observe size changes and match the overlay card's width/height
// const observer = new ResizeObserver((entries) => {
//   entries.forEach((entry) => {
//     const cardIndex = cards.indexOf(entry.target);
//     if (cardIndex >= 0) {
//       const { inlineSize: width, blockSize: height } = entry.borderBoxSize[0];
//       overlay.children[cardIndex].style.width = `${width}px`;
//       overlay.children[cardIndex].style.height = `${height}px`;
//     }
//   });
// });

// // Create an overlay clone for each real card
// const initOverlayCard = (cardEl) => {
//   const overlayCard = document.createElement("div");
//   overlayCard.classList.add("card");
//   overlayCard.setAttribute("aria-hidden", true);

//   // Copy the custom CSS properties from the source .card
//   const style = window.getComputedStyle(cardEl);
//   overlayCard.style.setProperty("--hue", style.getPropertyValue("--hue").trim());
//   overlayCard.style.setProperty("--saturation", style.getPropertyValue("--saturation").trim());
//   overlayCard.style.setProperty("--lightness", style.getPropertyValue("--lightness").trim());
//   overlayCard.style.setProperty("--hsl", style.getPropertyValue("--hsl").trim());

//   // Copy the CTA text
//   createOverlayCta(overlayCard, cardEl.lastElementChild);

//   // Append to overlay + observe
//   overlay.append(overlayCard);
//   observer.observe(cardEl);
// };

// // Initialize everything
// cards.forEach(initOverlayCard);
// document.body.addEventListener("pointermove", applyOverlayMask);
