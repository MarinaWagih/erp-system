$(function() {
	
	$('#print').click(function() {
        //alert('in');
		//var container = $(this).attr('rel');
		//$('#content').printArea();
        printAssessment()
		return false;
	});
	
});
$(document).keydown(function(event) {
    if (event.ctrlKey==true && (event.which == '80')) { //ctrl + p
        event.preventDefault();
        printAssessment();
    }
});

function printAssessment() {
    //alert("Print the little page");
    window.print();
}