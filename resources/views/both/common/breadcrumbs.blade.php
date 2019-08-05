@if (count($breadcrumbs))
    @if(Auth::check() && Request::is('*admin*') )
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                @endif
            @endforeach
        </ol>
    @else
        <section id="breadcrumbs">
            <div class="container">
                <nav role="navigation" aria-label="breadcrumbs">
                    <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if ($breadcrumb->url && !$loop->last)
                                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                    <a href="{{ $breadcrumb->url }}" itemprop="item">
                                        <span itemprop="name">{{ $breadcrumb->title }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                    <span itemprop="name">{{ $breadcrumb->title }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </section>
    @endif
@endif
