
$(function () {
    $('.toggle-menu').click(function () {
        $(this).toggleClass('active');
        $('#menu').toggleClass('open');
    });
});

// Validirane na forma
(function () {
    'use strict'
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    let forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})();


$(function (){
    $('#searchform').fadeOut();
});

function openSearch() {
    $('#searchform').fadeIn("slow");
    document.getElementById("myOverlay").style.display = "block";
}

function closeSearch() {
    $('#searchform').fadeOut("slow");
    document.getElementById("myOverlay").style.display = "none";
}

function toggleSharingModal() {
    const $sharingModal = $('#shareModal');
    const $sharingModalEmbeddedHtml = $('#shareModalEmbeddedHtml');

    $sharingModal.modal('toggle');
    $sharingModalEmbeddedHtml.modal('toggle');
}

function setEmbeddedHtml(selectedOptionClass) {
    const campaignId = $('#shareModalEmbeddedHtml').data('campaignId');
    const iframeHeights = {
        large: '650',
        medium: '380',
        small: '100'
    };
    const embeddedHtmlUrl = window.location.origin;
    const embeddedHtml = `<iframe src="${embeddedHtmlUrl}/embedCampaign/${selectedOptionClass}/${campaignId}" width="100%" height="${iframeHeights[selectedOptionClass]}" frameborder="0" scrolling="no"></iframe>`;

    $("#sharingOptionTextarea").val(embeddedHtml)
}

$('#searchform, #search-form, #searchform1, #searchform2').on('submit', (e) => {
    e.preventDefault();

    const $searchform = $(e.target);
    const $searchInput = $searchform.find('input[name=search]');
    const keywords = $searchInput.val().replace(/\s/g, '+');
    const url = $searchform.attr('action');

    location.href = url + '/' + keywords;
});


//Слайдер
$('#slider-home').slick({
    dots: true,
    arrows: true,
    infinite: true,
    autoplay: false,
    autoplaySpeed: 3000,
    slidesToShow: 1,
    slidesToScroll: 1,
    nextArrow: $(".left-arrow-slder"),
    prevArrow: $(".right-arrow-slder"),
    responsive: [

        {
            breakpoint: 700,
            settings: {
                dots: false,
            }
        },


    ]
});




//Слайдер Manufactures
$('.slider-manufactures').slick({
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    dots: false,
    arrows: true,
    autoplaySpeed: 3000,
    nextArrow: $(".slider-m-arrow-left"),
    prevArrow: $(".slider-m-arrow-right"),
    responsive: [
        {
            breakpoint: 1300,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 700,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },


    ]

});


//Слайдер Специално за теб
$('.product-slide-special').slick({
    infinite: false,
    slidesToShow: 4,
    slidesToScroll: 4,
    autoplay: false,
    dots: true,
    autoplaySpeed: 3000,
    nextArrow: $(".right-arrow-slde3"),
    prevArrow: $(".left-arrow-slde3"),
    responsive: [
        {
            breakpoint: 1300,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 900,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: false,
            }
        },
        {
            breakpoint: 500,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
            }
        }


    ]
});




//Слайдер на продукта
$('.slider-galeria').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    infinite: false,
    asNavFor: '.slider-galeria-thumbs',
});

$('.slider-galeria-thumbs').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    asNavFor: '.slider-galeria',
    vertical: false,
    verticalSwiping: false,
    focusOnSelect: true,
    infinite: false,
    responsive: [
        {
            breakpoint: 900,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 500,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        }
    ]
});



//Back to top
$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#toTopBtn').fadeIn(500);
        } else {
            $('#toTopBtn').fadeOut(500);
        }
    });

    $('#toTopBtn').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});
//END Back to top


//Kod za akordeonno menu
$('.list-hidden').addClass('d-block');

$('.p-btn').on('click', function () {

    $(this).next('div').toggleClass('d-none');
    let x = $(this).find(".fa-dynamic");
    if (x.hasClass('fa-plus')) {
        x.removeClass('fa-plus').addClass('fa-minus');
    } else {
        x.removeClass('fa-minus').addClass('fa-plus');
    }
});


$(function () {
    if ($(window).width() < 992) {
        $('.filter').addClass('collapse');
    } else {
        $('.filter').removeClass('collapse');
    }

    $(window).resize(function () {
        if ($(window).width() < 992) {
            $('.filter').addClass('collapse');
        } else {
            $('.filter').removeClass('collapse');
        }
    });
});


//Kod za dropdown filter
/*
$(function () {


    $('.custom-selects').on("click", function () {
        var chevron = $(this).parent().find(".chevron-plus");

        // Проверяваме текущото текстово съдържание и превключваме между "+" и "-"
        if (chevron.text() === "+") {
            chevron.text("-");
        } else {
            chevron.text("+");
        }

        // Останалата част от вашия код...
        $(document).click(function () {
            let showClass = $(this).find(".select2").hasClass("select2-container--open");
            if (!showClass) {
                $(".chevron").removeClass("flip");
            }
        });
    });

    $('.select-selected').on("click", function () {
        $(this).parent().find(".chevron").toggleClass("flip");
    });

    $(".btn-filter").on("click", function () {
        $(this).children(".chevrons").toggleClass("flip");
    });
});
*/
/*
$(function () {
    $('.custom-selects').on("click", function () {
        var chevron = $(this).find(".chevron-plus");

        // Toggle between "+" and "-"
        if (chevron.text() === "+") {
            chevron.text("-");
        } else {
            chevron.text("+");
        }

        // Toggle the visibility of the checkbox container
        $(this).find(".checkbox-container").toggle();

        $(document).click(function () {
            $(".chevron-plus").text("+"); // Reset the chevron when clicking outside
            $(".checkbox-container").hide(); // Hide all checkbox containers when clicking outside
        });
    });

    $('.select-selected').on("click", function () {
        $(this).parent().find(".chevron").toggleClass("flip");
    });

    $(".btn-filter").on("click", function () {
        $(this).children(".chevrons").toggleClass("flip");
    });
});
*/


//Produktite na 1 red
$("#oneRow").on("click", function (){
    $(".row-cat-list .col-6").each(function (){
        $(this).addClass("col-12");
    });
});

//Produktite na 2 reda
$("#twoRow").on("click", function (){
    $(".row-cat-list .col-6").each(function (){
        $(this).removeClass("col-12");
    });
});

//Slide menu - sizes
$(function () {
    const openMenuLink = $('#openMenu');
    const slideMenu = $('#slideMenu');
    const closeMenuButton = $('#closeMenu');
    const overlay = $('#overlay');

    function openSlideMenu() {
        slideMenu.animate({ right: '0' }, '100');
        overlay.fadeIn('100');
    }

    function closeSlideMenu() {
        slideMenu.animate({ right: '-300px' }, '100');
        overlay.fadeOut('100');
    }

    openMenuLink.on('click', openSlideMenu);
    closeMenuButton.on('click', closeSlideMenu);
});


$(function() {
    $(".read-more-btn").click(function() {
        $(".cat-description").toggleClass("expanded");
        $(this).text($(".cat-description").hasClass("expanded") ? "Виж по-малко" : "Виж повече");
    });
});

//Скриване на филтъра за мобилната версия
$(".btn-filter").on("click", function (){
    $("#collapseFilter").toggleClass("showFilter");
    $(".filter").toggleClass("collapse");
});

$(function (){
    $(".page-details img").addClass("img-fluid");
});

