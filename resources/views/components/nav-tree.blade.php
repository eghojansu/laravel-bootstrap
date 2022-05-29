<div class="list-group list-group-flush">
  @foreach ($tree as $item)
    <a {!! $clsa($item) !!}>
      @if ($item['icon'])<i class="bi-{{ $item['icon'] }} me-3"></i>@endif
      <span>{{ $item['label']}}</span>
      @if (!empty($item['items']))<i class="bi-caret-down-fill ms-auto"></i>@endif
    </a>
    @if (!empty($item['items']))
      <div class="collapse list-tree-child" id="{{ $menuid($item) }}">
        <x-nav-tree :items="$item['items']" />
      </div>
    @endif
  @endforeach
</div>
<!--

  const href = url ? trimEnd(`#${base}/${trimStart(url || '', '/')}`, '/') : '#'
  const active = activeUrl === href.slice(1)
  const props = {
    ...(attrs || {}),
    id,
    href,
    class: clsx(
      attrs?.class,
      'list-group-item list-group-item-action',
      parent && 'd-flex',
      active && 'active',
    ),
    'aria-current': active ? 'true' : null,
    ...(parent ? {
      href: `#${groupId}`,
      'data-bs-toggle': 'collapse',
      'aria-expanded': 'false',
    } : {}),
  }
-->
