@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/profile.css">
<link rel="stylesheet" href="/css/dropzone.min.css">
@endsection
@section('body')
<div id="loading">
  <div id="loading-center">
    <div id="loading-center-absolute">
      <div class="object" id="object_one"></div>
      <div class="object" id="object_two"></div>
      <div class="object" id="object_three"></div>
      <div class="object" id="object_four"></div>
    </div>
  </div>
</div>

<div class="hero" id="top">
  <div class="container hero-container">
    <h1>My Profile</h1>
  </div>
  <a href="#top" class="hidden" id="scroll"></a>
</div>
<div class="container">
  <div class="col-md-8">
    <div class="profcontainer">
      <div class="profbody main">
        <div class="col-md-3 pic-container">
          <span class="pic-body">
          <form action="{{route('user/upload')}}" method="POST" id="my-dropzone" class="form single-dropzone" files="true">
                {{ csrf_field() }}
                  <img src="{{Auth::user()->profile->avatar}}" class="profile-pic" id="prof-pic">
              </form>
          </span>
        </div>
        <div class="top-name col-md-offset-3">
          <div class="name-loc">
           <h1 class="prof-name"></h1>
           <i class="fa fa-lg fa-map-marker" aria-hidden="true"></i><p id="address"></p>
         </div>
         <div id="prof-skills" class="skills mousein">
          <div class="no-skill">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <p>Add Skills</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="profcontainer">
    <div class="profbody body-overview" >
      <div class="row profinfo">
        <h1>Overview</h1>
      </div>
      <p id="overview"></p>
    </div>
  </div>

  <div class="profcontainer">
    <div class="profbody">
      <div class="row profinfo">
        <button class="btn btn-md pull-right btn-tool" id="btnAddEdu"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
        <h1>Education</h1>
        <div id="divEdu"></div>
      </div>
    </div>
  </div>

<!--   <div class="profcontainer">
    <div class="profbody">
      <div class="row profinfo">
        <button class="btn btn-md pull-right btn-tool" id="btnAddWork"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
        <h1>Work & Experience</h1>
        <div id="divWork"></div>
      </div>
    </div>
  </div> -->

  <div class="profcontainer">
    <div class="profbody">
      <h1>Work Experience & Reviews</h1>
      <div id="divHistory">
      </div>    
    </div>
  </div>
</div> <!-- End of col-md-8 -->

<div class="col-md-4">
  <div class="profcontainer">
    <div class="profbody">
      <div class="balance">
        <h1>Balance </h1>
        <h1><i class="fa fa-usd" aria-hidden="true"></i>30.12</h1>
      </div>
    </div>
  </div>

  <button class="btn btn-block btn-lg"><i class="fa fa-cog" aria-hidden="true"></i> Account Settings</button>
</div> <!-- End of col-md-4 -->

<!-- Name Modal -->
<div class="modal fade" id="modal-name" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">Basic Information</h1>
        <p>Name and address.</p>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group-md col-sm-6 ">
           <h3>Firstname</h3>
           <input type="text" name="firstname" class="setup-textp" id="firstname">
         </div>
         <div class="form-group form-group-md col-sm-6 setup-header">
          <h3>Lastname</h3>
          <input type="text" name="lastname"  class="setup-textp" id="lastname" >
        </div>
        <div class="form-group form-group-md col-sm-12 setup-header">
          <h3>Location</h3>
          <input type="text" name="address"  class="setup-textp" id="modal-address" >
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" id="btn-update-name" class="btn btn-save btn-primary" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
    </div>
  </div> 
</div>
</div>

<!-- Skill Modal -->
<div class="modal fade" id="modal-skill" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">What are your skills?</h1>
        <p>Select your designated skills below.</p>
      </div>
      <div class="modal-body">
        <div class="row">
        <p id="clickme">Click me</p>
          <div class="col-md-3">
            <h3>Housekeeping</h3>
            <select name="house" id="house" class="selectpicker " data-style="setup-selectp" data-width="100%" multiple="multiple"></select>
          </div>
          <div class="col-md-3">
            <h3>Construction</h3>
            <select name="construction" id="construction" class="selectpicker " data-style="setup-selectp" data-width="100%" multiple="multiple"></select>
          </div>
          <div class="col-md-3">
            <h3>Personel</h3>
            <select name="personel" id="personel" class="selectpicker " data-style="setup-selectp" data-width="100%" multiple="multiple"></select>
          </div>
          <div class="col-md-3">
            <h3>Maintenance</h3>
            <select name="maintenance" id="maintenance" class="selectpicker " data-style="setup-selectp" data-width="100%" multiple="multiple"></select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btn-update-skill" class="btn btn-save btn-primary" data-dismiss="modal">Update</button>
        <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
      </div>
    </div> 
  </div>
</div>

<!-- Overview Modal -->
<div class="modal fade" id="modal-overview" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">How would you describe yourself?</h1>
        <p>Fill in the form below</p>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="form-group form-group-md col-sm-12">
           <h3>Overview</h3>
           <textarea  class="setup-textp" style="width:100%;height:130px;" name="aboutme" form="setup" id="modal-input-overview" ></textarea>
         </div>
       </div>
     </div>
     <div class="modal-footer">
      <button type="submit" id="btn-update-overview" class="btn btn-save btn-primary" data-dismiss="modal">Update</button>
      <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
    </div>
  </div> 
</div>
</div>

<!-- Education Modal -->
<div class="modal fade" id="eduModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">Where did you go to school?</h1>
        <p>Specify the school you've attended.</p>   
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group form-group-md col-sm-6 setup-school">
           <h3>Attainment</h3>
           <select name="attainment" id="attainment" class="selectpicker " data-style="setup-selectp" data-width="40%">
           </select>
         </div>
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

<!-- Update Education Modal -->
<div class="modal fade" id="EditeduModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">Where did you go to school?</h1>
        <p>Specify the school you've attended.</p>                
      </div>
      <div class="modal-body">
        <p class="hidden" id="educid"></p>
        <div class="row">
          <div class="form-group form-group-md col-sm-6 setup-school">
           <h3>Attainment</h3>
           <select name="attainment" id="edit-attainment" class="selectpicker " data-style="setup-selectp" data-width="40%">
           </select>
         </div>
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
     <p class="pull-left" id="edu-delete" data-dismiss="modal">Delete this education</p>
     <button type="submit" id="btn_editedu" class="btn btn-save btn-primary" data-dismiss="modal">Update</button>
     <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
   </div>
 </div> 
</div>
</div>

<!-- Work Modal -->
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
            <input type="text" class="setup-textp" name="employer" id="employer">
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

<!-- Update Work Modal -->
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
     <p class="pull-left" id="work-delete" data-dismiss="modal">Delete this education</p>
     <button type="submit" id="btn_editwork" class="btn btn-save btn-primary" data-dismiss="modal">Save</button>
     <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
   </div>
 </div> 
</div>
</div>

</div>
<!--End of Container -->
@endsection

@section('js')
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/dropzone.min.js"></script>
<script src="/js/jquery.barrating.min.js"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places"></script>
<script src="/js/profiles.js"></script>
@endsection