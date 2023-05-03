@extends('layout.base');
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$("#btn-delete").on('click', function() {
		$("#delete-form").attr('action', ($("#delete-form").attr('action') + "/" + $(this).attr('user-id')));
		$("#delete-form").submit();
	});

	function showModal($id) {
		$.ajax({
            url : '{{ route("user.index") }}/' + $id,
            type : 'GET',
            beforeSend : function() {
				$('#modal-user-name').html('');
				$('#modal-profile-photo').attr('src', '');
				$('#modal-banner').attr('src', '');
				$('#modal-email').html('');
				$('#modal-gender').html('');
				$('#modal-phone').html('');
				$('#modal-cell').html('');
				$('#modal-loc').html('');
                $('#loader').removeClass('display-none');
            },
            success : function(data) {
                $('#modal-user-name').html(data.info.name);
				$('#modal-profile-photo').attr('src', data.info.profile);
				$('#modal-banner').attr('src', data.info.banner);
				$('#modal-email').html(data.info.email);
				$('#modal-gender').html(data.info.gender);
				$('#modal-phone').html(data.info.phone);
				$('#modal-cell').html(data.info.cell);
				$('#modal-loc').html(data.info.location);
                $('#loader').addClass('display-none');
				$("#profileModal").modal("show");
            },
        });
	}
</script>
@endpush
@section('content')
<div id="profile-upper">
	<form action="{{ route('user.index') }}" method="POST" id="delete-form">
		@csrf
	</form>
</div>
<div id="main-content">
<div class="tb">
	<div class="td" id="m-col">
		@foreach($users as $user)
			@php
				$data = json_decode($user->userDetail->details);
			@endphp
			<div class="m-mrg" id="composer" style="cursor: pointer;">
				<div id="c-c-main" style="padding-top: 0px;">
					<div class="tb">
						<div class="td" id="p-c-i" onClick="showModal('{{ $user->id }}')"><img src="{{ $data->picture->thumbnail }}" alt="Profile pic"></div>
						<div class="td" id="c-inp">
							<h4 onClick="showModal('{{ $user->id }}')">{{ $user->name }}</h4>
							<p><a href="javascript:void(0)" id="btn-delete" user-id="{{ $user->id }}">Delete</a></p>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	
</div>
{!! $users->links() !!}
@endsection