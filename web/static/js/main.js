
$( document ).ready(function(){

    var $cashIn = $("#balance"),
        cash = parseInt($cashIn.val())|0
    ;

    //put in cash
    $('.putInCash').click(function(e){
        var cid = $(this).attr("data-coin"),
            worth = parseInt($(this).attr("data-worth"))|0,
            $uwc = $('#uw' + cid),
            $vmc = $('#vmw' + cid)
        ;

        num = parseInt($uwc.text())|0;
        if( num > 0 ){

            $.ajax({
                method: 'POST'
                ,url: 'spent-money'
                ,data: { money: worth, cid: cid }
            })
            .done(function( response ){
                if( response.result ){

                    cash = cash + worth;

                    //update number of coins in user's wallet
                    $uwc.text( num - 1 );

                    //update cash amount in vm
                    $cashIn.val( cash );

                    //update number of coins in vm's wallet
                    $vmc.text( parseInt($vmc.text()) + 1 );

                    $message.text('');
                }
            })
            .fail(function( response ){
                console.log('FAIL');
                console.log(response);
            });
        }

        return false;
    });

    //buy goods
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

                    cash = cash - price;

                    //update number of goods in vm
                    num = parseInt($num.text())|0;
                    $num.text( num - 1 );

                    //update cash amount in vm
                    $cashIn.val( cash );

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

    //get money back
    $('#btn').click(function(e){

        $.ajax({
            method: 'POST'
            ,url: 'get-money-back'
            ,data: { amount: $cashIn.val() }
        })
        .done(function( response ){
            if( response.result ){

                //update number of coins in vm wallet
                var data = response.data;
                for(var i=0; i<data.length; i++){
                    if( data[i]['num'] > 0 ){
                        $uc = $('#uw'+data[i]['cid']);
                        $uc.text( parseInt($uc.text()) + data[i]['num'] );
                    }
                }

                //update cash amount in vm
                $cashIn.val(0);

                $message.text('');
            }
        })
        .fail(function( response ){
            console.log('FAIL');
            console.log(response);
        });

        return false;
    });
});
