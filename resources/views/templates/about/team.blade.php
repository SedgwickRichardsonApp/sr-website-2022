{{--<section class="tpl-about-team">--}}
{{--  <div class="container-fluid">--}}
{{--    <div class="grid grid-cols-1 md:grid-cols-12">--}}
{{--      <div class="col-span-1 md:col-span-6 s-sequence-group">--}}
{{--        @unless ( empty( $team['title'] ) )--}}
{{--          <h4 class="team-title s-sequenced">--}}
{{--            {{ $team['title'] }}--}}
{{--          </h4>--}}
{{--        @endunless--}}

{{--        @unless ( empty( $team['description'] ) )--}}
{{--          <div class="team-description s-sequenced">--}}
{{--            {!! apply_filters( 'the_content', $team['description'] ) !!}--}}
{{--          </div>--}}
{{--        @endunless--}}
{{--      </div>--}}
{{--    </div>--}}

{{--    @unless ( empty( $team['members'] ) )--}}
{{--      <div class="team-members-wrapper">--}}
{{--        <div class="team-members-grid s-team-group grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-10 gap-y-12"--}}
{{--          data-team-members="{{ json_encode( $team['members'] ) }}">--}}
{{--          @foreach ( $team['members'] as $item )--}}
{{--            <div class="col-span-1 s-sequenced">--}}
{{--              <div class="team-member">--}}
{{--                <a class="team-member-image-wrapper people-modal-trigger {{$item['content'] ? 'cursor-staff': 'disabled'}} " --}}
{{--                  data-id="{{ $item['id'] }}">--}}
{{--                  @unless ( empty( $item['image'] ) )--}}
{{--                    <img src="{{ $item['image'] }}"--}}
{{--                         class="team-member-image"--}}
{{--                         loading="lazy"--}}
{{--                         decoding="async"--}}
{{--                         alt="{{ $item['title'] }}"--}}
{{--                    />--}}
{{--                  @endunless--}}
{{--                </a>--}}

{{--                @unless ( empty( $item['title'] ) )--}}
{{--                  <a class="team-member-title people-modal-trigger {{$item['content'] ? 'cursor-link': 'disabled'}}" data-id="{{ $item['id'] }}">--}}
{{--                    {{ $item['title'] }}--}}
{{--                  </a>--}}
{{--                @endunless--}}

{{--                @unless ( empty( $item['position'] ) )--}}
{{--                  <div class="team-member-position">--}}
{{--                    {{ $item['position'] }}--}}
{{--                  </div>--}}
{{--                @endunless--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          @endforeach--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    @endunless--}}
{{--  </div>--}}
{{--</section>--}}
<section class="tpl-about-team">
  <div class="container-fluid">

    {{-- 页面总标题和描述 (保持不变) --}}
    <div class="grid grid-cols-1 md:grid-cols-12 mb-12">
      <div class="col-span-1 md:col-span-6 s-sequence-group">
        @unless ( empty( $team['title'] ) )
          <h4 class="team-title s-sequenced">
            {{ $team['title'] }}
          </h4>
        @endunless

        @unless ( empty( $team['description'] ) )
          <div class="team-description s-sequenced">
            {!! apply_filters( 'the_content', $team['description'] ) !!}
          </div>
        @endunless
      </div>
    </div>

    {{-- 👇 这里开始修改：先判断有没有 sections --}}
    @unless ( empty( $team['sections'] ) )

      {{-- 第一层循环：遍历部门 (Sections) --}}
      @foreach ( $team['sections'] as $section )

        <div class="team-section-wrapper mb-16"> {{-- 给每个部门加个下间距 --}}

          {{-- 显示部门标题 (例如: Leadership, Tech Team) --}}
          <div class="grid grid-cols-1 md:grid-cols-12">
            <div class="col-span-1 md:col-span-12">
              <h5 class="text-3xl  s-sequenced">{{ $section['dept_name'] }}</h5>
            </div>
          </div>

          {{-- 第二层循环：遍历该部门下的员工 --}}
          @unless ( empty( $section['members'] ) )
            <div class="team-members-wrapper">
              {{-- 注意：data-team-members 放到这里，依然可以用于弹窗逻辑 --}}
              <div class="team-members-grid s-team-group grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-10 gap-y-12"
                   data-team-members="{{ json_encode( $section['members'] ) }}">

                @foreach ( $section['members'] as $item )
                  <div class="col-span-1 s-sequenced">
                    <div class="team-member">
                      {{-- 图片链接 --}}
                      <a class="team-member-image-wrapper people-modal-trigger {{$item['content'] ? 'cursor-staff': 'disabled'}} "
                         data-id="{{ $item['id'] }}">
                        @unless ( empty( $item['image'] ) )
                          <img src="{{ $item['image'] }}"
                               class="team-member-image"
                               loading="lazy"
                               decoding="async"
                               alt="{{ $item['title'] }}"
                          />
                        @endunless
                      </a>

                      {{-- 名字链接 --}}
                      @unless ( empty( $item['title'] ) )
                        <a class="team-member-title people-modal-trigger {{$item['content'] ? 'cursor-link': 'disabled'}}" data-id="{{ $item['id'] }}">
                          {{ $item['title'] }}
                        </a>
                      @endunless

                      {{-- 职位 --}}
                      @unless ( empty( $item['position'] ) )
                        <div class="team-member-position">
                          {{ $item['position'] }}
                        </div>
                      @endunless
                    </div>
                  </div>
                @endforeach

              </div>
            </div>
          @endunless

        </div> {{-- End team-section-wrapper --}}

      @endforeach {{-- End Sections Loop --}}

    @endunless

  </div>
</section>
