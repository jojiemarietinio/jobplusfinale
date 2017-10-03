
$(document).ready(function(){
 pendingConfirmation();
 initializeMap();
 activeJob();
 upcomingJob();
 loadEnd();

 function pendingConfirmation(){
  $('.pending_confirm').hide(400);
  $('.pending-feed').empty();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var pending = $.ajax({
    url: '/applicant/pending/confirmation',
    method: 'GET'
  });

  pending.done(function(data){
    console.log(data);
    if(data.status == 200){
      if(data.summary.summary.is_paid == 1){
        $('#sender').text('from '+ data.summary.employer.fname + ' '+ data.summary.employer.lname);
        $('#amount_received').text(data.summary.summary.total_salary);
        $('#btn-receive').attr('sumid',data.summary.summary.summary_id);
        $('#received_modal').modal('show');
      }
      else if(data.status == 200){
        $('.pending_confirm').show(400);
        var end = moment(data.summary.work.end_time).fromNow(true);
        $('.pending-feed').append($('<div>').addClass('card-cont col-md-12')
          .append($('<span>').addClass('app-image col-md-2')
            .append($('<img>').attr('src',data.summary.employer.avatar)))
          .append($('<span>').addClass('card-center col-md-7')
            .append($('<h2>').text(data.summary.work.schedules.jobs.title))
            .append($('<p>').text("waiting for employer's confirmation: "))
            .append($('<a>').text(data.summary.employer.fname + ' '+data.summary.employer.lname))
            .append($('<span>').addClass('button-tool')
              .append($('<p>').addClass('start-at').text('Ended ' + end + ' ago'))))
          .append($('<span>').addClass('end-time col-md-3')
            .append($('<p>').text('You will receive: '))
            .append($('<h3>').text('Php ' + data.summary.summary.total_salary)))
          )
      }
      else{
      }
    }
    else{

    }
  });
}
$(document).on('click','#btn-receive',function(){
  var sumid = $(this).attr('sumid');
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var confirmed = $.ajax({
    url: '/applicant/receive/confirm',
    method: 'GET',
    data:{
      'sumid' : sumid
    }
  });

  confirmed.done(function(data){
    console.log(data);
  });


});
$(document).on('change','#act-actions',function(){
  var val = $('#act-actions option:selected').val();
  if(val == 2){
    $('#actResched-Modal').modal('show');
    $('#active-datepicker1').datetimepicker({
      inline: true,
      sideBySide: true
    });
    $('#active-datepicker2').datetimepicker({
      inline: true,
      sideBySide: true
    });
  }
});

$(document).on('click','#btn-next',function(){
  $('#resched-end').click();
});

$(document).on('click','#btn-active-resched',function(){
  var start = $('#active-datepicker1').data('date');
  var end = $('#active-datepicker2').data('date');
  var workid = $('#act-workid').text();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var resched = $.ajax({
    url: '/get/dash/resched',
    method: 'GET',
    data:{
      'start': start,
      'end' : end,
      'workid' : workid
    }
  });

  resched.done(function(data){
    console.log(data);
  });

});

$(document).on('click','#btn-prev',function(){
  $('#resched-start').click();
});

$('.active-body').attr('hidden',true);

}); // End of Document Ready


// upcomingJob();
// $('#late').hide();
var options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};
function error(err) {
  console.warn('ERROR(' + err.code + '): ' + err.message);
};


function activeJob(){
  $('.actend').attr('hidden',true);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var active = $.ajax({
    url: '/app/activeJob',
    method: 'GET',
  });

  active.done(function(data){
    console.log(data);
    if(data.active == 1){
      $('.active-body').attr('hidden',false);
      $('#actgmap').attr('hidden',false);
      $('#active-p').attr('hidden',true);
      $('#actitle').text(data.response[0].job.title);
      $('#actemp').text('Hired by '+data.response[0].employer.fname + ' '+ data.response[0].employer.lname);
      $('#actdesc').text(data.response[0].job.description);
      $('#modalemp').text(data.response[0].employer.fname + ' '+ data.response[0].employer.lname +'?');
      $('#empid').text(data.response[0].employer.user_id);
      $('#act-workid').text(data.response[0].work.work_id);
      var start = new moment(data.response[0].schedule.start);
      var end = new moment(data.response[0].schedule.end);
      var startDay1 = start.format('dddd');
      var startMonth = start.format('MMM');
      var startDay2 = start.format('D'); 
      var startYear = start.format('YYYY');
      var startTime = start.format('LT');
      var endDay1 = end.format('dddd');
      var endMonth = end.format('MMM');
      var endDay2 = end.format('D'); 
      var endYear = end.format('YYYY');
      var endTime = end.format('LT');

      if(data.response[0].work.is_started == 1){
        $('#actstart').fadeOut(400);
        $('#actend').fadeIn(600);
        $('#actend').removeClass('hidden');
        $('#head-min').text(end.fromNow(true));
        $('#head-meta').text('until session ends');
      }
      else{
       $('#head-min').text(start.fromNow(true));
       $('#head-meta').text('until job starts');
     }
     $('#emp-pic').attr('src',data.response[0].employer.avatar);
     $('#startDay').text(startDay1 + ', '+startMonth + '. '+startDay2 + ' '+startYear);
     $('#startTime').text(startTime);
     $('#endDay').text(endDay1 + ', '+endMonth + '. '+endDay2 + ' '+endYear);
     $('#endTime').text(endTime);
     $('#actsal').text('Php '+data.response[0].job.salary + ' / ' + data.response[0].paytype);
     $('#actstart').attr('workid',data.response[0].work.work_id);
     $('#actend').attr('workid',data.response[0].work.work_id);

     var meo = [];
     var locs;
     var centers = { lat: parseFloat(data.response[0].coord_address.destination.lat), lng: parseFloat(data.response[0].coord_address.destination.lng) };
     meo.push(centers);

     $('#actaddress').text(data.response[0].string_address.destination);
     $('#actdistance').text(data.response[0].distandtime.distance);
     $('#acttime').text(data.response[0].distandtime.duration);

     var directionsDisplay = new google.maps.DirectionsRenderer;
     var directionsService = new google.maps.DirectionsService;
     var origin = new google.maps.LatLng(data.response[0].coord_address.origin.lat, data.response[0].coord_address.origin.lng);
     var destination = new google.maps.LatLng(data.response[0].coord_address.destination.lat, data.response[0].coord_address.destination.lng);
     directionsDisplay.setMap(actmap);
     calculateAndDisplayRoute(directionsService, directionsDisplay);
     google.maps.event.trigger(actmap, 'resize');
     actmap.setCenter(destination);

     function calculateAndDisplayRoute(directionsService, directionsDisplay) {
      directionsService.route({
        origin: origin, 
        destination: destination,  
        travelMode: google.maps.TravelMode.DRIVING
      }, function(response, status) {
        if (status == 'OK') {
          directionsDisplay.setDirections(response);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });
    }
  }
});
}

// function ongoingJob(){
//   $('#ongoing-active').attr('hidden',true);
//    $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//       }
//     });

//   var ongoing = $.ajax({
//           url: '/app/ongoingJob',
//           method: 'GET'
//         });

//         ongoing.done(function(data){
//           console.log(data);
//           if(data.status == 1){
//              // $('#ongoing-active').attr('hidden',false);
//             // $('#ongoing-noactive').attr('hidden',true);

//             // $('#actitle').text(data.job.title);
//             // $('#actdesc').text(data.job.description);
//             // $('#actsched').text(data.sched.start + ' until ' + data.sched.end);
//             // $('#actworkid').text(data.work.work_id).attr('hidden',true);
//             // $('#actschedid').text(data.sched.schedule_id).attr('hidden',true);
//             // $('#actemployer').text(data.job.user_id).attr('hidden',true);
//           }
//           else{
//              // $('#ongoing-noactive').attr('hidden',false);
//             // $('#ongoing-active').attr('hidden',true);
//           }
//           if(data.status== 0){
//             alert('none');
//           }
//         });
// }

function upcomingJob(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var upcoming = $.ajax({
    url: '/app/upcomingJob',
    method: 'GET'
  });
  var schedids = [];
  upcoming.done(function(data){
    console.log(data);
    if(data.status == 0){
      $('#upcoming-p').attr('hidden',false);
    }
    else{
     $('#upcoming-p').attr('hidden',true);

     for(i=0; i<data.sched.length; i++){
      for(x=0; x<data.work.length;x++){
        if(data.sched[i].schedule_id == data.work[x].sched_id){
          for(y=0; y<data.job.length; y++){
            if(data.sched[i].job_id == data.job[y].job_id){
              for(z=0; z<data.profile.length; z++){
                if(data.job[y].user_id == data.profile[z].user_id){
                  if(schedids.indexOf(data.sched[i].schedule_id) < 0){
                    schedids.push(data.sched[i].schedule_id);
                    console.log(schedids);
                    var start = moment(data.sched[i].start);
                    var end = moment(data.sched[i].end);

                    var startDay1 = start.format('dddd');
                    var startMonth = start.format('MMM');
                    var startDay2 = start.format('D'); 
                    var startYear = start.format('YYYY');
                    var startTime = start.format('LT');

                    var endDay1 = end.format('dddd');
                    var endMonth = end.format('MMM');
                    var endDay2 = end.format('D'); 
                    var endYear = end.format('YYYY');
                    var endTime = end.format('LT');

                    $('#upcoming-timeline').append($('<li>').addClass('timeline-inverted')
                      .append($('<div>').addClass('timeline-badge danger'))
                      .append($('<div>').addClass('timeline-panel')
                        .append($('<div>').addClass('timeline-heading')
                          .append($('<div>').addClass('row')
                            .append($('<div>').addClass('col-md-12')
                              .append($('<div>').addClass('timeline-heading')
                                .append($('<h1>').text(data.job[y].title))
                                .append($('<p>').text('by ' + data.profile[z].fname + ' '+data.profile[z].lname))
                                .append($('<div>').addClass('uphead-button pull-right')
                                 .append($('<button>').addClass('btn btn-md btn-bookmark btn-seemore').text('See More').attr({workid:''+data.work[x].work_id,schedid:''+data.sched[i].schedule_id}))))
                              .append($('<div>').addClass('timeline-body')
                                .append($('<div>').addClass('jtitle')
                                  .append($('<p>').text(data.job[y].description))))
                              .append($('<div>').addClass('row upcontents')
                                .append($('<div>').addClass('col-md-6')
                                  .append($('<div>').addClass('sched')
                                    .append($('<p>').text(startDay1 + ', '+startMonth + '. '+startDay2 + ' '+startYear))
                                    .append($('<h1>').text(startTime))
                                    .append($('<p>').text('Starts at')))
                                  .append($('<div>').addClass('sched head-center')
                                    .append($('<h1>')
                                      .append($('<i>').addClass('fa fa-long-arrow-right').attr('aria-hidden','true'))))
                                  .append($('<div>').addClass('sched')
                                    .append($('<p>').text(endDay1 + ', '+endMonth + '. '+endDay2 + ' '+endYear))
                                    .append($('<h1>').text(endTime))
                                    .append($('<p>').text('Ends at'))))
                                .append($('<div>').addClass('col-md-3 cont-col')
                                  .append($('<div>').addClass('head-time')
                                    .append($('<h1>').text(start.fromNow(true)))
                                    .append($('<p>').text('From now'))))
                                .append($('<div>').addClass('col-md-3 cont-col')
                                  .append($('<div>').addClass('head-time')
                                    .append($('<h1>').text('PHP '+data.job[y].salary))
                                    .append($('<p>').text('You will receive'))))
                                ))))))
                  }
                }
              }
            }
          }
        }
      }
    }
  }
});
} //End of Upcoming Job

var actmap;
var geolocations;
var modalmap;
var markers = [];
function initializeMap(){
  $('#actgmap').attr('hidden',false);
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocations = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      actmap = new google.maps.Map(document.getElementById('actgmap'), {
        center: {lat: geolocations.lat, lng: geolocations.lng},
        zoom: 18
      });

      modalmap = new google.maps.Map(document.getElementById('modalgmap'), {
        center: {lat: geolocations.lat, lng: geolocations.lng},
        zoom: 18
      });

    })};

  }

  function loadEnd(){
   $("#loading").fadeOut(300);
 }

 $(document).on('click','#act-endbtn',function(e){
  if($('#act-endbtn').is('[disabled]')){

  }
  else{
    $('#endModal').modal('show');
  };

});


 $(document).on('click','.btn-seemore',function(){
  var workid = this.getAttribute('workid');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var seemore = $.ajax({
    url: '/app/dashboard/seemore',
    method: 'GET',
    data: {
      'workid' : workid,
    }
  });

  seemore.done(function(data){
    console.log(data);
    $('#modal-title').text(data.job.title);
    $('#modal-emp').text('by '+data.employer.fname + ' '+data.employer.lname);
    $('#modal-desc').text(data.job.description);
    $('#modal-sal').text( data.job.salary + ' / ' +data.paytype);
    var start = moment(data.schedule.start);
    var end = moment(data.schedule.end);
    
    var startDay1 = start.format('dddd');
    var startMonth = start.format('MMM');
    var startDay2 = start.format('D'); 
    var startYear = start.format('YYYY');
    var startTime = start.format('LT');

    var endDay1 = end.format('dddd');
    var endMonth = end.format('MMM');
    var endDay2 = end.format('D'); 
    var endYear = end.format('YYYY');
    var endTime = end.format('LT');

    $('#modal-startDay').text(startDay1 + ', '+startMonth + '. '+startDay2 + ' '+startYear);
    $('#modal-startTime').text(startTime);
    $('#modal-endDay').text(endDay1 + ', '+endMonth + '. '+endDay2 + ' '+endYear);
    $('#modal-endTime').text(endTime);
    $('#modal-fromnow').text(start.fromNow(true));

    var meo = [];
    var locs;
    var centers = { lat: parseFloat(data.address.lat), lng: parseFloat(data.address.lng) };
    meo.push(centers);

    $('#modal-address').text(data.address.address);

    function setMapOnAll(map){
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
    }
    setMapOnAll(null);
    var marker = new google.maps.Marker({
      map: modalmap,
      position: meo[0],
      title: 'Hello World!'
    });

    $('#modalgmap').attr('hidden',false);
    setTimeout(google.maps.event.trigger(modalmap, 'resize'),300);
    modalmap.setCenter(centers);
  });

  $('#seeMoreModal').modal('show');

});

 var endworkID =0;

 $(document).on('click','#actend',function(){
  var endworkID = $(this).attr('workid');
  promptEndjob(endworkID);
});

 function promptEndjob(endworkID){
  swal({
    title: "Do you wis to end the current job session?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Confirm",
    closeOnConfirm: true
  },
  function(){
    EndJobSummary(endworkID);
  });
}

function EndJobSummary(endworkID){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var end = $.ajax({
    url: '/applicant/endjob/summary',
    method: 'get',
    data:{
      'workid': endworkID
    }
  });

  end.done(function(data){
    console.log(data);

    var salary = data.work[0].salary;
    var paytype = data.work[0].paytype.name;
    var start =   moment(data.work[0].started.date);
    var end =  moment(data.work[0].ended.date);
    var img = data.work[0].employer.avatar;
    var totalsalary = data.work[0].total_salary;
    var rendered = data.work[0].rendered; 
    var fines = data.work[0].fines;

    $('#fines').text(fines);
    $('#btn-confirm').attr('workid',endworkID);
    $('#applicant-img').attr('src',img);
    $('#totalsalary').text('Php ' +totalsalary);
    $('#salary').text('Php ' + salary + ' / '+paytype);
    $('#date-started').text(start.format('dddd, MMM. Mo hh:mm a'));
    $('#date-ended').text(end.format('dddd, MMM. Mo hh:mm a'));
    $('#hours_render').text(rendered);

    $('#endJob-Modal').modal('show');
  })
}

$(document).on('click','#btn-confirm',function(){
  var workid = $(this).attr('workid');
  var review = $('#review').val();
  var rate = $('#rating-system').val();
  console.log(workid);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var endjob = $.ajax({
    url: '/applicant/endjob',
    method: 'get',
    data:{
      'workid': workid,
      'rate': rate,
      'review': review
    }
  });

  endjob.done(function(data){
    console.log(data);
    if(data.status == 400){
      swal("Please Retry!", "You must give a rating.", "error")
    }
    else{
      $('#endJob-Modal').modal('hide');
      swal({
        title: "Great!",
        text: "Succesfully ended the job.",
        showConfirmButton: false,
        timer: 2000
      });
      activeJob();
    }
  });

});

$(document).on('click','#actstart',function(){
 $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


 var startjob = $.ajax({
  url: '/applicant/job/start',
  method: 'GET',
  data: {
    'workid' : this.getAttribute('workid'),
  }
});

 startjob.done(function(data){
  console.log(data);

  if(data.status == 1){
    var end = new moment(data.end);
    console.log(end);
    if(data.late == 1){
      swal("Oops.. It looks like you have exceed the 30 mins late allowance, we will deduct the penalty on your salary. ", " ", "warning");
    }
    else{
      swal("Job has started.", "Work Hard!", "info");
    }
    $('#actstart').fadeOut(1000);
    $('#actend').fadeIn(2000);
    $('#actend').removeClass('hidden');
    $('#head-min').text(end.fromNow());
    $('#head-meta').text('until session ends');
  }

});

});
