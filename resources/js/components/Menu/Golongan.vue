<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#mdlCreateGol"><i class="bx bx-plus"></i></button> Example Component Golongan
					</div>
						
					<div class="card-body">
						<table class="tbGol">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Golongan</th>
									<th>Act</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Modal Create Golongan -->
		<div class="modal fade" id="mdlCreateGol" tabindex="-1" role="dialog" aria-labelledby="CreateModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="CreateModal">Create Golongan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-3">
						<label for="txtCNama" class="col-sm-3 col-form-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="txtCNama" placeholder="Nama">
						</div>
					</div>
					<div class="row mb-3">
						<label for="txtCGolongan" class="col-sm-3 col-form-label">Golongan</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="txtCGolongan" placeholder="Golongan">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary btnNewGol">Save changes</button>
				</div>
				</div>
			</div>
		</div>
	</div>

	
</template>
<script>
export default {
	mounted() {
		var tbGol;

		//CREATE--------------------------------
		function createGol() {
			$.ajax({
				type: "POST",
				url: "api/golongan/",
				data: {
					_token: CSRF_TOKEN,
					nama:'HAU_Create',
					golongan:'menengah',
				},
				success: function (response) {
					tbGol.ajax.reload();
				}
			});
		}

		//UPDATE--------------------------------
		function updateGol(ths) {
			var gId = ths.attr('gId');
			$.ajax({
				type: "PUT",
				url: "api/golongan/"+gId,
				data: {
					_token: CSRF_TOKEN,
					id:gId,
					nama:'HAU',
					golongan:'bawah',
				},
				success: function (response) {
					tbGol.ajax.reload();
				}
			});
		}

		//DELETE--------------------------------
		function deleteGol(ths) {
			var gId = ths.attr('gId');
			$.ajax({
				type: "DELETE",
				url: "api/golongan/"+gId,
				success: function (response) {
					tbGol.ajax.reload();
				}
			});
		}

		//
		$('.btnNewGol').click(function (e) {
			createGol();
		});

		$(document).ready(function () {
			tbGol = $('.tbGol').DataTable({
				"ajax":'api/golongan',
				"columns": [
						{ "data": "id" },
						{ "data": "nama" },
						{ "data": "golongan" },
						{ "data": "link" }
				],
				"drawCallback":function (setting) {
					//UPDATE--------------------------------
					$('.btnUpdGol').click(function (e) { 
						updateGol($(this));
					});

					//DELETE--------------------------------
					$('.btnDelGol').click(function (e) { 
						deleteGol($(this));
					});
				}
			})
		});
		
	},
};
</script>
