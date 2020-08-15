<!--control bar 1-->
<div class="btn-group d-flex mb-3">
	<!--Move forward-->
	<button type="button" class="btn btn-outline-secondary w-100" data-dir="fore" onclick="moveAttra(this.dataset.dir)">
		<i class="fas fa-arrow-up"></i>
	</button>
	<!--Move backward-->
	<button type="button" class="btn btn-outline-secondary w-100" data-dir="back" onclick="moveAttra(this.dataset.dir)">
		<i class="fas fa-arrow-down"></i>
	</button>
	<!--Clear added list-->
	<button type="button" class="btn btn-outline-secondary w-100" onclick="clearAddList()">
    	<i class="fas fa-trash-alt"></i>
	</button>
</div>

<!--control bar 2-->
<div class="btn-group d-flex mb-3">
	<!--Set From attra-->
	<button type="button" class="btn btn-primary w-100 font-weight-bold" data-tag='from' onclick="setFromToTag(this.dataset.tag)">From</button>
	<!--Set To attra-->
	<button type="button" class="btn btn-info w-100 font-weight-bold" data-tag='to' onclick="setFromToTag(this.dataset.tag)">To</button>
	<!--Search Path-->
	<button type="button" class="btn btn-success w-100" onclick="getPath()">
		<i class="fas fa-route"></i>
	</button>
</div>

<!--Added attraction list-->
<div id="add_list" class="list-group"></div>


<!-- Modal -->
<div id="pathModal" class="modal fade" role="dialog" aria-labelledby="PathListModal">
  	<div class="modal-dialog modal-lg modal-dialog-centered">

	    <!-- Modal content-->
	    <div class="modal-content">

	    	<!--Modal header-->
	      	<div class="modal-header text-center">
	      		<div class="row">
	      			<div class="col-sm-4">
			            <span id="path-from-attra"></span>
			        </div>
			        <div class="col-sm-4">
		            	<i class="fas fa-route"></i>
			        </div>
			        <div class="col-sm-4">
			            <span id="path-to-attra"></span>
			        </div>
		        </div>
	      	</div>

	      	<!--Modal body-->
	      	<div class="modal-body path-list">	      		
	      		<div id="path-steps-list"></div>
		        <div class="text-center" style="margin-bottom: 5px;">
		          <i class="fas fa-angle-left" data-dir="prev" onclick="changePage(this.dataset.dir)"></i>
		          <span id="path-page" class="badge"></span>
		          <i class='fas fa-angle-right' data-dir="next" onclick="changePage(this.dataset.dir)"></i>
		        </div>
	      	</div>

	    </div>

  	</div>
</div>