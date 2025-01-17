//Page details
$(function () {
    $("#fastOrderSubmit").on("click", function () {
        let url = window.location.href;
        let price = $("#product-price").text();
        let name = $("#name").val();
        let phone = $("#phone").val();
        let warn = $("#warn").val();
        let gdpr = $("#gdpr").val();

        if(name !== "" && phone !== "" && warn !== "" && gdpr !== "") {
            gtag_report_conversion(url, price);
        }
    });
});


//Checkout
$(function () {
    $("#submit_order").on("click", function () {
        let url = window.location.href;
        let price = $("#total").text();

        let name = $("#name").val();
        let phone = $("#phone").val();
        let email = $("#email").val();
        let city = $("#city").val();
        let delivery_address = $("#delivery_address").val();
        let warn = $("#warn").val();
        let gdpr = $("#gdpr").val();

        // Поставяне на променливите в масив
        let variablesArray = [name, phone, email, city, delivery_address, warn, gdpr];

        let allFilled = true;

        // Ако искат фактура вземам още 2 задължителни полета и ги добавям към масива
        if($('#invoice').is(':checked')){
            let company = $("#company").val();
            let egn = $("#egn").val();
            variablesArray.push(company, egn);
        }

        // Проверка дали всички променливи са попълнени
        variablesArray.forEach(function(item) {
            if (item === "") {
                allFilled = false;
            }
        });

        // Ако всички задължителни полета са попълнени изпълнява евента
        if (allFilled) {
            gtag_report_conversion(url, price);
        }

    });
});


function gtag_report_conversion(url, price) {
    gtag('event', 'conversion', {
        'send_to': 'AW-749159828/HrQ8CIuSlpIZEJSLneUC',
        'value': price,
        'currency': 'BGN',
        'transaction_id': '',
        'event_callback': url
    });
    return false;
}