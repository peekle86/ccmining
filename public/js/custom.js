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

    function addErrorsMessages(messages) {
        $('.validation_messages').html('');

        $.each(messages.responseJSON.errors, function (key, value) {
            $('.validation_messages').append('<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"><strong class="font-bold">' + value[0] +'</strong></div>');
        });
    }

    function addPaymentErrorsMessages(messages) {
        $('.payment_validation_messages').html('');

        $.each(messages.responseJSON.errors, function (key, value) {
            $('.payment_validation_messages').append('<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"><strong class="font-bold">' + value[0] +'</strong></div>');
        });
    }

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

    /**
     * Підтвердження транзакції при купівлі
     */
    $(document).on('click', '.сonfirm_transaction', function (e) {
        e.preventDefault();

        $('.transaction_loader').css('display', 'block');

        let csrf = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

        var address_id = $('#address').data('address_id');
        var payment_id = $('#payment_id').val();

        $.ajax({
            type: "POST",
            url: 'transaction-verification',
            data: {
                'csrf': csrf,
                'address_id': address_id,
                'payment_id': payment_id,
            },
            success: function (response) {
                var route = response.route;
                window.location.href = route;

            }, error: function (xhr) {
                addPaymentErrorsMessages(xhr);
            }
        });

    });


});



