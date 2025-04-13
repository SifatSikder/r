<div class="w-100 bg-light border-top py-lg-5">
    <div class="container-fluid py-3 py-lg-5">
        <div class="w-100">
            <div class="w-100 d-inline-block px-3 px-lg-5">
                <div class="w-100 d-inline-block owl-carousel owl-theme">
                    @foreach($blog as $dt)
                        <div class="eachBlog w-100 bg-white p-2 border my-3">
                            <div class="w-100">
                                <img src="{{ asset($dt->banner_full_path) }}" alt="">
                                <h5 class="py-2"><a href="{{ route('front.blog', ['id' => $dt->_id]) }}" class="text-secondary text-decoration-none"><strong>{{ $dt->title }}</strong></a></h5>
                            </div>
                            <p class="text-secondary">{{$dt->content}}</p>
                            <p class="m-0 p-0 text-center">
                                <a class="btn btn-sm btn-primary py-1 rounded-pill" href="{{ route('front.blog', ['id' => $dt->_id]) }}">Read More</a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-100 text-center mt-5">
                <a class="btn btn-lg rounded-pill btn-warning border py-2 px-5 mt-3 mt-sm-0" href="{{ route('front.blog.home') }}">Explore All</a>
            </div>
        </div>
    </div>
</div>
