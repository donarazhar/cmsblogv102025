<!-- Staff / Struktur Organisasi Section -->
@php
    $strukturContent = \App\Models\Setting::get('profile_struktur_organisasi');
    // Ensure $staff is available if not passed directly (e.g. when called from the individual page)
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
            <span class="section-badge">Struktur Organisasi</span>
            <h2 class="section-title">Pengurus & Ustadz</h2>
            <p class="section-desc">Kenali pengurus dan ustadz yang mengabdi di Masjid Al Azhar</p>
        </div>

        @if(!empty($strukturContent))
            <div class="card shadow-sm border-0 rounded-4 mb-5" style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-body p-4 p-md-5 content-wrapper" style="padding: 40px; line-height: 1.8; font-size: 1.05rem; color: #4b5563;">
                    {!! $strukturContent !!}
                </div>
            </div>
        @endif

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
