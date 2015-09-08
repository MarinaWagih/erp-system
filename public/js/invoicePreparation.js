$(document).ready(function () {
    var record = [];
    var itemsajax = [];
    var item = 0;
    function calculateItemTotal()
    {
        var itemQuantity = $('#quantity').val();
        var itemPrice = $('#item_price').val();
        var itemDiscount_percentage = $('#discount_percentage').val();
        var total=(itemPrice - (itemPrice * itemDiscount_percentage) / 100) * itemQuantity;
        total=total.toFixed(3)
        //console.log(total);
       return total;
    }
    $(function () {
        $("#date").datepicker();
    });

    $("#clients").select2({
        dir: "rtl",
        ajax: {
            url: "/client/ajax_search",

            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    query: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, page) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data

                return {

                    results: data
                };
            },
            cache: true
        },
//            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1
//            templateResult: formatRepo, // omitted for brevity, see the source of this page
//            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });

    $("#items_list").select2({
        dir: "rtl",
        ajax: {
            url: "/item/ajax_search",

            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    query: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, page) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data

                return {

                    results: data
                };
            },
            cache: true
        },
//            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1
//            templateResult: formatRepo, // omitted for brevity, see the source of this page
//            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
    //to work with bootstrap.js
    $('#items_list').on("change", function () {
        var $container = $(this).prev(".select2-container");
        $container.height($container.children(".select2-choices").height());
    });

    $('#items_list').on("select2:select", function (e) {
       // console.log("select2:select", e.params.data);
        itemsajax[e.params.data.id]=e.params.data;
        $('#item_price').val(e.params.data.price_1050);

        item=e.params.data.id;
        console.log(itemsajax);
    });

    $('#item_price').on('change',function(){
        $('#total_item').html( calculateItemTotal());
    });
    $('#quantity').on('change',function(){

        $('#total_item').html( calculateItemTotal());
    });
    $('#discount_percentage').on('change',function(){

        $('#total_item').html( calculateItemTotal());
    });
    $('#item_add').click(function () {

        var itemId = $('#items_list').val();
        var itemQuantity = $('#quantity').val();
        var itemPrice = $('#item_price').val();
        var itemDiscount_percentage = $('#discount_percentage').val();
        record[itemId] = itemId + ',' + itemQuantity + ',' + itemPrice + ',' + itemDiscount_percentage;
        var table_show = '<tr id="' + itemId + '">';
        table_show += '<td>';
        table_show += calculateItemTotal();
        table_show += '</td>';
        table_show += '<td>';
        table_show += (itemPrice - (itemPrice * itemDiscount_percentage) / 100);
        table_show += '</td>';
        table_show += '<td>';
        table_show += itemDiscount_percentage;
        table_show += '</td>';
        table_show += '<td>';
        table_show += itemPrice;
        table_show += '</td>';
        table_show += '<td>';
        table_show += itemQuantity;
        table_show += '</td>';
        table_show += '<td>';
        table_show += '<img src="/images/'+itemsajax[itemId].picture+'">';
        table_show += '</td>';
        table_show += '<td>';
        table_show += itemsajax[itemId].text;
        table_show += '</td>';
        table_show += '<td>';
        table_show += itemsajax[itemId].id;
        table_show += '</td>';
        table_show += '</tr>';
        $('#tableBody').append(table_show);
        var text1=$('#items').val()+'=+='+record[itemId];
       alert(text1);
        $('#items').val(text1);
        //i++;

    });

});