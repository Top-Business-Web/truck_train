@extends('Admin.mainFrame')

@section('style')


@endsection

@section('content')
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title m-subheader__title--separator">السائقون</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>

					</ul>
				</div>

			</div>
		</div>

		<!-- END: Subheader -->
		<div class="m-content">

			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								السائقون
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<a href="{{route('drivers.create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>{{__('messages.Add')}}</span>
												</span>
								</a>
							</li>
							<li class="m-portlet__nav-item"></li>

						</ul>
					</div>
				</div>
				<div class="m-portlet__body">


				<!--begin: Datatable -->
					<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
						<thead>
						<tr>
{{--							<th>الصورة</th>--}}
							<th>الاسم</th>
							<th>رقم الجوال</th>
							<th>نوع المشترك</th>
							<th>الحالة الحالية</th>
							<th>وقت الإضافة</th>
							<th>التحكم</th>
						</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>

			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
@endsection

@section('script')

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

	<script>
		//============Datatable======================
		$("#m_table_1").DataTable({
			responsive: 1,
			lengthMenu: [5, 10, 25, 50],
			"processing": true,
			"pageLength": 50,
			"serverSide": true,
			"ordering": true,
			"searching": true,
			"ajax": "{{route('drivers.index')}}",
			"columns": [
				// {"data": "logo", orderable: false, searchable: false},
				{"data": "name",   orderable: false,searchable: true},
				{"data": "phone",   orderable: false,searchable: false},
				{"data": "user_type",   orderable: false,searchable: false},
				{"data": "is_block",   orderable: false,searchable: false},
				{"data": "created_at", searchable: false},
				{"data": "actions", orderable: false, searchable: false}
			],
			"language": {
				"sProcessing":   "جارى التحميل",
				"sZeroRecords":  "لايوجد بيانات للعرض",
				"sInfo":         "بيانات العرض",
				"sInfoEmpty":    "لايوجد بيانات للعرض",
				"sInfoFiltered": "بيانات البحث",
				"sInfoPostFix":  "",
				"sSearch":       "بحث:",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "الأول",
					"sPrevious": "السابق",
					"sNext":     "التالى",
					"sLast":     "الأخير"
				}
			},
			order: [
				[2, "desc"]
			],
		})

		$(document).on('click', '.status', function () {
			var id = $(this).attr('id');
			var status = $(this).attr('attr_type');
			if (confirm("هل أنت متأكد أنك تريد تغيير الحالة ؟")) {
				var url = '{{ route("drivers.changeBlock", ":id") }}'
				url = url.replace(':id', id);
				console.log(url);
				$.ajax({
					url: url,
					type: 'GET',
					data: {id: id},
					success: function (data) {
						swal.close()
						toastr.success('تمت العملية بنجاح','جيد', {"positionClass":"toast-top-right", "progressBar" : true})

						$('#m_table_1').DataTable().ajax.reload();
					},error: function(data) {
						swal.close()

					}

				});
			} else {

			}


		});




		//========================================================================
		//========================================================================
		//============================Delete======================================
		//========================================================================
		//delete one row
		$(document).on('click', '.delete', function () {
			var id = $(this).attr('id');

			if (confirm("هل أنت متأكد أنك تريد الحذف , لا يمكنك التراجع ؟")) {

				var url = '{{ route("drivers.destroy", ":id") }}';
				url = url.replace(':id', id);
				console.log(url);
				$.ajax({
					url: url,
					type: 'DELETE',
					data: {id: id},
					success: function (data) {
						swal.close()
						toastr.success('تمت العملية بنجاح','جيد', {"positionClass":"toast-top-right", "progressBar" : true})

						$('#m_table_1').DataTable().ajax.reload();
					}, error: function (data) {
						swal.close()

					}

				});

			}
		});
	</script>

@endsection

