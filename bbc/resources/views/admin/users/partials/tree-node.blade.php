{{-- resources/views/admin/users/partials/tree-node.blade.php --}}
<li>
    @if(!empty($node['children']))
        <span class="user-tree-toggle"><i class="fas fa-fw fa-caret-down"></i></span>
    @else
        <span class="user-tree-toggle" style="visibility: hidden;"><i class="fas fa-fw fa-circle" style="font-size: 0.6em; vertical-align: middle;"></i></span>
    @endif
    <span class="user-info" onclick="showUserTreeActions(event, '{{ $node['id'] }}', '{{ $node['name'] }}', '{{ $node['email'] }}', '{{ $node['level'] }}')">
        [레벨{{ $node['level'] }}] {{ $node['name'] }}
        <span class="email-tag">({{ $node['email'] }})</span>
        @if(config('app.show_treeview_labels')) {{-- <-- 조건부 렌더링 시작 --}}
            <span class="level-tag">{{ $node['level_name'] }}</span>
            <span class="level-tag">ID: {{ $node['id'] }}</span>
            <span class="level-tag">상위: {{ $node['recommander'] ?? '없음' }} / 스토어: {{ $node['store'] ?? '없음' }}</span>
        @endif {{-- <-- 조건부 렌더링 끝 --}}
    </span>
    
    @if(!empty($node['children']))
        <ul class="user-tree">
            @foreach($node['children'] as $childNode)
                @include('admin.users.partials.tree-node', ['node' => $childNode]) {{-- 재귀 호출 --}}
            @endforeach
        </ul>
    @endif
</li>