<div class="modal fade" id="endJob-Modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="wiz-body">
            <div class="wizard">
              <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                  <div class="tab-header header-top">
                    <h1>Work Summary</h1>
                  </div>  
                  <div class="row">
                    <div class="col-sm-12 setup-header first-tab">
                      <div class="col-md-6 category">
                       <h3 id="hours_render">2</h3>
                       <p>Total hours rendered</p>
                     </div>
                     <div class="col-md-6 category">
                      <h3 id="totalsalary"></h3>
                      <p>Total service fee</p>
                    </div>
                    <div class="col-md-6 work-time">
                      <h1>Time</h1>
                      <span class="started">
                       <p>Date started:</p>
                       <p id="date-started"></p>
                     </span>
                     <span class="ended">
                      <p>Date ended:</p>
                      <p id="date-ended"></p>
                    </span>
                  </div>
                  <div class="col-md-6 work-time">
                    <h1>Service Fee</h1>
                    <span class="fines">
                     <p>Late fines:</p>
                     <p id="fines"></p>
                   </span>
                   <span class="salary">
                     <p>Service fee:</p>
                     <p id="salary"></p>
                   </span>
                 </div>
               </div>
             </div>
             <div class="row">
               <div class="col-md-12">
                 <div class="rating tab-header">
                   <h1>Rate your Employer</h1>
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
           <button type="button" class="btn btn-nav confirm-end" id="btn-confirm">Rate Employer</button>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div> 
</div>
</div>
</div>