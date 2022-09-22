@forelse ($blogs as $blog)
    <div class="col-md-4">
        <div class="single-blog-post">
            <div class="date">
                <span>{{ $blog->created_at->format('d M Y') }}</span>
            </div>
            <div class="blog-post-content">
                <h3>
                    <a href="{{route('frontend.blog_detail', $blog->id)}}">
                        {{ app()->getLocale() == 'en' ? $blog->title_en : $blog->title_ar }}
                    </a>
                </h3>
                <a href="{{route('frontend.blog_detail', $blog->id)}}" class="read-more">
                    <span class="left"><i class="icofont-rounded-double-right"></i></span>
                    {{__('Frontend.read_more')}}
                    <span class="right"><i class="icofont-rounded-double-right"></i></span>
                </a>
            </div>
            <img src="{{ $blog->image }}" alt="blog">
        </div>
    </div>
@empty
    {{__('Frontend.blog_empty')}}
@endforelse