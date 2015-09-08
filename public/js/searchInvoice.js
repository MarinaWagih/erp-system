$(document).ready(function () {


function sendData()
{
    $.post('/invoice/search',
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
                toShow+='<a href="/invoice/'+result.data[i].id+'">'+'عرض'+'</a>';
                toShow+=' <a href="/invoice/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                if($('#U_type').val()=='admin')
                {
                    toShow+=' <a href="/invoice/'+result.data[i].id+'/delete">'+'مسح'+'</a>';
                }
                //console.log(result.data[i]);
                toShow+='</td>';
                toShow+='<td>'+result.data[i].date+'</td>';
                //toShow+='<td>'+result.data[i].total+'</td>';
                toShow+='<td>';
                if(result.data[i].installation=='1')
                {
                  toShow+='بالتركيب'  ;
                }
                else
                {
                    toShow+='بدون تركيب';
                }
                toShow+='</td>';
                toShow+='<td>'+result.data[i].id+'</td>';
                toShow+='</tr>';
            }
            $('#result').html(toShow);
            $('#render').html(result.render);
            //console.log();

        });
}
    $('#submit').click(function () {
                                        sendData()
                                    });
    $('#query').keyup(function () {
                                        sendData()
                                    });
});