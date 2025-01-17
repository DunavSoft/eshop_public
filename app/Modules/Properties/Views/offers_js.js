//Countdown logic
$('.time-end').each(function (index) {
    $(this).attr('id', 'end-time-' + index);
    changeTime(index);
});

$(".day").each(function (index) {
    $(this).attr('id', 'day-' + index);
});

$(".hour").each(function (index) {
    $(this).attr('id', 'hour-' + index);
});

$(".minutes").each(function (index) {
    $(this).attr('id', 'minutes-' + index);
});


$(".seconds").each(function (index) {
    $(this).attr('id', 'seconds-' + index);
});


function changeTime(index) {

    let target = $("#end-time-" + index).text();
    //let targetDate = new Date(target + 'T23:59:59').getTime();
    let targetDate = new Date(target).getTime();
	
    let propertyInterval = setInterval(function () {

        // Get the current date and time
        let now = new Date().getTime();

        // Calculate the time remaining until the target date and time
        let timeRemaining = targetDate - now;

        // Calculate the days, hours, minutes, and seconds remaining
        let days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        let hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        // Format the time remaining as a string
        let countdown = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';



        // Update the countdown on the HTML page
        $("#day-" + index).text(days);
        $("#hour-" + index).text(hours);
        $("#minutes-" + index).text(minutes);
        $("#seconds-" + index).text(seconds);

        if (days <= 0 && hours <= 0 && minutes <= 0 && seconds <= 0) {
            clearInterval(propertyInterval); // Stop the countdown
            $("#day-" + index).text(0).addClass("text-danger");
            $("#hour-" + index).text(0).addClass("text-danger");
            $("#minutes-" + index).text(0).addClass("text-danger");
            $("#seconds-" + index).text(0).addClass("text-danger");
        }


    }, 1000);
}