
$(document).ready(function(){
  getEducation();
  getWork();
  getDropzone();
  initializeData();
 // $('#btn_redirect').click();
  $('a[href*=#top]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
      || location.hostname == this.hostname) {

      var target = $('#top');
    target = target.length ? target : $('[name=' + '#top'.slice(1) +']');
    if (target.length) {
     $('html,body').animate({
       scrollTop: target.offset().top
     }, 1000);
     return false;
   }
 }
});

  $('.divdeg').hide('slow');
  $('.divmajor').hide('slow');

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

  $(document).on('click','#btnAddEdu',function(){
    $('#eduModal').modal('show');
    var i = 1;
    $('#attainment').selectpicker('val','' + i);
    $('.divdeg').hide('slow');
    $('.divmajor').hide('slow');
  });

  $(document).on('click','.btn-edu-delete',function(){
    var edu = $(this).attr('education_id');

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

  $(document).on('click','.btn-edu-edit',function(){
    $('#EditeduModal').modal('show');

    var edu = $(this).attr('education_id');

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

    education.done(function(data){
    });
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
  $('#divEdu').empty();
  if(data.hasEdu == 0){
    console.log('no education');
  }
  else{
    for(var i=0; i<data.education.length; i++){
      if(data.education[i].attainment == 1){
        $('#divEdu').append($('<div>').attr('id','user_edu')
          .append($('<h1>').text(data.education[i].school))
          .append($('<h3>').text(data.education[i].start + ' - ' +data.education[i].end ))
          .append($('<div>').addClass('btn-tool-delete btn-edu-delete pull-right').attr('education_id',data.education[i].education_id)
            .append($('<i>').addClass('fa fa-trash-o').attr('aria-hidden','true'))
            .append($('<p>').text('Delete')))
          .append($('<div>').addClass('btn-tool-edit btn-edu-edit pull-right').attr('education_id',data.education[i].education_id)
            .append($('<i>').addClass('fa fa-pencil').attr('aria-hidden','true'))
            .append($('<p>').text('Edit'))));
      }
      else{
        for(var y =0; y<data.degree.length; y++){
          if(data.education[i].degree_id == data.degree[y].degree_id){
            for(var z=0; z<data.field.length; z++){
              if(data.education[i].field_study == data.field[z].edu_field_id){
                $('#divEdu').append($('<div>').attr('id','user_edu')
                  .append($('<h1>').text(data.degree[y].name + ' in '+ data.field[z].title))
                  .append($('<h3>').text(data.education[i].school))
                  .append($('<i>').addClass('fa fa-circle').attr('aria-hidden','true'))
                  .append($('<h3>').text(data.education[i].start + ' - ' +data.education[i].end ))
                  .append($('<div>').addClass('btn-tool-delete btn-edu-delete pull-right').attr('education_id',data.education[i].education_id)
                    .append($('<i>').addClass('fa fa-trash-o').attr('aria-hidden','true'))
                    .append($('<p>').text('Delete')))
                  .append($('<div>').addClass('btn-tool-edit btn-edu-edit pull-right').attr('education_id',data.education[i].education_id)
                    .append($('<i>').addClass('fa fa-pencil').attr('aria-hidden','true'))
                    .append($('<p>').text('Edit'))));
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

 $(document).on('click','.btn-work-edit',function(){
  $('#edit-workModal').modal('show');

  var work = $(this).attr('experience_id');
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
    $('#edit-workstart').selectpicker('val',''+data.experience.year);
    $('#workid').text(data.experience.experience_id);
  });
});

 $(document).on('click','.btn-work-delete',function(){
  var work = $(this).attr('experience_id');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var deledu = $.ajax({
    url:'/remove/user/work',
    method:'GET',
    complete:getWork,
    data:{
      'experience' : work
    }
  });

  deledu.done(function(data){
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
       $('#divWork').append($('<div>').attr('id','user_edu')
        .append($('<h1>').text(data.experience[i].job_title))
        .append($('<h3>').text(data.experience[i].employer))
        .append($('<i>').addClass('fa fa-circle').attr('aria-hidden','true'))
        .append($('<h3>').text(data.experience[i].year))
        .append($('<div>').addClass('btn-tool-delete btn-work-delete pull-right').attr('experience_id',data.experience[i].experience_id)
          .append($('<i>').addClass('fa fa-trash-o').attr('aria-hidden','true'))
          .append($('<p>').text('Delete')))
        .append($('<div>').addClass('btn-tool-edit btn-work-edit pull-right').attr('experience_id',data.experience[i].experience_id)
          .append($('<i>').addClass('fa fa-pencil').attr('aria-hidden','true'))
          .append($('<p>').text('Edit'))));
     }
   }
 });  
}

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

  $('#upload-submit').on('click', function(e) {
    e.preventDefault();
    //trigger file upload select
    $("#my-dropzone").trigger('click');
  });
}

$('.tab-content').hide();
$('.tab-content').show('slow')


$('[data-toggle=offcanvas]').click(function() {
  $('.row-offcanvas').toggleClass('active');
});

$("#filter-box").mouseenter(function() {
  $('#filter-body').collapse('show',700);
});

$("#filter-box").mouseleave(function() {
  $('#filter-body').collapse('hide',700);
});

        //Initialize tooltips
// $('.nav-tabs > li a[title]').tooltip();
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e){
      var $target = $(e.target);
      if ($target.parent().hasClass('disabled')) {
        return false;
      }
    });

    $('a[href="#step3"]').on('show.bs.tab',function(){
      var mobile = $('#mobile').val();
      var cbhouse = document.getElementsByName('housekeeping[]');
      var cbconst = document.getElementsByName('construction[]');
      var cbpers =  document.getElementsByName('personel[]');
      var cbmaint =  document.getElementsByName('maintenance[]');

      var cbhouselen = cbhouse.length;
      var cbconstlen = cbconst.length;
      var cbperslen = cbpers.length;
      var cbmaintlen = cbmaint.length;


      var container = [];

      for(var i=0; i<cbhouselen; i++){
        if(cbhouse[i].checked == true){
          container.push(cbhouse[i].value);
        }
      }

      for(var i=0; i<cbconstlen; i++){
        if(cbconst[i].checked == true){
          container.push(cbconst[i].value);
        }
      }

      for(var i=0; i<cbperslen; i++){
        if(cbpers[i].checked == true){
          container.push(cbpers[i].value);
        }
      }

      for(var i=0; i<cbmaintlen; i++){
        if(cbmaint[i].checked == true){
          container.push(cbmaint[i].value);
        }
      }

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var verify = $.ajax({
        url:'/set/user/verify',
        method:'GET',
        data:{
          'mobile': mobile,
          'skills':container
        }
      });

      verify.done(function(data){
        console.log(data);
      });
    });

    $('a[href="#step2"]').on('show.bs.tab',function(){
      var fname = $('#firstname').val();
      var lname = $('#lastname').val();
      var address = $('#address').val();
      var mobile = $('#mobile').val();
      var about = $('#about').val();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var step1 = $.ajax({
        url:'/set/user/step1',
        method:'GET',
        data:{
          'mobile': mobile,
          'fname': fname,
          'lname' : lname,
          'address': address,
          'about': about
        }
      });

      step1.done(function(data){
        console.log(data);
      });
    });

    $(document).on('click','#resend-code',function(){
      var mobile = $('#mobile').val();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var step1 = $.ajax({
        url:'/get/user/resend',
        method:'GET',
        data:{
          'mobile': mobile,
        }
      });

      step1.done(function(data){
        console.log(data);
      });
    });

    $(document).on('click','#btn_verify',function(){
      var code = $('#verification').val();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var verify = $.ajax({
        url:'/get/user/verify',
        method:'GET',
        data:{
          'code': code
        }
      });

      verify.done(function(data){
        console.log(data);
        if(data.status == 1){
         swal("Congratulations!", "You have successfuly created your account.", "success");
         $('#btn_redirect').click();
       }
       else{
        swal("Please Retry!", "You have enter the wrong code.", "error")
       }
     });
    });


    $(document).on('click','#getselected',function(){

    });

    $(".next-step").click(function(e){
      var $active = $('.wizard .nav-tabs li.active');
      $active.next().removeClass('disabled');
      nextTab($active);
    });

    $(".prev-step").click(function(e){
      var $active = $('.wizard .nav-tabs li.active');
      prevTab($active);
    });

    function nextTab(elem){
      $(elem).next().find('a[data-toggle="tab"]').click();
      $('#scroll').click();
    }

    function prevTab(elem){
      $(elem).prev().find('a[data-toggle="tab"]').click();
      $('#scroll').click();
    }

    function initializeData(){

      input = document.getElementById('address');
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

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var jobdatas = $.ajax({
        url:'/get/user/setupdata',
        method:'GET',
      });

      jobdatas.done(function(data){
        var index = 0;

        $.each(data.attainment,function(key,val){
         $('#attainment').append($('<option>').text(val.name).attr('value',val.attainment_id).addClass('selectoption'))
       });

        $('#attainment').selectpicker('refresh');
     //  $.each(data.categories,function(key,val){
     //   $('#search-sel').append($('<option>').text(val.name).attr('value',val.category_id).addClass('selectoption'))
     // });

     $.each(data.degree,function(key,val){
       $('#degree').append($('<option>').text(val.name).attr('value',val.degree_id).addClass('selectoption'))
     });

     $('#degree').selectpicker('refresh');

   });
    }

