<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header"><button type="button" class="btn btn-default btnNewGol"><i class="bx bx-plus"></i></button> Example Component Golongan</div>
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
					<div class="card-body">I'm an example component Grade.</div>
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
