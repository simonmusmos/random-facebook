<header>
    <div class="tb">
        <div class="td" id="logo">
            <a href="#"><i class="fab fa-facebook-square"></i></a>
        </div>
        <div class="td" id="search-form">
            <form method="get" action="#">
                <input type="text" placeholder="Search Facebook">
                <button type="submit"><i class="material-icons">search</i></button>
            </form>
        </div>
        <div class="td" id="f-name-l"><span>{{ (Route::current()->getName() == 'user.index') ? $data->name->first . "'s facebook" : "Added Users List" }}</span></div>
        <div class="td" id="f-name-l"><a href="{{ route('user.index') }}"><span style="color: white; pointer-events:none; cursor: pointer;">Search for a random profile</span></a></div>
        @if (Route::current()->getName() == 'user.index')
        <div class="td" id="i-links">
            <div class="tb">
                
                <div class="td">
                <a href="#" id="p-link">
                
                <img src="{{ $data->picture->thumbnail }}">
                
                </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</header>