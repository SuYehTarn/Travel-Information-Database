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
	<button type="button" class="btn btn-primary w-100 font-weight-bold" data-tag='from' onclick="setFromToTag(this.dataset.tag)"><i class="fas fa-walking"></i></button>
	<!--Set To attra-->
	<button type="button" class="btn btn-info w-100 font-weight-bold" data-tag='to' onclick="setFromToTag(this.dataset.tag)"><i class="fas fa-flag-checkered"></i></button>
	<!--Search Path-->
	<button type="button" class="btn btn-success w-100" onclick="getPath()"><i class="fas fa-route"></i></button>
</div>

<!--Added attraction list-->
<div id="add_list" class="list-group"></div>


<!-- Modal -->
<div id="pathModal" class="modal fade" role="dialog" aria-labelledby="PathListModal">
	<div class="modal-dialog modal-sm modal-dialog-centered">

		<!-- Modal content-->
		<div class="modal-content">

			<!--Modal body-->
			<div class="modal-body path-list p-0">

				<div id="pathCarousel" class="carousel slide" data-ride="carousel" data-interval="false">

					<div class="d-flex justify-content-between align-items-center">
						
						<div class="d-flex align-items-center">
							<span class="fas fa-angle-left fa-lg mx-3"></span>	
							<a class="carousel-control-prev" href="#pathCarousel" role="button" data-slide="prev"></a>
							<span class="sr-only">Previous</span>
						</div>

						<div id="path-steps-list" class="carousel-inner my-3"></div>

						<div class="d-flex align-items-center">
							<span class="fas fa-angle-right fa-lg mx-3"></span>	
							<a class="carousel-control-next" href="#pathCarousel" role="button" data-slide="next"></a>
							<span class="sr-only">Next</span>
						</div>

					</div>

					<div class="d-flex justify-content-center align-items-center pb-3">
					  <button id="pnum" class="btn btn-sm btn-secondary" role="botton"></button>
					</div>

				</div>
			</div>

		</div>

	</div>
</div>