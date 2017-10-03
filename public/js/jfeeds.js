//----------------------------Initialize Datas------------------------------------//
var feedmap;
var recmap;
var nearmap;
var input;
var searchBox;
var place;
var nearbs;
var markers = [];
var geolocations;

//----------------------------Initialization------------------------------------//

function initializeMap(){
  $('#feed-gmap').attr('hidden',true);
  $('#rec-gmap').attr('hidden',true);
  $('#near-gmap').attr('hidden',true);

  var meos = [];
  var centers = { lat:10.3133 , lng:123.88 };
  meos.push(centers);
  feedmap = new google.maps.Map(document.getElementById('feed-gmap'), {
    center:centers,
    zoom: 18,
    mapTypeId: google.maps.MapTypeId.HYBRID
  });

  recmap = new google.maps.Map(document.getElementById('rec-gmap'), {
    center: centers,
    zoom: 18,
    mapTypeId: google.maps.MapTypeId.HYBRID
  });

  nearmap = new google.maps.Map(document.getElementById('near-gmap'), {
    center: centers,
    zoom: 18,
    mapTypeId: google.maps.MapTypeId.HYBRID
  });

  $("#loading").fadeOut(300);
}

function initializeData(){

 $('#feed-body').attr('hidden',true);
 $('#rec-body').attr('hidden',true);
 $('#near-body').attr('hidden',true);
 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
 var jobdatas = $.ajax({
  url:'/get/jobpagedata',
  method:'GET',
});

 jobdatas.done(function(data){
  console.log(data);
  var index = 0;

  $.each(data.categories,function(key,val){
   $('#search-sel').append($('<option>').text(val.name).attr('value',val.category_id).addClass('selectoption'))
 });

  $('#search-sel').selectpicker('refresh');

  $('#s-skill').empty();
  $.each(data.skill,function(key,val){
   $('#s-skill').append($('<option>').text(val.name).attr('value',val.skill_id).addClass('selectoption'))
 });
  
  $('#s-skill').selectpicker('refresh');

  $.each(data.paytypes,function(key,value){
    $('#fil-ptype').append($('<option>').text(value.name).attr('value',value.paytype_id).addClass('selectoption'));
  });

  $('#fil-ptype').selectpicker('refresh');

  var jobids = [];
  $(".windows8").fadeOut(200);
  //----------------Job Feeds------------//
  if(data.status != 400){
    for(i = 0; i< data.jobs.length; i++){
      jobids.push(data.jobs[i].job_id);
      $('#jobfeed-res').append($('<a>').addClass('list-group-item item-res').attr('data-val',data.jobs[i].job.job_id)
        .append($('<div>').addClass('cont-feeds')
          .append($('<img>').addClass('img-rounded pull-left').attr('src',data.jobs[i].employer.avatar))
          .append($('<h4>').addClass('list-group-item-heading ellipsis meta-title').text(data.jobs[i].job.title))
          .append($('<p>').addClass('list-group-item-text meta meta-employer').text('by '+data.jobs[i].employer.fname + ' ' + data.jobs[i].employer.lname))
          .append($('<i>').addClass('meta-loc meta-marker fa-1x fa fa-map-marker'))
          .append($('<p>').addClass('list-group-item-text meta meta-loc meta-locality').text(data.jobs[i].job.address.address))));
    }
  }
  $('#feeds').attr('hidden',false);

  $('.item-res ').click(function(e) {
    e.preventDefault();
    $('.item-res').removeClass('item-active');
    $(this).addClass('item-active')
  });

  //----------------Location------------//

  input = document.getElementById('search-loc');
  var options = {
    types: ['(cities)'],
    componentRestrictions: {country: "ph"}
  };
  
  searchBox = new google.maps.places.Autocomplete(input,options);
  searchBox.addListener('places_changed', function() {
   places = searchBox.getPlaces();
   if (places.length == 0) {
    return;
  }
});
});

};

$(document).ready(function(){

  initializeMap();
  initializeData();

  $('a[href*=#scrolled]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
      || location.hostname == this.hostname) {

      var target = $('#scrolled');
    target = target.length ? target : $('[name=' + '#scrolled'.slice(1) +']');
    if (target.length) {
     $('html,body').animate({
       scrollTop: target.offset().top
     }, 1000);
     return false;
   }
 }
});

//----------------------------Requests------------------------------------//
function loadStart(){
 $("#loading").fadeIn(200);
 $('#feed-body').attr('hidden',true);
}

function loadEnd(){
  $('#scroll').click();
  $('#loading').fadeOut(200);
}
//--------Job Search  --------//
var loc;
$(document).on('click','#btn-search',function(e){
  e.preventDefault();
  $('#tab-feeds').click();
  var json = $('#s-skill').val();
  $('#feed-body').hide();
  console.log(json);
  var zips = [];
  var geocode = new google.maps.Geocoder();
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  geocode.geocode({ 'address': $('#search-loc').val() }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      console.log(results);

      var res = results[0].address_components;
      for(var i=0; i<res.length; i++){
        if(res[i].types[0] =="locality"){
         this.loc =  res[i].long_name;
       }
     }
   }
   
   var search = $.ajax({
    url: '/app/jobsearch',
    method: 'GET',
    beforeSend:loadStart,
    complete:loadEnd,
    data:{
      'cat'  : $('#search-sel option:selected').val(),
      'skill': json,
      'location':loc,
      'salary': $('#fil-sal').val(),
      'ptype': $('#fil-ptype').val(),
    },
  });
   
   search.done(function(data){
    console.log(data);
    $('#jobfeed-res').empty();
    if(data.jobs.length == 0){
      $('.feed-panel').attr('hidden',true);
      $('#result-count').text('Sorry, no results were found. ');  
    }
    else{
      $('.feed-panel').attr('hidden',false);
      $('#result-count').text(data.jobs.length + ' Job(s) found in ' + data.loc);  
    }

    for(i = 0; i< data.jobs.length; i++){
      $('#jobfeed-res').append($('<a>').addClass('list-group-item item-res').attr('data-val',data.jobs[i].job.job_id)
        .append($('<div>').addClass('cont-feeds')
          .append($('<img>').addClass('img-rounded pull-left').attr('src',data.jobs[i].employer.avatar))
          .append($('<h4>').addClass('list-group-item-heading ellipsis meta-title').text(data.jobs[i].job.title))
          .append($('<p>').addClass('list-group-item-text meta meta-employer').text('by '+data.jobs[i].employer.fname + ' ' + data.jobs[i].employer.lname))
          .append($('<i>').addClass('meta-loc meta-marker fa-1x fa fa-map-marker'))
          .append($('<p>').addClass('list-group-item-text meta meta-loc meta-locality').text(data.jobs[i].address.address))));
    }

  }); 
 });
});

//-------- Onclick  Tab recommended --------//

$(document).on('click','#tab-recommended',function(e){
  e.preventDefault();
  $('#feed-body').attr('hidden',true);
  $('#rec-body').attr('hidden',true);
  $('.item-res').removeClass('item-active');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var jobids = [];
  var search = $.ajax({
    url: '/get/job/recommended',
    method: 'GET',
  });

  search.done(function(data){
    console.log(data);
    $('#recommended-res').empty();
    var jobids = [];

    for(i = 0; i< data.jobs.length; i++){
      jobids.push(data.jobs[i].job_id);
      $('#recommended-res').append($('<a>').addClass('list-group-item recom-res').attr('data-val',data.jobs[i].job.job_id)
        .append($('<div>').addClass('cont-feeds')
          .append($('<img>').addClass('img-rounded pull-left').attr('src',data.jobs[i].employer.avatar))
          .append($('<h4>').addClass('list-group-item-heading ellipsis meta-title').text(data.jobs[i].job.title))
          .append($('<p>').addClass('list-group-item-text meta meta-employer').text('by '+data.jobs[i].employer.fname + ' ' + data.jobs[i].employer.lname))
          .append($('<i>').addClass('meta-loc meta-marker fa-1x fa fa-map-marker'))
          .append($('<p>').addClass('list-group-item-text meta meta-loc meta-locality').text(data.jobs[i].job.address.address))));
    }


  });

});
$('.recom-res ').click(function(e) {
  e.preventDefault();
  $('.recom-res').removeClass('item-active');
  $(this).addClass('item-active')
});

//--------Job Onclick  --------//
$(document).on('click','.recom-res',function(e){
  $('#rec-body').hide(300);
  $('#feed-body').attr('hidden',true);
  e.preventDefault();
  $('#rec-result-sched').empty();
  $('#rec-result-skill').empty();
  $('#rec-body').attr('hidden',false);
  $('#rec-body').show(400);
  $('.conflict').hide(200);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var request = $.ajax({
    url:'/get/job',
    method:'GET',
    data:{
      'jobid': $(this).data('val'),
    }
  });

  request.done(function(data){
    console.log(data);
    var meos = [];
    var locs;
    var centers = { lat: parseFloat(data.response[0].address.lat), lng: parseFloat(data.response[0].address.lng) };
    meos.push(centers);

    if(data.response[0].conflict== null){
      $('.btn-apply').show(400);
    }
    else if(data.response[0].conflict.conflict == 1){
      $('.conflict').show(400);
      var myjob = data.response[0].conflict.work_sched.schedules.jobs.title;
      $('.conflict-message').text('Oops. it looks like this job conflicts with your work: ' + myjob );
      $('.btn-apply').hide(400);
    }
    else{
      $('.btn-apply').show(400);
    }

    if(data.response[0].applied == 1){
      $('.btn-apply').attr('disabled',true).text('Applied');
    }
    else{
      $('.btn-apply').attr('disabled',false).text('Apply');
    }

    $('#rec-result-add').text(data.response[0].address.address);
    $('#rec-res-jobid').text(data.response[0].job.job_id);
    $('#rec-result-title').text("(" +data.response[0].job.job_id + ") "+ data.response[0].job.title);
    
    for(i = 0; i<data.response[0].skill.length; i++){
      $('#rec-result-skill').append($('<p>').text(data.response[0].skill[i].name).addClass('mini-skill'));
    }

    $('#rec-desc').text(data.response[0].job.description);
    $('.meta-sal').text('Php ' + data.response[0].job.salary + ' / ' + data.response[0].paytype);
    $('.meta-slot').text(data.response[0].job.slot);
    $('.meta-jobtype').text(data.response[0].jobtype);

    var marker = new google.maps.Marker({
      map: recmap,
      position: meos[0],
      title: 'Hello World!'
    });

    $('#rec-gmap').attr('hidden',false);
    setTimeout(google.maps.event.trigger(recmap, 'resize'),300);
    recmap.setCenter(centers);

    var dateposted = moment(data.response[0].job.date_posted);
    $('.postedago').text('Posted ' +dateposted.fromNow());
    $('.sched-start').empty();
    $('.sched-end').empty();
    $('.sched-start').append($('<h3>').text('From'));
    $('.sched-end').append($('<h3>').text('Until'));
    for(i=0; i<data.response[0].schedule.length; i++){
      var start = moment(data.response[0].schedule[i].start).format('MMMM Do YYYY, h:mm a');
      var end = moment(data.response[0].schedule[i].end).format('MMMM Do YYYY, h:mm a');
      $('.sched-start').append($('<p>').text(start));
      $('.sched-end').append($('<p>').text(end));
    }

    $('#rec-t').text(data.response[0].job.title);
    $('#rec-p').text('by ' +data.response[0].user.fname + ' ' + data.response[0].user.lname);

  });
});

$(document).on('click','#tab-feeds',function(e){
 e.preventDefault();
 $('#rec-body').attr('hidden',true);
 $('#feed-body').attr('hidden',true);
 $('.feed-panel').attr('hidden',false);

});

//--------Job Onclick  --------//
$(document).on('click','.item-res',function(e){
  $('#feed-body').hide(300);
  $('#feed-body').show(400);
  e.preventDefault();
  $('.conflict').hide(200);
  $('#feed-result-sched').empty();
  $('#feed-result-skill').empty();
 // $('#feed-body').attr('hidden',false);

 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

 var request = $.ajax({
  url:'/get/job',
  method:'GET',
  data:{
    'jobid': $(this).data('val'),
  }
});

 request.done(function(data){
  console.log(data);
  if(data.response[0].conflict == null){
    $('.btn-apply').show(400);
  }
  else if(data.response[0].conflict.conflict == 1){
    $('.conflict').show(400);
    var myjob = data.response[0].conflict.work_sched.schedules.jobs.title;
    $('.conflict-message').text('Oops. it looks like this job conflicts with your work: ' + myjob );
    $('.btn-apply').hide(400);
  }
  else{
    $('.btn-apply').show(400);
  }

  if(data.response[0].applied == 1){
    $('.btn-apply').attr('disabled',true).text('Applied');
  }
  else{
    $('.btn-apply').attr('disabled',false).text('Apply');
  }

  var meo = [];
  var locs;
  var centers = { lat: parseFloat(data.response[0].address.lat), lng: parseFloat(data.response[0].address.lng) };
  meo.push(centers);

  $('#feed-result-add').text(data.response[0].address.address);

  $('#feed-res-jobid').text(data.response[0].job.job_id);

  for(i = 0; i<data.response[0].schedule.length; i++){
    $('#feed-result-sched').append($('<li>')
      .append($('<p>').text(data.response[0].schedule[i].start + " until " + data.response[0].schedule[i].end)));
  }

  for(i = 0; i<data.response[0].skill.length; i++){
    $('#feed-result-skill').append($('<p>').text(data.response[0].skill[i].name).addClass('mini-skill'));
  }

  $('#feed-desc').text(data.response[0].job.description);
  $('.meta-sal').text('Php ' + data.response[0].job.salary + ' / ' + data.response[0].paytype);
  $('.meta-slot').text(data.response[0].job.slot);
  $('.meta-jobtype').text(data.response[0].jobtype);

  var marker = new google.maps.Marker({
    map: feedmap,
    position: meo[0],
    title: 'Hello World!'
  });

  $('#feed-gmap').attr('hidden',false);
  setTimeout(google.maps.event.trigger(feedmap, 'resize'),300);
  feedmap.setCenter(centers);

  var dateposted = moment(data.response[0].job.date_posted);
  $('.postedago').text('Posted ' +dateposted.fromNow());
  $('.sched-start').empty();
  $('.sched-end').empty();
  $('.sched-start').append($('<h3>').text('From'));
  $('.sched-end').append($('<h3>').text('Until'));
  for(i=0; i<data.response[0].schedule.length; i++){
    var start = moment(data.response[0].schedule[i].start).format('MMMM Do YYYY, h:mm a');
    var end = moment(data.response[0].schedule[i].end).format('MMMM Do YYYY, h:mm a');
    $('.sched-start').append($('<p>').text(start));
    $('.sched-end').append($('<p>').text(end));
  }


      //   $('#result-sched').empty();
      //   $('#key').empty();
      //   $('#res-filtering').empty();  
      //   $('#result-title').text(data.job.title);
      //   $('#result-postby').text(data.user.fname + data.user.lname + dateposted.fromNow());
      //   $('#res-jobid').text(data.job.job_id).attr('hidden',true);
      
      //   $.each(data.sched, function(key,value){
      //   var start = moment(value.start).format('lll');
      //   var end = moment(value.end).format('lll');
      //   $('#result-sched').append('<p>' + start +' - '+ end +'</p>');
      // });

      $('#feed-t').text(data.response[0].job.title);
      $('#feed-p').text('by ' +data.response[0].user.fname + ' ' + data.response[0].user.lname);

    });

}); 

$(document).on('click','#tab-nearby',function(e){
  e.preventDefault();
  $('#feed-body').attr('hidden',true);
  $('#near-body').attr('hidden',true);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var jobids = [];
  var search = $.ajax({
    url: '/get/job/nearby',
    method: 'GET',
  });

  search.done(function(data){
    console.log(data);
    $('#nearby-res').empty();
    var jobids = [];
    
   $.each(data.jobs, function(i, jobItem) {
      jobids.push(jobItem.job_id);
      $('#nearby-res').append($('<a>').addClass('list-group-item near-res').attr('data-val',jobItem.job_id)
        .append($('<div>').addClass('cont-feeds')
          .append($('<img>').addClass('img-rounded pull-left').attr('src',jobItem.employer.avatar))
          .append($('<h4>').addClass('list-group-item-heading ellipsis meta-title').text(jobItem.job.title))
          .append($('<p>').addClass('list-group-item-text meta meta-employer').text('by '+jobItem.employer.fname + ' ' + jobItem.employer.lname))
          .append($('<i>').addClass('meta-loc meta-marker fa-1x fa fa-map-marker'))
          .append($('<p>').addClass('list-group-item-text meta meta-loc meta-locality').text(jobItem.job.address.address))));
    });

  });
});

$(document).on('click','.near-res',function(e){
 e.preventDefault();
 $('#near-body').hide(300);
 $('.conflict').hide(200);
 $('#near-result-sched').empty();
 $('#near-result-skill').empty();
 $('#near-body').attr('hidden',false);
 $('#near-body').show(400);
 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

 var request = $.ajax({
  url:'/get/job',
  method:'GET',
  data:{
    'jobid': $(this).data('val'),
  }
});

 request.done(function(data){
  console.log(data);
  if(data.response[0].conflict== null){
    $('.btn-apply').show(400);
  }
  else if(data.response[0].conflict.conflict == 1){
    $('.conflict').show(400);
    var myjob = data.response[0].conflict.work_sched.schedules.jobs.title;
    $('.conflict-message').text('Oops. it looks like this job conflicts with your work: ' + myjob );
    $('.btn-apply').hide(400);
  }
  else{
    $('.btn-apply').show(400);
  }

  if(data.response[0].applied == 1){
    $('.btn-apply').attr('disabled',true).text('Applied');
  }
  else{
    $('.btn-apply').attr('disabled',false).text('Apply');
  }

  var meos = [];
  var locs;
  var centers = { lat: parseFloat(data.response[0].address.lat), lng: parseFloat(data.response[0].address.lng) };
  meos.push(centers);
  $('#near-result-add').text(data.response[0].address.address);

  $('.btn-apply').attr('jobid',data.response[0].job.job_id);
  $('#near-res-jobid').text(data.response[0].job.job_id).attr('hidden',true);
  $('#near-result-title').text("(" +data.response[0].job.job_id + ") "+ data.response[0].job.title);
  // for(i = 0; i<data.response[0].schedule.length; i++){
  //   $('#near-result-sched').append($('<li>')
  //     .append($('<p>').text(data.response[0].schedule[i].start + " until " + data.response[0].schedule[i].end)));
  // }
  for(i = 0; i<data.response[0].skill.length; i++){
    $('#near-result-skill').append($('<p>').text(data.response[0].skill[i].name).addClass('mini-skill'));
  }

  $('#near-desc').text(data.response[0].job.description);
  $('.meta-sal').text('Php ' + data.response[0].job.salary + ' / ' + data.response[0].paytype);
  $('.meta-slot').text(data.response[0].job.slot);
  $('.meta-jobtype').text(data.response[0].jobtype);

  if(markers.length !== 0){
    markers.setMap(null);
  }

  markers = new google.maps.Marker({
    map: nearmap,
    position: centers,
  });

  $('#near-gmap').attr('hidden',false);
  setTimeout(google.maps.event.trigger(nearmap, 'resize'),300);
  nearmap.setCenter(centers);
   var dateposted = moment(data.response[0].job.date_posted);
  $('.postedago').text('Posted ' +dateposted.fromNow());
  $('.sched-start').empty();
  $('.sched-end').empty();
  $('.sched-start').append($('<h3>').text('From'));
  $('.sched-end').append($('<h3>').text('Until'));
  for(i=0; i<data.response[0].schedule.length; i++){
    var start = moment(data.response[0].schedule[i].start).format('MMMM Do YYYY, h:mm a');
    var end = moment(data.response[0].schedule[i].end).format('MMMM Do YYYY, h:mm a');
    $('.sched-start').append($('<p>').text(start));
    $('.sched-end').append($('<p>').text(end));
  }

  $('#near-t').text(data.response[0].job.title);
  $('#near-p').text('by ' +data.response[0].user.fname + ' ' + data.response[0].user.lname);

});
});
});

function loadAlert(){
  swal("Thank You!", "Application sent!", "success");
}

//-------- Job Application --------//

// $(document).on('click','.btn-apply',function(e){
//   var jobid = document.getElementsByClassName(this).getAttribute('jobid');
//   alert(jobid);

// });


$(document).on('click','#feed-apply-btn',function(e){
 e.preventDefault();
 var jobid = $('#feed-res-jobid').text();
 $('#btn-confirm').attr('jobid',jobid);
 $('#policy-Modal').modal('show');
});

$(document).on('click','#rec-apply-btn',function(e){
 e.preventDefault();
 var jobid = $('#rec-res-jobid').text();
 $('#btn-confirm').attr('jobid',jobid);
 $('#policy-Modal').modal('show');
});

$(document).on('click','#near-apply-btn',function(e){
 e.preventDefault();
 var jobid = $('#near-res-jobid').text();
 $('#btn-confirm').attr('jobid',jobid);
 $('#policy-Modal').modal('show');
});

$(document).on('click','#btn-confirm',function(e){
 var jobid = $(this).attr('jobid');

 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

 var apply = $.ajax({
  url: '/app/apply',
  method: 'GET',
  data:{'jobid':jobid},
});

 apply.done(function(data){
  console.log(data);
  $('.btn-apply').attr('disabled',true).text('Applied');
  $('#policy-Modal').modal('hide');
  loadAlert();
});


});

$(document).on('change','#search-sel',function(e){
  e.preventDefault();
  console.log($('#s-skill option:selected').val());
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var sel = $.ajax({
    url: '/app/job/getskill',
    method: 'GET',
    data:{
      'cat':$('#search-sel option:selected').val(),
    },
  });

  sel.done(function(data){
    console.log(data);
    $('#s-skill').empty();
    $.each(data.skills,function(key,val){
      console.log(val.name);
      $('#s-skill').append($('<option>').text(val.name).attr('value',val.skill_id).addClass('selectoption'))
    });

    $('#s-skill').selectpicker('refresh');
    $('#s-skill').selectpicker('toggle');
  });
});

//-------- Job Filters --------//
$(document).on('change','.filters',function(e){
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var filter = $.ajax({
    url: '/app/job/filter',
    method: 'GET',
    data:{
      'date':     $('#fil-date option:selected').val(),
      'salary':   $('#fil-sal option:selected').val(),
      'paytype':  $('#fil-ptype option:selected').val(),
      'distance': $('#fil-dist option:selected').val()
    }
  });
  filter.done(function(data){
    console.log(data);
  });
});

