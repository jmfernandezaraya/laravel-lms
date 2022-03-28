<div class="recent mt-3" id="showblog">
    <h6>@lang('Frontend.recent_post')</h6>
    @forelse($blog as $blog)
        <div class="row mt-3">
            <div class="col-md-4">
                <img class="blog-img" src="{{asset($blog->image)}}" alt="blog" style="width: 100%;">
            </div>
            <div class="col-md-8 pl-0">
                <div class="content">
                    <p>{!! $blog->{'description_'. get_language() } !!}</p>
                    <span><a href="{{route('frontend.blog_detail', $blog->id)}}">{{$blog->created_at->format('d M Y')}}</a></span>
                </div>
            </div>
        </div>
    @empty
        <div class="content">
            {{__('Frontend.blog_empty')
            }}
        </div>
    @endforelse
</div>