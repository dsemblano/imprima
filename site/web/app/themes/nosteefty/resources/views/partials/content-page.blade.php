
@php $page = (! is_page(['checkout', 'cart'])) ? "article" : "section" @endphp

<{{$page}} class="prose md:prose-lg lg:prose-xl mx-auto max-w-none bg-red-600">
    @php(the_content())
</{{$page}}>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
