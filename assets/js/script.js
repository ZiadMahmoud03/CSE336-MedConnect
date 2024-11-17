/*-----------------------------------------------------------------Donation History Filter---------------------------------------------------------*/

document.getElementById('filter-type').addEventListener('change', function() {
    const filterType = this.value;
    const filterDateContainer = document.getElementById('filter-date-container');
    const filterHospitalContainer = document.getElementById('filter-hospital-container');

    if (filterType === 'date') {
        filterDateContainer.style.display = 'block';
        filterHospitalContainer.style.display = 'none';
    } else {
        filterDateContainer.style.display = 'none';
        filterHospitalContainer.style.display = 'block';
    }
});

document.getElementById('filter-button').addEventListener('click', function() {
    const filterType = document.getElementById('filter-type').value;
    const filterDate = document.getElementById('filter-date').value;
    const filterHospital = document.getElementById('filter-hospital').value;

    let donations = [
        { date: '2022-01-02', amount: 100, hospital: 'Hospital 1' },
        { date: '2022-05-15', amount: 200, hospital: 'Hospital 3' },
        { date: '2022-07-23', amount: 50, hospital: 'Hospital 2' },
    ];

    let filteredDonations = donations.filter(donation => {
        if (filterType === 'date') {
            return donation.date === filterDate;
        } else {
            return donation.hospital === filterHospital;
        }
    });

    const donationList = document.getElementById('donation-list');
    donationList.innerHTML = '';
    filteredDonations.forEach(donation => {
        const li = document.createElement('li');
        li.textContent = `${donation.date} - $${donation.amount} to ${donation.hospital}`;
        donationList.appendChild(li);
    });
});

/*-----------------------------------------------------------------Sliders---------------------------------------------------------*/
// Define the sliding functions globally
function slideLeft(event) {
    // Find the wrapper that contains the clicked button
    const wrapper = event.currentTarget.closest('.wrapper');
    // Find the carousel within this specific wrapper
    const carousel = wrapper.querySelector('.carousel');
    carousel.scrollBy({
        left: -200,
        behavior: 'smooth'
    });
}

function slideRight(event) {
    // Find the wrapper that contains the clicked button
    const wrapper = event.currentTarget.closest('.wrapper');
    // Find the carousel within this specific wrapper
    const carousel = wrapper.querySelector('.carousel');
    carousel.scrollBy({
        left: 200,
        behavior: 'smooth'
    });
}

// Add event listeners when the document loads
document.addEventListener('DOMContentLoaded', function() {
    const prevButtons = document.querySelectorAll(".prev-btn");
    const nextButtons = document.querySelectorAll(".next-btn");

    // Add click listeners to all prev buttons
    prevButtons.forEach(btn => {
        btn.onclick = slideLeft;
    });

    // Add click listeners to all next buttons
    nextButtons.forEach(btn => {
        btn.onclick = slideRight;
    });
});
/*const cardData = [
    {
        imgSrc: "Images/kisspng-57357-hospital-dar-al-fouad-cancer-child-5b3e67bbbbbc02.222815191530816443769.jpg",
        title: "Hello 1"
    },
    {
        imgSrc: "Images/image2.jpg",
        title: "Hello 2"
    },
    {
        imgSrc: "Images/image3.jpg",
        title: "Hello 3"
    },
    {
        imgSrc: "Images/image4.jpg",
        title: "Hello 4"
    },
    {
        imgSrc: "Images/image5.jpg",
        title: "Hello 5"
    },
];
const carousel = document.querySelector('.carousel');

cardData.forEach(data => {
    // Create a card element
    const card = document.createElement('li');
    card.className = 'card';

    // Add content to the card
    card.innerHTML = `
        <div class="img">
            <img src="${data.imgSrc}" alt="${data.title}" draggable="false">
        </div>
        <h4>${data.title}</h4>
    `;

    // Append the card to the carousel
    carousel.appendChild(card);
});
const carouselWrapper = document.querySelector('.carousel');
const cardWidth = document.querySelector('.card').offsetWidth + 16; // Include margin or gap

function slideLeft() {
    carouselWrapper.scrollLeft -= cardWidth * 3; // Adjust based on the number of visible cards
}

function slideRight() {
    carouselWrapper.scrollLeft += cardWidth * 3;
}*/

/*-------------------------------------------------Login/Register Buttons------------------------------------------------*/

// Select login and register buttons
const loginButton = document.getElementById('login-button');
const registerButton = document.getElementById('register-button');
const authButtons = document.getElementById('auth-buttons');

// Add event listeners to both buttons
[loginButton, registerButton].forEach(button => {
    button.addEventListener('click', () => {
        // Hide the auth buttons container
        authButtons.style.display = 'none';
    });
});

/*---------------------------------------------PickUp/DropOff--------------------------------------------------------------*/
function togglePaymentOption() {
    const paymentMethodSelect = document.getElementById('frequency');
    const paymentMethodLabel = document.getElementById('payment-method-label');
    const paymentMethodDropdown = document.getElementById('payment-method');
    
    // Check if "Cash" is selected
    if (paymentMethodSelect.value === 'cash') {
        paymentMethodLabel.style.display = 'block';  // Show the Payment Option label
        paymentMethodDropdown.style.display = 'block';  // Show the Payment Option dropdown
    } else {
        paymentMethodLabel.style.display = 'none';  // Hide the Payment Option label
        paymentMethodDropdown.style.display = 'none';  // Hide the Payment Option dropdown
    }
}

// Call the function on page load to ensure the correct initial state
document.addEventListener('DOMContentLoaded', function() {
    togglePaymentOption();  // Ensure the dropdown is hidden if "Cash" is not selected initially
});


