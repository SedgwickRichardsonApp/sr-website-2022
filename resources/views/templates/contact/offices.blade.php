<section class="tpl-contact-offices">
  <div class="container-fluid">
    <div class="content-wrapper">

      @unless ( empty( $offices ) )
        <div class="s-reveal grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-12">
            @foreach ($offices as $office)

              @foreach ($office['info'] as $o)
              <div class="col-span-1 s-sequenced s-revealed">
                <div class="office-details-wrapper">

                  @if(!empty($o['city']))
                      <h3>{{ $o['city'] }}</h3>
                  @else
                      <h3>{{ $office['country'] }}</h3>
                  @endif
                  <div class="city-wrapper">


                      @foreach ($o['phone_group'] as $phone)
                        <p class="phone">{{ $phone }}</p>
                      @endforeach

                      @unless ( empty( $o['address']) )
                      <p class="address">
                        <span class="cursor-copy-address" data-text="{{ $o['address'] }}">
                          {{ $o['address'] }}
                        </span>
                      </p>
                      @endunless

                      @foreach ($o['email_group'] as $email)
                        <p class="email element-desktop">
                          <span class="cursor-copy-email" data-text="{{ $email }}">
                            {{ $email }}
                          </span>
                        </p>
                        <p class="email element-mobile">
                          <a class="cursor-copy-email" href="mailto:{{ $email }}">
                            {{ $email }}
                          </a>
                        </p>
                      @endforeach

                  </div>
                </div>
              </div>

              @endforeach
            @endforeach
        </div>

      @endunless
    </div>
  </div>
</section>
