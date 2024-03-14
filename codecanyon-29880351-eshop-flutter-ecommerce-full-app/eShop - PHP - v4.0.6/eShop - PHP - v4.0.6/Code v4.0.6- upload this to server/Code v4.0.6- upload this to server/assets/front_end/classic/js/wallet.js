function flutterwave_payment() {

    var order_id = $('#order_id').val()
    var amount = $('#amount').val()
    var promo_set = $('#promo_set').val()
    var promo_code = ''
    if (promo_set == 1) {
        promo_code = $('#promocode_input').val()
    }
    var logo = $('#logo').val()
    var public_key = $('#flutterwave_public_key').val()
    var currency_code = $('#flutterwave_currency').val()
    switch (currency_code) {
        case 'KES':
            var country = 'KE'
            break
        case 'GHS':
            var country = 'GH'
            break
        case 'ZAR':
            var country = 'ZA'
            break
        case 'TZS':
            var country = 'TZ'
            break

        default:
            var country = 'NG'
            break
    }
    $.post(
        base_url + 'cart/wallet_refill', {
            [csrfName]: csrfHash,
            payment_method: 'Flutterwave',
            currency_code: currency_code,
            amount: amount,
            order_id: order_id,

        },
        function (data) {
            csrfName = data.csrfName
            csrfHash = data.csrfHash
            if (data.error == false) {
                var amount = $('#amount').val()
                var order_id = $('#order_id').val()
                var phone_number = $('#user_contact').val()
                var email = $('#user_email').val()
                var name = $('#username').val()
                var title = $('#app_name').val()
                var d = new Date()
                var ms = d.getMilliseconds()
                var number = Math.floor(1000 + Math.random() * 9000)
                var tx_ref = title + '-' + ms + '-' + number
                FlutterwaveCheckout({
                    public_key: public_key,
                    tx_ref: tx_ref,
                    amount: amount,
                    meta: {
                        order_id: order_id,
                    },
                    currency: currency_code,
                    country: country,
                    payment_options: 'card,mobilemoney,ussd',
                    customer: {
                        email: email,
                        phone_number: phone_number,
                        name: name
                    },
                    callback: function (data) {
                        // specified callback function
                        if (data.status == 'successful') {
                            $('#flutterwave_transaction_id').val(data.transaction_id)
                            $('#flutterwave_transaction_ref').val(data.tx_ref)
                            // place_order().done(function(result) {

                            setTimeout(function () {
                                location.href = base_url + 'payment/wallet_success  '
                            }, 1000)

                            // })
                        } else {
                            location.href = base_url + 'payment/cancel'
                        }
                    },
                    customizations: {
                        title: title,
                        description: 'Payment for product purchase',
                        logo: logo
                    }
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong!'
                })
            }
        },
        'json'
    )
}
var stripe1

function stripe_setup(key) {
    console.log('stripe setup')
    // A reference to Stripe.js initialized with a fake API key.
    // Sign in to see examples pre-filled with your key.
    var stripe = Stripe(key)
    // Disable the button until we have Stripe set up on the page
    var elements = stripe.elements()
    var style = {
        base: {
            color: '#32325d',
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '12px',
            '::placeholder': {
                color: '#32325d'
            }
        },
        invalid: {
            fontFamily: 'Arial, sans-serif',
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }

    var card = elements.create('card', {
        style: style
    })
    card.mount('#stripe-card-element')

    card.on('change', function (event) {
        // Disable the Pay button if there are no card details in the Element
        document.querySelector('button').disabled = event.empty
        document.querySelector('#card-error').textContent = event.error ?
            event.error.message :
            ''
    })
    return {
        stripe: stripe,
        card: card
    }
}

function stripe_payment(stripe, card, clientSecret) {
    console.log('payment')
    console.log(card)
    // Calls stripe.confirmCardPayment
    // If the card requires authentication Stripe shows a pop-up modal to
    // prompt the user to enter authentication details without leaving your page.
    stripe
        .confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
            }
        })
        .then(function (result) {
            if (result.error == true) {
                // Show error to your customer
                var errorMsg = document.querySelector('#card-error')
                errorMsg.textContent = result.error.message
                setTimeout(function () {
                    errorMsg.textContent = ''
                }, 4000)
                Toast.fire({
                    icon: 'error',
                    title: result.error.message
                })
                $('#wallet_refill').attr('disabled', false).html('Success')
            } else {
                // The payment succeeded!
                if (result.error == false) {
                    setTimeout(function () {
                        location.href = base_url + 'payment/wallet_success'
                    }, 1000)
                }

            }
        })
}

function razorpay_setup(
    key,
    amount,
    app_name,
    logo,
    razorpay_order_id,
    order_id,
    username,
    user_email,
    user_contact
) {

    var options = {

        key: key, // Enter the Key ID generated from the Dashboard
        amount: amount * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        currency: 'INR',
        name: app_name,
        description: 'Product Purchase',
        image: logo,
        order_id: razorpay_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1

        handler: function (response) {
            $('#razorpay_payment_id').val(response.razorpay_payment_id)
            $('#razorpay_signature').val(response.razorpay_signature)


            setTimeout(function () {
                location.href = base_url + 'payment/wallet_success'
            }, 3000)

        },
        prefill: {
            name: username,
            email: user_email,
            contact: user_contact
        },
        notes: {
            order_id: order_id
        },
        theme: {
            color: '#3399cc'
        },
        escape: false,
        modal: {
            ondismiss: function () {
                $('#place_order_btn').attr('disabled', false).html('Place Order')
            }
        }
    }
    var rzp = new Razorpay(options)
    return rzp
}

function instamojo_setup(instamojo_redirect_url) {

    console.log(instamojo_redirect_url);
    Instamojo.open(instamojo_redirect_url)
}
Instamojo.configure({
    handlers: {
        onSuccess: onPaymentSuccessHandler,
        onFailure: onPaymentFailureHandler
    }
});

function onPaymentFailureHandler(response) {
    alert('Payment Failure');
    if (response.status == "failure") {
        location.href = base_url + 'payment/cancel';
    }
}

function onPaymentSuccessHandler(response) {
    console.log('Payment Success Response', response);
    // $('#instamojo_payment_id').val(response.paymentId);
    if (response.status == "success") {
        setTimeout(function () {
            location.href = base_url + 'payment/wallet_success'
        }, 3000)
    } else {
        location.href = base_url + 'payment/cancel';
    }
}

function paystack_setup(key, user_email, order_amount, order_id) {
    var handler = PaystackPop.setup({
        key: key,
        email: user_email,
        amount: order_amount,
        currency: 'NGN',
        order_id: order_id,
        metadata: {
            custom_fields: [],
            order_id,

        },
        callback: function (response) {
            $('#paystack_reference').val(response.reference)
            order_id
            if (response.status == 'success') {


                setTimeout(function () {
                    location.href = base_url + 'payment/wallet_success'
                }, 3000)


            } else {
                location.href = base_url + 'payment/cancel'
            }
        },
    })
    return handler
}

function paytm_setup(
    txnToken,
    orderId,
    amount,
    app_name,
    logo,
    username,
    user_email,
    user_contact
) {

    var config = {
        root: '',
        flow: 'DEFAULT',
        merchant: {
            name: app_name,
            logo: logo,
            redirect: false
        },
        style: {
            headerBackgroundColor: '#8dd8ff',
            headerColor: '#3f3f40'
        },
        data: {
            orderId: orderId,
            token: txnToken,
            tokenType: 'TXN_TOKEN',
            amount: amount,
            userDetail: {
                mobileNumber: user_contact,
                name: username
            }
        },
        handler: {
            notifyMerchant: function (eventName, data) {
                if (eventName == 'SESSION_EXPIRED') {
                    alert('Your session has expired!!')
                    location.reload()
                }
                if (eventName == 'APP_CLOSED') {
                    $('#wallet_refill').attr('disabled', false).html('Success')
                }

            },
            transactionStatus: function (data) {
                window.Paytm.CheckoutJS.close()
                if (data.STATUS == 'TXN_SUCCESS' || data.STATUS == 'PENDING') {

                    $.ajax({
                        type: 'POST',
                        data: formdata,
                        url: base_url + 'cart/wallet_refill',
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#wallet_refill')
                                .attr('disabled', true)
                                .html('Please Wait...')
                        },
                        success: function (data) {
                            csrfName = data.csrfName
                            csrfHash = data.csrfHash
                            $('#wallet_refill').attr('disabled', false).html('Success')
                            if (data.error == false) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                })
                                setTimeout(function () {
                                    location.href = base_url + 'payment/wallet_success'
                                }, 3000)
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.message
                                })
                            }
                        }
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong please try again!'
                    })
                }
            }
        }
    }

    if (window.Paytm && window.Paytm.CheckoutJS) {

        // initialze configuration using init method
        window.Paytm.CheckoutJS.init(config)
            .then(function onSuccess() {
                // after successfully update configuration invoke checkoutjs
                window.Paytm.CheckoutJS.invoke()
            })
            .catch(function onError(error) {
                console.log('Error => ', error)
            })
    }
}

function midtrans_setup(midtrans_transaction_token, order_id) {
    // console.log(order_id)
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    window.snap.pay(midtrans_transaction_token, {

        onSuccess: function (result) {
            console.log(result)
            /* You may add your own implementation here */
            // alert("payment success!");

            if (result.transaction_status == 'capture') {
                $.post(
                    base_url + 'app/v1/api/midtrans_webhook', {
                        order_id: order_id,
                    }, )
                // setTimeout(function() {
                //     location.href = base_url + 'payment/success'
                // }, 3000)
            }

        },
        onPending: function (result) {
            /* You may add your own implementation here */
            alert('wating your payment!')

        },
        onError: function (result) {
            /* You may add your own implementation here */
            alert('payment failed!')

        },
        onClose: function () {
            /* You may add your own implementation here */

        }
    })
}

function wallet_refill() {
    let myForm = document.getElementById('wallet_form')
    var formdata = new FormData(myForm)
    formdata.append(csrfName, csrfHash)
    var latitude =
        sessionStorage.getItem('latitude') === null ?
        '' :
        sessionStorage.getItem('latitude')
    var longitude =
        sessionStorage.getItem('longitude') === null ?
        '' :
        sessionStorage.getItem('longitude')
    formdata.append('latitude', latitude)
    formdata.append('longitude', longitude)
    return $.ajax({
        type: 'POST',
        data: formdata,
        url: base_url + 'cart/wallet_refill',
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#place_order_btn').attr('disabled', true).html('Please Wait...')
        },
        success: function (data) {
            csrfName = data.csrfName
            csrfHash = data.csrfHash
            $('#place_order_btn').attr('disabled', false).html('Place Order')
            if (data.error == false) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                })
            }
        }
    })
}

var fatoorah_url = '';

function my_fatoorah_setup() {
    window.location.replace(fatoorah_url)

}
$(document).on('click', '#wallet_refill', function () {
    console.log("in  wallet");
    var order_id = $('#order_id').val()
    var amount = $('#amount').val()
    var payment_methods = $("input[name='payment_method']:checked").val()
    var public_key = $('#flutterwave_public_key').val()

    if (amount == "") {
        Toast.fire({
            icon: 'error',
            title: 'You need to add amount'
        })
    } else {
        if (payment_methods == 'Flutterwave') {
            flutterwave_payment()
        } else if (payment_methods == 'Paypal') {
            var amount = $('#amount').val()
            var order_id = $('#order_id').val()
            $('#paypal_order_id').val(order_id)
            $('#paypal_amount').val(amount)
            $('#csrf_token').val(csrfHash)
            $('#paypal_form').submit()


        } else if (payment_methods == 'Razorpay') {
            $.post(
                base_url + 'cart/wallet_refill', {
                    [csrfName]: csrfHash,
                    payment_method: 'Razorpay',
                    amount: amount,
                    order_id: order_id,
                },
                function (data) {
                    csrfName = data.csrfName
                    csrfHash = data.csrfHash
                    if (data.error == false) {
                        $('#razorpay_order_id').val(data.order_id)
                        var key = $('#razorpay_key_id').val()
                        var app_name = $('#app_name').val()
                        var logo = $('#logo').val()
                        var razorpay_order_id = $('#razorpay_order_id').val()
                        var username = $('#username').val()
                        var user_email = $('#user_email').val()
                        var user_contact = $('#user_contact').val()
                        var order_id = $('#order_id').val()
                        var rzp1 = razorpay_setup(
                            key,
                            amount,
                            app_name,
                            logo,
                            razorpay_order_id,
                            order_id,
                            username,
                            user_email,
                            user_contact
                        )
                        rzp1.open()
                        rzp1.on('payment.failed', function (response) {
                            location.href = base_url + 'payment/cancel'
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    }
                },
                'json'
            )
        } else if (payment_methods == 'Paystack') {
            var key = $('#paystack_key_id').val()
            var user_email = $('#user_email').val()
            var amount = $('#amount').val()
            var order_id = $('#order_id').val()
            $.post(
                base_url + 'cart/wallet_refill', {
                    [csrfName]: csrfHash,
                    payment_method: 'Paystack',

                },
                function (data) {
                    csrfName = data.csrfName
                    csrfHash = data.csrfHash
                    if (data.error == false) {
                        var handler = paystack_setup(key, user_email, amount, order_id)
                        handler.openIframe()
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        })
                    }
                },
                'json'
            )
        } else if (payment_methods == "instamojo") {
            $.post(
                base_url + 'cart/wallet_refill', {
                    [csrfName]: csrfHash,
                    payment_method: 'instamojo',
                    amount: amount,
                    order_id: order_id,
                },
                function (data) {
                    csrfName = data.csrfName
                    csrfHash = data.csrfHash
                    if (data.error == false) {
                        // $('#instamojo_order_id').val(data.order_id);
                        var instamojo_payment = instamojo_setup(data.redirect_url);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    }
                },
                'json'
            )
        } else if (payment_methods == 'phonepe') {
            var amount = $('#amount').val()
            var user_id = $('#user_id').val()
            var order_id = $('#order_id').val()
            $.post(
                base_url + 'payment/phonepe', {
                    [csrfName]: csrfHash,
                    amount: amount,
                    user_id: user_id,
                    type: 'wallet',
                    order_id: order_id,
                },
                function (data) {
                    console.log(data);
                    let url = (data["data"]["data"]['instrumentResponse']['redirectInfo']['url']) ? data["data"]["data"]['instrumentResponse']['redirectInfo']['url'] : ""
                    let message = (data['message']) ? data['message'] : ""
                    wallet_refill().done(function (result) {
                        console.log(result);
                        // return
                        if (url != "") {
                            window.location.replace(url);
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: message
                            })
                        }
                    })
                },
                'json'
            )
        } else if (payment_methods == 'Paytm') {
            var amount = $('#amount').val()
            var user_id = $('#user_id').val()
            var order_id = $('#order_id').val()

            $.post(
                base_url + 'payment/initiate-paytm-transaction', {
                    [csrfName]: csrfHash,
                    amount: amount,
                    user_id: user_id,
                    type: 'wallet',
                    order_id: order_id,
                },
                function (data) {
                    if (
                        typeof data.data.body.txnToken != 'undefined' &&
                        data.data.body.txnToken !== null
                    ) {
                        $('#paytm_transaction_token').val(data.data.body.txnToken)
                        $('#paytm_order_id').val(data.data.order_id)
                        var txn_token = $('#paytm_transaction_token').val()
                        var order_id = $('#order_id').val()
                        var app_name = $('#app_name').val()
                        var logo = $('#logo').val()
                        var username = $('#username').val()
                        var user_email = $('#user_email').val()
                        var user_contact = $('#user_contact').val()
                        paytm_setup(
                            txn_token,
                            order_id,
                            data.final_amount,
                            app_name,
                            logo,
                            username,
                            user_email,
                            user_contact
                        )
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong please try again later.'
                        })
                    }
                },
                'json'
            )
        } else if (payment_methods == 'Stripe') {
            var order_id = $('#order_id').val()
            var amount = $('#amount').val()
            // $('#stripe_div').slideUp()
            // if (payment_methods == 'Stripe') {
            //     stripe1 = stripe_setup($('#stripe_key_id').val())
            //     $('#stripe_div').slideDown()
            // } else {
            //     $('#stripe_div').slideUp()
            // }


            $.post(
                base_url + 'cart/wallet_refill', {
                    [csrfName]: csrfHash,
                    payment_method: 'Stripe',
                    order_id: order_id,
                    amount: amount,

                },
                function (data) {
                    $('#stripe_client_secret').val(data.client_secret)
                    $('#stripe_payment_id').val(data.id)
                    var stripe_client_secret = data.client_secret
                    stripe_payment(stripe1.stripe, stripe1.card, stripe_client_secret)
                    csrfName = data.csrfName
                    csrfHash = data.csrfHash
                },
                'json'
            )
        } else if (payment_methods == 'Midtrans') {
            var amount = $('#amount').val()
            var order_id = $('#order_id').val()
            $.post(
                base_url + 'cart/wallet_refill', {
                    [csrfName]: csrfHash,
                    payment_method: 'Midtrans',
                    amount: amount,
                    order_id: order_id,


                },
                function (data) {
                    // console.log(data)
                    csrfName = data.csrfName
                    csrfHash = data.csrfHash
                    if (data.error == false) {
                        $('#midtrans_transaction_token').val(data.token)
                        $('#midtrans_order_id').val(data.order_id)
                        var order_id = data.order_id
                        var midtrans_transaction_token = data.token
                        var midtrans_payment = midtrans_setup(midtrans_transaction_token, order_id)

                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    }
                },
                'json'
            )
        } else if (payment_methods == "my_fatoorah") {


            fatoorah_order_id = $('#my_fatoorah_order_id').val();
            // console.log($('#my_fatoorah_order_id').val());
            $('#csrf_token').val(csrfHash);
            var amount = $('#amount').val()
            var order_id = $('#order_id').val()


            $.post(base_url + "cart/wallet_refill", {
                    [csrfName]: csrfHash,
                    'payment_method': 'my_fatoorah',
                    'my_fatoorah_order_id': fatoorah_order_id,
                    amount: amount,
                    order_id: order_id,



                },

                function (data) {

                    csrfName = data.csrfName;
                    csrfHash = data.csrfHash;
                    if (data.error == false) {
                        $('#my_fatoorah_order_id').val(data.order_id);
                        fatoorah_url = data.PaymentURL;
                        var my_fatoorah_payment = my_fatoorah_setup();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                }, "json");



        }
    }
})


$("input[name='payment_method']").on('change', function (e) {
    e.preventDefault()
    var payment_method = $('input[name=payment_method]:checked').val()
    if (payment_method == 'Stripe') {
        stripe1 = stripe_setup($('#stripe_key_id').val())
        $('#stripe_div').slideDown()
    } else {
        $('#stripe_div').slideUp()
    }

})

$(document).on('click', '#withdraw_amount', function () {
    var user_id = $('#user_id').val()
    var payment_address = $('#payment_address').val()
    var amount = $('#withdrawal_amount').val()

    $.ajax({
        type: 'POST',
        data: {
            user_id: user_id,
            payment_address: payment_address,
            amount: amount,
            [csrfName]: csrfHash
        },
        dataType: 'json',
        url: base_url + 'my_account/withdraw_money',
        success: function (result) {

            csrfName = result['csrfName'];
            csrfHash = result['csrfHash'];
            if (result.error == false) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })
                setTimeout(function () {
                    location.reload()
                }, 600)


            } else {
                Toast.fire({
                    icon: 'error',
                    title: result.message
                })
            }
        }
    })

})