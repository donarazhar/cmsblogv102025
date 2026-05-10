<!-- Vision & Mission Section -->
<section class="section section-light">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Visi & Misi</span>
            <h2 class="section-title">Landasan Kami</h2>
        </div>

        @php
            $visiMisiContent = \App\Models\Setting::get('profile_visi_misi');
        @endphp

        @if(!empty($visiMisiContent))
            <div class="card shadow-sm border-0 rounded-4" style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-body p-4 p-md-5 content-wrapper" style="padding: 40px; line-height: 1.8; font-size: 1.05rem; color: #4b5563;">
                    {!! $visiMisiContent !!}
                </div>
            </div>
        @else
            <div class="vm-grid">
                <!-- Vision Card -->
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="vm-title">Visi</h3>
                    <p class="vm-text">
                        Menjadi pusat kegiatan keagamaan, pendidikan, dan dakwah Islam yang modern dan berperan aktif dalam
                        pembangunan masyarakat yang beriman, bertakwa, dan berakhlak mulia.
                    </p>
                </div>

                <!-- Mission Card -->
                <div class="vm-card mission">
                    <div class="vm-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="vm-title">Misi</h3>
                    <div class="mission-list">
                        <div class="mission-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Menyelenggarakan kegiatan ibadah yang berkualitas</span>
                        </div>
                        <div class="mission-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Memberikan pendidikan Islam yang komprehensif</span>
                        </div>
                        <div class="mission-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Melaksanakan dakwah Islam rahmatan lil alamin</span>
                        </div>
                        <div class="mission-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Memberdayakan masyarakat melalui program sosial</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
