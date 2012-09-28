$(function() {
   
    getData();
   
    $('#randomInsert').submit(function() {
	var url = $(this).attr('action');
	var data = $(this).serialize();
	
	$.post(url, data, function(o) {
	    getData();
	});
	return false;
    });


    $('.del').live('click', function() {
	var delItem = $(this);
	$.post('/dashboard/delRow', 'id='+delItem.attr('rel'), function(o) {
	    delItem.parent().remove();
	});
	return false;
      
    });
   
   
   
});

function getData() {
    
    $.get('/dashboard/getData',function(o) {
	console.log(o)
	$('#listinserts').html('');
	for (var i = 0; i< o.length; i++) {
	    
	    $('#listinserts').append('<div>' + o[i].data +
		' <a class="del" rel="'+  o[i].id +'" href="#">X</a> ' +
		'</div>');
	}
    }, 'json');
}