<ul class="gameTab">
  <li class="hasGuideBtn">
    <button type="button" class="tabBtn {{Route::currentRouteName() == 'game.under40' ? 'current':''}}" onclick="location.href='{{route('game.under40')}}'">40" @lang('BLOCK UNDER')</button>
    <button type="button" class="guideBtn" onclick="popGuide(4)">?</button>
  </li>
  <li class="hasGuideBtn">
    <button type="button" class="tabBtn {{Route::currentRouteName() == 'game.oddEven40' ? 'current':''}}" onclick="location.href='{{route('game.oddEven40')}}'">40" @lang('ODD / EVEN')</button>
    <button type="button" class="guideBtn" onclick="popGuide(5)">?</button>
  </li>
  <li class="hasGuideBtn">
    <button type="button" class="tabBtn {{Route::currentRouteName() == 'game.underOver40' ? 'current':''}}"  onclick="location.href='{{route('game.underOver40')}}'">40" @lang('UNDER / OVER')</button>
    <button type="button" class="guideBtn" onclick="popGuide(6)">?</button>
  </li>
</ul>
