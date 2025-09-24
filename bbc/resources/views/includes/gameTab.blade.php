<ul class="gameTab">
  <li class="hasGuideBtn">
    <button type="button" class="tabBtn {{Route::currentRouteName() == 'game.under' ? 'current':''}}" onclick="location.href='{{route('game.under')}}'">@lang('BLOCK UNDER')</button>
    <button type="button" class="guideBtn" onclick="popGuide(4)">?</button>
  </li>
  <li class="hasGuideBtn">
    <button type="button" class="tabBtn {{Route::currentRouteName() == 'game.oddEven' ? 'current':''}}" onclick="location.href='{{route('game.oddEven')}}'">@lang('ODD / EVEN')</button>
    <button type="button" class="guideBtn" onclick="popGuide(5)">?</button>
  </li>
  <li class="hasGuideBtn">
    <button type="button" class="tabBtn {{Route::currentRouteName() == 'game.underOver' ? 'current':''}}"  onclick="location.href='{{route('game.underOver')}}'">@lang('UNDER / OVER')</button>
    <button type="button" class="guideBtn" onclick="popGuide(6)">?</button>
  </li>
</ul>
