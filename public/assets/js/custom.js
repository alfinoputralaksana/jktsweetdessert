// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// toggle overlay menu
function openNav() {
    document.getElementById("myNav").classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeNav() {
    document.getElementById("myNav").classList.remove("active");
    document.body.style.overflow = "auto";
}

// Close overlay when clicking outside
document.addEventListener('click', function(event) {
    const overlay = document.getElementById("myNav");
    const menuBtn = document.querySelector(".custom_menu-btn");
    
    if (overlay && overlay.classList.contains("active")) {
        if (!overlay.contains(event.target) && !menuBtn.contains(event.target)) {
            closeNav();
        }
    }
});

// Navbar scroll effect
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header_section');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Close overlay on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeNav();
    }
});

// nice select
$(document).ready(function () {
    $('select').niceSelect();
});

// slick slider

$(".slider_container").slick({
    autoplay: true,
    autoplaySpeed: 10000,
    speed: 600,
    slidesToShow: 4,
    slidesToScroll: 1,
    pauseOnHover: false,
    draggable: false,
    prevArrow: '<button class="slick-prev"> </button>',
    nextArrow: '<button class="slick-next"></button>',
    responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                adaptiveHeight: true,
            },
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 576,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 420,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            },
        }
    ]
});