@unless ( empty( $content['tnc_contents'] ) )
  <div class="terms-heading" id="tnc_title">
    {{ $content['tnc_title'] }}
  </div>

  <ol>
  @foreach ( $content['tnc_content_arr'] as $item )

  @if($item['show_on_menu'])
    <li class="terms-title" id="{{ $item['id'] }}">
      {{ $item['title'] }}
    </li>
    @else 
    {{ $item['title'] }}
    @endif

    <div class="terms-content" id="{{ $item['id'] }}">
      {!! $item['content'] !!}
    </div>
  @endforeach
  </ol>
@endunless

@unless ( empty( $content['policy_contents'] ) )
  <div class="terms-heading" id="policy_title">
    {{ $content['policy_title'] }}
  </div>

  <ol>
  @foreach ( $content['policy_content_arr'] as $item )
 
  @if($item['show_on_menu'])
    <li class="terms-title" id="{{ $item['id'] }}">
      {{ $item['title'] }}
    </li>
    @else 
    {{ $item['title'] }}
    @endif
    
    <div class="terms-content" id="{{ $item['id'] }}">
      {!! $item['content'] !!}
    </div>
    
  @endforeach
  </ol>
@endunless
