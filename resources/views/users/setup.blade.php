@extends('masters.AppSetup')
@section('css')
<link rel="stylesheet" href="/css/setup.css">
<link rel="stylesheet" href="/css/dropzone.min.css">
@endsection
@section('body')
<div class="hero" id="top">
  <div class="container hero-container">
    <h1>Hi {{Auth::user()->username}}, let's setup your account first</h1>
  </div>
  <a href="#top" class="hidden" id="scroll"></a>
</div>
<div class="container">
  <div class="row wiz-body">
    <section>
      <div class="wizard">
        <div class="wizard-inner" >
          <div class="connecting-line"></div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                <span class="round-tab">
                  <i class="glyphicon glyphicon-user"></i>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                <span class="round-tab">
                  <i class="glyphicon glyphicon-wrench"></i>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                <span class="round-tab">
                 <i class="glyphicon glyphicon-ok"></i>
               </span>
             </a>
           </li>
         </ul>
       </div>
       <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="step1">
          <div class="tab-header">
            <h1>Basic Informations</h1>
            <p>Kindly fill in the form below.</p>
          </div>  
          <div class="row">
            <div class="col-sm-12 setup-header">
              <h2>Upload Picture</h2>
              <form action="{{route('user/upload')}}" method="POST" id="my-dropzone" class="form single-dropzone" files="true">
                {{ csrf_field() }}
                <button id="upload-submit" class="btn btn-upload">
                 <div id="img-thumb-preview">
                  <img id="img-thumb" class="user size-lg img-thumbnails" src="/img/setup-hero.jpg">
                  <h1>Click to upload</h1>
                  <i class="fa fa-2x fa-upload" aria-hidden="true"></i>
                </button> 
              </form>
            </div>
          </div>
          <hr>
          <div class="row setup-header">
           <h1>Personal Information</h1>
           <p>(Name , Contact, Address, etc.)</p>
           <div class="form-group-md col-sm-6 ">
             <h3>Firstname</h3>
             <input type="text" name="lastname" class="setup-textp" id="lastname">
           </div>
           <div class="form-group form-group-md col-sm-6 setup-header">
            <h3>Lastname</h3>
            <input type="text" name="firstname"  class="setup-textp" id="firstname" >
          </div>
          <div class="form-group form-group-md col-sm-6 setup-header">
            <h3>Current Address (City)</h3>
            <input type="text" name="address"  class="setup-textp" id="address" >
          </div>
          <div class="form-group form-group-md col-sm-6 setup-header">
            <h3>Mobile Number</h3>
            <input type="text" name="mobile"  class="setup-textp" id="mobile">
          </div>
        </div>
        <div class="row setup-header">
          <div class="form-group form-group-md col-sm-12">
           <h3>About Yourself</h3>
           <textarea  class="setup-textp" style="width:100%;height:130px;" name="aboutme" form="setup" id="about" placeholder="Tell us about yourself"></textarea>
         </div>
       </div>
       <hr>
       <div class="row setup-header div-edu">
         <h1>Where did you go to school?</h1>
         <p>(Highschool, College, University, etc.)</p>
         <div class="modal fade" id="eduModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header edu-header">
                <h1 class="modal-title">Where did you go to school?</h1>
              </div>
              <div class="modal-body">
                <div class="row">
                 <h3>Attainment</h3>
                 <select name="attainment" id="attainment" class="selectpicker " data-style="setup-selectp" data-width="20%">
                 </select>
               </div>
               <div class="row">
                 <div class="form-group form-group-md col-sm-6 setup-school">
                   <h3>School</h3>
                   <div id="divschool">
                    <input type="text" class="setup-textp" name="school" id="school">
                  </div>
                </div>
                <div class="form-group form-group-md col-sm-3">
                 <h3>From</h3>
                 <div id="divstartyear">
                   <select name="yearstart" id="yearstart" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
                     @for($x=2016; $x >1950; $x--)
                     <option class="setup-selectoption" value="{{ $x }}" >{{ $x }}</option>
                     @endfor
                   </select>
                 </div>
               </div>
               <div class="form-group form-group-md col-sm-3 setup-year">
                 <h3>To (Year ended)</h3>
                 <div id="divendyear">
                   <select name="yearend" id="yearend" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
                     @for($x=2025; $x >1950; $x--)
                     <option class="setup-selectoption" value="{{ $x }}" >{{ $x }}</option>
                     @endfor
                   </select>
                 </div>
               </div>
             </div>
             <div class="row">
               <div class="form-group form-group-md col-md-6 setup-school divdeg">
                 <h3>Degree</h3>
                 <div id="divschool" class="form-group">
                   <select name="degree" id="degree" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
                     <option class="setup-selectoption">Select a Degree</option>
                   </select>
                 </div>
               </div>
               <div class="form-group form-group-md col-md-6 setup-school divmajor">
                 <h3>Field of Study</h3>
                 <div id="divschool" class="form-group">
                   <select name="field_study" id="field_study" class="selectpicker form-control" data-style="setup-selectp" data-width="100%"></select>
                 </div>
               </div>
             </div>
           </div>

           <div class="modal-footer">
            <button type="submit" id="btn_edusave" class="btn btn-save btn-primary" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
          </div>
        </div> 
      </div>
    </div>

    <div class="modal fade" id="EditeduModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header edu-header">
            <h1 class="modal-title">Where did you go to school?</h1>
            <img id="emp-pic" class="modal-pic">
          </div>
          <div class="modal-body">
            <p class="hidden" id="educid"></p>
            <div class="row">
             <h3>Attainment</h3>
             <select name="attainment" id="edit-attainment" class="selectpicker " data-style="setup-selectp" data-width="20%">
             </select>
           </div>
           <div class="row">
             <div class="form-group form-group-md col-sm-6 setup-school">
               <h3>School</h3>
               <div id="divschool">
                <input type="text" class="setup-textp" name="school" id="edit-school">
              </div>
            </div>
            <div class="form-group form-group-md col-sm-3">
             <h3>From</h3>
             <div id="divstartyear">
               <select name="yearstart" id="edit-yearstart" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
                 @for($x=2016; $x >1950; $x--)
                 <option class="setup-selectoption" value="{{ $x }}" >{{ $x }}</option>
                 @endfor
               </select>
             </div>
           </div>
           <div class="form-group form-group-md col-sm-3 setup-year">
             <h3>To (Year ended)</h3>
             <div id="divendyear">
               <select name="yearend" id="edit-yearend" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
                 @for($x=2025; $x >1950; $x--)
                 <option class="setup-selectoption" value="{{ $x }}" >{{ $x }}</option>
                 @endfor
               </select>
             </div>
           </div>
         </div>
         <div class="row">
           <div class="form-group form-group-md col-md-6 setup-school divdeg">
             <h3>Degree</h3>
             <div id="divschool" class="form-group">
               <select name="degree" id="edit-degree" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
                 <option class="setup-selectoption">Select a Degree</option>
               </select>
             </div>
           </div>
           <div class="form-group form-group-md col-md-6 setup-school divmajor">
             <h3>Field of Study</h3>
             <div id="divschool" class="form-group">
               <select name="field_study" id="edit-field_study" class="selectpicker form-control" data-style="setup-selectp" data-width="100%"></select>
             </div>
           </div>
         </div>
       </div>
       <div class="modal-footer">
        <button type="submit" id="btn_editedu" class="btn btn-save btn-primary" data-dismiss="modal">Update</button>
        <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
      </div>
    </div> 
  </div>
</div>

<div id="divEdu"></div>
<button id="btnAddEdu" class="btn btn-md"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Add Education</button>
</div>
<button type="button" class="btn btn-nav btn-first next-step" id="next">Next Step</button>
</div>
<div class="tab-pane" role="tabpanel" id="step2">
  <div class="tab-header">
    <h1>Work Experience and Skills</h1>
    <p>Kindly fill in the form below.</p>
  </div>
  <div class="row setup-header">
   <h1>What is your current/recent work?</h1>
   <p>(Your past or recent work experience.)</p>
   <div id="divWork"></div>
   <button class="btn btn-md" id="btnAddWork"><i class="fa fa-briefcase" aria-hidden="true"></i> Add Work</button>
   <div class="modal fade" id="workModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header edu-header">
          <h1 class="modal-title">What was your recent work?</h1>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group form-group-md col-sm-6">
             <h3>You've worked as</h3>
             <input type="text" name="worktitle"  class="setup-textp" id="worktitle" >
           </div>
         </div>
         <div class="row">
           <div class="form-group form-group-md col-sm-6 ">
             <h3>Employer</h3>
             <div id="divschool">
              <input type="text" class="setup-textp" name="school" id="employer">
            </div>
          </div>
          <div class="form-group form-group-md col-sm-3">
           <h3>Year</h3>
           <div id="divstartyear">
             <select name="yearstart" id="workstart" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
               @for($x=2016; $x >1950; $x--)
               <option class="setup-selectoption" value="{{ $x }}" >{{ $x }}</option>
               @endfor
             </select>
           </div>
         </div>
       </div>
     </div>
     <div class="modal-footer">
      <button type="submit" id="btn_worksave" class="btn btn-save btn-primary" data-dismiss="modal">Save</button>
      <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
    </div>
  </div> 
</div>
</div>

<div class="modal fade" id="edit-workModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">What was your recent work?</h1>
      </div>
      <div class="modal-body">
        <div class="row">
          <p class="hidden" id="workid"></p>
          <div class="form-group form-group-md col-sm-6">
           <h3>You've worked as</h3>
           <input type="text" name="edit-worktitle"  class="setup-textp" id="edit-worktitle" >
         </div>
       </div>
       <div class="row">
         <div class="form-group form-group-md col-sm-6 ">
           <h3>Employer</h3>
           <div id="divschool">
            <input type="text" class="setup-textp" name="employer" id="edit-employer">
          </div>
        </div>
        <div class="form-group form-group-md col-sm-3">
         <h3>Year</h3>
         <div id="divstartyear">
           <select name="yearstart" id="edit-workstart" class="selectpicker form-control" data-style="setup-selectp" data-width="100%">
             @for($x=2016; $x >1950; $x--)
             <option class="setup-selectoption" value="{{ $x }}" >{{ $x }}</option>
             @endfor
           </select>
         </div>
       </div>
     </div>
   </div>
   <div class="modal-footer">
    <button type="submit" id="btn_editwork" class="btn btn-save btn-primary" data-dismiss="modal">Save</button>
    <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
  </div>
</div> 
</div>
</div>

</div>
<hr>
<div class="row setup-header">
 <h1>What are your skills? </h1>
 <p>(Select your designated skills below.)</p>
 <div class="col-md-3">
  <h3>Housekeeping</h3>
  <ul class="input-list">
   <li class="setup-skills">
    @foreach ($housekeeping as $house)
    <label>
      <input id="{{$house->name}}" class="skill-select" name="housekeeping[]" type="checkbox" value="{{$house->skill_id}}"/>
      {{$house->name}}
    </label>
    @endforeach
  </li>
</ul>
</div>
<div class="col-md-3">
  <h3>Construction</h3>
  <ul class="input-list">
   <li class="setup-skills">
     @foreach ($construction as $cons)
     <label>
      <input id="{{$cons->name}}" name="construction[]" type="checkbox" value="{{$cons->skill_id}}"/>
      {{$cons->name}}
    </label>
    @endforeach
  </li>
</ul>
</div>
<div class="col-md-3">
  <h3>Personel</h3>
  <ul class="input-list">
   <li class="setup-skills">
    @foreach ($personel as $per)
    <label>
     <input id="{{$per->name}}[]" name="personel[]" type="checkbox" value="{{$per->skill_id}}"/>
     {{$per->name}}
   </label>
   @endforeach
 </li>
</ul>
</div>
<div class="col-md-3">
  <h3>Maintenance</h3>
  <ul class="input-list">
   <li class="setup-skills">
    @foreach ($maintenance as $main)
    <label>
      <input id="{{$main->name}}" value="{{$main->skill_id}}" name="maintenance[]" type="checkbox"/>
      {{$main->name}}
    </label>
    @endforeach
  </li>
</ul>
</div>
</div>
<ul class="list-inline btn-second">
  <li><button type="button" class="btn  btn-prev prev-step">Previous</button></li>
  <li><button type="button" class="btn btn-nav next-step">Next Step</button></li>
</ul>
</div>
<div class="tab-pane" role="tabpanel" id="step3">
  <div class="tab-header">
    <h1>Mobile Verification</h1>
    <p>We've sent a code in your mobile number</p>
  </div>
  <div class="row setup-header step3">
    <h1>Enter the code we've sent below</h1>
    <div class="col-md-6 verif-input" >
      <input type="text" class="setup-textp" id="verification" >
      <button class="btn btn-md" id="btn_verify">Verify</button>
      <p id="resend-code">Didn't receive any code yet? Resend code</p>
    </div>
    <div class="col-md-6">
      <img src="/img/sms.png" id="sms">
    </div>
  </div>
  <ul class="list-inline  btn-third">
    <li><button type="button" class="btn btn-prev prev-step">Previous</button></li>
  </ul>
</div>

<form action="{{route('app/dashboard')}}" method="get">
  <button type="submit" class="hidden" id="btn_redirect"></button>
</form>

</div>
</div>
</section>
</div>
</div>
@stop
@section('js')
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script src="/js/dropzone.min.js"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script src="/js/setup.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places"></script>
@endsection
