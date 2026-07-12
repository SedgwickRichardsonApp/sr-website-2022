<section class="tpl-privacy-menu">
  <div class="privacy-menu-wrap">
    @unless ( empty( $content['tnc_contents'] ) )
      <a class="menu-item-link menu-title cursor-link" data-href="#tnc_title">
        {{ $content['tnc_title'] }}
      </a>
      <ol>
        @foreach ( $content['tnc_content_arr'] as $item )
          @if($item['show_on_menu'])
            <li>
              <a class="menu-item-link cursor-link" data-href="#{{$item['id']}}" id="link-{{$item['id']}}">
                {{ $item['title'] }}
              </a>
            </li>
          @endif
        @endforeach
      </ol>
    @endunless

    @unless ( empty( $content['policy_contents'] ) )
      <a class="menu-item-link menu-title cursor-link" data-href="#policy_title">
        {{ $content['policy_title'] }}
      </a>
      <ol>
        @foreach ( $content['policy_content_arr'] as $item )
        @if($item['show_on_menu'])
        <li>
          <a class="menu-item-link cursor-link" data-href="#{{$item['id']}}" id="link-{{$item['id']}}">
            {{ $item['title'] }}
          </a>
        </li>
        @endif
        @endforeach
      </ol>
    @endunless
  </div>
</section>
