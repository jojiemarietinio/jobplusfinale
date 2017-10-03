$(document).ready(function(){
	initializeData();
	getDropzone();

	$(document).on('click','#clickme',function(data){
		$('#modal-skill').modal('hide');
		$('#modal-overview').modal('show');
	});

	function getDropzone(){
  //Dropzone.js Options - Upload an image via AJAX.
  Dropzone.options.myDropzone = {
  	uploadMultiple: false,
    // previewTemplate: '',
    addRemoveLinks: false,
    // maxFiles: 1,
    dictDefaultMessage: '',
    init: function() {
    	this.on("addedfile", function(file) {
        // console.log('addedfile...');
        $('.dz-image').hide();
        $('.dz-details').hide();
        $('.dz-success-mark').hide();
        $('.dz-error-mark').hide();
    });
    	this.on("thumbnail", function(file, dataUrl) {
        // console.log('thumbnail...');
        $('.dz-image').hide();
        $('.dz-details').hide();
        $('.dz-success-mark').hide();
        $('.dz-error-mark').hide();
    });
    	this.on("success", function(file, res) {
    		location.reload();
    		console.log('upload success...');
    		$('#img-thumb').attr('src', res.path);
    		$('input[name="pic_url"]').val(res.path);
    		$('.dz-image').hide();
    		$('.dz-details').hide();
    		$('.dz-success-mark').hide();
    		$('.dz-error-mark').hide();
    	});
    }
};

var myDropzone = new Dropzone("#my-dropzone");

$('#prof-pic').on('click', function(e) {
	e.preventDefault();
    //trigger file upload select
    $("#my-dropzone").trigger('click');
});
}



var hoverin = {
	'backgroundColor' : '#e7e7e7',
	'border-radius': '20px',
	'cursor': 'pointer',
	'transition':'0.2s ease-in-out'
};

var hoverout = {
	'backgroundColor' : '',
	'transition':'0.2s ease-in-out'
};

$('#prof-skills')
.mouseover(function() {
	$('.skills').css(hoverin);
})
.mouseout(function() {
	$('.skills').css(hoverout);
});

$(document).on('click','#btnAddEdu',function(){
	$('#eduModal').modal('show');

	var i = 1;
	$('#attainment').selectpicker('refresh');
	$('#attainment').selectpicker('val','' + i);
	$('#school').empty();
	$('.divdeg').hide('slow');
	$('.divmajor').hide('slow');
});

$(document).on('change','#edit-attainment',function(){
	var attainment = $('#edit-attainment option:selected').val();
	if(attainment == 2){
		$('.divdeg').show('slow');
		$('.divmajor').show('slow');
	}
	else{
		$('.divdeg').hide('slow');
		$('.divmajor').hide('slow');
	}
});

$(document).on('change','#attainment',function(){
	var attainment = $('#attainment option:selected').val();
	if(attainment == 2){
		$('.divdeg').show('slow');
		$('.divmajor').show('slow');
	}
	else{
		$('.divdeg').hide('slow');
		$('.divmajor').hide('slow');
	}
});

$(document).on('change','#degree',function(){
	var degree = $('#degree option:selected').val();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var jobdatas = $.ajax({
		url:'/get/user/degree',
		method:'GET',
		data:{
			'attainment_id': degree
		}
	});

	jobdatas.done(function(data){
		$('#field_study').empty();

		$.each(data.field,function(key,val){
			$('#field_study').append($('<option>').text(val.title).attr('value',val.edu_field_id).addClass('selectoption'))
		});

		$('#field_study').selectpicker('refresh');
	});
});

$(document).on('change','#edit-degree',function(){
	var degree = $('#edit-degree option:selected').val();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var jobdatas = $.ajax({
		url:'/get/user/degree',
		method:'GET',
		data:{
			'attainment_id': degree
		}
	});

	jobdatas.done(function(data){
		$('#edit-field_study').empty();

		$.each(data.field,function(key,val){
			$('#edit-field_study').append($('<option>').text(val.title).attr('value',val.edu_field_id).addClass('selectoption'))
		});
		$('#edit-field_study').selectpicker('refresh');
	});

});


$(document).on('click','.name-loc',function(){
	$('#modal-name').modal('show');
});

$(document).on('click','#overview',function(){
	$('#modal-overview').modal('show');
});

$(document).on('click','#prof-skills',function(){
	$('#modal-skill').modal('show');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var skills = $.ajax({
		url:'/get/profile/skill',
		method:'GET',
	});

	skills.done(function(data){
		console.log(data);		

		$('#construction').empty();
		$('#house').empty();
		$('#personel').empty();
		$('#maintenance').empty();

		$.each(data.cons,function(key,val){
			$('#construction').append($('<option>').text(val.name).attr({'value':val.skill_id}).addClass('selectoption'))
		});
		$.each(data.house,function(key,val){
			$('#house').append($('<option>').text(val.name).attr({'value':val.skill_id}).addClass('selectoption'))
		});
		$.each(data.pers,function(key,val){
			$('#personel').append($('<option>').text(val.name).attr({'value':val.skill_id}).addClass('selectoption'))
		});
		$.each(data.main,function(key,val){
			$('#maintenance').append($('<option>').text(val.name).attr({'value':val.skill_id}).addClass('selectoption'))
		});

		$('#construction').selectpicker('refresh');
		$('#house').selectpicker('refresh');
		$('#personel').selectpicker('refresh');
		$('#maintenance').selectpicker('refresh');

		var skill = [];
		for(var i=0; i<data.pskill.length;i++){
			skill.push(data.pskill[i]);
		}

		console.log(skill);
		$('#construction').selectpicker('val', skill);
		$('#house').selectpicker('val', skill);
		$('#personel').selectpicker('val', skill);
		$('#maintenance').selectpicker('val', skill);
	});

});

$(document).on('click','#btn-update-name',function(){
	var fname = $('#firstname').val();
	var lname = $('#lastname').val();
	var address = $('#modal-address').val();
	$('#loading').fadeIn(200);
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var name = $.ajax({
		url:'/set/user/profile/name',
		method:'GET',
		complete:initializeData,
		data:{
			'fname': fname,
			'lname': lname,
			'address': address
		}
	});


});

$(document).on('click','#btn-update-overview',function(){
	var overview = $('#modal-input-overview').val();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var overview = $.ajax({
		url:'/set/user/profile/overview',
		method:'GET',
		complete:initializeData,
		data:{
			'overview': overview
		}
	});

});

$(document).on('click','#btn-update-skill',function(){
	$('#loading').fadeIn(200);
	var skills = [];
	var new_skill = [];
	var house = $('#house').val();
	var personel = $('#personel').val();
	var construction = $('#construction').val();
	var maintenance = $('#maintenance').val(); 
	if(house == null){
		house = [];
	}
	if(personel == null){
		personel = [];
	}
	if(construction == null){
		construction = [];
	}
	if(maintenance == null){
		maintenance = [];
	}
	var first = skills.concat(house,personel);
	var second = skills.concat(construction,maintenance);
	var third = new_skill.concat(first,second);
		// console.log('first:' + first +' second:'+second + ' third:'+third);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var skills = $.ajax({
			url:'/update/profile/skill',
			method:'GET',
			complete:initializeData,
			data:{
				'skills': third
			}
		});

		skills.done(function(data){
			console.log(data);
		});

		// console.log(skills);
		// console.log(house);
	});

$('#edit-name').on('click',function(){
	$('#myModal').modal('show');
	$('.modal-title').text('Edit Name & Skills');
	$('#skillbox').prop('checked',true);
});

$('#name-save').on('click',function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var updatename = $.ajax({
		url:'/get/update/name',
		method:'GET',
		complete:initializeData,
		data:{
			'lname': $('#lastname').val(),
			'fname' : $('#firstname').val()
		}
	});

});

});

function loadEnd(){
	$('#loading').fadeOut(200);
}

function initializeData(){
$('#loading').fadeOut(200);
	input = document.getElementById('modal-address');
	var options = {
		componentRestrictions: {country: "ph"}
	};

	searchBox = new google.maps.places.Autocomplete(input,options);
	searchBox.addListener('places_changed', function() {
		places = searchBox.getPlaces();
		if (places.length == 0) {
			return;
		}
	});

	getEducation();
	getWork();
	getHistory();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var profiledata = $.ajax({
		url:'/get/profiledata',
		method:'GET',
		complete:loadEnd,
	});

	profiledata.done(function(data){
		console.log(data);
		$('#balance').text('Php '+data.balance);
		$('.prof-name').text(data.profile.fname + ' ' + data.profile.lname);
		$('#address').text(data.profile.address);
		$('#modal-address').val(data.profile.address);
		$('#lastname').attr('value',data.profile.lname);
		$('#firstname').attr('value',data.profile.fname);
		$('#overview').text(data.profile.biography);
		$('#modal-input-overview').val(data.profile.biography);
		$('#prof-skills').empty();

		$.each(data.skills,function(key,val){
			$('#prof-skills').append($('<p>').text(val.name));
		});

		if(data.skills.length == 0){
			$('#prof-skills').append($('<i>').addClass('fa fa-plus').attr('aria-hidden','true'))
			.append($('<p>').text('Click to add skills'))
		}

		$.each(data.attainment,function(key,val){
			$('#attainment').append($('<option>').text(val.name).attr('value',val.attainment_id).addClass('selectoption'))
		});

		$('#attainment').selectpicker('refresh');

		$.each(data.degree,function(key,val){
			$('#degree').append($('<option>').text(val.name).attr('value',val.degree_id).addClass('selectoption'))
		});

		$('#degree').selectpicker('refresh');

	});


	$(document).on('click','.education',function(){
		var edu = $(this).attr('id');
		$('#EditeduModal').modal('show');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var deledu = $.ajax({
			url:'/find/user/education',
			method:'GET',
			complete:getEducation,
			data:{
				'education' : edu
			}
		});

		deledu.done(function(data){
			$('#edit-attainment').empty();
			$('#edit-degree').empty();
			$('#edit-field_study').empty();
			$('#educid').text(data.education.education_id);
			if(data.education.attainment == 2){
				$('.divdeg').show('slow');
				$('.divmajor').show('slow');
			}
			else{
				$('.divdeg').hide('slow');
				$('.divmajor').hide('slow');
			}

			$.each(data.attainment,function(key,val){
				$('#edit-attainment').append($('<option>').text(val.name).attr('value',val.attainment_id).addClass('selectoption'))
			});

			$('#edit-attainment').selectpicker('refresh');
			$('#edit-attainment').selectpicker('val', ''+data.education.attainment);
			$('#edit-school').val(data.education.school);
			$('#edit-yearstart').selectpicker('refresh');
			$('#edit-yearend').selectpicker('refresh');
			$('#edit-yearstart').selectpicker('val',''+data.education.start);
			$('#edit-yearend').selectpicker('val',''+data.education.end);

			$.each(data.degree,function(key,val){
				$('#edit-degree').append($('<option>').text(val.name).attr('value',val.degree_id).addClass('selectoption'))
			});

			$('#edit-degree').selectpicker('refresh');
			$('#edit-degree').selectpicker('val',''+data.education.degree_id);

			$.each(data.field,function(key,val){
				$('#edit-field_study').append($('<option>').text(val.title).attr('value',val.edu_field_id).addClass('selectoption'))
			});

			$('#edit-field_study').selectpicker('refresh');
			$('#edit-field_study').selectpicker('val',''+data.education.field_study);
		});
	});

	$(document).on('click','#btn_editedu',function(){
		var attainment = $('#edit-attainment option:selected').val();
		var school = $('#edit-school').val();
		var from = $('#edit-yearstart').val();
		var end = $('#edit-yearend').val();
		var degree = $('#edit-degree option:selected').val();
		var field = $('#edit-field_study option:selected').val();
		var education = $('#educid').text();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var education = $.ajax({
			url:'/update/user/education',
			method:'GET',
			complete:getEducation,
			data:{
				'education' : education,
				'attainment': attainment,
				'school': school,
				'start': from,
				'end' : end,
				'degree' : degree,
				'field' : field
			}
		});
	});

	$(document).on('click','#edu-delete',function(){
		var edu = $('#educid').text();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var deledu = $.ajax({
			url:'/remove/user/education',
			method:'GET',
			complete:getEducation,
			data:{
				'education' : edu
			}
		});

		deledu.done(function(data){
			console.log(data);
		});
	});


	$(document).on('click','#btn_edusave',function(){
		var attainment = $('#attainment option:selected').val();
		var school = $('#school').val();
		var from = $('#yearstart').val();
		var end = $('#yearend').val();
		var degree = $('#degree option:selected').val();
		var field = $('#field_study option:selected').val();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var education = $.ajax({
			url:'/set/user/education',
			method:'GET',
			complete:getEducation,
			data:{
				'attainment': attainment,
				'school': school,
				'start': from,
				'end' : end,
				'degree' : degree,
				'field' : field
			}
		});

		education.done(function(data){
			console.log(data);
		});
	});

	function getEducation(){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var education = $.ajax({
			url:'/get/user/education',
			method:'GET',
		});

		education.done(function(data){
			console.log(data);
			$('#divEdu').empty();
			if(data.hasEdu == 0){
				console.log('no education');
			}
			else{
				for(var i=0; i<data.education.length; i++){
					if(data.education[i].attainment == 1){
						$('#divEdu').append($('<div>').addClass('education').attr('id',''+ data.education[i].education_id)
							.append($('<h2>').text(data.education[i].school))
							.append($('<h3>').text(data.education[i].start + ' - ' +data.education[i].end )))
					}
					else{
						for(var y =0; y<data.degree.length; y++){
							if(data.education[i].degree_id == data.degree[y].degree_id){
								for(var z=0; z<data.field.length; z++){
									if(data.education[i].field_study == data.field[z].edu_field_id){
										$('#divEdu').append($('<div>').addClass('education').attr('id',''+ data.education[i].education_id)
											.append($('<h2>').text(data.degree[y].name + ' in '+ data.field[z].title))
											.append($('<h3>').text(data.education[i].school))
											.append($('<i>').addClass('fa fa-circle').attr('aria-hidden','true'))
											.append($('<h3>').text(data.education[i].start + ' - ' +data.education[i].end ))
											);
									}
								}
							}
						}
					}
				}
			}
		}
		)};


		$(document).on('click','#btnAddWork',function(){
			$('#workModal').modal('show');
			$('#worktitle').empty();
			$('#employer').empty();
		});

		$(document).on('click','#btn_worksave',function(){
			var work = $('#worktitle').val();
			var employer = $('#employer').val();
			var year = $('#workstart option:selected').val();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var work = $.ajax({
				url:'/set/user/work',
				method:'GET',
				complete:getWork,
				data:{
					'work' : work,
					'year': year,
					'employer' : employer,
				}
			});

			work.done(function(data){
				console.log(data);
			});
		});

		$(document).on('click','#btn_editwork',function(){
			var work = $('#edit-worktitle').val();
			var employer = $('#edit-employer').val();
			var year = $('#edit-workstart option:selected').val();
			var id = $('#workid').text();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var work = $.ajax({
				url:'/update/user/work',
				method:'GET',
				complete:getWork,
				data:{
					'work' : work,
					'year': year,
					'employer' : employer,
					'id': id
				}
			});

			work.done(function(data){
				console.log(data);
			});
		});

		$(document).on('click','.work',function(){
			$('#edit-workModal').modal('show');

			var work = $(this).attr('id');
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var editwork = $.ajax({
				url:'/find/user/work',
				method:'GET',
				complete:getEducation,
				data:{
					'work' : work
				}
			});

			editwork.done(function(data){
				console.log(data);
				$('#edit-worktitle').val(data.experience.job_title);
				$('#edit-employer').val(data.experience.employer);
				$('#edit-workstart').selectpicker('refresh');
				$('#edit-workstart').selectpicker('val',''+data.experience.year);
				$('#workid').text(data.experience.experience_id);
			});
		});

		$(document).on('click','#work-delete',function(){
			var work = $('#workid').text();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var workfunc = $.ajax({
				url:'/remove/user/work',
				method:'GET',
				complete:getWork,
				data:{
					'experience' : work
				}
			});

			workfunc.done(function(data){
				console.log(data);
			});
		});


		function getWork(){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var work = $.ajax({
				url:'/get/user/work',
				method:'GET',
			});

			work.done(function(data){
				$('#divWork').empty();
				if(data.hasWork == 0){
					console.log('No work');
				}
				else{
					for(var i=0; i<data.experience.length;i++){
						$('#divWork').append($('<div>').addClass('work').attr('id',''+ data.experience[i].experience_id)
							.append($('<h2>').text(data.experience[i].job_title))
							.append($('<h3>').text(data.experience[i].employer))
							.append($('<i>').addClass('fa fa-circle').attr('aria-hidden','true'))
							.append($('<h3>').text(data.experience[i].year)));
					}
				}
			});  
		}

		function getHistory(){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var work = $.ajax({
				url:'/get/history',
				method:'GET',
			});

			work.done(function(data){
				console.log(data);
				if(data.status == 200){
					for(var i =0; i< data.reviews.length; i++){
							var end = moment(data.reviews[0].review.work.end_time).fromNow();
						$('#divHistory').append($('<div>').addClass('history')
							.append($('<img>').addClass('history-img').attr('src',data.reviews[0].employer.avatar))
							.append($('<div>').addClass('history-cont')
								.append($('<h2>').text(data.reviews[0].employer.fname + ' ' + data.reviews[0].employer.lname))
								.append($('<p>').text(data.reviews[0].job.title + ' - ' + end))
								.append($('<select>').attr('id','example').addClass('rating')
									.append($('<option>').attr('value',1).text('1'))
									.append($('<option>').attr('value',2).text('2'))
									.append($('<option>').attr('value',3).text('3'))
									.append($('<option>').attr('value',4).text('4'))
									.append($('<option>').attr('value',5).text('5'))
									)
								.append($('<p>').text(data.reviews[0].review.comment))
								))

						$('.rating').barrating({
							theme: 'fontawesome-stars',
							readonly:'true',
							initialRating: ''+data.reviews[0].review.rating,
						});
					}
				}
			});




		}



	}