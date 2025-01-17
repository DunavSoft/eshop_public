//Start video
$('.fa-play-circle').click(function () {
    $('video')[0].play();
    $('video').attr("controls", "controls");
});

$(".video-modal .btn-close").on("click", function () {
    $('video')[0].pause();
});

$('.ss-slider').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    speed: 300,
    centerMode: false,
    fade: true,
    cssEase: 'linear',
    nextArrow: $(".nps3-next"),
    prevArrow: $(".nps3-prev"),

});


$(".calculator__value").on("click", function () {
    $("#amount").toggleClass("d-none");
});

function calPercent(val) {
    let res = (val * 15) / 100;
    return res;
}

function getSum(val) {
    let res = (val * 15) / 100;
    let sum = val - res;
    return sum;
}

function setValue() {
    let v = $(".v-here").text();
    let result = getSum(v);
    let sum = v - result;
    $(".res-here").text(result);
    $(".d-here").text(sum);
}

$(function (){
    setValue();
});


$("#amount li").on("click", function () {
    let value = $(this).data("value");
    $(".v-here").text(value);

    let result = (value * 15) / 100;
    let sum = value - result;
    $(".res-here").text(sum);
    $(".d-here").text(result);

    $("#amount").addClass("d-none");
});