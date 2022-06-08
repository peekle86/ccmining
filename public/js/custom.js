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
            $('.validation_messages').append('<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"><strong class="font-bold">' + value[0] + '</strong></div>');
        });
    }

    function addPaymentErrorsMessages(messages) {
        $('.payment_validation_messages').html('');

        $.each(messages.responseJSON.errors, function (key, value) {
            $('.payment_validation_messages').append('<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"><strong class="font-bold">' + value[0] + '</strong></div>');
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

        var payment_id = $('#payment_id').val();
        var wallet_id = $('#wallet_id').val();

        $.ajax({
            type: "POST",
            url: 'transaction-verification',
            data: {
                'csrf': csrf,
                'wallet_id': wallet_id,
                'payment_id': payment_id,
            },
            success: function (response) {
                var route = response.route;
                if (route) {
                    window.location.href = route;
                }

            }, error: function (xhr) {
                addPaymentErrorsMessages(xhr);
            }
        });

    });

    /**
     * Copy
     * @param text
     */
    function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text;
        sampleTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
    }

    function copyInput(input)
    {
        input.css('color', 'green');
        setTimeout(function () {
            input.css('color', '#3b82f6');
        }, 2000);
    }

    $(document).on('click', '.wallet_copy', function (e) {
        var inputCopy = $('#wallet');
        var inputCopyVal = inputCopy.val();

        copyToClipboard(inputCopyVal);
        copyInput(inputCopy)

    });

    $(document).on('click', '.amount_copy', function (e) {
        var inputCopy = $('#amount');
        var inputCopyVal = inputCopy.val();

        copyToClipboard(inputCopyVal);
        copyInput(inputCopy)

    });




});



