@extends('layout.base');
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("document").ready(function() {
        $.ajax({
            url : '{{ route("user.posts") }}',
            type : 'GET',
            beforeSend : function() {
                $('#loader').removeClass('display-none');
            },
            success : function(data) {
                var current = $("#post-list").html();
                var fetch = "";   
                $.each(data, function(index, value) {
                    fetch += '<div class="post">'+
                    '<div class="tb">'+
                    '<a href="#" class="td p-p-pic"><img src="{{ $data->picture->thumbnail }}"></a>'+
                        '<div class="td p-r-hdr">'+
                        '<div class="p-u-info">'+
                            '<a href="#">{{ $data->name->first }} {{ $data->name->last }}</a>'+
                            '</div>'+
                            '<div class="p-dt">'+
                            '<i class="material-icons">calendar_today</i>'+
                            '<span>just now</span>'+
                            '</div>'+
                            '</div>'+
                        '<div class="td p-opt"><i class="material-icons">keyboard_arrow_down</i></div>'+
                        '</div>'
                    if (value.message != '') {
                        fetch += '<p>'+
                            value.message+
                        '</p>';
                    }
                    
                    if (value.has_image == 1) {
                        fetch += '<a href="#" class="p-cnt-v">'+
                            '<img src="https://picsum.photos/400/500?random=' + Math.random() + '">'+
                        '</a>';
                    }
                    
                    
                    fetch += '<div>'+
                    '<div class="p-acts">'+
                        '<div class="p-act like"><i class="material-icons">thumb_up_alt</i><span></span></div>'+
                            '<div class="p-act comment"><i class="material-icons">comment</i><span></span></div>'+
                            '<div class="p-act share"><i class="material-icons">reply</i></div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                });
                $("#post-list").html(current + fetch);
                $('#loader').addClass('display-none');
            },
        });
        
        $("#add-user-btn").on('click', function() {
            $.ajax({
                url : '{{ route("user.store") }}',
                type : 'POST',
                data : {
                    json_data : '{{ $data_encoded }}',
                },
                beforeSend : function() {
                    $('#loader').removeClass('display-none');
                },
                success : function(data) {
                    $('#loader').addClass('display-none');
                    if (data) {
                        $('#add-user-btn').addClass("display-none");
                        $('#added-btn').removeClass("display-none");
                    }
                },
            });
        });
    });
</script>
@endpush
@section('content')
<div id="profile-upper">
	<div id="profile-banner-image">
		<img src="https://picsum.photos/500/500?random=10" alt="Banner image">
	</div>
	<div id="profile-d">
		<div id="profile-pic">
			<img src="{{ $data->picture->large }}">
		</div>
		<div id="u-name">{{ $data->name->first }} {{ $data->name->last }}</div>
		<div class="tb" id="m-btns">
			<div class="td">
				<div class="m-btn" id="add-user-btn"><i class="material-icons">add</i><span>Add this user</span></div>
				<div class="m-btn display-none" id="added-btn"><span>Added</span></div>
			</div>
			<div class="td">
				<div class="m-btn"><a style="color: black; text-decoration: none !important;" href="{{ route('user.list') }}"><i class="material-icons">format_list_bulleted</i><span>View User List</span></a></div>
			</div>
		</div>
	</div>
	<div id="black-grd"></div>
</div>
<div id="main-content">
	<div class="tb">
		<div class="td" id="l-col">
			<div class="l-cnt">
				<div class="cnt-label">
					<i class="l-i" id="l-i-i"></i>
					<span>Intro</span>
					<div class="lb-action"></div>
				</div>
				<div id="i-box">
					<div id="intro-line">{{ ucfirst($data->gender) }}</div>
					<div id="u-occ">{{ $data->email }}</div>
					<div id="u-occ">{{ $data->phone }}</div>
					<div id="u-occ">{{ $data->cell }}</div>
					<div id="u-loc"><i class="material-icons">location_on</i><a href="#">{{ $data->location->city }}, {{ $data->location->state }}, {{ $data->location->country }}</a></div>
				</div>
			</div>
			<div class="l-cnt l-mrg">
				<div class="cnt-label">
					<i class="l-i" id="l-i-p"></i>
					<span>Photos</span>
				</div>
				<div id="photos">
					<div class="tb">
						<div class="tr">
							<div class="td"></div>
							<div class="td"></div>
							<div class="td"></div>
						</div>
						<div class="tr">
							<div class="td"></div>
							<div class="td"></div>
							<div class="td"></div>
						</div>
						<div class="tr">
							<div class="td"></div>
							<div class="td"></div>
							<div class="td"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="l-cnt l-mrg">
				<div class="cnt-label">
					<i class="l-i" id="l-i-k"></i>
					<span>Did You Know<i id="k-nm">1</i></span>
				</div>
				<div>
					<div class="q-ad-c">
						<a href="#" class="q-ad">
						<img src="https://imagizer.imageshack.com/img923/1849/4TnLy1.png">
						<span>My favorite superhero is...</span>
						</a>
					</div>
					<div class="q-ad-c">
						<a href="#" class="q-ad" id="add_q">
						<i class="material-icons">add</i>
						<span>Add Answer</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="td" id="m-col">
			<div class="m-mrg" id="p-tabs">
				<div class="tb">
					<div class="td">
						<div class="tb" id="p-tabs-m">
							<div class="td active"><span>TIMELINE</span></div>
							<div class="td"><span>FRIENDS</span></div>
							<div class="td"><span>PHOTOS</span></div>
							<div class="td"><span>ABOUT</span></div>
							<div class="td"><span>ARCHIVE</span></div>
						</div>
					</div>
					<div class="td" id="p-tab-m"></div>
				</div>
			</div>
			<div class="m-mrg" id="composer">
				<div id="c-tabs-cvr">
					<div class="tb" id="c-tabs">
						<div class="td active"><i class="material-icons">subject</i><span>Make Post</span></div>
						<div class="td"><i class="material-icons">camera_enhance</i><span>Photo/Video</span></div>
						<div class="td"><i class="material-icons">videocam</i><span>Live Video</span></div>
						<div class="td"><i class="material-icons">event</i><span>Life Event</span></div>
					</div>
				</div>
				<div id="c-c-main">
					<div class="tb">
						<div class="td" id="p-c-i"><img src="{{ $data->picture->thumbnail }}" alt="Profile pic"></div>
						<div class="td" id="c-inp">
							<input type="text" placeholder="What's on your mind?">
						</div>
					</div>
					<div id="insert_emoji"><i class="material-icons">insert_emoticon</i></div>
				</div>
			</div>
			<div id="post-list">
			</div>
		</div>
	</div>
</div>
@endsection