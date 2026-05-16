<!-- History Section -->
<section class="section">
    <div class="container">
        <div class="history-grid">
            <div class="history-image">
                <img src="{{ asset('storage/img/maa.jpg') }}" alt="Masjid Agung Al Azhar" loading="lazy"
                    onerror="this.src='https://placehold.co/600x400/0053C5/ffffff?text=Masjid+Al+Azhar'">
            </div>
            <div class="history-content">
                <span class="section-badge">Sejarah</span>
                <h2 class="history-title">Sejarah Masjid Agung Al Azhar</h2>
                <div class="history-text">
                    {!! \App\Models\Setting::get('profile_sejarah', '
                    <p>
                        Masjid Agung Al Azhar merupakan salah satu masjid terbesar dan tertua di Jakarta yang telah
                        berdiri
                        sejak tahun 1960-an. Masjid ini didirikan oleh Yayasan Pendidikan Islam (YPI) Al Azhar dengan
                        tujuan
                        menyediakan tempat ibadah yang layak bagi umat Islam di Jakarta.
                    </p>
                    <p>
                        Sejak awal berdirinya, Masjid Al Azhar tidak hanya berfungsi sebagai tempat ibadah, tetapi juga
                        sebagai pusat pendidikan dan dakwah Islam. Berbagai kegiatan keagamaan, pendidikan, dan sosial
                        telah
                        diselenggarakan untuk membangun umat yang lebih baik.
                    </p>
                    <p>
                        Hingga saat ini, Masjid Al Azhar terus berkembang dan menjadi salah satu ikon masjid modern di
                        Indonesia yang tetap menjaga nilai-nilai keislaman yang kuat.
                    </p>
                    ') !!}
                </div>
            </div>
        </div>
    </div>
</section>
