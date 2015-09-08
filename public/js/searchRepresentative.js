$(document).ready(function () {

    function sendData() {
        $.post('/representative/search',
               {
                   'query':$('#query').val(),
                   '_token':$('#_token').val(),
                    'type':'json'
               },
               function(result){
                   var count=result.data.length;
                   var toShow="";
                   for(var i=0;i<count;i++)
                   {
                    toShow+='<tr>' ;
                      toShow+='<td>';
                       toShow+='<a href="/representative/'+result.data[i].id+'">'+'عرض'+'</a>';
                       toShow+=' <a href="/representative/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                       if($('#U_type').val()=='admin')
                       {
                           toShow+=' <a href="/representative/'+result.data[i].id+'/delete">'+'مسح'+'</a>';
                       }
                       toShow+='</td>';
                       toShow+='<td>'+result.data[i].phone+'</td>';
                       toShow+='<td>'+result.data[i].name+'</td>';
                       toShow+='<td>'+result.data[i].id+'</td>';
                    toShow+='</tr>';
                   }
                   $('#result').html(toShow);
                   $('#render').html(result.render);
                   //console.log();

               });
    };
    $('#submit').click(function () {
        sendData()
    });
    $('#query').keyup(function () {
        sendData()
    });
});