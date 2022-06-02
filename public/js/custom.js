$(document).ready(function () {

    /**
     * Cпособ оплаты
     * /cart
     */
    $(document).on('click', '.payment_block', function () {

        $('.payment').removeClass("payment_block_border");
        var payment = $(this).data('payment');

        console.log('some');

        $(this).addClass('payment_block_border');
        $('input[name="payment"]').val(payment);
    });

    /**
     * Відображення блоку підтвердження транзакції
     */
    $(document).on('click', '.btn_checkout_form', function (e) {
        e.preventDefault();

        var url = $(this).data('url');
        var payment = $('#payment_type');

        let csrf = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'csrf': csrf,
                'payment': payment.val(),
            },
            success: function (response) {
                var payment_html = response.payment_html;

                $('.seller-info-row').html(payment_html).promise()
                    .then(function () {
                        var fiveMinutes = 60 * 60, display = $('.future_date');
                        startTimer(fiveMinutes, display);
                    });

                $('.cart_payments_block').hide();

            }, error: function (xhr) {
                addErrorsMessages(xhr);
            }
        });

    });

    /**
     * Відхилити транзакції при купівлі
     */
    $(document).on('click', '.reject_сonfirm_transaction', function (e) {
        e.preventDefault();

        $('#payment_block').remove();
        $('.cart_payments_block').show();
    });


});



