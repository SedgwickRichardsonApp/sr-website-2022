<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')

<body @php body_class() @endphp>
{{-- Header --}}
@php do_action('get_header') @endphp
@include('partials.header')

<div class="cursors-wrapper"></div>

<div class="wrap main-content-wrap" role="document" data-current-top="">
  <div class="content content-wrap">
    <main class="main s-sequence-group">
      @yield('content')
    </main>
  </div>

  {{-- Footer --}}
  @php do_action('get_footer') @endphp
  @include('sections.newsletter')
  @include('partials.footer')
</div>

{{-- Modals --}}
@include('modals.contact')
@include('modals.jobs')
@include('modals.people')
@include('modals.search')
{{-- @include('modals.view-restriction') --}}

@include('partials.copied-prompt')
@include('partials.sticky-contact-box')

@yield('scripts')
@php wp_footer() @endphp
</body>
<footer>
  <script type="text/javascript"> _linkedin_partner_id = "5081121"; window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || []; window._linkedin_data_partner_ids.push(_linkedin_partner_id); </script><script type="text/javascript"> (function(l) { if (!l){window.lintrk = function(a,b){window.lintrk.q.push([a,b])}; window.lintrk.q=[]} var s = document.getElementsByTagName("script")[0]; var b = document.createElement("script"); b.type = "text/javascript";b.async = true; b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js"; s.parentNode.insertBefore(b, s);})(window.lintrk); </script> <noscript> <img height="1" width="1" style="display:none;" alt="linkedin" src="https://px.ads.linkedin.com/collect/?pid=5081121&fmt=gif" /> </noscript>
</footer>
</html>
