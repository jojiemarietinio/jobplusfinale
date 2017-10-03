<div class="modal fade" id="jobpost-Modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="wiz-body">
            <div class="wizard">
              <div class="wizard-inner" >
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-briefcase"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-credit-card"></i>
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
                  <h1>Job Informations</h1>
                  <p>Kindly fill in the form below.</p>
                </div>  
                <div class="row">
                  <div class="col-sm-12 setup-header first-tab">
                    <div class="col-md-4 category">
                     <h3>Job Type</h3>
                     <select class="selectpicker" data-style="selectp" title="Select Job Type" id="job-type"></select>
                   </div>
                   <div class="col-md-4 category">
                    <h3>Category</h3>
                    <select class="selectpicker" data-style="selectp" title="Select Category" id="job-category"></select>
                  </div>
                  <div class="col-md-4 category">
                    <h3>Skills</h3>
                    <select class="selectpicker" data-style="selectp"  multiple title="Select skills" id="s-skill"></select>
                  </div>
                  <div class="form-group form-group-md col-sm-12">
                   <h3>Job Title</h3>
                   <input type="text" name="firstname"  class="setup-textp" id="jobtitle" >
                 </div>
                 <div class="form-group form-group-md col-sm-12">
                   <h3>Description</h3>
                   <textarea  class="setup-textp" style="width:100%;height:130px;" name="aboutme" form="setup" id="description"></textarea>
                 </div>
                 <div class="form-group form-group-md col-sm-12">
                   <h3>Job Address</h3>
                   <p>Search and click the map to pinpoint location</p>
                   <input id="clat" type="text" class="setup-textp hidden">
                   <input id="clong" type="text" class="setup-textp hidden">
                   <input type="text" name="address"  class="setup-textp" id="job-address">
                   <div class="map" id="map"></div>
                 </div>
                 <h2>Schedule</h2>
                 <div class="form-group form-group-md col-sm-6">
                   <h3>Start Date and time</h3>
                   <div class="input-group date form_datetime " data-date-format="dd MM yyyy - HH:ii p" data-link-field="job-start">
                    <input class="form-control"  type="text" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
                  <input type="hidden" id="job-start" value="" /><br/>
                </div>
                <div class="form-group form-group-md col-sm-6 end-date">
                 <h3>End Date</h3>
                 <div class="input-group date form_datetime " data-date-format="dd MM yyyy - HH:ii p" data-link-field="job-end">
                  <input class="form-control"  type="text" readonly>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="job-end" value="" /><br/>
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-nav btn-first next-step" id="next">Next Step</button>
        <div class="tab-pane" role="tabpanel" id="step2">
          <div class="tab-header">
            <h1>Payment Information</h1>
            <p>Kindly fill in the form below.</p>
          </div>
          <div class="row">
            <div class="col-sm-12 ">
            <span class="col-md-6">
             <h3>Applicants needed</h3>
             <select class="selectpicker" data-style="selectp"  title="Select slot" id="slot">
              <option value="1" class="selectoption" >1</option>
              <option value="2" class="selectoption" >2</option>
              <option value="3" class="selectoption" >3</option>
              <option value="4" class="selectoption" >4</option>
              <option value="5" class="selectoption" >5</option>
            </select>
          </span>
        </div>
        <div class="col-md-12">
          <span class="col-md-6">
            <h3>Salary</h3>
            <input type="text" name="no-show" class="setup-textp" id="salary">
          </span>
          <span class="col-md-6">
           <h3>Paytype</h3>
           <select class="selectpicker" data-style="selectp"  title="Select Paytype" id="job-paytype"></select>
         </span>
       </div>
     </div>
     <ul class="list-inline btn-second">
      <li><button type="button" class="btn  btn-prev prev-step">Previous</button></li>
      <li><button type="button" class="btn btn-nav next-step" id="goto3">Next Step</button></li>
    </ul>
  </div>
  <div class="tab-pane" role="tabpanel" id="step3">
    <div class="tab-header">
      <h1>Job Summary</h1>
      <p>Please confirm the informations below.</p>
    </div>
    <div class="row">
      <div class="setup-header step3">
        <div class="col-sm-12 setup-header">
          <h3>Job Type</h3>
          <p id="sum-jobtype"></p> 
          <hr>
          <h3>Category</h3>
          <p id="sum-category"></p>
          <hr>              
          <h3>Skill/s</h3>
          <p id="sum-skill"></p> 
          <hr>             
          <h3>Job Title</h3>
          <p id="sum-title"></p>
          <hr>
          <h3>Description</h3>
          <p id="sum-description"></p>
          <hr>
          <h3>Job address</h3>
          <p id="sum-address"></p>
          <hr>
          <h2>Schedule</h2>
          <h3>Start</h3>
          <p id="sum-start"></p>
          <h3>End</h3>
          <p id="sum-end"></p>
          <hr>
          <h3>Applicants Needed</h3>
          <p id="sum-slot"></p>
          <hr>
          <h3>Salary</h3>
          <p id="sum-salary" class="sum-sal"></p>
          <p id="sum-paytype"></p>
        </div>
      </div>
    </div>
    <ul class="list-inline  btn-second">
      <li><button type="button" class="btn btn-prev prev-step">Previous</button></li>
      <li><button type="button" class="btn btn-finish next-step">Finish</button></li>
    </ul>
  </div>
</div>
</div>
</div>
</div>
</div> 
</div>
</div>
</div>