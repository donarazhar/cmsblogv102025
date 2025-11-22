@extends('admin.layouts.app')

@section('title', 'Database Backup')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Database Backup</h1>
            <p class="page-subtitle">Kelola backup database untuk keamanan data</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Total Backups</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ count($backups) }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-archive" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Storage Used</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">
                        {{ isset($totalStorage) ? number_format($totalStorage / 1024 / 1024, 2) : '0' }} MB
                    </div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-hdd" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Latest Backup</div>
                    <div style="font-size: 1.2rem; font-weight: 700;">
                        @if (count($backups) > 0)
                            {{ $backups[0]['date']->diffForHumans() }}
                        @else
                            Never
                        @endif
                    </div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clock" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Schedule</div>
                    <div style="font-size: 1.2rem; font-weight: 700;">Daily 02:00</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-calendar-check" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px; border-radius: 12px; color: white; margin-bottom: 25px;">
        <h3 style="font-size: 1.3rem; margin-bottom: 10px;">
            <i class="fas fa-shield-alt"></i> Mengapa Backup Penting?
        </h3>
        <p style="margin-bottom: 15px;">Backup database adalah langkah penting untuk melindungi data dari:</p>
        <ul style="margin: 0 0 0 20px; line-height: 1.8;">
            <li><strong>Serangan Hacker:</strong> Data bisa dikembalikan jika terjadi ransomware atau SQL injection</li>
            <li><strong>Human Error:</strong> Pemulihan mudah jika terjadi kesalahan penghapusan data</li>
            <li><strong>Hardware Failure:</strong> Data tetap aman meskipun server mengalami kerusakan</li>
            <li><strong>Disaster Recovery:</strong> Rencana pemulihan bencana yang solid</li>
        </ul>
    </div>

    <!-- Quick Actions -->
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
        <form action="{{ route('admin.backups.create') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit"
                style="width: 100%; background: white; border: 2px solid var(--primary); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
                <i class="fas fa-database"
                    style="font-size: 2.5rem; color: var(--primary); margin-bottom: 15px; display: block;"></i>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px;">Backup Database</h4>
                <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">Backup hanya database (Cepat)</p>
            </button>
        </form>

        <form action="{{ route('admin.backups.create-full') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit"
                style="width: 100%; background: white; border: 2px solid var(--success); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
                <i class="fas fa-hdd"
                    style="font-size: 2.5rem; color: var(--success); margin-bottom: 15px; display: block;"></i>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px;">Full Backup</h4>
                <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">Backup database + files (Lengkap)</p>
            </button>
        </form>

        <form action="{{ route('admin.backups.clean') }}" method="POST" style="margin: 0;"
            onsubmit="return confirm('Yakin ingin membersihkan backup lama?')">
            @csrf
            <button type="submit"
                style="width: 100%; background: white; border: 2px solid var(--warning); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
                <i class="fas fa-broom"
                    style="font-size: 2.5rem; color: var(--warning); margin-bottom: 15px; display: block;"></i>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px;">Clean Old Backups</h4>
                <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">Hapus backup yang sudah kadaluarsa</p>
            </button>
        </form>

        <button type="button" onclick="document.getElementById('restoreModal').style.display='flex'"
            style="width: 100%; background: white; border: 2px solid var(--danger); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
            <i class="fas fa-undo"
                style="font-size: 2.5rem; color: var(--danger); margin-bottom: 15px; display: block;"></i>
            <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px;">Restore Database</h4>
            <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">Kembalikan dari backup (Hati-hati!)</p>
        </button>
    </div>

    <!-- Backup List -->
    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
            <h3
                style="font-size: 1.1rem; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-archive"></i> Daftar Backup
            </h3>
            <span
                style="padding: 5px 12px; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                {{ count($backups) }} Backup
            </span>
        </div>

        @if (count($backups) > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border);">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Nama File
                            </th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Ukuran</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Tanggal</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Status</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: var(--dark);"
                                width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backups as $backup)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 12px;">
                                    <i class="fas fa-file-archive" style="color: var(--primary); margin-right: 8px;"></i>
                                    <strong>{{ $backup['name'] }}</strong>
                                </td>
                                <td style="padding: 12px;">{{ $backup['size'] }}</td>
                                <td style="padding: 12px;">
                                    <div>{{ $backup['date']->format('d M Y') }}</div>
                                    <small style="color: #6b7280;">{{ $backup['date']->format('H:i:s') }} WIB</small>
                                </td>
                                <td style="padding: 12px;">
                                    @if ($backup['date']->isToday())
                                        <span
                                            style="padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-check-circle"></i> Fresh
                                        </span>
                                    @else
                                        <span
                                            style="padding: 4px 12px; background: #dbeafe; color: #1e40af; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            {{ $backup['date']->diffForHumans() }}
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <div style="display: flex; gap: 5px; justify-content: center;">
                                        <a href="{{ route('admin.backups.download', $backup['name']) }}"
                                            style="padding: 6px 12px; background: var(--info); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem;"
                                            title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{ route('admin.backups.destroy', $backup['name']) }}"
                                            method="POST" style="display: inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus backup ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="padding: 6px 12px; background: var(--danger); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
                <i class="fas fa-inbox" style="font-size: 4rem; margin-bottom: 20px; opacity: 0.3;"></i>
                <h3 style="font-size: 1.3rem; color: var(--dark); margin-bottom: 10px;">Belum Ada Backup</h3>
                <p style="margin-bottom: 20px;">Mulai dengan membuat backup pertama untuk mengamankan data Anda</p>
                <form action="{{ route('admin.backups.create') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="padding: 12px 24px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-plus"></i> Buat Backup Sekarang
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Restore Modal -->
    <div id="restoreModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%;">
            <h3 style="margin-bottom: 20px; color: var(--danger);">
                <i class="fas fa-exclamation-triangle"></i> Restore Database
            </h3>
            <p style="margin-bottom: 20px; color: #6b7280;">
                <strong>Peringatan:</strong> Restore database akan menimpa semua data yang ada. Pastikan Anda memiliki
                backup terbaru sebelum melakukan restore!
            </p>

            <form action="{{ route('admin.backups.restore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Upload Backup File (.sql atau
                        .zip)</label>
                    <input type="file" name="backup_file" accept=".sql,.zip" required
                        style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="document.getElementById('restoreModal').style.display='none'"
                        style="padding: 10px 24px; background: var(--light); color: var(--dark); border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit"
                        style="padding: 10px 24px; background: var(--danger); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;"
                        onclick="return confirm('Apakah Anda YAKIN ingin restore database? Ini akan menghapus semua data saat ini!')">
                        <i class="fas fa-undo"></i> Restore Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Close modal on outside click
        document.getElementById('restoreModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    </script>
@endpush
