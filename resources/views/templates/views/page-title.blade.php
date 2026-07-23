<section class="tpl-views-page-title js-header-white">
  <div class="container-fluid">
    @unless ( empty( $page_title ) )
      <h1 class="hero-h1-title">{!! get_the_title(get_queried_object_id()) !!}</h1>
      <h2 class="h2 page-title">{!! $page_title !!}</h2>
    @endunless
  </div>
</section>