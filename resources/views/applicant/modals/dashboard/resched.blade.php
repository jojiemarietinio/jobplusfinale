<div class="modal fade" id="actResched-Modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header edu-header">
        <h1 class="modal-title">Request for reschedule</h1>
        <p>Select the date and time below.</p>
      </div>

      <div class="modal-body">
        <div class="row">
          <ul class="nav nav-tabs resched-head" role="tablist">
            <li role="presentation" class="active"><a href="#start" aria-controls="start" role="tab" data-toggle="tab" id="resched-start">Start</a></li>
            <li role="presentation"><a href="#end" aria-controls="end" role="tab" data-toggle="tab" id="resched-end">End</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="start">
             <div style="overflow:hidden;">
              <div class="form-group">
                <div id="active-datepicker1"></div>
              </div>
            </div>
            <button class="btn  btn-cancel" id="btn-next">Next   <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
          </div>
          <div role="tabpanel" class="tab-pane" id="end">
            <div style="overflow:hidden;">
              <div class="form-group">
                <div id="active-datepicker2"></div>
              </div>
            </div>
            <button class="btn btn-cancel " id="btn-prev">Previous   <i class="fa fa-arrow-left" aria-hidden="true"></i></button>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" id="btn-active-resched" class="btn btn-save btn-primary btn-req" data-dismiss="modal">Submit Request</button>
        <button type="button" class="btn btn-cancel " data-dismiss="modal">Cancel</button>
      </div>
    </div> 
  </div>
</div>
</div>