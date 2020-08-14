<!--control bar 1-->
<div class="btn-group btn-group-justified">
	<div class="btn-group">
  		<button type="button" class="btn btn-default" data-dir="fore" onclick="moveAttra(this.dataset.dir)">
			<span class="glyphicon glyphicon-arrow-up"></span>
  		</button>
  	</div>
  	<div class="btn-group">
  		<button type="button" class="btn btn-default" data-dir="back" onclick="moveAttra(this.dataset.dir)">
  			<span class="glyphicon glyphicon-arrow-down"></span>
  		</button>
  	</div>
  	<div class="btn-group">
 		<button type="button" class="btn btn-default" onclick="clearAddList()">
 			<span class="glyphicon glyphicon-trash"></span>
 		</button>
 	</div>
</div>


<!--control bar 2-->
<div class="btn-group btn-group-justified">
	<div class="btn-group">
  		<button type="button" class="btn btn-primary" data-tag='from' onclick="setFromToTag(this.dataset.tag)">
			<span><strong>From</strong></span>
  		</button>
  	</div>
  	<div class="btn-group">
  		<button type="button" class="btn btn-info" data-tag='to' onclick="setFromToTag(this.dataset.tag)">
  			<span><strong>To</strong></span>
  		</button>
  	</div>
  	<div class="btn-group">
 		<button type="button" class="btn btn-success" onclick="getPath()">
 			<span class="glyphicon glyphicon-search"></span>
 		</button>
 	</div>
</div>


<!--Panel of add list-->
<div id="add_list" class="panel-default"></div>


<!-- Modal -->
<div id="pathModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header text-center">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<span id="path-from-attra" class="modal-title"></span>
          <span class="glyphicon glyphicon-arrow-right"></span>
          <span id="path-to-attra" class="modal-title"></span>              
	      	</div>
	      	<div class="modal-body path-list">
	      		<div id="path-steps-list"></div>
          <div class="text-center" style="margin-bottom: 5px;">
            <span class="glyphicon glyphicon-chevron-left" data-dir="prev" onclick="changePage(this.dataset.dir)"></span>
            <span id="path-page" class="badge"></span>
            <span class='glyphicon glyphicon-chevron-right' data-dir="next" onclick="changePage(this.dataset.dir)"></span>
          </div>
	      	</div>
	    </div>

  	</div>
</div>