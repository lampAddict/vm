
$( document ).ready(function(){

    var $cashIn = $("#balance"),
        cash = $cashIn.val()
    ;

    $('.putInCash').click(function(e){
        var cid = $(this).attr("data-coin"),
            worth = parseInt($(this).attr("data-worth"))|0,
            $num =  $('#uw'+cid)
        ;

        num = parseInt($num.text())|0;
        if( num > 0 ){

            $.ajax({
                method: 'POST'
                ,url: 'spent-money'
                ,data: { money: worth, cid: cid }
            })
            .done(function( response ){
                if( response.result ){

                    cash = cash + worth;

                    $num.text( num - 1 );

                    $cashIn.val( cash );
                }
            })
            .fail(function( response ){
                console.log('FAIL');
                console.log(response);
            });
        }

        return false;
    });


    $('.buyIt').click(function(e){

        var gid = $(this).attr("data-good"),
            price = parseInt($(this).attr("data-price"))|0,
            $num =  $('#vm'+gid),
            $message = $("#status")
        ;

        if( cash >= price ){

            $.ajax({
                method: 'POST'
                ,url: 'buy'
                ,data: { goods: gid }
            })
            .done(function( response ){
                if( response.result ){

                    num = parseInt($num.text())|0;
                    $num.text( num - 1 );

                    $cashIn.val( cash - price );

                    $message.text('Спасибо!');
                }
            })
            .fail(function( response ){
                console.log('FAIL');
                console.log(response);
            });
        }
        else{
            $message.text('Недостаточно средств');
        }

        return false;
    });
});
