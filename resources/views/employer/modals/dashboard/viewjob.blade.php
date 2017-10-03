<div class="modal fade" id="viewJob-Modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="wiz-body">
            <div class="wizard">
              <div class="wizard-inner" >
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                      <span class="round-tab">
                        <i class="glyphicon glyphicon-briefcase"></i>
                      </span>
                    </a>
                  </li>

                </ul>
              </div> 
              <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                  <div class="tab-header">
                    <h1>View Job</h1>
                  </div>  
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
             <div class="row">
               <div class="col-md-12">
                 <div class="rating tab-header">
                   <h1>Rate your Applicant</h1>
                 </div>
                 <span class="app-img">
                 <img id="applicant-img">
                 </span>
                 <input id="rating-system" name="rate" type="number" class="rating" min="1" max="5" step="1">
                 <hr>
                 <div class="form-group ">
                   <textarea style="width:100%;height:130px;font-size:19px;padding:15px;" name="review" id="review" placeholder="Write a short review."></textarea>
                 </div>
               </div>
             </div>
           <button type="button" class="btn btn-nav confirm-end" id="btn-confirm">Rate Applicant</button>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div> 
</div>
</div>
</div>