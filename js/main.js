const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav-btn');
const closeNavBtn = document.querySelector('#close_nav-btn');
const sliderContainer = document.querySelector('.slider_container');
const slides = document.querySelectorAll('.featured');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

// opens nav dropdown
const openNav =() => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';

}
// close nav dropdown
const closeNav =() => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none';

}

openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);


const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar-btn')
;
const hideSidebarBtn = document.querySelector('#hide_sidebar-btn')
;


const showSidebar = () => {
    sidebar.style.left = '0';
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'inline-block';
}
const hideSidebar = () =>{
    sidebar.style.left = '-100%';
    showSidebarBtn.style.display = 'inline-block';
    hideSidebarBtn.style.display = 'none';
}

showSidebarBtn.addEventListener('click', showSidebar);
hideSidebarBtn.addEventListener('click', hideSidebar);

const cartItems = [];

    function addToCart(productName) {
      // Add product to the cart array
      cartItems.push(productName);

      // Update the cart display
      updateCart();
    }

    function updateCart() {
      const cartItemsContainer = document.getElementById('cart-items');
      cartItemsContainer.innerHTML = ''; // Clear previous content

      // Add each item in the cart to the display
      cartItems.forEach((item, index) => {
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `<span>${item}</span> <button onclick="removeFromCart(${index})">Remove</button>`;
        cartItemsContainer.appendChild(div);
      });
    }

    function removeFromCart(index) {
      // Remove item from the cart
      cartItems.splice(index, 1);

      // Update the cart display
      updateCart();
    }

    function clearCart() {
      // Clear the cart array
      cartItems.length = 0;

      // Update the cart display
      updateCart();
    }

    let currentIndex = 0;

    function updateSlider() {
      sliderContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    nextButton.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % slides.length;
      updateSlider();
    });

    prevButton.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateSlider();
    });