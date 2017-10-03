$(document).ready(function(){
	$("#loading").fadeOut(300);
	initialize();

	function initialize(){
		$('#appfeeds').hide('slow');
		$('#appfeeds').empty();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var sel = $.ajax({
			url: '/employer/applications/data',
			method: 'get',
		});
		
		sel.done(function(data){
			console.log(data);
			$('#appfeeds').show('slow');
			if(data.status == 400){}else{
			for(var i=0; i< data.response.length; i++){
				var date = new moment(data.response[i].date).fromNow();
				console.log(date);
				$('#appfeeds').append($('<div>').addClass('card-cont col-md-12')
					.append($('<span>').addClass('app-image col-md-2')
						.append($('<img>').attr('src', data.response[i].user.avatar)))
					.append($('<span>').addClass('card-center col-md-8')
						.append($('<h2>').text(data.response[i].user.fname + ' ' + data.response[i].user.lname))
						.append($('<i>').addClass('fa fa-clock-o clock-icon').attr('aria-hidden','true'))
						.append($('<p>').text('applied '+date).addClass('app-date'))
						.append(($('<span>').addClass('jobs-cont'))
							.append($('<p>').text('wants to apply in your job: '))
							.append($('<a>').text(data.response[i].job.title).attr('jobid',data.response[i].job.job_id))
							)
						.append($('<button>').addClass('btn btn-md btn-profile').attr('profile_id',data.response[i].user.profile_id).text('View Profile')))
					.append($('<span>').addClass('btn-response col-md-2')
						.append($('<button>').addClass('btn btn-md btn-approve').text('Accept').attr('appid',data.response[i].app_id))
						.append($('<button>').addClass('btn btn-md btn-decline').text('Decline').attr('appid',data.response[i].app_id)))
					)
			
			}}
		});	

	}

	$(document).on('click','.btn-approve',function(){
		var appid = $(this).attr('appid');
		var response = 1;
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var sel = $.ajax({
			url: '/employer/application/response',
			method: 'get',
			 data:{'appid':appid,
			 'response': response},
		});

		sel.done(function(data){
			console.log(data);
			initialize();
		});
	});

	$(document).on('click','.btn-decline',function(){
		var appid = $(this).attr('appid');
		var response = 0;
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var sel = $.ajax({
			url: '/employer/application/response',
			method: 'get',
			 data:{'appid':appid,
			 'response': response},
		});

		sel.done(function(data){
			console.log(data);
			initialize();
		});
	});



});