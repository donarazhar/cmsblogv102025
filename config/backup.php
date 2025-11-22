<?php

return [
    'backup' => [
        /*
         * Nama backup. Akan digunakan dalam nama file backup.
         */
        'name' => env('APP_NAME', 'masjid-alazhar'),

        'source' => [
            'files' => [
                /*
                 * File/folder yang akan dibackup.
                 */
                'include' => [
                    base_path(),
                ],

                /*
                 * File/folder yang tidak akan dibackup.
                 */
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('.git'),
                    base_path('public/storage'),
                    storage_path('framework/cache'),
                    storage_path('framework/sessions'),
                    storage_path('framework/views'),
                    storage_path('logs'),
                ],

                /*
                 * Follow symlinks saat backup.
                 */
                'follow_links' => false,

                /*
                 * Ignore hidden files.
                 */
                'ignore_unreadable_directories' => false,

                /*
                 * Default permission yang akan diset pada backup.
                 */
                'relative_path' => null,
            ],

            /*
             * Database yang akan dibackup.
             */
            'databases' => [
                'mysql',
            ],
        ],

        /*
         * Database dump settings.
         */
        'database_dump_compressor' => null,

        'database_dump_file_extension' => '',

        /*
         * Lokasi penyimpanan backup.
         */
        'destination' => [
            /*
             * Disk yang akan digunakan untuk menyimpan backup.
             */
            'disks' => [
                'local',
            ],
        ],

        /*
         * Password untuk mengenkripsi backup (opsional).
         */
        'password' => env('BACKUP_ARCHIVE_PASSWORD'),

        /*
         * Compression untuk backup.
         */
        'compression_method' => Spatie\DbDumper\Compressors\GzipCompressor::class,
    ],

    /*
     * Cleanup settings untuk backup lama.
     */
    'cleanup' => [
        /*
         * Strategy untuk cleanup backup lama.
         */
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        /*
         * Default strategy config.
         */
        'default_strategy' => [
            /*
             * Jumlah hari backup akan disimpan.
             */
            'keep_all_backups_for_days' => 7,

            /*
             * Jumlah backup harian yang akan disimpan.
             */
            'keep_daily_backups_for_days' => 16,

            /*
             * Jumlah backup mingguan yang akan disimpan.
             */
            'keep_weekly_backups_for_weeks' => 8,

            /*
             * Jumlah backup bulanan yang akan disimpan.
             */
            'keep_monthly_backups_for_months' => 4,

            /*
             * Jumlah backup tahunan yang akan disimpan.
             */
            'keep_yearly_backups_for_years' => 2,

            /*
             * Delete oldest backup jika storage penuh.
             */
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
    ],

    /*
     * Monitor settings.
     */
    'monitor_backups' => [
        [
            'name' => env('APP_NAME', 'masjid-alazhar'),
            'disks' => ['local'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    /*
     * Notifikasi settings.
     */
    'notifications' => [
        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification::class => ['mail'],
        ],

        /*
         * Email untuk notifikasi.
         */
        'mail' => [
            'to' => env('BACKUP_NOTIFICATION_EMAIL', 'admin@alazhar.com'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'backup@alazhar.com'),
                'name' => env('MAIL_FROM_NAME', 'Backup System'),
            ],
        ],

        'slack' => [
            'webhook_url' => '',
            'channel' => null,
            'username' => null,
            'icon' => null,
        ],

        'discord' => [
            'webhook_url' => '',
            'username' => '',
            'avatar_url' => '',
        ],
    ],
];