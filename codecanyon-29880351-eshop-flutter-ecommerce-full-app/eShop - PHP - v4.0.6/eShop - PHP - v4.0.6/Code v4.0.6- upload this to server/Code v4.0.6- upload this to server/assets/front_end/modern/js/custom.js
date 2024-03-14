'use strict'
var base_url = $('#baseUrl').val();
var currency = $('#currency').val();
var quickViewgalleryTop
var is_rtl = $('#body').data('is-rtl')
var mode = is_rtl == 1 ? 'right' : 'left'
const is_loggedin = $('#is_loggedin').val()
var custom_url = location.href

const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast'
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
})


function queryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    }
}

function transaction_query_params(p) {
    return {
        transaction_type: 'transaction',
        user_id: $('#transaction_user_id').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    }
}

function customer_wallet_query_params(p) {
    return {
        transaction_type: 'wallet',
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    }
}

function customer_withdrawal_query_params(p) {
    return {
        payment_type: 'customer',
        limit: p.limit,
        offset: p.offset,
        sort: p.sort,
        order: p.order,
        search: p.search
    }
}

$(document).ready(() => {
    $('.add-to-fav-btn').on('click', function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var product_id = $(this).data('product-id')
        var fav_btn = $(this)
        formdata.append(csrfName, csrfHash)
        formdata.append('product_id', product_id)
        $.ajax({
            type: 'POST',
            url: base_url + 'my-account/manage-favorites',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == true) {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                } else {
                    if (fav_btn.find("ion-icon").attr("name") == "heart") {
                        fav_btn.find("ion-icon").attr("name", "heart-outline").removeClass("heart text-danger").addClass("heart-outline text-dark")
                    } else {
                        fav_btn.find("ion-icon").attr("name", "heart").removeClass("heart-outline text-dark").addClass("heart text-danger")
                    }
                    $('.wishlist-product-remove').on("click", function () {
                        var productId = $(this).closest(".fav-product").data("product-id");
                    })
                }
            }
        })
    })

    $('.wishlist-product-remove').on("click", function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var product_id = $(this).closest(".fav-product").data("product-id");
        var fav_btn = $(this)
        formdata.append(csrfName, csrfHash)
        formdata.append('product_id', product_id)
        $.ajax({
            type: 'POST',
            url: base_url + 'my-account/manage-favorites',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                fav_btn.html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == true) {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                } else {
                    if (result) {
                        fav_btn.closest(".fav-product").fadeOut(300);
                    } else {
                        console.log(result.message);
                    }
                }
            }
        });
    });

    (function () {
        function logElementEvent(eventName, element) {}

        var callback_enter = function (element) {}
        var callback_exit = function (element) {}
        var callback_loading = function (element) {}
        var callback_loaded = function (element) {}
        var callback_error = function (element) {
            'https://via.placeholder.com/440x560/?text=Error+Placeholder'
        }
        var callback_finish = function () {}
        var callback_cancel = function (element) {}

        var ll = new LazyLoad({
            threshold: 0,
            // Assign the callbacks defined above
            callback_enter: callback_enter,
            callback_exit: callback_exit,
            callback_cancel: callback_cancel,
            callback_loading: callback_loading,
            callback_loaded: callback_loaded,
            callback_error: callback_error,
            callback_finish: callback_finish
        })
    })();

    $('.wishlist-bulk-remove').on("click", function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var product_id = $(this).closest(".fav-product").data("product-id");
        var fav_btn = $(this)
        formdata.append(csrfName, csrfHash)
        formdata.append('product_id', product_id)
        $.ajax({
            type: 'POST',
            url: base_url + 'my-account/manage-favorites',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            // beforeSend: function () {
            //     fav_btn.html('<div class="spinner-border" role="status">' +
            //         '<span class="visually-hidden">Loading...</span>' +
            //         '</div>').attr('disabled', true);
            // },
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == true) {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                } else {
                    if (result) {
                        fav_btn.$('.checkbox-clicked:checked').closest(".fav-product").data("product-id").hide()
                    } else {
                        console.log(result.message);
                    }
                }
            }
        });
    });

    // shuffle
    // $('.shuffle-added').hide()
    // $('.shuffle-box').on("click", function () {
    //     $(this).find('.shuffle-added').toggle();
    //     $(this).find('.shuffle').toggle();
    // })

    $('#validate-zipcode-form').on('submit', function (e) {
        e.preventDefault()
        var formdata = new FormData(this)
        formdata.append(csrfName, csrfHash)

        $.ajax({
            type: 'POST',
            url: base_url + 'products/check_zipcode',
            data: formdata,
            beforeSend: function () {
                $('#validate_zipcode').html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result) {
                csrfHash = result.csrfHash
                $('#validate_zipcode').html('Check Availability').attr('disabled', false)
                if (result.error == false) {
                    $('#add_cart').removeAttr('disabled')
                    $('#error_box').html(result.message)
                } else {
                    $('#add_cart').attr('disabled', 'true')
                    $('#error_box').html(result.message)
                }
            }
        })
    })

    $('#load-user-ratings').on('click', function (e) {
        e.preventDefault()
        var limit = $(this).attr('data-limit')
        var offset = $(this).attr('data-offset')
        var product_id = $(this).attr('data-product')
        var btn_html = $(this).html()
        var btn = $(this)
        var html = ''
        $.ajax({
            type: 'GET',
            data: {
                limit: limit,
                offset: offset,
                product_id: product_id
            },
            url: base_url + 'products/get-rating',
            dataType: 'json',
            beforeSend: function () {
                $(this).html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {
                $(this).html(btn_html).attr('disabled', false)
                if (result.error == false) {
                    $.each(result.data.product_rating, function (i, e) {
                        html +=
                            '<div class="col-md-6">' +
                            '<div class="comment-text">' +
                            '<div class="d-flex justify-content-between mb-1">' +
                            '<p class="comment-title">' +
                            e.user_name +
                            ' </p><p class="comment-time">' +
                            e.data_added +
                            '</p></div>' +
                            '<div class="d-flex justify-content-between mb-1">' +
                            '<input type="text" name="input-3-ltr-star-md" class="kv-ltr-theme-svg-star kv-fa rating-loading" value="' +
                            e.rating +
                            '" data-size="xs" dir="ltr" readonly>' +
                            '</div>' +
                            '<div class="discription"><p>' +
                            e.comment +
                            '</p></div><div class="comment-image"><div class="row">' +
                            $.each(e.images, function (j, image) {
                                html +=
                                    '<div class="col-3">' +
                                    '<a href="' +
                                    image +
                                    '" data-lightbox="review-images">' +
                                    '<img src="' +
                                    image +
                                    '" width="120px" height="120px" alt="' +
                                    image +
                                    '"></a></div>'
                            })

                        html += '</div>' + '</div>' + '</div>' + '</div>'
                    })
                    offset += limit
                    $('#review-list').append(html)
                    $('.kv-fa').rating('create', {
                        filledStar: '<i class="fas fa-star"></i>',
                        emptyStar: '<i class="far fa-star"></i>',
                        size: 'xs',
                        showCaption: false,
                        showClear: false
                    })
                    btn.attr('data-offset', offset)
                    $('.load-more-container').hide()
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
            }
        })
    })

    $('#product-rating-form').on('submit', function (e) {
        e.preventDefault()
        var submit_btn_html = $('#rating-submit-btn').html()
        var formdata = new FormData(this)
        formdata.append(csrfName, csrfHash)
        $.ajax({
            type: 'POST',
            data: formdata,
            url: $(this).attr('action'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#rating-submit-btn').html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                    $('#product-rating-form')[0].reset()
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }

                $('#rating-submit-btn').html(submit_btn_html).attr('disabled', false)
            }
        })
    })

    $('#delete_rating').on('click', function (e) {
        e.preventDefault()
        if (confirm('Are you sure want to Delete Rating ?')) {
            var rating_id = $(this).data('rating-id')
            $.ajax({
                type: 'POST',
                data: {
                    [csrfName]: csrfHash,
                    rating_id: rating_id
                },
                url: $(this).attr('href'),
                dataType: 'json',
                success: function (result) {
                    csrfName = result['csrfName']
                    csrfHash = result['csrfHash']
                    if (result.error == false) {
                        Toast.fire({
                            icon: 'success',
                            title: result.message
                        })
                        $('#delete_rating').parent().parent().parent().remove()
                        $('#no_ratings').text(result.data.rating[0].no_of_rating)
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: result.message
                        })
                    }
                }
            })
        }
    })

    $(document).ready(function () {
        if (localStorage.getItem('compare')) {
            var compare = localStorage.getItem('compare').length
            compare = compare !== null ? JSON.parse(compare) : null
            if (compare) {
                display_compare()
            }
        }
    })

    $(document).on('click', '.compare', function (e) {
        e.preventDefault()
        var product_id = $(this).attr('data-product-id')
        var product_variant_id = $(this).attr('data-product-variant-id')
        var compare_item = {
            product_id: product_id.trim(),
            product_variant_id: product_variant_id.trim()
        }
        var compare = localStorage.getItem('compare')
        Toast.fire({
            icon: 'success',
            title: 'product compare'
        })
        compare = compare !== null ? JSON.parse(compare) : null
        if (compare !== null && compare !== undefined) {
            if (compare.find(item => item.product_id === product_id)) {
                Toast.fire({
                    icon: 'error',
                    title: 'This item is already present in your compare'
                })
                return
            }
            compare.push(compare_item)
        } else {
            compare = [compare_item]
        }
        localStorage.setItem('compare', JSON.stringify(compare))
        var compare_count = compare.length ? compare.length : ''
        $('#compare_count').text(compare_count)
        if (compare !== null && compare_count <= 1) {
            Toast.fire({
                icon: 'error',
                title: 'Please select 1 more item compare'
            })
            return false
        }
    })

    function shortDescriptionWordLimit(string, length = 32, dots = "...") {
        return (string.length > length) ? string.substring(0, length - dots.length) + dots : string;
    }

    function display_compare() {
        var compare = localStorage.getItem('compare')
        compare = localStorage.getItem('compare') !== null ? compare : null
        $.ajax({
            type: 'POST',
            url: base_url + 'compare/add_to_compare',
            data: {
                product_id: compare,
                product_variant_id: compare,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                var compare_count = JSON.parse(compare).length ? JSON.parse(compare).length : 0
                $('#compare_count').text(result.data.total)
                var comp = ''
                if (result.error == false) {
                    if (compare !== null && compare_count > 0) {
                        comp +=
                            ' <table class="compare-table"><tbody><tr>' +
                            '<th class="compare-field"></th>'
                        $.each(result.data.product, function (i, e) {
                            var variant_price =
                                e.variants[0]['special_price'] > 0 &&
                                e.variants[0]['special_price'] != '' ?
                                e.variants[0]['special_price'] :
                                e.variants[0]['price']
                            var data_min = e.minimum_order_quantity ?
                                e.minimum_order_quantity :
                                1
                            var data_step =
                                e.minimum_order_quantity && e.quantity_step_size ?
                                e.quantity_step_size :
                                1
                            var data_max = e.total_allowed_quantity ?
                                e.total_allowed_quantity :
                                1
                            comp +=
                                '<td class="compare-value">' +
                                '<div class="wishlist-product-actions d-flex mb-1">' +
                                '<div class="wishlist-product-remove">' +
                                '<a class="align-middle gray-700 gray-500-hover remove-compare-item pointer" data-product-id="' +
                                e.id +
                                '"><ion-icon name="close-outline" class="vertical-align-middle"></ion-icon>remove' +
                                '</a></div></div>' +
                                '<div class="card product-card p-2 bg-light shadow-none text-start">' +
                                '<div class="compare-product-img">' +
                                '<img class="pic-1" src="' +
                                e.image +
                                '"></div><div class="card-body">' +
                                '<h4 class="card-title">' +
                                shortDescriptionWordLimit(e.name) +
                                ' </h4><div class="d-flex flex-column"><div itemscope itemtype="https://schema.org/Product">'
                            if (e.rating != '') {
                                comp +=
                                    '<div class="col-md-12 mb-1 product-rating-small" dir="ltr" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"><meta itemprop="ratingValue" content="' +
                                    e.rating +
                                    '" /><input type="text" class="kv-fa rating-loading" value="' +
                                    e.rating +
                                    '" data-size="sm" title="" readonly></div>'
                            } else {
                                comp +=
                                    '<div class="col-md-12 mb-1 product-rating-small" dir="ltr"><input type="text" class="kv-fa rating-loading" value="' +
                                    e.rating +
                                    '" data-size="sm" title="" readonly></div>'
                            }

                            comp += '</div></div>'
                            comp +=
                                '<h4 class="card-price">' +
                                currency +
                                ' ' +
                                (e.type == 'simple_product' ?
                                    e.variants[0]['price'] :
                                    e.min_max_price.max_special_price +
                                    ' - ' +
                                    e.min_max_price.max_price) +
                                '</h4></div>'
                            if (e.type == 'simple_product') {
                                var variant_id = e.variants[0]['id']
                                var modal = ''
                            } else {
                                var variant_id = ''
                                var modal = '#quick-view'
                            }
                            comp +=
                                '<a href="products/details/' +
                                e.slug +
                                '" class="btn btn-primary" data-product-id="' +
                                '><span class="add-in-cart">select option</span></a>' +
                                '</div></div></a></td>'
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">variants </th>'
                        $.each(result.data.product, function (i, e) {
                            var attribute_name = e.variants[0]['attr_name'].split(',')
                            var attribute_values = e.variants[0]['variant_values'].split(',')
                            if (e.type == 'variable_product') {
                                comp +=
                                    '<td class="compare-value" data-title="variants">'
                                for (var i = 0; i < attribute_name.length; i++) {
                                    if (attribute_name[i] !== attribute_values[i]) {
                                        comp +=
                                            attribute_name[i] + ' : ' + attribute_values[i] + '<br>'
                                    }
                                }
                                comp += '</td>'
                            } else {
                                comp +=
                                    '<td class="compare-value" data-title="variants">-</td>'
                            }
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">Availability </th>'
                        $.each(result.data.product, function (i, e) {
                            comp +=
                                '<td class="compare-value" data-title="Availability">' +
                                (e.availability == '0' ?
                                    (e.availability = 'Out of Stock') :
                                    (e.availability = 'In Stock')) +
                                '</td>'
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">Made In </th>'
                        $.each(result.data.product, function (i, e) {
                            comp +=
                                '<td class="compare-value" data-title="made in">' +
                                (e.made_in ? e.made_in : '-') +
                                '</td>'
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">Warranty</th>'
                        $.each(result.data.product, function (i, e) {
                            comp +=
                                '<td class="compare-value" data-title="warranty period">' +
                                (e.warranty_period ? e.warranty_period : '-') +
                                '</td>'
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">Gurantee</th>'
                        $.each(result.data.product, function (i, e) {
                            comp +=
                                '<td class="compare-value" data-title="warranty period">' +
                                (e.guarantee_period ? e.guarantee_period : '-') +
                                '</td>'
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">Returnable</th>'
                        $.each(result.data.product, function (i, e) {
                            comp +=
                                '<td class="compare-value" data-title="Returnable">' +
                                (e.is_returnable == '1' ?
                                    (e.is_returnable = 'Yes') :
                                    (e.is_returnable = 'No')) +
                                '</td>'
                        })
                        comp += '</tr>'
                        comp +=
                            '<tr>' +
                            '<th class="compare-field">Cancelable</th>'
                        $.each(result.data.product, function (i, e) {
                            comp +=
                                '<td class="compare-value" data-title="cancelable">' +
                                (e.is_cancelable == '1' ?
                                    (e.is_cancelable = 'Yes') :
                                    (e.is_cancelable = 'No')) +
                                '</td>'
                        })
                        comp += '</tr>'
                        comp += '</tbody>' + '</table>'
                    } else {
                        comp +=
                            '<div class="text-center">' +
                            '<h2 class="fw-semibold">Compare list is empty.</h2>' +
                            '<p class="mb-2 text-secondary">No products added in the compare list. You must add some products to compare them.You will find a lot of interesting products on our "Shop" page.</p>' +
                            '<div class="text-center mt-2"><a class="btn btn-primary" href="' +
                            base_url +
                            'products">return to shop</a></div></div>'
                    }
                    $('#compare-items').html(comp)
                    $('.kv-fa').rating({
                        theme: 'krajee-fa',
                        filledStar: '<i class="fas fa-star"></i>',
                        emptyStar: '<i class="far fa-star"></i>',
                        showClear: false,
                        showCaption: false,
                        size: 'md'
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
            }
        })
    }

    //Remove from compare item.
    $(document).on('click', '.remove-compare-item', function (e) {
        e.preventDefault()
        var product_id = $(this).attr('data-product-id')
        if (confirm('Are you sure want to remove this?')) {
            var compare_count = $('#compare_count').text();
            compare_count--;

            if (compare_count < 1) {
                // Check if the comparison is empty before showing the message
                var compare = localStorage.getItem('compare');
                var html = ""
                compare = compare !== null ? JSON.parse(compare) : null;

                if (!compare || compare.length === 1) {
                    html +=
                        '<div class="text-center ">' +
                        '<h2 class="fw-semibold">Compare list is empty.</h2>' +
                        '<p class="mb-2 text-secondary">No products added in the compare list. You must add some products to compare them.You will find a lot of interesting products on our "Shop" page.</p>' +
                        '<div class="text-center mt-2"><a class="btn btn-primary" href="' +
                        base_url +
                        '/products' +
                        '">return to shop</a></div>' +
                        '</div>'
                    $('#comparison_empty_msg').html(html)
                }
            }

            $('#compare_count').text(compare_count);
            $(this).parent().parent().parent().parent().parent().remove();

            var compare = localStorage.getItem('compare')
            compare = compare !== null ? JSON.parse(compare) : null
            if (compare) {
                var new_compare = compare.filter(function (item) {
                    return item.product_id != product_id
                })
                localStorage.setItem('compare', JSON.stringify(new_compare))
                display_compare()
            }
        }
    })

    // password show and hide
    $('.password-hide').hide()
    const passwordSections = document.querySelectorAll('.password-insert');

    // Loop through each password section
    passwordSections.forEach(section => {
        const passwordInput = section.querySelector('input[type="password"]');
        const passwordShowIcon = section.querySelector('.password-show');
        const passwordHideIcon = section.querySelector('.password-hide');

        // Add click event listener to show password icon
        passwordShowIcon.addEventListener('click', () => {
            passwordInput.type = 'text';
            passwordShowIcon.style.display = 'none';
            passwordHideIcon.style.display = 'inline-block';
        });

        // Add click event listener to hide password icon
        passwordHideIcon.addEventListener('click', () => {
            passwordInput.type = 'password';
            passwordHideIcon.style.display = 'none';
            passwordShowIcon.style.display = 'inline-block';
        });
    });

    // login register section toggle
    $('.login-section').hide();
    $('.register-text').hide();
    $('.login-btn').on("click", () => {
        toggleSections('.registration-section', '.login-section');
        toogleText('.login-text', '.register-text')
    });

    $('.register-btn').on("click", () => {
        toggleSections('.login-section', '.registration-section');
        toogleText('.register-text', '.login-text')
    });

    function toggleSections(hideSection, showSection) {
        $(hideSection).hide();
        $(showSection).fadeIn(400);
    }

    function toogleText(hideText, showText) {
        $(hideText).hide();
        $(showText).show();
    }

    $('.checkbox-clicked').on("click", () => {
        if ($('.checkbox-clicked').is(':checked')) {
            $('.wishlist-bulk-action').addClass('wishlist-visible');
            $('.wishlist-btn').addClass('wishlist-btn-visible');
        } else {
            $('.wishlist-bulk-action').removeClass('wishlist-visible');
            $('.wishlist-btn').removeClass('wishlist-btn-visible');
        }
    })

    $('.wishlist-deselectall-action').hide()
    $('.wishlist-selectall-action').on("click", () => {
        $('.checkbox-clicked').prop('checked', true);
        $('.wishlist-deselectall-action').show()
        $('.wishlist-selectall-action').hide()
    })
    $('.wishlist-deselectall-action').on("click", () => {
        $('.checkbox-clicked').prop('checked', false);
        $('.wishlist-bulk-action').removeClass('wishlist-visible');
        $('.wishlist-btn').removeClass('wishlist-btn-visible');
        $('.wishlist-deselectall-action').hide()
        $('.wishlist-selectall-action').show()
    })

    // add address code
    $("#add-address-form").validate({
        rules: {
            mobile: {
                required: true,
                number: true,
                maxlength: 16,
            },
            alternate_mobile: {
                number: true,
                minlength: 10,
                maxlength: 10,
            },
            name: {
                required: true
            },
            address: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            city_id: {
                required: true
            },
            area_id: {
                required: true
            }
        },

        submitHandler: function (form) {
            var formdata = new FormData(form);
            formdata.append(csrfName, csrfHash);

            $.ajax({
                type: 'POST',
                data: formdata,
                url: $(form).attr('action'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#save-address-submit-btn').val('Please Wait...');
                },
                success: function (result) {
                    csrfName = result.csrfName;
                    csrfHash = result.csrfHash;
                    if (result.error == false) {
                        $('#save-address-result')
                            .html("<div class='alert alert-success'>" + result.message + '</div>')
                            .delay(1500)
                            .fadeOut();
                        $(form)[0].reset();
                        $('#address_list_table').bootstrapTable('refresh');
                    } else {
                        $('#save-address-result')
                            .html("<div class='alert alert-danger'>" + result.message + '</div>')
                            .delay(1500)
                            .fadeOut();
                    }
                    $('#save-address-submit-btn').val('Save');
                }
            });
        }
    });

    $("#send_forgot_password_otp_form").validate({
        rules: {
            mobile_number: {
                required: true,
                number: true,
                maxlength: 16,
            }
        }
    })
    $("#edit-address-form").validate({
        rules: {
            mobile: {
                required: true,
                number: true,
                maxlength: 16,
            }
        }
    })

    $("#login_form").validate({
        rules: {
            identity: {
                required: true,
                number: true,
                maxlength: 16,
            }
        }
    })

    $("#verify-otp-form").validate({
        rules: {
            otp: {
                required: true,
                number: true,
                maxlength: 16,
            }
        }
    })

    // $("#edit_city").select2({
    //     ajax: {
    //         url: base_url + 'my-account/get_cities',
    //         type: "GET",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 search: params.term, // search term
    //             };
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     },

    //     minimumInputLength: 1,
    //     theme: 'bootstrap4',
    //     placeholder: 'Search for cities',
    // })
    $('#edit_city').on('change', function (e, pincode) {
        e.preventDefault()
        var city_id = $(this).val();
        var value = $(this).val()
        if (value == 0 || value == '') {
            $('.edit_area').addClass('d-none')
            $('#edit_area').val('')
            // $('.edit_city').addClass('d-none')
            $('.edit_pincode').addClass('d-none')
            $('.other_city').removeClass('d-none')
            $('.other_areas').removeClass('d-none')
            $('.other_pincode').removeClass('d-none')
        } else {
            $('.edit_area').removeClass('d-none')
            $('.edit_pincode').removeClass('d-none')
            $('.edit_city').removeClass('d-none')
            $('.other_city').addClass('d-none')
            $('.other_areas').addClass('d-none')
            $('.other_pincode').addClass('d-none')

            $.ajax({
                type: 'POST',
                data: {
                    'city_id': $(this).val(),
                    [csrfName]: csrfHash,
                },
                url: base_url + 'my-account/get-zipcode',
                dataType: 'json',
                success: function (result) {
                    csrfName = result.csrfName;
                    csrfHash = result.csrfHash;
                    if (result.error == false) {
                        var html = '';
                        $.each(result.data, function (i, e) {
                            var is_selected = (e.zipcode == pincode) ? "selected" : "";
                            html += '<option value="0">Other</option>';
                            html += '<option value=' + e.zipcode + ' ' + is_selected + '>' + e.zipcode + '</option>';
                        });
                        $('#edit_pincode').html(html);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: result.message
                        });
                        $('#edit_pincode').html('');
                    }
                }
            })
        }
    });


    // $("#city").select2({
    //     ajax: {
    //         url: base_url + 'my-account/get_cities',
    //         type: "GET",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 search: params.term, // search term
    //             };
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     },

    //     minimumInputLength: 1,
    //     theme: 'bootstrap4',
    //     placeholder: 'Search for cities',
    //     // Set the predefined options as selected

    // }),

    $('#city').on('change', function (e) {
        e.preventDefault();
        var value = $(this).val()
        if (value == 0 || value == -1) {
            $('.city_name').removeClass('d-none')
            $('.area_name').removeClass('d-none')
            $('.pincode_name').removeClass('d-none')
            $('.area').addClass('d-none')
            $('.pincode').addClass('d-none')
        } else {
            $('#edit_pincode').empty()
            $('.city').trigger('change')
            $('.city').removeClass('d-none')
            $('.area').removeClass('d-none')
            $('.pincode').removeClass('d-none')
            $('.city_name').addClass('d-none')
            $('.area_name').addClass('d-none')
            $('.pincode_name').addClass('d-none')
            $.ajax({
                type: 'POST',
                data: {
                    'city_id': $(this).val(),
                    [csrfName]: csrfHash,
                },
                url: base_url + 'my-account/get-zipcode',
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    csrfName = result.csrfName;
                    csrfHash = result.csrfHash;
                    if (result.error == false) {
                        var html = '';
                        html += '<option value="">--Select Zipcode--</option>';
                        html += '<option value="0">Other</option>';
                        $.each(result.data, function (i, e) {

                            html += '<option value=' + e.zipcode + '>' + e.zipcode + '</option>';

                        });

                        $('#pincode').html(html);

                    } else {
                        var html = '';
                        html += '<option value="">--Select Zipcode--</option>';
                        html += '<option value="0">Other</option>';

                        $('#pincode').html(html);
                    }

                }

            })
        }

    })
    // $('#area').on('change', function (e) {
    //     e.preventDefault()
    //     $.ajax({
    //         type: 'POST',
    //         data: {
    //             area_id: $(this).val(),
    //             [csrfName]: csrfHash
    //         },
    //         url: base_url + 'my-account/get-zipcode',
    //         dataType: 'json',
    //         success: function (result) {
    //             csrfName = result.csrfName
    //             csrfHash = result.csrfHash
    //             if (result.error == false) {
    //                 $('#pincode').val(result.data[0].zipcode)
    //             } else {
    //                 Toast.fire({
    //                     icon: 'error',
    //                     title: result.message
    //                 })
    //             }
    //         }
    //     })
    // })

    $('#pincode').on('change', function (e) {
        e.preventDefault();
        var value = $(this).val()
        if (value == 0 || value == -1) {
            $('.pincode_name').removeClass('d-none')
        } else {
            $('.pincode_name').addClass('d-none')
        }
    });
    $('#edit_pincode').on('change', function (e) {
        e.preventDefault();
        var value = $(this).val()
        if (value == 0 || value == -1) {
            $('.other_pincode').removeClass('d-none')
        } else {
            $('.other_pincode').addClass('d-none')
        }
    });

    $('#edit-address-form').on('submit', function (e) {
        e.preventDefault()
        var formdata = new FormData(this)
        formdata.append(csrfName, csrfHash)
        $.ajax({
            type: 'POST',
            data: formdata,
            url: $(this).attr('action'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#edit-address-submit-btn').val('Please Wait...')
            },
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    $('#edit-address-result')
                        .html("<div class='alert alert-success'>" + result.message + '</div>')
                        .delay(1500)
                        .fadeOut()
                    $('#edit-address-form')[0].reset()
                    $('#address_list_table').bootstrapTable('refresh')
                    setTimeout(function () {
                        $('#address-modal').modal('hide')
                    }, 2000)
                } else {
                    $('#edit-address-result')
                        .html("<div class='alert alert-danger'>" + result.message + '</div>')
                        .delay(1500)
                        .fadeOut()
                }
                $('#edit-address-submit-btn').val('Save')
            }
        })
    })
    $(document).on('click', '.delete-address', function (e) {
        e.preventDefault()
        if (confirm('Are you sure ? You want to delete this address?')) {
            $.ajax({
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    [csrfName]: csrfHash
                },
                url: base_url + 'my-account/delete-address',
                dataType: 'json',
                success: function (result) {
                    csrfName = result.csrfName
                    csrfHash = result.csrfHash
                    if (result.error == false) {
                        $('#address_list_table').bootstrapTable('refresh')
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: result.message
                        })
                    }
                }
            })
        }
    })

    $(document).on('click', '.default-address', function (e) {
        e.preventDefault()
        if (confirm('Are you sure ? You want to set this address as default?')) {
            $.ajax({
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    [csrfName]: csrfHash
                },
                url: base_url + 'my-account/set-default-address',
                dataType: 'json',
                success: function (result) {
                    csrfName = result.csrfName
                    csrfHash = result.csrfHash
                    if (result.error == false) {
                        $('#address_list_table').bootstrapTable('refresh')
                        Toast.fire({
                            icon: 'success',
                            title: result.message
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: result.message
                        })
                    }
                }
            })
        }
    })

    // swipers
    var swiper = new Swiper('.mySwiper-thumb', {
        spaceBetween: 10,
        direction: 'vertical',
        mousewheel: true,
        slidesPerView: 4,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper('.mySwiper-preview', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: swiper,
        },
    });
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
    });
    var swiper2 = new Swiper(".swiperForCategories", {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            991: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
            1440: {
                slidesPerView: 6,
                spaceBetween: 10,
            },
        },
    });
    var swiper3 = new Swiper(".mySwiper3", {
        slidesPerView: 1,
        spaceBetween: 10,
        lazyLoading: true,
        lazyLoadingInPrevNextAmount: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            1440: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
        },
    });
    var swiper4 = new Swiper(".mySwiper4", {
        slidesPerView: 1,
        spaceBetween: 10,
        lazyLoading: true,
        lazyLoadingInPrevNextAmount: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
        },
    });
    var swiper5 = new Swiper(".mySwiper5", {
        slidesPerView: 1,
        spaceBetween: 10,
        lazyLoading: true,
        lazyLoadingInPrevNextAmount: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1440: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
        },
    });

    var swiper6 = new Swiper(".mySwiper6", {
        slidesPerView: 1,
        spaceBetween: 10,
        lazyLoading: true,
        lazyLoadingInPrevNextAmount: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
        },
    });

    var swiper_quickview = new Swiper(".mySwiper-quickview", {
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        }
    });

    var swiperFilterSection = new Swiper(".mySwiper-filtersection", {
        spaceBetween: 10,
        freeMode: true,
        breakpoints: {
            320: {
                slidesPerView: 3,
            },
            640: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1440: {
                slidesPerView: 4,
            },
        },
    });

    var swiper = new Swiper(".mySwiper-productview", {
        direction: "vertical",
        slidesPerView: 5,
        spaceBetween: 0,
        mousewheel: true,
    });


    // This button will increment the value
    // $('[data-quantity="plus"]').on("click", function (e) {
    //     e.preventDefault();
    //     var input = $(this).closest('.input-group').find('input[name="qty"]');
    //     var currentValue = parseInt(input.val());
    //     input.val(currentValue + 1);
    // });
    // // This button will decrement the value till 1
    // $('[data-quantity="minus"]').on("click", function (e) {
    //     e.preventDefault();
    //     var input = $(this).closest('.input-group').find('input[name="qty"]');
    //     var currentValue = parseInt(input.val());
    //     if (currentValue > 1) {
    //         input.val(currentValue - 1);
    //     }
    // });


    //Hide and show
    $(".expand").hide();
    $(".show-less").hide();
    $(".show-btn").on("click", function () {
        $(".expand").show();
        $(".show-more").hide();
        $(".show-less").show();
    })
    $(".hide-btn").on("click", function () {
        $(".expand").hide();
        $(".show-less").hide();
        $(".show-more").show();
    })



    $('.get_e_time').each((val, element) => {
        get_flash_sale_timer(element)
    })

    function get_flash_sale_timer(element) {
        const end_date = $(element).text()
        const elementId = $(element).data('value')
        // Update the count down every 1 second
        var x = setInterval(function () {
            var timer = ' '
            var countDownDate = new Date(end_date).getTime()
            var now = new Date().getTime()

            // Find the distance between now and the count down date
            var distance = countDownDate - now

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24))
            var hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            )
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
            var seconds = Math.floor((distance % (1000 * 60)) / 1000)

            timer +=
                '<ul class="p-0  default-cursor">' +
                '<li><span id="days">' +
                days +
                '</span>days</li>' +
                '<li><span id="hours">' +
                hours +
                '</span>Hr</li>' +
                '<li><span id="minutes">' +
                minutes +
                '</span>Min</li>' +
                ' <li><span id="seconds">' +
                seconds +
                '</span>Sc</li>' +
                '</ul>'

            $(`#timer-${elementId}`).html(timer)

            $(`#timer-${elementId}`).addClass('badge-success')

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x)
                $(`#timer-${elementId}`).text('Sale is Expired')
                $(`#timer-${elementId}`).addClass('badge-warning')
            }
        }, 1000)
    }

    // star rating
    $('.kv-ltr-theme-svg-star').rating({
        hoverOnClear: false,
        theme: 'krajee-svg'
    });
    $(document).on("click", ".clear-rating", () => {
        $('.star-rating').rating('reset');
    })

    $(document).on("click", '.swatch', function () {
        $(this).addClass('border-active').siblings().removeClass('border-active');
    });

    $('#product-filters-mobile').on('click', '.nav-link', function () {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    })

    // $(".tab-pane").first().addClass("show").css("display", "block");
    // // Handle filter title click event
    // $(".filter-titles").click(function () {
    //     $(".tab-pane").removeClass("show").css("display", "none");

    //     // Show the selected filter section
    //     var target = $(this).attr("data-bs-target");
    //     $(target).addClass("show").css("display", "block");
    // });

    // // $('.swatch-images').show().siblings('div').hide();
    // $('[data-target=".swatch-images"]').on("click", function () {
    //     $(this).$('.swatch-images').show().siblings('div').hide();
    // });

    /* reduce the height of sticky nav when sticks to top */
    var searchNav = $('.search-nav');
    var mainContent = $('main');

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
        var topNav = $('.top-nav').height();

        if (scrollTop >= topNav && scrollTop >= mainContent.offset().top) {
            $(".nav-outer").addClass("nav-sticky");
        } else {
            $(".nav-outer").removeClass("nav-sticky");
        }

        if (scrollTop >= mainContent.offset().top + 300) {
            $(searchNav).addClass("nav-scroll-down");
        } else {
            $(searchNav).removeClass("nav-scroll-down");
        }
    });

    $(window).bind('mousewheel', function (event) {
        var isScrollingWithinMain = $(event.target).closest(mainContent).length > 0;

        if (isScrollingWithinMain) {
            if (event.originalEvent.wheelDelta >= 0) {
                $(searchNav).addClass("nav-scroll-up").slideDown(250);
            } else {
                $(searchNav).removeClass("nav-scroll-up").slideUp(250);
            }
        }
    });

    var lastYPosition = window.pageYOffset;
    $(document).on('touchmove', function (e) {
        var currentYPosition = window.pageYOffset;
        if (currentYPosition > lastYPosition) {
            // Scrolled down
            $(searchNav).removeClass("nav-scroll-up")
        } else {
            // Scrolled up
            $(searchNav).addClass("nav-scroll-up")
        }
        lastYPosition = currentYPosition;
    });

    // $('.step').each(function (index, element) {
    //     $(element).not('.active').addClass('done').html('<i class="fa-solid fa-check"></i>');
    //     if ($(this).is('.active')) {
    //         return false;
    //     }
    // });

    $('#modal-add-to-cart-button').on('click', function (e) {
        e.preventDefault()
        var title = $('#modal-product-title').text()
        var qty = $('#modal-product-quantity').val()
        var description = $('#modal-product-short-description').text()
        var image = $('.swiper-slide-quickview img').attr('src')
        var price = $('#modal-product-price').text()
        var price_without_currency = price.match(/\d+/)[0];
        $('#quick-view').data('data-product-id', $(this).data('productId'))
        var product_variant_id = $(this).attr('data-product-variant-id')
        var product_type = $('#modal-product-type').text()
        var min = $(this).attr('data-min')
        var max = $(this).attr('data-max')
        var step = $(this).attr('data-step')
        var btn = $(this)
        var btn_html = $(this).html()

        if (product_type != 'digital_product') {
            if (!product_variant_id) {
                Toast.fire({
                    icon: 'error',
                    title: 'Please select variant'
                })
                return
            }
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'cart/manage',
            data: {
                product_variant_id: product_variant_id,
                qty: $('#modal-product-quantity').val(),
                is_saved_for_later: false,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            beforeSend: function () {
                btn.html('Please Wait').html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                btn.html(btn_html).attr('disabled', false)
                // var cart_count = cart.length ? cart.length : ''
                // $('#cart-count').text(cart_count)
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                    $('#cart-count').text(result.data.cart_count)
                    var html = ''

                    display_cart(result.data.items)
                } else {
                    if (is_loggedin == 0) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Item added to cart'

                        })
                        var cart_item = {
                            product_variant_id: product_variant_id.trim(),
                            title: title,
                            description: description,
                            qty: qty,
                            image: image,
                            price: price_without_currency,
                            min: min,
                            max: max,
                            step: step
                        }
                        var cart = localStorage.getItem('cart')
                        cart =
                            localStorage.getItem('cart') !== null ? JSON.parse(cart) : null
                        if (cart !== null && cart !== undefined) {
                            cart.push(cart_item)
                        } else {
                            cart = [cart_item]
                        }
                        display_cart(cart)
                        localStorage.setItem('cart', JSON.stringify(cart))
                        $('#cart-count').text(result.data.cart_count)
                        return
                    }
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
            }
        })
    })

    $('.quickview-trigger').on('click', function () {
        var productId = $(this).closest('.product-card').data('product-id');
        var url = base_url + 'products/get-details/' + productId;

        // Fetch product details from the backend
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modal-product-title').text(data.name);
                $('#modal-product-short-description').text(data.short_description)
                $('#modal-product-brand').text(data.brand);
                $('#modal-product-rating').rating('update', data.rating);
                $('#modal-product-no-of-ratings').text(data.no_of_ratings);
                $('#modal-product-price').text(data.get_price.range);
                $('#modal-category_name').text(data.category_name);
                $('#modal-product-type').text(data.type);
                $('#modal-product-quantity').attr("data-id", data.id)
                $('#modal-product-quantity').attr("data-price", data.min_max_price.special_price)
                // var id = data.id;
                // var price = data.min_max_price.special_price;
                // console.log(data);
                // console.log(price);
                // console.log(id);
                let variant_id = $('#modal-variants-id').text(data.variants[0].id);

                var product_detail_URL = "products/details/";
                var detailURL = product_detail_URL + data.slug;
                $('#product-link').attr('href', detailURL);

                var product_category_URL = "products/category/";
                var categoryURL = product_category_URL + data.category_name;
                $('#category-link').attr('href', categoryURL);


                if (data.type != 'variable_product') {
                    $('#modal-add-to-cart-button').attr('data-product-variant-id', data.variants[0].id);
                }

                var variant_attributes = '';
                var variants = '';
                var total_images = 1;
                var variant_attributes = ''
                var is_image = 0
                var is_color = 0
                $.each(data.variant_attributes, function (i, e) {
                    var attribute_ids = e.ids.split(',')
                    var attribute_values = e.values.split(',')
                    var swatche_types = e.swatche_type.split(',')
                    var swatche_values = e.swatche_value.split(',')
                    var style =
                        '<style> .product-page-details .btn-group>.active { border: 1px solid black;}</style>'
                    variant_attributes +=
                        '<ul class="d-flex gap-2 flex-wrap align-items-center list-unstyled quickview-variant-sec"><li class="fw-semibold">' +
                        e.attr_name +
                        ' : </li>'
                    $.each(attribute_ids, function (j, id) {
                        var color_code = ''
                        if (swatche_types[j] == '1') {
                            is_color = 1
                            color_code =
                                'style="background-color:' + swatche_values[j] + '";'
                            variant_attributes +=
                                '<style> .product-page-details 1 .btn-group>.active { border: 1px solid black;}</style>' +
                                '<li class="color-swatch swatch"><label class="product-color m-0"' + color_code +
                                '>' +
                                '<input type="radio" name="' +
                                e.attr_name +
                                '" value="' +
                                id +
                                '" class="attributes filter-input modal-product-attributes" autocomplete="off">' +
                                '</label></li>'
                        } else if (swatche_types[j] == '2') {
                            is_image = 1
                            variant_attributes +=
                                '<style> .product-page-details 2 .btn-group>.active { color: #000000; border: 1px solid black;}</style>' +
                                '<li class="image-swatch swatch"><label class="color-swatch-img m-0">' +
                                '<img class="swatche-image" src="' +
                                swatche_values[j] +
                                '">' +
                                '<input type="radio" name="' +
                                e.attr_name +
                                '" value="' +
                                id +
                                '" class="attributes filter-input modal-product-attributes" autocomplete="off">' +
                                '</label></li>'
                        } else {
                            variant_attributes +=
                                '<li class="default-swatch swatch"><label class="m-0 position-relative">' +
                                '<input type="radio" name="' +
                                e.attr_name +
                                '" value="' +
                                id +
                                '" class="attributes filter-input modal-product-attributes" autocomplete="off">' +
                                attribute_values[j] +
                                '</label>' +
                                '</li>'
                        }
                    })
                    variant_attributes += '</li></ul>'
                })
                var variants = ''
                total_images = 1
                $.each(data.variants, function (i, e) {
                    variants +=
                        '<input type="hidden" class="modal-product-variants" data-image-index="' +
                        total_images +
                        '" name="variants_ids" data-name="' +
                        data.name +
                        '" value="' +
                        e.variant_ids +
                        '" data-id="' +
                        e.id +
                        '" data-price="' +
                        e.price +
                        '" data-special_price="' +
                        e.special_price +
                        '">'
                    total_images += e.images.length
                    // console.log(e);
                    // console.log(e.images.length);
                    // console.log(total_images);
                })
                $('#modal-product-variant-attributes').html(variant_attributes);
                $('#modal-product-variants-div').html(variants);

                if (
                    data.minimum_order_quantity != 1 &&
                    data.minimum_order_quantity != '' &&
                    data.minimum_order_quantity != 'undefined'
                ) {
                    $('.plus-minus-input').attr({
                        'data-min': data.minimum_order_quantity // values (or variables) here
                    })
                    $('.minus-btn').attr({
                        'data-min': data.minimum_order_quantity // values (or variables) here
                    })
                    $('#modal-add-to-cart-button').attr({
                        'data-min': data.minimum_order_quantity // values (or variables) here
                    })
                } else {
                    $('.plus-minus-input').attr({
                        'data-min': 1 // values (or variables) here
                    })
                    $('.minus-btn').attr({
                        'data-min': 1 // values (or variables) here
                    })
                    $('#modal-add-to-cart-button').attr({
                        'data-min': 1 // values (or variables) here
                    })
                }
                if (
                    data.quantity_step_size != 1 &&
                    data.quantity_step_size != '' &&
                    data.quantity_step_size != 'undefined'
                ) {
                    $('.plus-minus-input').attr({
                        'data-step': data.quantity_step_size // values (or variables) here
                    })
                    $('.minus-btn').attr({
                        'data-step': data.quantity_step_size // values (or variables) here
                    })
                    $('.plus-btn').attr({
                        'data-step': data.quantity_step_size // values (or variables) here
                    })
                    $('#modal-add-to-cart-button').attr({
                        'data-step': data.quantity_step_size // values (or variables) here
                    })
                } else {
                    $('.plus-minus-input').attr({
                        'data-step': 1 // values (or variables) here
                    })
                    $('.minus-btn').attr({
                        'data-step': 1 // values (or variables) here
                    })
                    $('.plus-btn').attr({
                        'data-step': 1 // values (or variables) here
                    })
                    $('#modal-add-to-cart-button').attr({
                        'data-step': 1 // values (or variables) here
                    })
                }
                if (
                    data.total_allowed_quantity != "" &&
                    data.total_allowed_quantity != 'undefined' &&
                    data.total_allowed_quantity != null
                ) {

                    $('.plus-minus-input').attr({
                        'data-max': data.total_allowed_quantity // values (or variables) here
                    })
                    $('.plus-btn').attr({
                        'data-max': data.total_allowed_quantity // values (or variables) here
                    })
                    $('#modal-add-to-cart-button').attr({
                        'data-max': data.total_allowed_quantity // values (or variables) here
                    })
                } else {

                    $('.plus-minus-input').attr({
                        'data-max': 1 // values (or variables) here
                    })
                    $('.plus-btn').attr({
                        'data-max': 1 // values (or variables) here
                    })
                    $('#modal-add-to-cart-button').attr({
                        'data-max': 1 // values (or variables) here
                    })
                }
                // Show the quickview modal
                $('#quickview').modal('show');
                if (!quickViewgalleryTop) {
                    quickViewgalleryTop = new Swiper('.mySwiper-quickview', {
                        spaceBetween: 0,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        }
                    });
                } else {
                    // Clear existing slides
                    quickViewgalleryTop.removeAllSlides();

                    // Add new slides
                    var main_images = $('<div class="swiper-slide swiper-slide-quickview text-center">' +
                        '<img src="' + data.image_md + '">' +
                        '</div>');
                    $(".swiper-wrapper-main").append(main_images);

                    var variant_images_md = data.variants.map(function (value, index) {
                        return value.images_md;
                    });

                    $.each(variant_images_md, function (i, images) {
                        if (images != null && images != '') {
                            $.each(images, function (i, url) {
                                var main_images = $('<div class="swiper-slide swiper-slide-quickview text-center">' +
                                    '<img src="' + url + '">' +
                                    '</div>');
                                $(".swiper-wrapper-main").append(main_images);
                            });
                        }
                    });

                    $.each(data.other_images_md, function (i, url) {
                        if (url != null && url != '') { // Check if the URL is not blank
                            total_images++;
                            var main_images = $('<div class="swiper-slide swiper-slide-quickview text-center">' +
                                '<img src="' + url + '">' +
                                '</div>');
                            $(".swiper-wrapper-main").append(main_images);
                        }
                    });

                    // Update the Swiper instance
                    quickViewgalleryTop.update();
                }

                quickViewgalleryTop = new Swiper('.mySwiper-quickview', {
                    spaceBetween: 0,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    }
                });

                quickViewgalleryTop.removeAllSlides();

                var main_images = $('<div class="swiper-slide swiper-slide-quickview text-center">' +
                    '<img src="' + data.image_md + '">' +
                    '</div>');
                $(".swiper-wrapper-main").append(main_images);

                var variant_images_md = data.variants.map(function (value, index) {
                    return value.images_md;
                });

                $.each(variant_images_md, function (i, images) {
                    if (images != null && images != '') {
                        $.each(images, function (i, url) {
                            var main_images = $('<div class="swiper-slide swiper-slide-quickview text-center">' +
                                '<img src="' + url + '">' +
                                '</div>');
                            $(".swiper-wrapper-main").append(main_images);
                        });
                    }
                });

                $.each(data.other_images_md, function (i, url) {
                    if (url != null && url != '') { // Check if the URL is not blank
                        total_images++;
                        var main_images = $('<div class="swiper-slide swiper-slide-quickview text-center">' +
                            '<img src="' + url + '">' +
                            '</div>');
                        $(".swiper-wrapper-main").append(main_images);
                    }
                });
                if (main_images.length > 1) {
                    quickViewgalleryTop.addSlide(1, main_images);
                }
                $('#quickview').on('hidden.bs.modal', function () {
                    if (quickViewgalleryTop) {
                        quickViewgalleryTop.removeAllSlides();
                        quickViewgalleryTop.destroy();
                        quickViewgalleryTop = null;
                    }
                });
            }
        });
    });

    // $('.add-in-cart-btn').on('click', function () {
    //     Toast.fire({
    //         icon: 'error',
    //         title: 'Please select variant'
    //     })
    //     console.log('click');
    // })

    // Product Details Page.
    $('.attributes').on('change', function (e) {
        e.preventDefault()
        var selected_attributes = []
        var attributes_length = ''
        var price = ''
        var is_variant_available = false
        var variant = []
        var prices = []
        var variant_prices = []
        var variants = []
        var variant_ids = []
        var image_indexes = []
        var selected_image_index
        $('.variants').each(function () {
            prices = {
                price: $(this).data('price'),
                special_price: $(this).data('special_price')
            }
            variant_ids.push($(this).data('id'))
            variant_prices.push(prices)
            variant = $(this).val().split(',')
            variants.push(variant)
            image_indexes.push($(this).data('image-index'))
        })

        attributes_length = variant.length
        $('.attributes').each(function (i, e) {
            if ($(this).prop('checked')) {
                selected_attributes.push($(this).val())
                if (selected_attributes.length == attributes_length) {
                    /* compare the arrays */
                    prices = []
                    var selected_variant_id = ''
                    $.each(variants, function (i, e) {
                        if (arrays_equal(selected_attributes, e)) {
                            is_variant_available = true
                            prices.push(variant_prices[i])
                            selected_variant_id = variant_ids[i]
                            selected_image_index = image_indexes[i]
                        }
                    })
                    if (is_variant_available) {
                        $('#add_cart').attr('data-product-variant-id', selected_variant_id)
                        galleryTop.slideTo(selected_image_index, 500, false)
                        // swiperF.slideTo(selected_image_index, 500, false)
                        if (
                            prices[0].special_price < prices[0].price &&
                            prices[0].special_price != 0
                        ) {
                            price = prices[0].special_price
                            $('#price').html(currency + ' ' + price.toLocaleString())
                            $('#striped-price').html(currency + ' ' + prices[0].price)
                            $('#striped-price-div').show()
                            $('#add_cart').removeAttr('disabled')
                        } else {
                            price = prices[0].price
                            $('#price').html(currency + ' ' + price.toLocaleString())
                            $('#striped-price-div').hide()
                            $('#add_cart').removeAttr('disabled')
                        }
                    } else {
                        price = '<small class="text-danger h5">No Variant available!</small>'
                        $('#price').html(price.toLocaleString())
                        $('#striped-price-div').hide()
                        $('#striped-price').html('')
                        $('#add_cart').attr('disabled', 'true')
                    }
                }
            }
        })
        variants = ''
    })

    var galleryTop = new Swiper('.gallery-top-1', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
    })

    //Modal Product Variant Selection Event
    $(document).on('change', '.modal-product-attributes', function (e) {
        e.preventDefault()
        var selected_attributes = []
        var attributes_length = ''
        var price = ''
        var is_variant_available = false
        var variant = []
        var prices = []
        var variant_prices = []
        var variants = []
        var variant_ids = []
        var image_indexes = []
        var selected_image_index
        $('.modal-product-variants').each(function () {
            prices = {
                price: $(this).data('price'),
                special_price: $(this).data('special_price')
            }
            variant_ids.push($(this).data('id'))
            variant_prices.push(prices)
            variant = $(this).val().split(',')
            variants.push(variant)
            image_indexes.push($(this).data('image-index'))
        })
        attributes_length = variant.length
        $('.modal-product-attributes').each(function () {
            if ($(this).prop('checked')) {
                selected_attributes.push($(this).val())

                if (selected_attributes.length == attributes_length) {
                    /* compare the arrays */
                    prices = []
                    var selected_variant_id = ''
                    $.each(variants, function (i, e) {
                        if (arrays_equal(selected_attributes, e)) {
                            is_variant_available = true
                            prices.push(variant_prices[i])
                            selected_variant_id = variant_ids[i]
                            selected_image_index = image_indexes[i]
                        }
                    })
                    if (is_variant_available) {
                        quickViewgalleryTop.slideTo(selected_image_index, 500, false)
                        if (
                            prices[0].special_price < prices[0].price &&
                            prices[0].special_price != 0
                        ) {
                            price = prices[0].special_price
                            $('#modal-product-price').text(currency + ' ' + price)

                            $('#modal-product-special-price').text(
                                currency + ' ' + prices[0].price
                            )

                            $('#modal-add-to-cart-button').attr(
                                'data-product-variant-id',
                                selected_variant_id
                            )
                            $('#modal-product-special-price-div').show()
                        } else {
                            price = prices[0].price
                            $('#modal-product-price').html(currency + ' ' + price)
                            $('#modal-product-special-price-div').hide()
                            $('#modal-add-to-cart-button').attr(
                                'data-product-variant-id',
                                selected_variant_id
                            )
                        }
                    } else {
                        // price = '<small class="text-danger h5">No Variant available!</small>';
                        // $('#modal-product-price').html(price);
                        $('#modal-product-special-price-div').hide()
                    }
                }
            }
        })
    })

    function arrays_equal(_arr1, _arr2) {
        if (
            !Array.isArray(_arr1) ||
            !Array.isArray(_arr2) ||
            _arr1.length !== _arr2.length
        ) {
            return false
        }

        const arr1 = _arr1.concat().sort()
        const arr2 = _arr2.concat().sort()

        for (let i = 0; i < arr1.length; i++) {
            if (arr1[i] !== arr2[i]) {
                return false
            }
        }

        return true
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text
    }
    var search_products = $('.search_product').select2({
        ajax: {
            url: base_url + 'home/get_products',
            dataType: 'json',
            delay: 1000,
            data: function (params) {
                return {
                    search: params.term, // search term
                    page: params.page
                }
            },
            processResults: function (response, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1

                return {
                    results: response.data,
                    pagination: {
                        more: params.page * 30 < response.total
                    }
                }
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup
        },
        minimumInputLength: 3,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        theme: 'adwitt',
        placeholder: 'Search for products'
    })

    search_products.on('select2:select', function (e) {
        var data = e.params.data
        if (data.link != undefined && data.link != null) {
            window.location.href = data.link
        }
    })

    function formatRepo(repo) {
        if (repo.loading) return repo.text
        var markup =
            "<div class='select2-result-repository clearfix pointer'>" +
            "<div class='select2-result-repository__avatar'><img src='" +
            repo.image_sm +
            "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" +
            repo.name +
            '</div>'

        if (repo.category_name) {
            markup +=
                "<div class='select2-result-repository__description'> In " +
                repo.category_name +
                '</div>'
        }

        return markup
    }

    //Qty Counter
    $(document).on('change', 'input.in-num', function (e) {
        e.preventDefault()
        var input = $(this)
        if (input.val() == null || typeof input.val() == 'string') {
            if (!$.isNumeric(input.val())) {
                input.val(1)
            } else {
                if (input.val() == '0') {
                    input.val(1)
                }
            }
        }
    })
    $(document).on('focusout', '.in-num', function (e) {
        e.preventDefault()
        var value = $(this).val()
        var min = $(this).data('min')
        var step = $(this).data('step')
        var max = $(this).data('max')
        if (value < min) {
            $(this).val(min)
            Toast.fire({
                icon: 'error',
                title: 'Minimum allowed quantity is ' + min
            })
        } else if (value > max) {
            $(this).val(max)
            Toast.fire({
                icon: 'error',
                title: 'Maximum allowed quantity is ' + max
            })
        }
        // else if (value % step != 0) {
        //     $(this).val(min);
        //     Toast.fire({
        //         icon: 'error',
        //         title: 'Invalid quantity'
        //     });
        // }
    })

    // $(document).on('click', '.num-block .num-in span', function (e) {
    //     e.preventDefault()
    //     var input = $(this).parents('.num-block').find('input.in-num')
    //     if (input.val() == null) {
    //         input.val(1)
    //     }
    //     if ($(this).hasClass('minus')) {
    //         var step = $(this).data('step')
    //         var count = parseFloat(input.val()) - step
    //         var min = $(this).data('min')
    //         if (count >= min) {
    //             input.val(count)
    //         } else {
    //             input.val(min)
    //             Toast.fire({
    //                 icon: 'error',
    //                 title: 'Minimum allowed quantity is ' + min
    //             })
    //         }
    //     } else {
    //         var step = $(this).data('step')
    //         var max = $(this).data('max')
    //         var count = parseFloat(input.val()) + step
    //         if (max != 0) {
    //             if (count <= max) {
    //                 input.val(count)
    //                 if (count > 1) {
    //                     $(this).parents('.num-block').find('.minus').removeClass('dis')
    //                 }
    //             } else {
    //                 input.val(max)
    //                 Toast.fire({
    //                     icon: 'error',
    //                     title: 'Maximum allowed quantity is ' + max
    //                 })
    //             }
    //         } else {
    //             input.val(count)
    //         }
    //     }
    //     input.change()
    //     return false
    // })

    $(document).on('click', '.add_to_cart', function (e) {
        e.preventDefault()
        var qty = $('[name="qty"]').val()
        $('#quick-view').data('data-product-id', $(this).data('productId'))
        var product_variant_id = $(this).attr('data-product-variant-id')
        var title = $(this).attr('data-product-title')
        var image = $(this).attr('data-product-image')
        var price = $(this).attr('data-product-price')
        var description = $(this).attr('data-product-description')
        var min = $(this).attr('data-min')
        var max = $(this).attr('data-max')
        var step = $(this).attr('data-step')
        var btn = $(this)
        var btn_html = $(this).html()
        var QuickViewModal = $(this).attr('data-bs-target');
        if (!product_variant_id) {
            Toast.fire({
                icon: 'error',
                title: 'Please select variant'
            })
            return
        }
        if (QuickViewModal == '' || QuickViewModal == undefined) {
            $.ajax({
                type: 'POST',
                url: base_url + 'cart/manage',
                data: {
                    product_variant_id: product_variant_id,
                    qty: qty,
                    is_saved_for_later: false,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                beforeSend: function () {
                    btn.html('<div class="spinner-border" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                        '</div>').attr('disabled', true);
                },
                success: function (result) {
                    csrfName = result['csrfName']
                    csrfHash = result['csrfHash']
                    btn.html(btn_html).attr('disabled', false)
                    if (result.error == false) {
                        Toast.fire({
                            icon: 'success',
                            title: result.message
                        })
                        $('#cart-count').text(result.data.cart_count)
                        var html = ''

                        display_cart(result.data.items)
                    } else if (is_loggedin == 0) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Item added to cart'
                        })
                        var cart_item = {
                            product_variant_id: product_variant_id.trim(),
                            title: title,
                            description: description,
                            qty: min,
                            image: image,
                            price: price.trim(),
                            min: min,
                            max: max,
                            step: step
                        }
                        var cart = localStorage.getItem('cart')
                        cart =
                            localStorage.getItem('cart') !== null ? JSON.parse(cart) : null
                        if (cart !== null && cart !== undefined) {
                            cart.push(cart_item)
                        } else {
                            cart = [cart_item]
                        }
                        localStorage.setItem('cart', JSON.stringify(cart))

                        display_cart(cart)
                        return false
                    }
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                }
            })
        }
    })

    $(document).ready(function () {
        var cart = localStorage.getItem("cart");
        cart = (localStorage.getItem("cart") !== null) ? JSON.parse(cart) : null;
        if (cart) {
            var cart_count = cart.length ? cart.length : ''
            $('#cart-count').text(cart_count)
            var html = ''
            if (cart !== null && cart.length > 0) {
                cart.forEach(item => {
                    html +=
                        '<div class="cart-modal-card card" style="max-width: 540px;">' +
                        '<div class="row">' +
                        '<div class="col-4">' +
                        '<div class="cart-img-box">' +
                        '<img class="img-fluid rounded-start pic-1 lazy" src="' +
                        item.image +
                        '"></div></div>' +
                        '<div class="col-8">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' +
                        item.title +
                        '</h5>' +
                        '<p class="card-text">' +
                        item.description +
                        '</p>' +
                        '<div class="input-group plus-minus-input mb-3 num-block">' +
                        '<div class="input-group-button">' +
                        '<button type="button" class="button hollow circle minus-btn minus" data-quantity="minus"' + 'data-field="quantity" data-min="' +
                        item.min +
                        '" data-step="' +
                        item.step +
                        '"><i class="fa-solid fa-minus"></i></button></div>' +
                        '<div class="product-quantity product-sm-quantity">' +
                        '<input type="number" name="qty" class="input-group-field input-field-cart-modal form-input in-num" value="' +
                        item.qty +
                        '" data-id="' +
                        item.product_variant_id +
                        ' " data-price="' +
                        item.price +
                        '" min="' +
                        item.min +
                        '" max="' +
                        item.max +
                        '" step="' +
                        item.step +
                        '"></div><div class="input-group-button"><button type="button" class="button hollow circle plus-btn plus" data-quantity="plus" data-field="quantity" data-max="' +
                        item.max +
                        ' " data-step="' +
                        item.step +
                        '"><i class="fa-solid fa-plus"></i></button></div></div>' +
                        '<p class="product-line-price cart-modal-pricing">' +
                        currency +
                        " " +
                        item.price +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-sm-removal align-self-center">' +
                        '<button class="remove-product btn" data-id="' +
                        item.product_variant_id +
                        '"><ion-icon name="close-outline"></ion-icon>' +
                        '</button>' +
                        '</div>' +
                        '</div>'
                })
            } else {
                html +=
                    '<div class="offcanvas-body p-0">' +
                    '<div class="text-center py-5">' +
                    '<ion-icon name="bag-add-outline" class="fa-6x text-body-tertiary opacity-50"></ion-icon>' +
                    '<h5 class="">Your Cart Is Empty</h5>' +
                    ' <div class="text-center mt-2"><a class="btn btn-primary" href="' +
                    base_url +
                    'product' +
                    ' ">return to shop</a></div>' +
                    '</div></div>'
            }
            $('#cart-item-sidebar').html(html)
            updateSubtotal();
        }
    });

    function display_cart(cart) {

        if (is_loggedin == 0) {
            var cart_count = cart.length ? cart.length : ''
            $('#cart-count').text(cart_count)
            var html = ''
            if (cart !== null && cart.length > 0) {
                cart.forEach(item => {
                    html +=
                        '<div class="cart-modal-card card" style="max-width: 540px;">' +
                        '<div class="row">' +
                        '<div class="col-4">' +
                        '<div class="cart-img-box">' +
                        '<img class="img-fluid rounded-start pic-1 lazy" src="' +
                        item.image +
                        '"></div></div>' +
                        '<div class="col-8">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' +
                        item.title +
                        '</h5>' +
                        '<p class="card-text">' +
                        item.description +
                        '</p>' +
                        '<div class="input-group plus-minus-input mb-3 num-block">' +
                        '<div class="input-group-button">' +
                        '<button type="button" class="button hollow circle minus-btn minus" data-quantity="minus"' + 'data-field="quantity" data-min="' +
                        item.min +
                        '" data-step="' +
                        item.step +
                        '"><i class="fa-solid fa-minus"></i></button></div>' +
                        '<div class="product-quantity product-sm-quantity">' +
                        '<input type="number" name="qty" class="input-group-field input-field-cart-modal form-input in-num" value="' +
                        item.qty +
                        '" data-id="' +
                        item.product_variant_id +
                        ' " data-price="' +
                        item.price +
                        '" min="' +
                        item.min +
                        '" max="' +
                        item.max +
                        '" step="' +
                        item.step +
                        '"></div><div class="input-group-button"><button type="button" class="button hollow circle plus-btn plus" data-quantity="plus" data-field="quantity" data-max="' +
                        item.max +
                        ' " data-step="' +
                        item.step +
                        '"><i class="fa-solid fa-plus"></i></button></div></div>' +
                        '<p class="product-line-price cart-modal-pricing">' +
                        currency +
                        " " +
                        item.price.toLocaleString() +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-sm-removal align-self-center">' +
                        '<button class="remove-product btn" data-id="' +
                        item.product_variant_id +
                        '"><ion-icon name="close-outline"></ion-icon>' +
                        '</button>' +
                        '</div>' +
                        '</div>'
                })
            } else {
                html +=
                    '<div class="offcanvas-body p-0">' +
                    '<div class="text-center py-5">' +
                    '<ion-icon name="bag-add-outline" class="fa-6x text-body-tertiary opacity-50"></ion-icon>' +
                    '<h5 class="">Your Cart Is Empty</h5>' +
                    ' <div class="text-center mt-2"><a class="btn btn-primary" href="' +
                    base_url +
                    'product' +
                    ' ">return to shop</a></div>' +
                    '</div></div>'
            }
            $('#cart-item-sidebar').html(html)
            updateSubtotal();
        } else {

            var cart_count = cart.length ? cart.length : ''
            $('#cart-count').text(cart_count)
            var html = ''
            if (cart !== null && cart.length > 0) {
                cart.forEach(item => {
                    html +=
                        '<div class="cart-modal-card card" style="max-width: 540px;">' +
                        '<div class="row">' +
                        '<div class="col-4">' +
                        '<div class="cart-img-box">' +
                        '<img class="img-fluid rounded-start pic-1 lazy" src="' +
                        base_url +
                        item.image +
                        '"></div></div>' +
                        '<div class="col-8">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' +
                        item.name +
                        '</h5>' +
                        '<p class="card-text">' +
                        item.short_description +
                        '</p>' +
                        '<div class="input-group plus-minus-input mb-3 num-block">' +
                        '<div class="input-group-button">' +
                        '<button type="button" class="button hollow circle minus-btn minus" data-quantity="minus"' + 'data-field="quantity" data-min="' +
                        item.minimum_order_quantity +
                        '" data-step="' +
                        item.quantity_step_size +
                        '"><i class="fa-solid fa-minus"></i></button></div>' +
                        '<div class="product-quantity product-sm-quantity">' +
                        '<input type="number" name="qty" class="input-group-field input-field-cart-modal form-input in-num" value="' +
                        item.qty +
                        '" data-id="' +
                        item.product_variant_id +
                        ' " data-price="' +
                        item.special_price +
                        '" min="' +
                        item.minimum_order_quantity +
                        '" max="' +
                        item.total_allowed_quantity +
                        '" step="' +
                        item.quantity_step_size +
                        '"></div><div class="input-group-button"><button type="button" class="button hollow circle plus-btn plus" data-quantity="plus" data-field="quantity" data-max="' +
                        item.total_allowed_quantity +
                        ' " data-step="' +
                        item.quantity_step_size +
                        '"><i class="fa-solid fa-plus"></i></button></div></div>' +
                        '<p class="product-line-price cart-modal-pricing">' +
                        currency +
                        " " +
                        item.special_price.toLocaleString() +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-sm-removal align-self-center">' +
                        '<button class="remove-product btn" data-id="' +
                        item.product_variant_id +
                        '"><ion-icon name="close-outline"></ion-icon>' +
                        '</button>' +
                        '</div>' +
                        '</div>'
                })

            } else {
                html +=
                    '<div class="offcanvas-body p-0">' +
                    '<div class="text-center py-5">' +
                    '<ion-icon name="bag-add-outline" class="fa-6x text-body-tertiary opacity-50"></ion-icon>' +
                    '<h5 class="">Your Cart Is Empty</h5>' +
                    ' <div class="text-center mt-2"><a class="btn btn-primary" href="' +
                    base_url +
                    'product' +
                    ' ">return to shop</a></div>' +
                    '</div></div>'
            }
            $('#cart-item-sidebar').html(html)
            updateSubtotal();
        }
    }
    // const selectedVariant = variantsSelect.val();
    // if (selectedVariant === "") {
    //     // No variant selected, show alert and redirect to quickview modal
    //     Toast.fire({
    //         icon: 'error',
    //         title: 'select variant  '

    //     })
    //     // Replace the following line with code to open your quickview modal
    //     // For example: openQuickViewModal();
    //     console.log("Redirecting to quickview modal...");
    // } else {
    //     // Variant selected, add the product to the cart
    //     addToCart(selectedVariant);
    //     Toast.fire({
    //         icon: 'success',
    //         title: 'Item added to cart'

    //     })
    // }


    function mycartTotal() {
        var cartTotal = 0
        $('#cart_item_table > tbody > tr > .total-price  > .product-line-price').each(
            function (i) {
                cartTotal =
                    parseFloat(cartTotal) +
                    parseFloat(
                        $(this)
                        .text()
                        .replace(/[^\d\.]/g, '')
                    )
            }
        )
        $('#final_total').text(cartTotal.toFixed(2))
    }

    function recalculateCart() {
        var subtotal = 0

        /* Set rates + misc */
        var taxRate = 0.05
        var shippingRate = 15.0
        var fadeTime = 300
        /* Sum up row totals */
        $('.product').each(function () {
            subtotal += parseFloat($(this).children('.product-line-price').text())
        })

        /* Calculate totals */
        var tax = subtotal * taxRate
        var shipping = subtotal > 0 ? shippingRate : 0
        var total = subtotal + tax + shipping

        /* Update totals display */
        $('.totals-value').fadeOut(fadeTime, function () {
            $('#cart-subtotal').html(subtotal.toFixed(2))
            $('#cart-tax').html(tax.toFixed(2))
            $('#cart-shipping').html(shipping.toFixed(2))
            $('#cart-total').html(total.toFixed(2))
            if (total == 0) {
                $('.checkout').fadeOut(fadeTime)
            } else {
                $('.checkout').fadeIn(fadeTime)
            }
            $('.totals-value').fadeIn(fadeTime)
        })
    }
    /* Update quantity */
    function updateQuantity(quantityInput, price) {
        /* Calculate line price */
        if (quantityInput.data('page') == 'cart') {
            var productRow = $(quantityInput)
                .parent()
                .parent()
                .parent()
                .siblings('.total-price')
        } else {
            var productRow = $(quantityInput).parent().parent()
        }
        var quantity = $(quantityInput).val()
        var linePrice = price * quantity

        /* Update line price display and recalc cart totals */
        productRow.find('.product-line-price').fadeOut(200, function () {
            $(this).fadeOut(200, function () {
                $(this).text(currency + linePrice.toFixed(2))
                recalculateCart()
                mycartTotal()
                $(this).fadeIn(200)
            })
        })
    }

    $(document).on('click', '.num-block .input-group-button button', function (e) {
        e.preventDefault();
        var input = $(this).parents('.num-block').find('input');
        // console.log(input.val());
        if (input.val() == null) {
            input.val(1);
        }
        if ($(this).hasClass('minus-btn')) {
            var step = $(this).data('step');
            var count = parseFloat(input.val()) - step;
            var min = $(this).data('min');
            if (count >= min) {
                input.val(count);
            } else {
                input.val(min);
                Toast.fire({
                    icon: 'error',
                    title: 'Minimum allowed quantity is ' + min
                });
            }
            updateSubtotal();
            update_price()
        } else if ($(this).hasClass('plus-btn')) {
            var step = $(this).data('step');
            var max = $(this).data('max');
            var count = parseFloat(input.val()) + step;
            if (max != 0) {
                if (count <= max) {
                    input.val(count);
                    if (count > 1) {
                        $(this).parents('.num-block').find('.minus-btn').removeClass('dis');
                    }
                } else {
                    input.val(max);
                    Toast.fire({
                        icon: 'error',
                        title: 'Maximum allowed quantity is ' + max
                    });
                }
            } else {
                input.val(count);
            }
            updateSubtotal();
            update_price()
        } else if ($(this).hasClass('product-sm-quantity')) {
            var step = $(this).data('step');
            var max = $(this).data('max');
            var count = parseFloat(input.val()) + step;
            if (max != 0) {
                if (count <= max) {
                    input.val(count);
                    if (count > 1) {
                        // $(this).parents('.num-block').find('.minus-btn').removeClass('dis');
                    }
                } else {
                    input.val(max);
                    Toast.fire({
                        icon: 'error',
                        title: 'Maximum allowed quantity is ' + max
                    });
                }
            } else {
                input.val(count);
            }
            updateSubtotal();
            update_price()
        }
        // $(document).find(".product-quantity input,.product-sm-quantity input,.itemQty").trigger("change");
        input.change();
        return false;
    });

    setTimeout(function () {

        $(document).on(
            'input click',
            '.product-quantity input,.product-sm-quantity input, .num-block .input-group-button button',
            function (e) {
                e.preventDefault()

                // var id = $('.product-quantity .input-field-cart-modal').data('id')
                // let price = $('.product-quantity .input-field-cart-modal').data('price')
                // let qty = $('.product-quantity .input-field-cart-modal').val()
                // var temp = $('.product-quantity .input-field-cart-modal')
                let productQuantity = $(this).parent().siblings().closest('.product-quantity');
                let id = productQuantity.find('.input-field-cart-modal').data('id');
                let price = productQuantity.find('.input-field-cart-modal').data('price');
                let qty = productQuantity.find('.input-field-cart-modal').val();
                let temp = productQuantity.find('.input-field-cart-modal');

                console.log($(this));
                console.log($(this)[0].attributes[5]);
                console.log(id);
                console.log(price);
                console.log(qty);
                let step
                if ($(this).attr('step')) {
                    step = $(this).attr('step')
                } else {
                    step = $(this).data('step')
                }
                var min = $(this).attr('min')
                if (qty <= 0) {
                    Toast.fire({
                        icon: 'error',
                        title: `Oops! Please set minimum ${min} quantity for product`
                    })
                    return
                }
                if (qty % step == 0) {
                    if (is_loggedin == 1) {
                        $.ajax({
                            url: base_url + 'cart/manage',
                            type: 'POST',
                            data: {
                                product_variant_id: id,
                                qty: qty,
                                [csrfName]: csrfHash
                            },
                            dataType: 'json',
                            success: function (result) {
                                csrfName = result.csrfName
                                csrfHash = result.csrfHash
                                if (result.error == false) {
                                    updateQuantity(temp, price)
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: result.message
                                    })
                                }
                            }
                        })
                    } else {
                        updateQuantity(temp, price)
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: `Oops! you can only set quantity in step size of ${step}`
                    })
                }
            }
        )
    }, 2000);
    /* Assign actions */

    //Remove from Cart.
    $(document).on(
        'click',
        '.product-removal button,.product-removal ion-icon,.product-sm-removal button',
        function (e) {
            e.preventDefault()
            var id = $(this).data('id')
            var is_save_for_later =
                typeof $(this).data('is-save-for-later') != 'undefined' &&
                $(this).data('is-save-for-later') == 1 ?
                '1' :
                '0'
            var product = $(this).parent().parent()
            if (is_loggedin == 1) {
                // remove from server
                $.ajax({
                    type: 'POST',
                    url: base_url + 'cart/remove',
                    data: {
                        product_variant_id: id,
                        is_save_for_later: is_save_for_later,
                        [csrfName]: csrfHash
                    },
                    dataType: 'json',
                    success: function (result) {

                        csrfName = result['csrfName']
                        csrfHash = result['csrfHash']
                        if (result.error == false) {
                            var cart_count = $('#cart-count').text()
                            cart_count--
                            $('#cart-count').text(cart_count)
                            removeItem(product)
                            // location.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Item Remove From Cart'
                            })

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: result.message
                            })
                        }
                    }
                })
            } else {
                // remove from local storage
                removeItem(product)
                var cart = localStorage.getItem('cart')
                cart = localStorage.getItem('cart') !== null ? JSON.parse(cart) : null
                if (cart) {
                    var new_cart = cart.filter(function (item) {
                        return item.product_variant_id != id
                    })
                    localStorage.setItem('cart', JSON.stringify(new_cart))
                    if (cart) display_cart(new_cart)
                    updateSubtotal();
                }
            }
        }
    )


    /* Remove item from cart */
    function removeItem(removeProduct) {
        /* Remove row from DOM and recalc cart total */
        var productRow = $(removeProduct)
        productRow.slideUp(200, function () {
            productRow.remove()
            recalculateCart()
            mycartTotal()
            updateSubtotal()
        })
    }

    function updateSubtotal() {

        var subtotal = 0;
        var price = 0;
        var quantity = 0;

        $('.cart-modal-card').each(function () {
            price = parseFloat($(this).find('.input-field-cart-modal').data('price'));
            quantity = parseInt($(this).find('.product-quantity input').val());
            if (!isNaN(price) && !isNaN(quantity)) {
                subtotal += price * quantity;

            }
        })
        $('#subtotal-amount').fadeOut(200, function () {
            $(this).text(currency + ' ' + subtotal.toFixed(2));
            $(this).fadeIn(200);
        });
    }
    updateSubtotal();
    $('.product-quantity input').on('input', function () {
        updateSubtotal();
    });

    function update_price() {
        $('.cart-modal-card').each(function () {
            var card = $(this);
            var price = card.find('.product-quantity .input-field-cart-modal').data('price');
            var quantity = card.find('.product-quantity input').val();
            var linePrice = card.find('.product-line-price');

            if (!isNaN(price) && !isNaN(quantity)) {
                var product_price = price * quantity;

                linePrice.fadeOut(200, function () {
                    $(this).text(currency + ' ' + product_price.toFixed(2));
                    $(this).fadeIn(200);
                });
            }
        });
    }

    function setUrlParameter(url, paramName, paramValue) {
        paramName = paramName.replace(/\s+/g, '-')
        if (paramValue == null || paramValue == '') {
            return url
                .replace(new RegExp('[?&]' + paramName + '=[^&#]*(#.*)?$'), '$1')
                .replace(new RegExp('([?&])' + paramName + '=[^&]*&'), '$1')
        }
        var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)')
        if (url.search(pattern) >= 0) {
            return url.replace(pattern, '$1' + paramValue + '$2')
        }
        url = url.replace(/[?#]$/, '')
        return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
    }

    function buildUrlParameterValue(
        paramName,
        paramValue,
        action,
        custom_url = ''
    ) {
        if (custom_url != '') {
            var param = getUrlParameter(paramName, custom_url)
        } else {
            var param = getUrlParameter(paramName)
        }
        if (action == 'add') {
            if (param == undefined) {
                param = paramValue
            } else {
                param += '|' + paramValue
            }
            return param
        } else if (action == 'remove') {
            if (param != undefined) {
                param = param.split('|')
                param.splice($.inArray(paramValue, param), 1)
                return param.join('|')
            } else {
                return ''
            }
        }
    }

    $(document).on('change', '.product_attributes', function (e) {
        e.preventDefault()
        var attribute_name = $(this).data('attribute')
        attribute_name = 'filter-' + attribute_name
        var get_param = getUrlParameter(attribute_name)
        var current_param_value = $(this).val()
        if (get_param == undefined) {
            get_param = ''
        }
        if (this.checked) {
            var param = buildUrlParameterValue(
                attribute_name,
                current_param_value,
                'add',
                custom_url
            )
        } else {
            var param = buildUrlParameterValue(
                attribute_name,
                current_param_value,
                'remove',
                custom_url
            )
        }
        custom_url = setUrlParameter(custom_url, attribute_name, param)
    })

    function getUrlParameter(sParam, custom_url = '') {
        sParam = sParam.replace(/\s+/g, '-')
        if (custom_url != '') {
            if (custom_url.indexOf('?') > -1) {
                var sPageURL = custom_url.substring(custom_url.indexOf('?') + 1)
            } else {
                return undefined
            }
        } else {
            var sPageURL = window.location.search.substring(1)
        }

        var sURLVariables = sPageURL.split('&'),
            sParameterName,
            i

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=')

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ?
                    true :
                    decodeURIComponent(sParameterName[1])
            }
        }
    }

    if ($('#product-filters').length) {
        if (!checkUrlHasParam()) {
            sessionStorage.setItem(
                $('#product-filters').data('key'),
                $('#product-filters').val()
            )
            var filters = sessionStorage.getItem($('#product-filters').data('key'))
            filters = filters.replace(/\\/g, '')
            print_filters_desktop(filters, 'Desktop', '#product-filters-desktop')
            print_filters_mobile(filters, 'Mobile', '#product-filters-mobile')
            print_filters_mobile_value(filters, 'Mobile', '#product-filters-mobile-value')
        } else {
            if (
                sessionStorage.getItem($('#product-filters').data('key')) == undefined
            ) {
                sessionStorage.setItem(
                    $('#product-filters').data('key'),
                    $('#product-filters').val()
                )
            }
            var filters = sessionStorage.getItem($('#product-filters').data('key'))
            filters = filters.replace(/\\/g, '')
            print_filters_desktop(filters, 'Desktop', '#product-filters-desktop')
            print_filters_mobile(filters, 'Mobile', '#product-filters-mobile')
            print_filters_mobile_value(filters, 'Mobile', '#product-filters-mobile-value')
        }
    }

    function print_filters_desktop(filters, prefix = '', target) {
        var html = ''
        var attribute_values_id
        var attribute_values
        var new_attr_val
        var attr_name
        var collapse_status
        var selected_attributes
        var attr_checked_status
        var e_name
        if (filters != '') {
            $.each(JSON.parse(filters), function (i, e) {
                e_name = e.name.replace(' ', '-').toLowerCase()
                e_name = decodeURIComponent(e_name)
                attr_name = getUrlParameter('filter-' + e_name)
                collapse_status = attr_name == undefined ? ' ' : 'show'
                selected_attributes = attr_name != undefined ? attr_name.split('|') : ''
                html +=
                    ' <div class="accordion accordion-flush border-top" id="accordionFlushExample">' +
                    '<div class="accordion-item">' +
                    '<h2 class="accordion-header" id="flush-headingOne">' +
                    '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' +
                    prefix +
                    i +
                    '" aria-expanded="false" aria-controls="flush-collapseOne">' +
                    e.name +
                    '</button></h2>' +
                    '<div id="' +
                    prefix +
                    i +
                    '" class="accordion-collapse collapse ' +
                    collapse_status +
                    '" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">' +
                    '<div class="accordion-body">'
                attribute_values_id = e.attribute_values_id.split(',')
                attribute_values = e.attribute_values.split(',')

                $.each(attribute_values, function (j, v) {
                    attr_checked_status =
                        $.inArray(v, selected_attributes) !== -1 ? 'checked' : ''
                    new_attr_val = e_name + ' ' + v
                    html +=
                        '<div class="form-check d-flex ps-0">' +
                        '<input type="checkbox" name="' +
                        v +
                        '" value="' +
                        v +
                        '" class="toggle-input product_attributes width15px" id="' +
                        prefix +
                        new_attr_val +
                        '" data-attribute="' +
                        e_name +
                        '" ' +
                        attr_checked_status +
                        '> <label class="form-check-label ms-2" for="' +
                        prefix +
                        new_attr_val +
                        '">' +
                        v +
                        '</label></div>'
                })
                html += '</div>' + '</div>' + '</div>' + '</div>'
            })
        }
        $(target).html(html)
    }

    function print_filters_mobile(filters, prefix = '', target) {
        var html = ''
        var attribute_values_id
        var attribute_values
        var new_attr_val
        var attr_name
        var collapse_status
        var selected_attributes
        var attr_checked_status
        var e_name
        if (filters != '') {
            $.each(JSON.parse(filters), function (i, e) {
                e_name = e.name.replace(' ', '-').toLowerCase()
                e_name = decodeURIComponent(e_name)
                attr_name = getUrlParameter('filter-' + e_name)
                collapse_status = attr_name == undefined ? ' ' : 'show'
                selected_attributes = attr_name != undefined ? attr_name.split('|') : ''
                html +=
                    '<div class="nav flex-column nav-pills" id="' +
                    prefix +
                    i +
                    '-tab1" role="tablist" aria-orientation="vertical">' +
                    '<button class="nav-link filter-titles" id="' +
                    prefix +
                    i +
                    '-tab" data-bs-toggle="tab" data-bs-target="#' +
                    prefix +
                    i +
                    '" type="button" role="tab" aria-controls="' +
                    prefix +
                    i +
                    '" aria-selected="true">' +
                    e.name +
                    '</button></div>'
            })
        }
        $(target).html(html)
    }

    function print_filters_mobile_value(filters, prefix = '', target) {
        var html = ''
        var attribute_values_id
        var attribute_values
        var new_attr_val
        var attr_name
        var collapse_status
        var selected_attributes
        var attr_checked_status
        var e_name
        if (filters != '') {
            $.each(JSON.parse(filters), function (i, e) {
                e_name = e.name.replace(' ', '-').toLowerCase()
                e_name = decodeURIComponent(e_name)
                attr_name = getUrlParameter('filter-' + e_name)
                collapse_status = attr_name == undefined ? ' ' : 'show'
                selected_attributes = attr_name != undefined ? attr_name.split('|') : ''
                html +=
                    '<div class="tab-pane fade' +
                    collapse_status +
                    '" id="' +
                    prefix +
                    i +
                    '" role="tabpanel" aria-labelledby="' +
                    prefix +
                    i +
                    '-tab" tabindex="0">' +
                    '<div class="form-check">'

                attribute_values_id = e.attribute_values_id.split(',')
                attribute_values = e.attribute_values.split(',')

                $.each(attribute_values, function (j, v) {
                    attr_checked_status =
                        $.inArray(v, selected_attributes) !== -1 ? 'checked' : ''
                    new_attr_val = e_name + ' ' + v
                    html +=
                        '<label class="form-check-label py-2" for="' +
                        prefix +
                        new_attr_val +
                        '">' +
                        '<input type="checkbox" name="' +
                        v +
                        '" value="' +
                        v +
                        '" class="toggle-input product_attributes width15px form-check-input" id="' +
                        prefix +
                        new_attr_val +
                        '" data-attribute="' +
                        e_name +
                        '" ' +
                        attr_checked_status +
                        ">" +
                        v +
                        '</label>'
                })
                html += '</div>' + '</div>'
            })
        }
        $(target).html(html)
    }

    $('.nav-link').on('click', function () {
        // Hide all tab-panes
        $('.tab-pane').removeClass('show active');

        // Get the ID of the corresponding tab-pane
        var targetTab = $(this).attr('aria-controls');

        // Show the clicked tab-pane
        $('#' + targetTab).addClass('show active');
    });

    function checkUrlHasParam(custom_url = '') {
        if (custom_url == '') {
            custom_url = window.location.href
        }

        if (custom_url.indexOf('?') > -1) {
            return true
        } else {
            return undefined
        }
    }

    //Set URL in Product Listing Page Style buttons
    var type_url = ''
    type_url = setUrlParameter(custom_url, 'type', null)
    $('#product_grid_view_btn').attr('href', type_url)
    type_url = setUrlParameter(custom_url, 'type', 'list')
    $('#product_list_view_btn').attr('href', type_url)
    if (getUrlParameter('type') == 'list') {
        $('#product_list_view_btn').addClass('active')
    } else {
        $('#product_grid_view_btn').addClass('active')
    }

    $('.product_filter_btn').on('click', function (e) {
        e.preventDefault()
        location.href = custom_url
    })

    $('#product_sort_by').on('change', function (e) {
        e.preventDefault()
        var sort = $(this).val()
        location.href = setUrlParameter(location.href, 'sort', sort)
    })

    $('input[type=radio][name=flexRadioDefault]').on('change', function (e) {
        e.preventDefault()
        var sort = $(this).val()
        location.href = setUrlParameter(location.href, 'sort', sort)
    });

    $('#contact-us-form').on('submit', function (e) {
        e.preventDefault()
        var submit_btn_html = $('#contact-us-submit-btn').html()
        var formdata = new FormData(this)
        formdata.append(csrfName, csrfHash)
        $.ajax({
            type: 'POST',
            data: formdata,
            url: $(this).attr('action'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#contact-us-submit-btn').html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                    $('#contact-us-form')[0].reset()
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
                $('#contact-us-submit-btn').html(submit_btn_html).attr('disabled', false)
            }
        })
    })

    $(document).on('click', '.delete_user_account', function () {

        var mobile = $('#Mobile_number').val();

        var password = $('#password').val();
        $.ajax({
            type: 'POST',
            data: {
                mobile: mobile,
                password: password,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            url: base_url + 'My_account/delete_account',
            success: function (result) {
                csrfName = result['csrfName'];
                csrfHash = result['csrfHash'];
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                    window.location.href = base_url;
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
            }
        })

    })

    $(document).on('click', '.delete_social_account', function () {
        var uid = ''
        var session_user_id = document.getElementById("session_user_id").value;
        firebase.auth().onAuthStateChanged((user) => {
            if (user) {
                uid = user.uid
                user.delete().then(function () {
                    // User deleted.
                    $.ajax({
                        type: 'POST',
                        data: {
                            session_user_id: session_user_id,
                            [csrfName]: csrfHash
                        },
                        dataType: 'json',
                        url: base_url + 'My_account/delete_social_account',
                        success: function (result) {

                            csrfName = result['csrfName'];
                            csrfHash = result['csrfHash'];
                            if (result.error == false) {
                                Toast.fire({
                                    icon: 'success',
                                    title: result.message
                                })
                                location.replace(base_url);

                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: result.message
                                })
                            }
                        }
                    })


                    var ref = firebase.database().ref(
                        "users/".concat(user.uid, "/")
                    );
                    ref.remove();
                });


            } else {

            }
        });
    })

    $('.update-order-item').on('click', function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var order_item_id = $(this).data('item-id')
        var status = $(this).data('status')
        var t = $(this)
        var btn_text = t.text()
        formdata.append(csrfName, csrfHash)
        formdata.append('order_item_id', order_item_id)
        formdata.append('status', status)
        $.ajax({
            type: 'POST',
            url: base_url + 'my-account/update-order-item-status',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                t.html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {

                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
                t.html(btn_text).attr('disabled', false)
            }
        })
    })
    $('.update-order-item').on('click', function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var order_item_id = $(this).data('item-id')
        var status = $(this).data('status')
        var t = $(this)
        var btn_text = t.text()
        formdata.append(csrfName, csrfHash)
        formdata.append('order_item_id', order_item_id)
        formdata.append('status', status)
        $.ajax({
            type: 'POST',
            url: base_url + 'my-account/update-order-item-status',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                t.html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {

                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
                t.html(btn_text).attr('disabled', false)
            }
        })
    })

    $('.update-order-item').on('click', function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var order_item_id = $(this).data('item-id')
        var status = $(this).data('status')
        var t = $(this)
        var btn_text = t.text()
        formdata.append(csrfName, csrfHash)
        formdata.append('order_item_id', order_item_id)
        formdata.append('status', status)
        $.ajax({
            type: 'POST',
            url: base_url + 'my-account/update-order-item-status',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                t.html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>').attr('disabled', true);
            },
            success: function (result) {

                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: result.message
                    })
                }
                t.html(btn_text).attr('disabled', false)
            }
        })
    })

    $('.update-order').on('click', function (e) {
        e.preventDefault()
        var formdata = new FormData()
        var order_id = $(this).data('order-id')
        var status = $(this).data('status')
        var temp = ''
        if (status == 'cancelled') {
            temp = 'Cancel'
        } else {
            temp = 'Return'
        }
        if (confirm('Are you sure you want to ' + temp + ' this order ?')) {
            var t = $(this)
            var btn_text = t.text()
            formdata.append(csrfName, csrfHash)
            formdata.append('order_id', order_id)
            formdata.append('status', status)
            $.ajax({
                type: 'POST',
                url: base_url + 'my-account/update-order',
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    t.html('<div class="spinner-border" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                        '</div>').attr('disabled', true);
                },
                success: function (result) {
                    csrfName = result.csrfName
                    csrfHash = result.csrfHash
                    if (result.error == false) {
                        Toast.fire({
                            icon: 'success',
                            title: result.message
                        })
                        setTimeout(function () {
                            window.location.reload()
                        }, 3000)
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: result.message
                        })
                    }
                    t.html(btn_text).attr('disabled', false)
                }
            })
        }
    })


    // form - submit - event
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    })

    $(document).on('submit', '#send_forgot_password_otp_form', function (e) {
        e.preventDefault()
        var send_otp_btn = $('#forgot_password_send_otp_btn').html()
        var phoneNumber =
            $('#send_forgot_password_otp_form').find('.selected-dial-code').text() + $('#forgot_password_number').val()
        var response = is_user_exist($('#forgot_password_number').val())
        if (response.error == false) {
            $('#forgot_pass_error_box').html(
                'You have not registered using this number.'
            )
            $('#forgot_password_send_otp_btn')
                .html(send_otp_btn)
                .attr('disabled', false)
        } else {
            var appVerifier = window.recaptchaVerifier
            firebase
                .auth()
                .signInWithPhoneNumber(phoneNumber, appVerifier)
                .then(function (confirmationResult) {
                    resetRecaptcha()
                    $('#verify_forgot_password_otp_form').removeClass('d-none')
                    $('#send_forgot_password_otp_form').hide()
                    $('#forgot_pass_error_box').html(response.message)
                    $('#forgot_password_send_otp_btn')
                        .html(send_otp_btn)
                        .attr('disabled', false)
                    $(document).on(
                        'submit',
                        '#verify_forgot_password_otp_form',
                        function (e) {
                            e.preventDefault()
                            var reset_pass_btn_html = $('#reset_password_submit_btn').html()
                            var code = $('#forgot_password_otp').val()
                            var formdata = new FormData(this)
                            var url = base_url + 'home/reset-password'
                            $('#reset_password_submit_btn')
                                .html('Please Wait...')
                                .attr('disabled', true)
                            confirmationResult
                                .confirm(code)
                                .then(function (result) {
                                    formdata.append(csrfName, csrfHash)
                                    formdata.append('mobile', $('#forgot_password_number').val())
                                    $.ajax({
                                        type: 'POST',
                                        url: url,
                                        data: formdata,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $('#reset_password_submit_btn')
                                                .html('<div class="spinner-border" role="status">' +
                                                    '<span class="visually-hidden">Loading...</span>' +
                                                    '</div>').attr('disabled', true);
                                        },
                                        success: function (result) {
                                            csrfName = result.csrfName
                                            csrfHash = result.csrfHash
                                            $('#reset_password_submit_btn')
                                                .html(reset_pass_btn_html)
                                                .attr('disabled', false)
                                            $('#set_password_error_box').html(result.message).show()
                                            if (result.error == false) {
                                                setTimeout(function () {
                                                    $('.forget-password-section').hide()
                                                    $('.register-login-section').show()
                                                    $('.login-section').show()
                                                }, 2000)
                                            }
                                        }
                                    })
                                })
                                .catch(function (error) {
                                    $('#reset_password_submit_btn')
                                        .html(reset_pass_btn_html)
                                        .attr('disabled', false)
                                    $('#set_password_error_box')
                                        .html('Invalid OTP. Please Enter Valid OTP')
                                        .show()
                                })
                        }
                    )
                })
                .catch(function (error) {
                    $('#forgot_pass_error_box').html(error.message).show()
                    $('#forgot_password_send_otp_btn')
                        .html(send_otp_btn)
                        .attr('disabled', false)
                    resetRecaptcha()
                })
        }
    })

    $(document).on('submit', '.form-submit-event', function (e) {
        e.preventDefault()
        var formData = new FormData(this)
        var form_id = $(this).attr('id')
        var error_box = $('#error_box', this)
        var submit_btn = $(this).find('.submit_btn')
        var btn_html = $(this).find('.submit_btn').html()
        var btn_val = $(this).find('.submit_btn').val()
        var button_text =
            btn_html != '' || btn_html != 'undefined' ? btn_html : btn_val
        formData.append(csrfName, csrfHash)
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            beforeSend: function () {
                submit_btn.html('<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                    '</div>')
                submit_btn.attr('disabled', true)
                setTimeout(function () {
                    location.reload()
                }, 600)
            },
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result) {
                csrfName = result['csrfName']
                csrfHash = result['csrfHash']
                if (result['error'] == true) {

                    error_box
                        .addClass('rounded p-3 alert alert-danger')
                        .removeClass('d-none alert-success')
                    error_box.show().delay(5000).fadeOut()
                    error_box.html(result['message'])
                    submit_btn.html(button_text)
                    submit_btn.attr('disabled', false)
                    $('.form-submit-event')[0].reset()
                } else {

                    error_box
                        .addClass('rounded p-3 alert alert-success')
                        .removeClass('d-none alert-danger')
                    error_box.show().delay(3000).fadeOut()
                    error_box.html(result['message'])
                    submit_btn.html(button_text)
                    submit_btn.attr('disabled', false)
                    $('.form-submit-event')[0].reset()
                    if (form_id == 'login_form') {
                        cart_sync()
                    }
                    // setTimeout(function () {
                    //   location.reload()
                    // }, 600)
                }
            }
        })
    })

    function show_message(title, message, type) {
        // Implementation of showing a message
        console.log(`${type}: ${title} - ${message}`);
    }

    function cart_sync() {
        var cart = localStorage.getItem('cart');
        if (cart == null || !cart) {
            var message = 'Please add items to cart'
            show_message('Oops!', message, 'error')
            return
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'cart/cart_sync',
            data: {
                [csrfName]: csrfHash,
                data: cart,
                is_saved_for_later: false
            },
            dataType: 'json',
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                    localStorage.removeItem('cart')
                    return true
                }
            }
        })
    }

    function send_bank_receipt() {
        var order_id = $(this).data('order-id')
        $.ajax({
            type: 'POST',
            url: base_url + 'cart/send_bank_receipt',
            data: {
                [csrfName]: csrfHash,
                data: order_id,
            },
            dataType: 'json',
            success: function (result) {
                csrfName = result.csrfName
                csrfHash = result.csrfHash
                console.log(result);
                if (result.error == false) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                }
            }
        })
    }
    // $('#submit_btn').on('click', function () {
    //     console.log('click');
    //     var order_id = $(this).data('order-id')
    //     $.ajax({
    //         type: 'POST',
    //         url: base_url + 'cart/send_bank_receipt',
    //         data: {
    //             [csrfName]: csrfHash,
    //             order_id: order_id,
    //         },
    //         success: function (result) {
    //             csrfName = result.csrfName
    //             csrfHash = result.csrfHash
    //             console.log(result);
    //             return
    //             if (result.error == false) {
    //                 Toast.fire({
    //                     icon: 'success',
    //                     title: result.message
    //                 })
    //             }
    //         }
    //     })
    // })

    $(document).on('click', '.ticket_button', function (e) {
        $('.display_fields').removeClass('d-none')
    })
    $(document).on('click', '.ask_question', function () {

        var type = $('#ticket_type').val();
        var email = $('#email').val();
        var subject = $('#subject').val();
        var description = $('#description').val();
        var id = $('#user_id').val();

        $.ajax({
            type: 'POST',
            data: {
                ticket_type_id: type,
                email: email,
                subject: subject,
                description: description,
                user_id: id,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            url: base_url + 'Tickets/add_ticket',
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

    $(".ticket-chat-link").click(function () {
        window.location = $(this).data("href");
    });

    $('#upload').on('change', function () {
        var imagePreviewContainer = $('.image-preview-container');
        imagePreviewContainer.empty(); // Clear existing previews

        var files = this.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var imagePreview = $('<img>').addClass('chat-image-preview').attr('src', e.target.result);
                var imagePreviewtext = `<p class="m-0 text-black-50 text-center">Preview</p><ion-icon name="close-circle" class="preview-close fs-5 text-danger"></ion-icon>`
                var previewWrapper = $('<div>').addClass('preview-wrapper').append(imagePreview, imagePreviewtext);
                imagePreviewContainer.append(previewWrapper);
            };

            reader.readAsDataURL(file);
        }
    });

    $('.image-preview-container').on('click', '.preview-close', function () {
        $(this).closest('.preview-wrapper').remove();
    });

    $('#ticket_send_msg_form').on('submit', function (e) {

        var user_type = $('#user_type').val();
        var user_id = $('#user_id').val();
        var ticket_id = $('#ticket_id').val();
        var message = $('#message_input').val();
        var attachments = $('#upload').val();

        e.preventDefault()
        $('.image-preview-container').empty().hide();
        $('.image-preview-container').show();
        if (message == "" && attachments == "") {
            Toast.fire({
                icon: 'error',
                title: 'You need to add atleast one image or message'
            })
        } else {

            function load_messages(element, ticket_id) {

                var limit = element.data('limit')
                var offset = element.data('offset')

                element.data('offset', limit + offset)
                var max_loaded = element.data('max-loaded')
                var loader =
                    '<div class="loader text-center"><img src="' +
                    base_url +
                    'assets/pre-loader.gif" alt="Loading. please wait.. ." title="Loading. please wait.. ."></div>'
                $.ajax({
                    type: 'get',
                    data: 'ticket_id=' + ticket_id + '&limit=' + limit + '&offset=' + offset,
                    url: base_url + 'tickets/get_ticket_messages',
                    beforeSend: function () {
                        $('.ticket_msg').prepend(loader)
                    },
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {

                        if (result.error == false) {
                            if (result.error == false && result.data.length > 0) {
                                var messages_html = ''
                                var is_left = ''
                                var is_right = ''
                                var atch_html = ''
                                var i = 1
                                result.data.reverse().forEach(messages => {
                                    is_left = messages.user_type == 'user' ? 'left' : 'right'
                                    is_right = messages.user_type == 'user' ? 'right' : 'left'
                                    if (messages.attachments.length > 0) {
                                        messages.attachments.forEach(atch => {
                                            atch_html +=
                                                "<div class='container-fluid image-upload-section'>" +
                                                "<a class='btn btn-danger btn-xs mr-1 mb-1' href='" +
                                                atch.media +
                                                "'  target='_blank' alt='Attachment Not Found'>Attachment " +
                                                i +
                                                '</a>' +
                                                "<div class='col-md-3 col-sm-12 shadow p-3 mb-5 bg-white rounded m-4 text-center grow image d-none'></div>" +
                                                '</div>'
                                            i++
                                        })
                                    }
                                    messages_html +=
                                        "<div class='direct-chat-msg " +
                                        is_left +
                                        "'>" +
                                        "<div class='direct-chat-infos clearfix'>" +
                                        "<span class='direct-chat-name float-" +
                                        is_left +
                                        "' id='name'>" +
                                        messages.name +
                                        '</span>' +
                                        "<span class='direct-chat-timestamp float-" +
                                        is_left +
                                        "' id='last_updated'>" +
                                        messages.last_updated +
                                        '</span>' +
                                        '</div>' +
                                        "<div class='direct-chat-text' id='message'>" +
                                        messages.message +
                                        '</br>' +
                                        atch_html +
                                        '</div>' +
                                        '</div>'
                                })

                                $('.ticket_msg').prepend(messages_html)
                                $('.ticket_msg').find('.loader').remove()
                                $(element).animate({
                                    scrollTop: $(element).offset().top
                                })
                            }
                        } else {
                            element.data('offset', offset)
                            element.data('max-loaded', true)
                            $('.ticket_msg').find('.loader').remove()
                            $('.ticket_msg').prepend(
                                '<div class="text-center"> <p>You have reached the top most message!</p></div>'
                            )
                        }
                        $('#element').scrollTop(20) // Scroll alittle way down, to allow user to scroll more
                        $(element).text();
                        $(element).animate({
                            scrollTop: $(element).offset().top
                        })
                        return false
                    }
                })

            }

            // e.preventDefault()
            var formdata = new FormData(this)
            formdata.append(csrfName, csrfHash)
            $.ajax({
                type: 'POST',
                data: formdata,
                url: base_url + 'Tickets/send_message',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                success: function (result) {
                    csrfName = result.csrfName
                    csrfHash = result.csrfHash
                    if (result.error == false) {

                        var time = result['data'].last_updated;
                        if (result['data'].attachments[0] !== undefined) {

                            var image = result['data'].attachments[0].media;
                        }

                        // var img = document.createElement('img');
                        var div = $('.msg-body');
                        var ticket_id = $('#ticket_id').val();
                        load_messages(div, ticket_id);
                        var message = $('#message_input').val();
                        var last_added = $('#last_added').val();
                        var div1 = document.createElement('div')
                        var span = document.createElement('span')
                        var messagediv = document.getElementById('message-ul');

                        div1.setAttribute('class', 'text-end py-2')
                        if (image) {

                            div1.innerHTML =
                                `<div class="reply-box"><div class="reply"><img class="chat-img" src=${image}></div></div><p class="chat-send-time">${time}</p>`
                            document.getElementsByName('attachments[]')[0].value = '';

                        } else {
                            div1.innerHTML = `<div class="reply-box"><div class="reply">${message}</div></div><p class="chat-send-time">${time}</p>`
                        }

                        messagediv.append(div1)
                        document.getElementById("message_input").value = "";
                        //   window.location

                    } else {
                        $('#save-address-result')
                            .html("<div class='alert alert-danger'>" + result.message + '</div>')
                            .delay(1500)
                            .fadeOut()
                    }
                    $('#save-address-submit-btn').val('Save')
                }
            })
        }
    })

    if ($('#element').length) {
        $('#element').scrollTop($('#element')[0].scrollHeight)
        $('#element').scroll(function () {
            // var ticket_id = $(this).data('ticket_id');
            if ($('#element').scrollTop() == 0) {
                load_messages($('.ticket_msg'), ticket_id)
            }
        })

        $('#element').bind('mousewheel', function (e) {
            if (e.originalEvent.wheelDelta / 120 > 0) {
                if ($('.ticket_msg')[0].scrollHeight < 370 && scrolled == 0) {
                    load_messages($('.ticket_msg'), ticket_id)
                    scrolled = 1
                }
            }
        })
    }

});
// refer and earn code
function copyText() {
    /* Get the text to copy */
    const text = $("#text-to-copy").text();

    /* Create a temporary input element */
    const tempInput = $("<input>");
    tempInput.attr("type", "text");
    tempInput.val(text);
    $("body").append(tempInput);

    /* Select and copy the text */
    tempInput.select();
    document.execCommand("copy");

    /* Remove the temporary input element */
    tempInput.remove();

    /* Update the copy button text */
    const copyButton = $(".copy-button");
    copyButton.text("Copied!");
    setTimeout(function () {
        copyButton.text("Tap to copy");
    }, 1000);
}

$(document).on('click', '#googleLogin', function (e) {
    e.preventDefault();
    googleSignIn();
});
$(document).on('click', '#facebookLogin', function (e) {
    e.preventDefault();
    facebookSignIn();
});


$(document).on('submit', '.sign-up-form', function (e) {
    e.preventDefault()
    var countrycode = $('.selected-dial-code').html()
    $phonenumber = $('#phone-number').val()
    $username = $('input[name="username"]').val()
    $email = $('input[name="email"]').val()
    $passwd = $('input[name="password"]').val()

    $.ajax({
        type: 'POST',
        url: base_url + 'auth/register_user',
        data: {
            country_code: countrycode,
            mobile: $phonenumber,
            name: $username,
            email: $email,
            password: $passwd,
            [csrfName]: csrfHash
        },
        dataType: 'json',
        success: function (result) {
            if (result.error == true) {
                $('#sign-up-error').html(
                    '<span class="text-danger" >' + response.message + '</span>'
                )
            }
        }
    })
})


function googleSignIn() {
    var provider = new firebase.auth.GoogleAuthProvider();
    firebase.auth().signInWithPopup(provider).then(function (result) {
        var type = 'google';
        var name = result.user.displayName;
        var email = result.user.email;
        var password = result.user.uid;
        $.ajax({
            type: 'POST',
            url: base_url + 'home/verifyUser',
            data: {
                email: email,
                type: type,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            success: function (result) {
                csrfName = result['csrfName'];
                csrfHash = result['csrfHash'];
                if (result.error == true) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'auth/register_user',
                        data: {
                            type: type,
                            name: name,
                            email: email,
                            password: password,
                            [csrfName]: csrfHash
                        },
                        dataType: 'json',
                        success: function (result) {
                            csrfName = result['csrfName'];
                            csrfHash = result['csrfHash'];
                            if (result.error == false) {
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + 'home/login',
                                    data: {
                                        identity: email,
                                        type: type,
                                        password: password,
                                        [csrfName]: csrfHash
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'home/login',
                        data: {
                            identity: email,
                            type: type,
                            password: password,
                            [csrfName]: csrfHash
                        },
                        dataType: 'json',
                        success: function (result) {
                            location.reload();
                        }
                    });
                }
            }
        });
    }).catch(function (error) {
        console.log(error);
    });
}

function facebookSignIn() {
    var provider = new firebase.auth.FacebookAuthProvider();
    firebase.auth().signInWithPopup(provider).then(function (result) {
        var type = 'facebook';
        var name = result.user.displayName;
        var email = result.additionalUserInfo.profile.email;
        var password = result.user.uid;
        $.ajax({
            type: 'POST',
            url: base_url + 'home/verifyUser',
            data: {
                email: email,
                type: type,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            success: function (result) {
                csrfName = result['csrfName'];
                csrfHash = result['csrfHash'];
                if (result.error == true) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'auth/register_user',
                        data: {
                            type: type,
                            name: name,
                            email: email,
                            password: password,
                            [csrfName]: csrfHash
                        },
                        dataType: 'json',
                        success: function (result) {
                            csrfName = result['csrfName'];
                            csrfHash = result['csrfHash'];
                            if (result.error == false) {
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + 'home/login',
                                    data: {
                                        identity: email,
                                        type: type,
                                        password: password,
                                        [csrfName]: csrfHash
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'home/login',
                        data: {
                            identity: email,
                            type: type,
                            password: password,
                            [csrfName]: csrfHash
                        },
                        dataType: 'json',
                        success: function (result) {
                            location.reload();
                        }
                    });
                }
            }
        });
    }).catch(function (error) {
        console.log(error);
    });
}

// js social
if ($(".quick_view_share").length > 0)
    $(".quick_view_share").jsSocials({
        showLabel: false,
        shares: [{
            share: "facebook",
            logo: base_url + "assets/front_end/modern/ionicons/dist/ionicons/svg/logo-facebook.svg"
        }, {
            share: "whatsapp",
            logo: base_url + "assets/front_end/modern/ionicons/dist/svg/logo-whatsapp.svg"
        }, {
            share: "twitter",
            logo: base_url + "assets/front_end/modern/ionicons/dist/svg/logo-twitter.svg"
        }, {
            share: "linkedin",
            logo: base_url + "assets/front_end/modern/ionicons/dist/svg/logo-linkedin.svg"
        }]

    });


// color switcher
jQuery(document).ready(function ($) {
    $('ul.color-style .blue').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/blue.css'
        )
        return false
    })

    $('ul.color-style .cyan-dark').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/cyan-dark.css'
        )
        return false
    })

    $('ul.color-style .dark-blue').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/dark-blue.css'
        )
        return false
    })

    $('ul.color-style .dark-purple').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/dark-purple.css'
        )
        return false
    })

    $('ul.color-style .default').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/default.css'
        )
        return false
    })

    $('ul.color-style .green').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/green.css'
        )
        return false
    })

    $('ul.color-style .indigo').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/indigo.css'
        )
        return false
    })

    $('ul.color-style .orange').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/orange.css'
        )
        return false
    })

    $('ul.color-style .peach').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/peach.css'
        )
        return false
    })

    $('ul.color-style .pink').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/pink.css'
        )
        return false
    })
    $('ul.color-style .purple').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/purple.css'
        )
        return false
    })
    $('ul.color-style .red').click(function () {
        $('#color-switcher').attr(
            'href',
            base_url + 'assets/front_end/modern/css/colors/red.css'
        )
        return false
    })

    $('ul.color-style li a').click(function (e) {
        e.preventDefault()
        $(this).parent().parent().find('a').removeClass('active')
        $(this).addClass('active')
    })

    $('#colors-switcher .color-bottom a.settings').click(function (e) {
        e.preventDefault()
        var div = $('#colors-switcher')
        if (div.css(mode) === '-189px') {
            $('#colors-switcher').animate({
                [mode]: '0px'
            })
        } else {
            $('#colors-switcher').animate({
                [mode]: '-189px'
            })
        }
    })
    $('#colors-switcher').animate({
        [mode]: '-189px'
    })
})

// initiate the plugin and pass the id of the div containing gallery images
$(".zoom_03").elevateZoom({
    gallery: 'gallery_01',
    cursor: 'pointer',
    easing: true,
    // scrollZoom:true,
    galleryActiveClass: 'active',
    imageCrossfade: true,
    borderSize: 2,
    loadingIcon: 'https://www.elevateweb.co.uk/spinner.gif'
});

// $(document).on('opening', '.register-login-section', function (e) {
$(this).removeClass('d-none')
// e.preventDefault()
// closeNav()
// $('.send-otp-form')[0].reset()
$('.send-otp-form').show()
$('#verify-otp-form').addClass('d-none');
// $('.sign-up-form')[0].reset()
$('.sign-up-form').hide()
$('#is-user-exist-error').html('')
$('#sign-up-error').html('')

if ($('#recaptcha-container').length > 0) {
    $('#recaptcha-container').html('')
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container')
    window.recaptchaVerifier.render().then(function (widgetId) {
        grecaptcha.reset(widgetId)
    })
}

var telInput = $('#phone-number'),
    errorMsg = $('#error-msg'),
    validMsg = $('#valid-msg')

// initialise plugin
telInput.intlTelInput({
    allowExtensions: true,
    formatOnDisplay: true,
    autoFormat: true,
    autoHideDialCode: true,
    autoPlaceholder: true,
    defaultCountry: 'in',
    ipinfoToken: 'yolo',

    nationalMode: false,
    numberType: 'MOBILE',
    preferredCountries: ['in', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
    preventInvalidNumbers: true,
    separateDialCode: true,
    initialCountry: 'auto',
    geoIpLookup: function (callback) {
        $.get('https://ipinfo.io', function () {}, 'jsonp').always(function (
            resp
        ) {
            var countryCode = resp && resp.country ? resp.country : ''
            callback(countryCode)
        })
    },
    utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js'
})

var reset = function () {
    telInput.removeClass('error')
    errorMsg.addClass('hide')
    validMsg.addClass('hide')
}

// on blur: validate
telInput.blur(function () {
    reset()
    if ($.trim(telInput.val())) {
        if (telInput.intlTelInput('isValidNumber')) {
            validMsg.removeClass('hide')
        } else {
            telInput.addClass('error')
            errorMsg.removeClass('hide')
        }
    }
})
// on keyup / change flag: reset
telInput.on('keyup change', reset)
// })
$('.forget-password-section').hide()
$('.cancel-btn-forget-password').on('click', function () {
    $('.register-login-section').show()
    $('.forget-password-section').hide()
})

$(document).on('click', '#forgot_password_link', function (e) {
    e.preventDefault()
    $('.forget-password-section').fadeIn(300)
    $('.register-login-section').hide()
    $('#forgot_password_div')
        .removeClass('hide')
        .siblings('section')
        .addClass('hide')
    if ($('#recaptcha-container-2').length > 0) {
        $('#recaptcha-container-2').html('')
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
            'recaptcha-container-2'
        )
    }
    window.recaptchaVerifier.render().then(function (widgetId) {
        grecaptcha.reset(widgetId)
    })
    var telInput = $('#forgot_password_number')
    // initialise plugin
    telInput.intlTelInput({
        allowExtensions: true,
        formatOnDisplay: true,
        autoFormat: true,
        autoHideDialCode: true,
        autoPlaceholder: true,
        defaultCountry: 'in',
        ipinfoToken: 'yolo',

        nationalMode: false,
        numberType: 'MOBILE',
        preferredCountries: ['in', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
        preventInvalidNumbers: true,
        separateDialCode: true,
        initialCountry: 'auto',
        geoIpLookup: function (callback) {
            $.get('https://ipinfo.io', function () {}, 'jsonp').always(function (
                resp
            ) {
                var countryCode = resp && resp.country ? resp.country : ''
                callback(countryCode)
            })
        },
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js'
    })
})

/**
 * Set up UI event listeners and registering Firebase auth listeners.
 */
window.onload = function () {
    // Event bindings.
    $('#send-otp-form').on('submit', onSignInSubmit);
    $('#phone-number').on('keyup change', updateSignInButtonUI);

    var offerPopupValue = $("#offer_popup_value").val();
    if (offerPopupValue === "refresh" || offerPopupValue === "session_storage") {
        $("#offer_popup").modal("show");
    }
}

/**
 * Function called when clicking the Login/Logout button.
 */
$("#send-otp-form").validate({
    rules: {
        mobileNumber: {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
        }
    }
});

function onSignInSubmit(e) {
    e.preventDefault();

    var recaptchaResponse = grecaptcha.getResponse();
    if (!recaptchaResponse) {
        $('#recaptcha-error').html('Please complete the reCAPTCHA.');
        return;
    }

    if (isPhoneNumberValid()) {
        $('#send-otp-button').html('Please Wait...');
        var response = is_user_exist();
        updateSignInButtonUI();

        if (response.error == true) {
            $('#is-user-exist-error').html(response.message);
            $('#send-otp-button').html('Send OTP');
        } else {
            window.signingIn = true;

            var phoneNumber = getPhoneNumberFromUserInput();
            var appVerifier = window.recaptchaVerifier;

            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then(function (confirmationResult) {
                    $('#send-otp-button').html('Send OTP');
                    // $('.send-otp-form').unblock();
                    window.signingIn = false;
                    updateSignInButtonUI();
                    resetRecaptcha();
                    $('#send-otp-form').hide();
                    $('#otp_div').show();
                    $('#verify-otp-form').removeClass('d-none');

                    $(document).on('submit', '#verify-otp-form', function (e) {
                        e.preventDefault()
                        $('#registration-error').html('')
                        var code = $('#otp').val()
                        var formdata = new FormData(this)
                        var url = $(this).attr('action')
                        $('#register_submit_btn')
                            .html('Please Wait...')
                        confirmationResult
                            .confirm(code)
                            .then(function (result) {
                                formdata.append(csrfName, csrfHash)
                                formdata.append('mobile', $('#phone-number').val())
                                formdata.append('country_code', $('.selected-dial-code').text())
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    data: formdata,
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    dataType: 'json',
                                    beforeSend: function () {
                                        $('#register_submit_btn')
                                            .html('<div class="spinner-border" role="status">' +
                                                '<span class="visually-hidden">Loading...</span>' +
                                                '</div>').attr('disabled', true);
                                    },
                                    success: function (result) {
                                        csrfName = result.csrfName
                                        csrfHash = result.csrfHash
                                        $('#register_submit_btn')
                                            .html('Submit')
                                        $('#registration-error').html(result.message).show()
                                        $('.registration-section').hide()
                                        $('.login-section').show()
                                    }
                                })
                            })
                            .catch(function (error) {
                                $('#register_submit_btn')
                                    .html('Please Wait...')
                                $('#registration-error')
                                    .html('Invalid OTP. Please Enter Valid OTP')
                                    .show()
                                $('#register_submit_btn')
                                    .html('Submit')
                            })
                    })

                })
                .catch(function (error) {
                    window.signingIn = false;
                    $('#is-user-exist-error').html(error.message).show();
                    $('#send-otp-button').html('Send OTP');
                    updateSignInButtonUI();
                    resetRecaptcha();
                });
        }
    }
}

//Gallery Swiper
// var galleryThumbs = new Swiper('.gallery-thumbs-1', {
//     spaceBetween: 10,
//     slidesPerView: 4,
//     freeMode: true,
//     watchSlidesVisibility: true,
//     watchSlidesProgress: true
// })
var galleryTop = new Swiper('.gallery-top-1', {
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    }
})

//preview-image-swiper
var swiperF = new Swiper('.preview-image-swiper', {
    pagination: {
        el: '.preview-image-swiper-pagination'
    }
})

$(document).on('click', '#resend-otp', function (e) {

    e.preventDefault()
})
/**
 * Reads the phone number from the user input.
 */
function getPhoneNumberFromUserInput() {
    var countrycode = $('.selected-dial-code').html()
    var phonenumber = $('#phone-number').val()
    return countrycode + phonenumber
}

/**
 * Returns true if the phone number is valid.
 */
function isPhoneNumberValid() {
    var pattern = /^\+[0-9\s\-\(\)]+$/
    var phoneNumber = getPhoneNumberFromUserInput()
    return phoneNumber.search(pattern) !== -1
}

/**
 * This resets the recaptcha widget.
 */
function resetRecaptcha() {
    return window.recaptchaVerifier.render().then(function (widgetId) {
        grecaptcha.reset(widgetId)
    })
}

/**
 * Updates the Sign-in button state depending on ReCaptcha and form values state.
 */
function updateSignInButtonUI() {}

function is_user_exist(phone_number = '') {
    if (phone_number == '') {
        var phoneNumber = $('#phone-number').val()
    } else {
        var phoneNumber = phone_number
    }
    var response
    $.ajax({
        type: 'POST',
        async: false,
        url: base_url + 'auth/verify_user',
        data: {
            mobile: phoneNumber,
            [csrfName]: csrfHash
        },
        dataType: 'json',
        success: function (result) {
            csrfName = result['csrfName']
            csrfHash = result['csrfHash']
            response = result
        }
    })
    return response
}

(function ($) {
    "use strict";

    $(document).ready(function () {
        "use strict";

        //Scroll back to top

        var progressPath = document.querySelector('.progress-wrap path');
        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
        progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
        var updateProgress = function () {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength / height);
            progressPath.style.strokeDashoffset = progress;
        }
        updateProgress();
        $(window).scroll(updateProgress);
        var offset = 50;
        var duration = 550;
        jQuery(window).on('scroll', function () {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.progress-wrap').addClass('d-block active-progress');
                jQuery('.progress-wrap').removeClass('d-none');
            } else {
                jQuery('.progress-wrap').removeClass('active-progress');
                jQuery('.progress-wrap').addClass('d-none');
            }
        });
        jQuery('.progress-wrap').on('click', function (event) {
            event.preventDefault();
            jQuery('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        })


    });

})(jQuery);