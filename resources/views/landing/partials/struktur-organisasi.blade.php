<!-- Staff / Pengurus Section -->
@php
    // Ensure $staff is available if not passed directly
    if (!isset($staff)) {
        $staff = \App\Models\Staff::active()
            ->ordered()
            ->select('id', 'name', 'slug', 'position', 'department', 'photo')
            ->get();
    }
@endphp

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Pengurus & Staf</span>
            <h2 class="section-title">Pengurus & Ustadz</h2>
            <p class="section-desc">Kenali pengurus dan ustadz yang mengabdi di Masjid Al Azhar</p>
        </div>

        @if ($staff->count() > 0)
            <div class="staff-grid">
                @foreach ($staff as $person)
                    <article class="staff-card">
                        <div class="staff-image-wrapper">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                    class="staff-image" loading="lazy">
                            @else
                                <div class="staff-placeholder">
                                    {{ strtoupper(substr($person->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="staff-body">
                            <h4 class="staff-name">{{ $person->name }}</h4>
                            <p class="staff-position">{{ $person->position }}</p>
                            <div class="staff-meta">
                                @if ($person->department)
                                    <span class="staff-meta-item">
                                        <i class="fas fa-briefcase"></i>
                                        {{ $person->department }}
                                    </span>
                                @endif
                                @if ($person->specialization ?? false)
                                    <span class="staff-meta-item">
                                        <i class="fas fa-star"></i>
                                        {{ $person->specialization }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
