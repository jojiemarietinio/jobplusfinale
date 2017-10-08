$(document).ready(function(){
    initialize();
    initializeMap();
    // $('.jobfeeds').append($('<div>').addClass('feed-cont')
    //  .append($('<div>').addClass('feed-body')
    //      .append($('<h2>').text('Need Katabang'))
    //      .append($('<p>').text('posted on Thursday, March. 12, 2017'))
    //      .append($('<p>').text('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porttitor lectus nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vivamus suscipit tortor eget felis porttitor volutpat.')))
    //  .append($('<span>').addClass('slot')
    //      .append($('<p>').text('Available slot'))
    //      .append($('<p>').text('1')))
    //  .append($('<div>').addClass('feed-footer')
    //      .append($('<div>').addClass('col-md-6')
    //          .append($('<div>').addClass('applicants')
    //              .append($('<span>').addClass('app-img')
    //                  .append($('<img>').attr('src','/img/dp.jpg'))
    //                  .append($('<img>').attr('src','/img/cd.jpg'))
    //                  .append($('<img>').attr('src','/img/db.jpg'))
    //                  )
    //              .append($('<p>').text('Pending Applicant/s'))))
    //      .append($('<div>').addClass('col-md-4 btn-feeds')
    //          .append($('<button>').addClass('btn btn-sm btn-viewjob').text('View Job'))
    //          )))
    $('a[href="#step2"]').on('show.bs.tab',function(){
        var container = [];
        var skills = $('#s-skill').val();
        console.log(skills);
    });
    $(document).on('click','.btn-finish',function(e){
        e.preventDefault();
        var category = $('#job-category option:selected').val();
        var skills = $('#s-skill option:selected').val();
        var title = $('#jobtitle').val();
        var description = $('#description').val();
        var address = $('#job-address').val();
        var start = $('#job-start').val();
        var end = $('#job-end').val();
        var slot = $('#slot option:selected').val();
        var salary = $('#salary').val();
        var paytype = $('#job-paytype option:selected').val();
        var jobtype = $('#job-type option:selected').val();
        var skills = $('#s-skill').val();
        var lat = $('#clat').val();
        var lng = $('#clong').val();
        $('#jobpost-Modal').modal('hide');
        // $('#recommended-Modal').modal('show');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sel = $.ajax({
            url: '/set/postjob',
            method: 'GET',
            data:{
                'category': category,
                'skills': skills,
                'title':title,
                'description':description,
                'address':address,
                'start':start,
                'end':end,
                'slot':slot,
                'salary':salary,
                'paytype':paytype,
                'jobtype':jobtype,
                'lat':lat,
                'lng':lng,
                'locality':local
            }
        });
        sel.done(function(data){
            console.log(data);
            thankAlert();
            initialize();
        });
    });
    function thankAlert(){
        swal("Thank You!", "You have successfuly posted a job!", "success");
    };
    $(document).on('click','#goto3',function(e){
        e.preventDefault();
        var category = $('#job-category option:selected').text();
        var skills = $('#s-skill option:selected').text();
        var title = $('#jobtitle').val();
        var description = $('#description').val();
        var address = $('#job-address').val();
        var start = $('#job-start').val();
        var end = $('#job-end').val();
        var slot = $('#slot option:selected').text();
        var salary = $('#salary').val();
        var paytype = $('#job-paytype option:selected').text();
        var jobtype = $('#job-type option:selected').text();
        $('#sum-category').text(category);
        $('#sum-title').text(title);
        $('#sum-description').text(description);
        $('#sum-address').text(address);
        $('#sum-start').text(start);
        $('#sum-end').text(end);
        $('#sum-slot').text(slot);
        $('#sum-salary').text(salary);
        $('#sum-paytype').text('/ '+ paytype);
        $('#sum-jobtype').text(jobtype);
        $('#sum-skill').text(skills);
    });
    $(document).on('change','#job-category',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sel = $.ajax({
            url: '/app/job/getskill',
            method: 'GET',
            data:{
                'cat':$('#job-category option:selected').val(),
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
    $(document).on('click','#btn-postjob',function(){
        $('#jobpost-Modal').modal('show');
    });
    // $('#job-startdate').on('dp.change',function(e){
    //  $('#job-enddate').data("DateTimePicker").minDate(e.date);
    // });
    // $('#job-enddate').on('dp.change',function(e){
    //  console.log(e);
    //  $('#job-startdate').data("DateTimePicker").maxDate(e.date);
    //  writeDates();
    // });
    // $('.time').datetimepicker({
    //  format:"h:mm a"
    // });
    // $('#table-dates').append($('<tr>')
    //                  .append($('<td>').text('March 13 2017'))
    //                  .append($('<td>').append($('<input>').attr({type:'text',class:'form-control time',id:'start-time'})))
    //                  .append($('<td>').append($('<input>').attr({type:'text',class:'form-control time',id:'end-time'})))
    //                  );
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
function initialize(){
$('.jobfeeds').hide('slow');
$('.jobfeeds').empty();
    $(".form_datetime").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        showMeridian: true,
        pickerPosition: "bottom-left"
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var jobdatas = $.ajax({
        url:'/employer/jobpost/data',
        method:'GET',
    });
    jobdatas.done(function(data){
        console.log(data);
        $('.jobfeeds').show('slow');
        $.each(data.category,function(key,val){
            $('#job-category').append($('<option>').text(val.name).attr('value',val.category_id).addClass('selectoption'))
        });
        $.each(data.paytype,function(key,val){
            $('#job-paytype').append($('<option>').text(val.name).attr('value',val.paytype_id).addClass('selectoption'))
        });
        $.each(data.jobtype,function(key,val){
            $('#job-type').append($('<option>').text(val.name).attr('value',val.jobtype_id).addClass('selectoption'))
        });
        $('#job-category').selectpicker('refresh');
        $('#job-paytype').selectpicker('refresh');
        $('#job-type').selectpicker('refresh');
        for(var i=0; i<data.jobs.length;i++){
            var day= new moment(data.jobs[i].posted).format('dddd');
            var date = new moment(data.jobs[i].posted).format('MMM Do YYYY');
            $('.jobfeeds').append($('<div>').addClass('feed-cont')
                .append($('<div>').addClass('feed-body')
                    .append($('<h2>').text(data.jobs[i].title))
                    .append($('<p>').text('posted on ' + day + ', ' + date))
                    .append($('<p>').text(data.jobs[i].description)))
                .append($('<span>').addClass('tool')
                    .append($('<span>').addClass('btn-feeds')
                        .append($(' ').addClass(' ').text(' ').attr('jobid',data.jobs[i].id))))
                .append($('<div>').addClass('feed-footer')
                    .append($('<div>').addClass('col-md-3')
                        .append($('<div>').addClass('job-info')
                            .append($('<h2>').text(data.jobs[i].category))
                            .append($('<p>').text('Category'))))
                    .append($('<div>').addClass('col-md-3')
                        .append($('<div>').addClass('job-info')
                            .append($('<h2>').text(data.jobs[i].jobtype))
                            .append($('<p>').text('Job Type'))))
                    .append($('<div>').addClass('col-md-3')
                        .append($('<div>').addClass('job-info')
                            .append($('<h2>').text(data.jobs[i].salary + ' /' + data.jobs[i].paytype))
                            .append($('<p>').text('Salary'))))
                    .append($('<div>').addClass('col-md-3')
                        .append($('<div>').addClass('job-info slot')
                            .append($('<h2>').text(data.jobs[i].slot))
                            .append($('<p>').text('Available Slot'))))
                    )
                )
        }
    }
    );
}
 
$(document).on('click','.btn-viewjob',function(){
  var jobid = this.getAttribute('jobid');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var viewjob = $.ajax({
    url: '/get/employer/viewJob',
    method: 'GET',
    data: {
      'jobid' : jobid,
    }
  });

  viewjob.done(function(data){
    console.log(data);
    $('#modal-title').text(data.jobs.title);
    $('#modal-emp').text('by '+data.employer.fname + ' '+data.employer.lname);
    $('#modal-desc').text(data.jobs.description);
    $('#modal-sal').text( data.jobs.salary + ' / ' +data.paytype);
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

  $('#viewJob-Modal').modal('show');

});

var local;
var map;
var centers = {lat:10.309937078055952,lng:123.89307975769043};
function initializeMap(){
    map = new google.maps.Map(document.getElementById('map'), {
        center:centers,
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.HYBRID
    });
    var input = document.getElementById('job-address');
    var searchBox = new google.maps.places.SearchBox(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });
        var markers = [];
        google.maps.event.addListener(map, 'click', function (e) {
            var ll = {lat: e.latLng.lat(), lng: e.latLng.lng()};
              //alert(e.latLng.lat());
              markers.forEach(function(marker) {
                marker.setMap(null);
              });
              markers = [];
              lastMarker = new google.maps.Marker({
                position: ll,
                map: map,
                title: 'Hello World!'
              });
              markers.push(lastMarker);
              getAddressByLatlng(ll);
          });
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];
          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
      });
          map.fitBounds(bounds);
      });
        function getAddressByLatlng(latlng){
            var lat =latlng.lat;
            var lng =latlng.lng;
            var inputSearchBox = document.getElementById('job-address');
            var cLatValId = document.getElementById('clat');
            var cLongValId = document.getElementById('clong');
            cLatValId.value=lat;
            cLongValId.value=lng;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        inputSearchBox.value =  results[1].formatted_address;
                    }
                    var res = results[0].address_components;
                    for(var i=0; i<res.length; i++){
                        for (var y = 0; y<(res[i].types).length; y++) {
                            if(res[i].types[y] === "locality") {
                                local= res[i].long_name;
                            }
                        }
                     }
                 }
            });
        }
    }



 