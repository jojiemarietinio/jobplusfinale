<div class="modal fade" id="seeMoreModal" role="dialog">
  <div class="col-md-12">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <div class="timeline-heading">
            <h1 id="modal-title"></h1>
            <p id="modal-emp"></p>
            <div class="head-button pull-right">
              <select class="selectpicker " data-width="170px" data-style="actselect" multiple title="Set actions">
                <option  class="actoption" data-icon="fa fa-envelope"> Send a message</option>
                <option class="actoption" data-icon="fa fa-calendar"> Request a reschedule</option>
                <option class="actoption" data-icon="fa fa-times"> Dismiss this job</option>
              </select>
            </div>
          </div>
          <div class="timeline-body">
            <div class="jtitle">
             <p id="modal-desc">

             </p>
           </div>
           <div class="row contents">
            <div class="col-md-6">
              <div class="sched">
               <p id="modal-startDay"></p>
               <h1 id="modal-startTime"></h1>
               <p>Starts at</p>
             </div>
             <div class="sched head-center">
              <h1><i class="fa fa-long-arrow-right" aria-hidden="true"></i></h1>
            </div>
            <div class="sched">
              <p id="modal-endDay"></p>
              <h1 id="modal-endTime"></h1>
              <p>Ends at</p>
            </div>
          </div>
          <div class="row contents">
            <div class="col-md-3 cont-col">
              <div class="head-time">
                <h1 id="modal-fromnow"></h1>
                <p>From now</p>
              </div>
            </div>
            <div class="col-md-3 cont-col">
              <div class="head-time">
                <h1 id="modal-sal"></h1>
                <p>You will receive</p>
              </div>
            </div>
          </div>
          <div class="modalmap">
            <div id="modalgmap" style="height:300px;"></div>
          </div>
          <div class="col-md-12 cont-col">
            <h1 id="modal-address"></h1>
            <p>Located at</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>