@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="simple-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">Prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled dots">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .simple-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }

        .simple-pagination .page-item {
            display: inline-block;
        }

        .simple-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 45px;
            padding: 0 15px;
            background: white;
            color: var(--dark);
            border: 2px solid var(--border);
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .simple-pagination .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .simple-pagination .page-item.active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .simple-pagination .page-item.disabled .page-link {
            background: #f3f4f6;
            color: #9ca3af;
            border-color: #e5e7eb;
            cursor: not-allowed;
            pointer-events: none;
        }

        .simple-pagination .page-item.dots .page-link {
            border: none;
            background: transparent;
            pointer-events: none;
            min-width: auto;
            padding: 0 5px;
        }

        /* Number buttons - fixed width */
        .simple-pagination .page-item:not(:first-child):not(:last-child):not(.dots) .page-link {
            min-width: 45px;
            padding: 0;
        }

        /* Prev/Next buttons - flexible width */
        .simple-pagination .page-item:first-child .page-link,
        .simple-pagination .page-item:last-child .page-link {
            min-width: 70px;
            padding: 0 20px;
        }

        @media (max-width: 768px) {
            .simple-pagination {
                gap: 5px;
            }

            .simple-pagination .page-link {
                min-width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .simple-pagination .page-item:first-child .page-link,
            .simple-pagination .page-item:last-child .page-link {
                min-width: 60px;
                padding: 0 15px;
            }

            /* Hide some page numbers on mobile */
            .simple-pagination .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)):not(.dots) {
                display: none;
            }
        }
    </style>
@endif
