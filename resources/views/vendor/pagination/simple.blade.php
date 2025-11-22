@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: space-between; align-items: center;">
        <div style="color: #6b7280; font-size: 0.9rem;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        
        <ul style="display: flex; list-style: none; gap: 5px; margin: 0; padding: 0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li style="opacity: 0.5;">
                    <span style="display: block; padding: 8px 12px; background: var(--light); border-radius: 8px; color: #9ca3af;">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="display: block; padding: 8px 12px; background: var(--light); border-radius: 8px; color: var(--dark); text-decoration: none; transition: all 0.3s ease;">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span style="display: block; padding: 8px 12px;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display: block; padding: 8px 12px; background: var(--primary); color: white; border-radius: 8px; font-weight: 600;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display: block; padding: 8px 12px; background: var(--light); border-radius: 8px; color: var(--dark); text-decoration: none; transition: all 0.3s ease;">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="display: block; padding: 8px 12px; background: var(--light); border-radius: 8px; color: var(--dark); text-decoration: none; transition: all 0.3s ease;">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li style="opacity: 0.5;">
                    <span style="display: block; padding: 8px 12px; background: var(--light); border-radius: 8px; color: #9ca3af;">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif