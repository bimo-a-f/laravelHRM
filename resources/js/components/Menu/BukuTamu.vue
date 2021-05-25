<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#mdlCreateBkTm"><i class="bx bx-plus"></i></button>
						
						<input type="hidden" name="hdnMultiDeleteId" id="hdnMultiDeleteId">
						<button id="btnMultiBkTmDelete" class="btn btn-lg btn-danger float-right" disabled="disabled"><i class="bx bx-trash"></i></button>
					</div>
						
					<div class="card-body">
						<table class="tbBkTm">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Tamu</th>
									<th>Keperluan</th>
									<th>Lama Kunjungan</th>
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
		
		<!-- Modal Create BukuTamu -->
		<div class="modal fade" id="mdlCreateBkTm" tabindex="-1" role="dialog" aria-labelledby="CreateModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="CreateModal">Create Buku-Tamu</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-3">
						<label for="txtCNama" class="col-sm-3 col-form-label">Nama Tamu</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="txtCNama" placeholder="Nama Tamu">
						</div>
					</div>
					<div class="row mb-3">
						<label for="txtCKeperluan" class="col-sm-3 col-form-label">Keperluan</label>
						<div class="col-sm-9">
                            <textarea class="form-control" name="txtCKeperluan" id="txtCKeperluan" cols="30" rows="10"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary btnNewBkTm" data-dismiss="modal">Save changes</button>
				</div>
				</div>
			</div>
		</div>
		
		<!-- Modal Update BukuTamu -->
		<div class="modal fade" id="mdlUpdateBkTm" tabindex="-1" role="dialog" aria-labelledby="UpdateModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="UpdateModal">Update Buku-Tamu</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-3">
						<label for="txtUNama" class="col-sm-3 col-form-label">Nama Tamu</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="txtUNama" placeholder="Nama Tamu">
						</div>
					</div>
					<div class="row mb-3">
						<label for="txtUKeperluan" class="col-sm-3 col-form-label">Keperluan</label>
						<div class="col-sm-9">
                            <textarea class="form-control" name="txtUKeperluan" id="txtUKeperluan" cols="30" rows="10"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary btnUpdateBkTm">Save changes</button>
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
		var tbBkTm;
		var mltDel=[];

		//CREATE--------------------------------
		function createBkTm() {
			$.ajax({
				type: "POST",
				url: "api/buku-tamu/",
				data: {
					_token: CSRF_TOKEN,
					nama: $('#txtCNama').val(),
					keperluan: $('#txtCKeperluan').val(),
				},
				success: function (response) {
					$('.modal').modal('hide');
					tbBkTm.ajax.reload();
                    $('#txtCNama').val('')
                    $('#txtCKeperluan').val('')
				}
			});
		}

        //TAMU-SELESAI--------------------------
        function tamuSelesai(ths) {
            var btId = ths.attr('btId');
			var cnfSls = confirm('Kunjungan Tamu Ini Selesai?');
			if (cnfSls) {
				$.ajax({
					type: "PUT",
					url: "api/tamu-selesai/"+btId,
					success: function (response) {
						$('.modal').modal('hide');
						tbBkTm.ajax.reload();
					}
				});
			}
        }

		//UPDATE--------------------------------
        var btId = '';
		function updateBkTm(ths) {
			btId = ths.attr('btId');
			$.ajax({
				type: "GET",
				url: "api/buku-tamu/"+btId,
				success: function (response) {
					$('#txtUNama').val(response[0]['nama_tamu'])
					$('#txtUKeperluan').val(response[0]['keperluan'])
					$('#mdlUpdateBkTm').modal('show')
				}
			});
		}
		$('.btnUpdateBkTm').click(function () {
			$.ajax({
				type: "PUT",
				url: "api/buku-tamu/"+btId,
				data: {
					_token: CSRF_TOKEN,
					id:btId,
					nama:$('#txtUNama').val(),
					keperluan:$('#txtUKeperluan').val(),
				},
				success: function (response) {
					$('.modal').modal('hide');
					tbBkTm.ajax.reload();
				}
			});
		})

		//DELETE--------------------------------
		function deleteBkTm(ths) {
			var btId = ths.attr('btId');
			var cnfDel = confirm('Delete data ini?');
			if (cnfDel) {
				$.ajax({
					type: "DELETE",
					url: "api/buku-tamu/"+btId,
					success: function (response) {
						$('.modal').modal('hide');
						tbBkTm.ajax.reload();
					}
				});
			}
		}

		//MULTI-DELETE--------------------------
		function multiDeleteBkTm(ths) {
			var btId = ths.attr('btId');
			if (ths.is(':checked')) {
				var index = mltDel.indexOf(btId);
				if (index > -1) {
					mltDel.splice(index, 1);
				}
				mltDel.push(btId);
			}else{
				var index = mltDel.indexOf(btId);
				if (index > -1) {
					mltDel.splice(index, 1);
				}
			}
			
			$('#hdnMultiDeleteId').val(mltDel.join(','))

			if (mltDel.length>0) {
				$('#btnMultiBkTmDelete').removeAttr('disabled')
			} else {
				$('#btnMultiBkTmDelete').attr('disabled','disabled')
			}
		}
        $('#btnMultiBkTmDelete').click(function () {
            var cnfMltDel = confirm("Anda yakin akan menghapus data yang sudah dipilih?")
            if (cnfMltDel) {
                $.ajax({
                type: "POST",
                url: "api/bukuTamuMultiDelete/",
                data: {ids:$('#hdnMultiDeleteId').val()},
                success: function (response) {
                    $('.modal').modal('hide');
                    tbBkTm.ajax.reload();
                    mltDel=[];
                    $('#hdnMultiDeleteId').val('')
                    $('#btnMultiBkTmDelete').attr('disabled','disabled');
                }
            });
            }
        });

		//--------------------------------------

		$(document).ready(function () {
			$('.btnNewBkTm').click(function (e) {
				createBkTm();
			});
			
			$('[data-dismiss="modal"]').click(function (e) { 
				$('.modal').modal('hide');
			});

			tbBkTm = $('.tbBkTm').DataTable({
				"ajax":'api/buku-tamu',
				"columns": [
						{ "data": "num" },
						{ "data": "nama_tamu" },
						{ "data": "keperluan" },
						{ "data": "lama_kunjungan" },
						{ "data": "link" }
				],
				"drawCallback":function (setting) {
					//TAMU-SELESAI--------------------------
					$('.btnTamuSelesai').click(function (e) { 
						tamuSelesai($(this));
					});

					//UPDATE--------------------------------
					$('.btnUpdBkTm').click(function (e) { 
						updateBkTm($(this));
					});

					//DELETE--------------------------------
					$('.btnDelBkTm').click(function (e) { 
						deleteBkTm($(this));
					});

					//MULTI-DELETE
					$('.chkDeleteMultiBkTm').click(function () {
						multiDeleteBkTm($(this));
					})
				}
			})
		});
		
	},
};
</script>
