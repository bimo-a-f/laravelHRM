<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#mdlCreateGol"><i class="bx bx-plus"></i></button>
						
						<input type="hidden" name="hdnMultiDeleteId" id="hdnMultiDeleteId">
						<button id="btnMultiGolDelete" class="btn btn-lg btn-danger float-right" disabled="disabled"><i class="bx bx-trash"></i></button>
					</div>
						
					<div class="card-body">
						<table class="tbGol">
							<thead>
								<tr>
									<th>No</th>
									<th>ID</th>
									<th>Nama</th>
									<th>Golongan</th>
									<th>Act</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="card-footer">
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
					<button type="button" class="btn btn-primary btnNewGol" data-dismiss="modal">Save changes</button>
				</div>
				</div>
			</div>
		</div>
		
		<!-- Modal Update Golongan -->
		<div class="modal fade" id="mdlUpdateGol" tabindex="-1" role="dialog" aria-labelledby="CreateModal" aria-hidden="true">
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
						<label for="txtUNama" class="col-sm-3 col-form-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="txtUNama" placeholder="Nama">
						</div>
					</div>
					<div class="row mb-3">
						<label for="txtUGolongan" class="col-sm-3 col-form-label">Golongan</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="txtUGolongan" placeholder="Golongan">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary btnUpdateGol">Save changes</button>
				</div>
				</div>
			</div>
		</div>
	</div>

	
</template>
<script>
export default {
	mounted() {
		//VARIABLE------------------------------
		var tbGol;
		var mltDel=[];

		//CREATE--------------------------------
		function createGol() {
			var nam = $('#txtCNama').val();
			var gol = $('#txtCGolongan').val();
			$.ajax({
				type: "POST",
				url: "api/golongan/",
				data: {
					_token: CSRF_TOKEN,
					nama: nam,
					golongan:gol,
				},
				success: function (response) {
					$('.modal').modal('hide');
					tbGol.ajax.reload();
				}
			});
		}

		//UPDATE--------------------------------
		function updateGol(ths) {
			var gId = ths.attr('gId');
			$.ajax({
				type: "GET",
				url: "api/golongan/"+gId,
				success: function (response) {
					$('#txtUNama').val(response[0]['nama'])
					$('#txtUGolongan').val(response[0]['golongan'])
					$('#mdlUpdateGol').modal('show')
				}
			});
			$('.btnUpdateGol').click(function () {
				$.ajax({
					type: "PUT",
					url: "api/golongan/"+gId,
					data: {
						_token: CSRF_TOKEN,
						id:gId,
						nama:$('#txtUNama').val(),
						golongan:$('#txtUGolongan').val(),
					},
					success: function (response) {
						$('.modal').modal('hide');
						tbGol.ajax.reload();
					}
				});
			})
		}

		//DELETE--------------------------------
		function deleteGol(ths) {
			var gId = ths.attr('gId');
			var cnfDel = confirm('Delete data ini?');
			if (cnfDel) {
				$.ajax({
					type: "DELETE",
					url: "api/golongan/"+gId,
					success: function (response) {
						$('.modal').modal('hide');
						tbGol.ajax.reload();
					}
				});
			}
		}

		//MULTI-DELETE--------------------------
		function multiDeleteGol(ths) {
			var gId = ths.attr('gId');
			if (ths.is(':checked')) {
				var index = mltDel.indexOf(gId);
				if (index > -1) {
					mltDel.splice(index, 1);
				}
				mltDel.push(gId);
			}else{
				var index = mltDel.indexOf(gId);
				if (index > -1) {
					mltDel.splice(index, 1);
				}
			}
			
			$('#hdnMultiDeleteId').val(mltDel.join(','))

			if (mltDel.length>0) {
				$('#btnMultiGolDelete').removeAttr('disabled')
			} else {
				$('#btnMultiGolDelete').attr('disabled','disabled')
			}
		}
		$('#btnMultiGolDelete').click(function () {
			var cnfMltDel = confirm("Anda yakin akan menghapus data yang sudah dipilih?")
			if (cnfMltDel) {
				$.ajax({
				type: "POST",
				url: "api/golonganMultiDelete/",
				data: {ids:$('#hdnMultiDeleteId').val()},
				success: function (response) {
					$('.modal').modal('hide');
					tbGol.ajax.reload();
					mltDel=[];
					$('#hdnMultiDeleteId').val('')
					$('#btnMultiGolDelete').attr('disabled','disabled');
				}
			});
			}
		})

		//

		$(document).ready(function () {
			$('.btnNewGol').click(function (e) {
				createGol();
			});
			
			$('[data-dismiss="modal"]').click(function (e) { 
				$('.modal').modal('hide');
			});

			tbGol = $('.tbGol').DataTable({
				"ajax":'api/golongan',
				"columns": [
						{ "data": "num" },
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

					//MULTI-DELETE
					$('.chkDeleteMultiGol').click(function () {
						multiDeleteGol($(this));
					})
				}
			})
		});
		
	},
};
</script>
