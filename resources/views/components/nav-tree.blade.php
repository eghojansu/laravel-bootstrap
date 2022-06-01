<div class="list-group list-group-flush">
  @foreach ($tree as $item)
    <a {!! $clsa($item) !!}>
      @if ($item['icon'])<i class="bi-{{ $item['icon'] }} me-3"></i>@endif
      <span>{{ $item['label']}}</span>
      @if (!empty($item['items']))<i class="bi-caret-down-fill ms-auto"></i>@endif
    </a>
    @if (!empty($item['items']))
      <div class="collapse list-tree-child {{ $item['active'] ? 'show' : null }}" id="{{ $menuid($item) }}">
        <x-nav-tree :items="$item['items']" />
      </div>
    @endif
  @endforeach
</div>
