$(document).ready(function () {
    var record = [];
    var itemsajax = {};
    var item_to_add={};
    var item = 0;
    //$('#items').val('');
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
    function boardcalc()
    {
        var Total_invoice_before_discount=0;
        var Total_invoice_after_discount=0;
        $.each(item_to_add, function( index, value ){
            Total_invoice_before_discount += value.price * value.quantity;
            Total_invoice_after_discount += (value.price-
                (value.price * value.discount_percent)/100)*value.quantity;
        });
        $('#Total_invoice_before_discount').html(Total_invoice_before_discount.toFixed(3));
        $('#Total_invoice_after_discount').html(Total_invoice_after_discount.toFixed(3));
        $('#Total_additional_discount').html(
            (Total_invoice_after_discount-(Total_invoice_after_discount*
            parseInt($('#Total_invoice_discount').val())/100)).toFixed(3)
        );
        if( $('#tax_check').is(':checked') )
        {
            // alert($('#Total_additional_discount').html());
            var total= (Total_invoice_after_discount-(Total_invoice_after_discount*
            parseInt($('#Total_invoice_discount').val())/100));
            var taxes=(total+(total*10/100)).toFixed(3);
            // alert(taxes);
            $('#Total_after_taxes').html(taxes);
            $('#total_after_sales_tax').val(taxes);
        }
        else
        {
            $('#Total_after_taxes').html('0.000');
            $('#total_after_sales_tax').val('');
        }

    }
    function buildTable()
    {
        $.each(item_to_add, function( index, value ){

            var table_show = '';
            table_show+='<td class="delete_item" id="x-'+index+'">'+"مسح"+'</td>';
            table_show += '<td>';
            table_show += ((value.price - (value.price * value.discount_percent) / 100)*value.quantity).toFixed(3);
            table_show += '</td>';
            table_show += '<td>';
            table_show += ((value.price - (value.price * value.discount_percent) / 100)).toFixed(3);
            table_show += '</td>';
            table_show += '<td>';
            table_show += value.discount_percent;
            table_show += '</td>';
            table_show += '<td>';
            table_show += value.price;
            table_show += '</td>';
            table_show += '<td>';
            table_show += value.quantity;
            table_show += '</td>';
            table_show += '<td>';
            table_show += '<img src="/images/'+itemsajax[index].picture+'" style="height: 50px;width:50px" >';
            table_show += '</td>';
            table_show += '<td>';
            table_show += itemsajax[index].text;
            table_show += '</td>';
            table_show += '<td>';
            table_show += index;
            table_show += '</td>';

            $('#'+index).html(table_show);
        });
    }
    function doAjax()
    {
        $.each(item_to_add, function( index, value ){

            $.ajax({url:'/item/search_by_id',
                data: {
                    query: index, // search term
                    price_type:$('#price_type').val()
                },
                dataType: 'json',
                success: function (data)
                {
//                                        console.log(data);
                    item_to_add[index].price=data[0].price
                    console.log(item_to_add);
                    buildTable();
                    boardcalc();
                    $('#items').val(JSON.stringify(item_to_add));
                }
            });
        });
//                    buildTable();
    }
    function changeDiscount()
    {
        $.each(item_to_add, function( index, value )
        {
            console.log(value.discount_percent);
            item_to_add[index].discount_percent=$('#discount_percentage').val();
            console.log(value.discount_percent);
            buildTable();
            boardcalc();
        });
    }
    //date picker
    $(function () {
        $("#date").datepicker({
            dateFormat: 'yy-mm-dd'
        })
                  .datepicker('setDate', new Date());
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
                    page: params.page,
                    price_type:$('#price_type').val()
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
       //console.log("select2:select", e.params.data);
        itemsajax[e.params.data.id]=e.params.data;
        //alert('added to array');
        $('#item_price').val(e.params.data.price);
        //alert('price in price');
        item=e.params.data.id;
        //alert(item);
        console.log(itemsajax);
    });

    $('#item_price').on('change',function(){
        $('#total_item').html( calculateItemTotal());

    });

    $('#Total_invoice_discount').on('change',function(){
        //$('#total_item').html( calculateItemTotal());
       var total= parseInt($('#Total_invoice_after_discount').html());
       var discount=$(this).val();
       var result=total-(total*discount/100);
       $('#additional_discount_value').html(total*discount/100);
       $('#Total_additional_discount').html(result);
        if( $('#tax_check').is(':checked') )
        {
            // alert($('#Total_additional_discount').html());
            var total=result;
            var taxes=(total+(total*10/100)).toFixed(3);
            // alert(taxes);
            $('#Total_after_taxes').html(taxes);
            $('#total_after_sales_tax').val(taxes);
        }
        else
        {
            $('#Total_after_taxes').html('0.000');
            $('#total_after_sales_tax').val('');
        }

    });

    $('#quantity').on('change',function(){

        $('#total_item').html( calculateItemTotal());
    });

    $('#discount_percentage').on('change',function(){

        $('#total_item').html( calculateItemTotal());
        changeDiscount();
    });

    $('#item_add').click(function () {

        var itemId = $('#items_list').val();
        var itemQuantity = $('#quantity').val();
        var itemPrice = $('#item_price').val();
        var itemDiscount_percentage = $('#discount_percentage').val();
        if(parseInt(itemQuantity) > 0 && parseFloat(itemPrice) > 0)
        {
            if(item_to_add.hasOwnProperty(itemId))
            {
                item_to_add[itemId].quantity=parseInt(itemQuantity);
                item_to_add[itemId].price=itemPrice;
                item_to_add[itemId].discount_percent=itemDiscount_percentage;
                itemQuantity=item_to_add[itemId].quantity;
                record[itemId] = itemId + ',' + itemQuantity + ',' + itemPrice + ',' + itemDiscount_percentage;
                var table_show = '';
                table_show+='<td class="delete_item" id="x-'+itemId+'">'+"مسح"+'</td>';
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
                table_show += '<img src="/images/'+itemsajax[itemId].picture+'" style="height: 50px;width:50px" >';
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].text;
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].id;
                table_show += '</td>';

                $('#'+itemId).html(table_show);
            }
            else
            {
                item_to_add[itemId]={
                                      price:itemPrice,
                                      discount_percent:itemDiscount_percentage,
                                      quantity:parseInt(itemQuantity)
                                        };
                record[itemId] = itemId + ',' + itemQuantity + ',' + itemPrice + ',' + itemDiscount_percentage;
                var table_show = '<tr id="' + itemId + '">';
                table_show+='<td class="delete_item" id="x-'+itemId+'">'+"مسح"+'</td>';
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
                table_show += '<img src="/images/'+itemsajax[itemId].picture+'" style="height: 50px;width:50px" >';
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].text;
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].id;
                table_show += '</td>';
                table_show += '</tr>';
                $('#tableBody').append(table_show);
                $('#'+itemId).dblclick(function() {
                    //alert('double click');
                    $('#itemFormModel').modal();
                    var id=$(this).attr('id');
                    //alert(id);
                    console.log(itemsajax[id]);
                    $('#items_list').select2('val',id);
                    //$('#items_list').text(itemsajax[id].text);
                    $('#quantity').val(item_to_add[id].quantity);
                    $('#item_price').val(item_to_add[id].price);
                    $('#discount_percentage').val(item_to_add[id].discount_percent);
                    $('#total_item').html( calculateItemTotal());

                });
                $('#x-'+itemId).dblclick(function(){
                    var id_of_deleted_item=$(this).attr('id');
                    var id=id_of_deleted_item.split('-')[1];
                    //$('#'.id).hide();
                    $(this).parent().remove();
                    delete item_to_add[id];
//                           console.log(item_to_add);
                    $('#items').val(JSON.stringify(item_to_add));
                    boardcalc();
                });
            }

            $('#items').val(JSON.stringify(item_to_add));
        }
        else
        {
            alert('الكمية او السعر ب صفر ');
        }
        boardcalc()
        //i++;

    });

    $('#item_add_end').click(function () {

        var itemId = $('#items_list').val();
        var itemQuantity = $('#quantity').val();
        var itemPrice = $('#item_price').val();
        var itemDiscount_percentage = $('#discount_percentage').val();
        if(parseInt(itemQuantity) > 0 && parseFloat(itemPrice) > 0)
        {
            if(item_to_add.hasOwnProperty(itemId))
            {
                item_to_add[itemId].quantity=parseInt(itemQuantity);
                item_to_add[itemId].price=itemPrice;
                item_to_add[itemId].discount_percent=itemDiscount_percentage;
                itemQuantity=item_to_add[itemId].quantity;
                record[itemId] = itemId + ',' + itemQuantity + ',' + itemPrice + ',' + itemDiscount_percentage;
                var table_show = '';
                table_show+='<td class="delete_item" id="x-'+itemId+'">'+"مسح"+'</td>';
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
                table_show += '<img src="/images/'+itemsajax[itemId].picture+'" style="height: 50px;width:50px" >';
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].text;
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].id;
                table_show += '</td>';

                $('#'+itemId).html(table_show);
            }
            else
            {
                item_to_add[itemId]={
                                      price:itemPrice,
                                      discount_percent:itemDiscount_percentage,
                                      quantity:parseInt(itemQuantity)
                                        };
                record[itemId] = itemId + ',' + itemQuantity + ',' + itemPrice + ',' + itemDiscount_percentage;
                var table_show = '<tr id="' + itemId + '">';
                table_show+='<td class="delete_item" id="x-'+itemId+'">'+"مسح"+'</td>';
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
                table_show += '<img src="/images/'+itemsajax[itemId].picture+'" style="height: 50px;width:50px" >';
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].text;
                table_show += '</td>';
                table_show += '<td>';
                table_show += itemsajax[itemId].id;
                table_show += '</td>';
                table_show += '</tr>';
                $('#tableBody').append(table_show);
                $('#'+itemId).dblclick(function() {
                    //alert('double click');
                    $('#itemFormModel').modal();
                    var id=$(this).attr('id');
                    //alert(id);
                    console.log(itemsajax[id]);
                    $('#items_list').select2('val',id);
                    //$('#items_list').text(itemsajax[id].text);
                    $('#quantity').val(item_to_add[id].quantity);
                    $('#item_price').val(item_to_add[id].price);
                    $('#discount_percentage').val(item_to_add[id].discount_percent);
                    $('#total_item').html( calculateItemTotal());

                });
                $('#x-'+itemId).dblclick(function(){
                    var id_of_deleted_item=$(this).attr('id');
                    var id=id_of_deleted_item.split('-')[1];
                    //$('#'.id).hide();
                    $(this).parent().remove();
                    delete item_to_add[id];
//                           console.log(item_to_add);
                    $('#items').val(JSON.stringify(item_to_add));
                    boardcalc();
                });
            }

            $('#items').val(JSON.stringify(item_to_add));
            $('#itemFormModel').modal('hide');
        }
        else
        {
            alert('الكمية او السعر ب صفر ');
        }
        boardcalc()
        //i++;

    });

    $('input:radio[name="type"]').change(function(){
            var price='سعر';
            if (this.checked && this.value == 'buy')
            {

               var options='<option value="price_32_b">32 b'+price+' </option>'+
                ' <option value="price_31_a">31 a '+price+'</option>';
                $('#price_type').html(options);
                doAjax();
                changeDiscount();
                boardcalc();
            }
            else if (this.checked && this.value == 'sell')
            {
                var options='<option value="price_1050">1050 '+price+'</option>'+
                   ' <option value="price_1250">1250 '+price+'</option>'+
            '<option value="price_1034">1034 '+price+'</option>';
                $('#price_type').html(options);
                doAjax();
                changeDiscount();
                boardcalc();
            }
        var type=$('#price_type').val();
        switch (type)
        {
            case 'price_1050':
                $('#discount_percentage').val(20);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',28);
                $('#discount_percentage').removeAttr('disabled');
//                                alert('1050');
                break;
            case 'price_1250':
                $('#discount_percentage').val(20);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',28);
                $('#discount_percentage').removeAttr('disabled');

                break;
            case 'price_1034':
                $('#discount_percentage').val(0);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',0);
                $('#discount_percentage').attr('disabled','true');
                break;
            case 'price_31_a':
                $('#discount_percentage').val(0);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',0);
                $('#discount_percentage').attr('disabled','true');
//                            $('#discount_percentage').attr('hidden','true');
                break;
            case 'price_32_b':
                $('#discount_percentage').val(0);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',0);
                $('#discount_percentage').attr('disabled','true');
//                            $('#discount_percentage').attr('hidden','true');
                break;
        }
        doAjax();
        changeDiscount();
        boardcalc();
        });

    $('#tax_check').click( function(){
        if( $(this).is(':checked') )
        {
           // alert($('#Total_additional_discount').html());
            var total=parseInt($('#Total_additional_discount').html());
            var taxes=(total+(total*10/100)).toFixed(3);
           // alert(taxes);
            $('#Total_after_taxes').html(taxes);
            $('#total_after_sales_tax').val(taxes);

        }
        else
        {
            $('#Total_after_taxes').html('0.000');
            $('#total_after_sales_tax').val('');
        }
    });

    $('.delete_item').dblclick(function(){
        var id_of_deleted_item=$(this).attr('id');
        var id=id_of_deleted_item.split('-')[1];
        $('#'.id).hide();
        $(this).parent().remove();
        delete item_to_add[id];
//                           console.log(item_to_add);
        $('#items').val(JSON.stringify(item_to_add));
        boardcalc();
    });

    $('#price_type').on('change',function(){

        var type=$(this).val();
        switch (type)
        {
            case 'price_1050':
                $('#discount_percentage').val(20);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',28);
                $('#discount_percentage').removeAttr('disabled');
//                                alert('1050');
                break;
            case 'price_1250':
                $('#discount_percentage').val(20);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',28);
                $('#discount_percentage').removeAttr('disabled');

                break;
            case 'price_1034':
                $('#discount_percentage').val(0);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',0);
                $('#discount_percentage').attr('disabled','true');
                break;
            case 'price_31_a':
                $('#discount_percentage').val(0);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',0);
//                            $('#discount_percentage').attr('disabled','true');
                $('#discount_percentage').attr('hidden','true');
                break;
            case 'price_32_b':
                $('#discount_percentage').val(0);
                $('#discount_percentage').attr('min',0);
                $('#discount_percentage').attr('max',0);
//                            $('#discount_percentage').attr('disabled','true');
                $('#discount_percentage').attr('hidden','true');
                break;
        }
        doAjax();
        changeDiscount();
        boardcalc();


    });

    $('#submit').on('click',function (e){
        var flag=false;
        var discount=$('#discount_percentage').val();
        var total_discount=$('#Total_invoice_discount').val();
        var total=parseInt(discount)+parseInt(total_discount);
        var client=$('#client_id').val();
        var date=$('#date').val();
        var msg='';
        if(total>28)
        {
            flag=true;
            msg +='<div>مجموع نسب الخصم لا يجب ان يتعدي ٢٨ ٪ </div>';

        }else{flag=false;}
        if(client==undefined)
        {
            flag=true;
            msg +='<div> العميل إجباري</div>';
        }else{flag=false;}
        if(date=='')
        {
            flag=true;
            msg +='<div> التاريخ إجباري</div>';
        }else{flag=false;}
        if(flag)
        {
            e.preventDefault();
            $('#msg').addClass(" alert alert-danger");
            $('#msg').html('<strong>هناك خطأ</strong>');
            $('#msg').append(msg);

        }
    });


});