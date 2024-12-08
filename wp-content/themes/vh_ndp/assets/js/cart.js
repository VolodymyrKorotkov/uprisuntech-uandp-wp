$= jQuery

$(document).ready(function (){
    $(document).on('click','.cart-table__delete button,.cart-dropdown__item__delete', function(){
        let url=$(this).attr('data-remove');
        $.get({
            url:url,
            success:function (){
                $('.cart-table').load(window.location.href +' tbody');
                $('.cart__header').load(window.location.href +' .cart__item__amount, .cart__title');
                $('.cart-dropdown__overlay').load(window.location.href +' .cart-dropdown__overlay>.cart-dropdown');

                $('.static-nav__button__application span').load(window.location.href +' .static-nav__item__application span p');

            }

        })
    });

     function updatequantity(el) {
        let cart_item_key = $(el).data("cart-item-key");
        let quantity = $(el).val();  // предположим, что у вас есть поле ввода с классом "quantity-input" рядом с кнопкой
         $.post(ajaxurl, {
                action: "update_cart_item_quantity_callback",
                cart_item_key: cart_item_key,
                quantity: quantity
            }, function(response) {
                if(response.success) {
                    // Обновите интерфейс или сообщите пользователю об успешном обновлении
                } else {
                    console.log(response.message);
                }
                $('.cart__header').load(window.location.href +' .cart__item__amount, .cart__title');
                $('.cart-dropdown__header__text').load(window.location.href +' .cart-dropdown__title, .cart-dropdown__item__amount');
                response = JSON.parse(response);
                if (response.hasOwnProperty('total_items')) {
                    $('.cart-total_items').text(response.total_items)
                }
            })
        }

    $(document).on('click','.cart-table__amount__plus,.cart-dropdown__item__plus',function (){
           let stock= +$(this).prev().val();
            $(this).parent().find('.btn-disabled').removeClass('btn-disabled')
            $(this).prev().val(stock+1);
            updatequantity($(this).prev().get(0));
        });
    $(document).on('click','.cart-table__amount__minus,.cart-dropdown__item__minus',function (){

        let stock= $(this).next().val();
        if (stock==1){
            return;
        }
        if (stock==2){
            $(this).addClass('btn-disabled');
        }
        $(this).next().val(stock-1);
        updatequantity($(this).next().get(0));
    });
    
    $( document.body ).on( 'added_to_cart', function(){
       $('.static-nav__button__application span').load(window.location.href +' .static-nav__item__application span p');

        $('.cart-dropdown__overlay').load(window.location.href +' .cart-dropdown__overlay>.cart-dropdown');
        let text = 'Item added to the solution';
        let $cartDropdownBlock = $('.cart-dropdown-block');
        if ($cartDropdownBlock.length && $cartDropdownBlock.attr('data-item-added') !== '') {
            text = $cartDropdownBlock.attr('data-item-added');
        }
        productAddedMessage(text);
    });

});

function productAddedMessage(text='') {
    if (!text) return;

    const added = '<div class="added-block"><span></span> <i class="bt-close"></i></div>';

    let $added = $(added);
    $added.addClass('visible');
    $added.find('span').text(text);
    let bottom = 20;
    let height = parseInt($(window).height());

    if ($('.added-block').length) {
        let $last = $('.added-block:last');
        bottom = parseInt($last.css('bottom'),10) + 64;
        if (bottom > height) {
            bottom = 20;
        }
    }
    $added.css('bottom', bottom);
    $('body').append($added);

    setTimeout(function() {
        $added.remove()
    }, 3000)

    $('.bt-close').one('click', function(event) {
        $(event.target).closest('.added-block').remove();
    });

}


