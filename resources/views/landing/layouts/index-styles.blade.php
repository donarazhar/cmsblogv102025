<style>
    .hero-slider {
        position: relative;
        height: 100vh;
        min-height: 600px;
        overflow: hidden;
    }

    .hero-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s ease, visibility 1s ease;
    }

    .hero-slide.active {
        opacity: 1;
        visibility: visible;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        height: 100%;
        color: white;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 20px;
        text-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 15px;
        font-weight: 600;
        text-shadow: 0 3px 15px rgba(0, 0, 0, 0.3);
    }

    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn {
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 30px rgba(0, 83, 197, 0.3);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 83, 197, 0.4);
    }

    .btn-outline {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-outline:hover {
        background: white;
        color: var(--primary);
    }

    .slider-controls button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .slider-controls button:hover {
        background: var(--primary);
    }

    .slider-prev {
        left: 30px;
        border-radius: 0 50px 50px 0;
    }

    .slider-next {
        right: 30px;
        border-radius: 50px 0 0 50px;
    }

    .slider-indicators {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .indicator {
        width: 40px;
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator.active {
        background: white;
        width: 60px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .hero-buttons {
            flex-direction: column;
        }

        .slider-controls button {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>

<style>
    .stat-box {
        background: white;
        padding: 40px 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 1rem;
        font-weight: 500;
    }
</style>

<style>
    .program-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .program-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .program-image {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
    }

    .program-content {
        padding: 25px;
    }

    .program-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 15px;
    }

    .program-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .program-description {
        color: #6b7280;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .program-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: #9ca3af;
    }

    .program-meta i {
        margin-right: 5px;
    }

    .program-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
    }

    .program-link:hover {
        gap: 12px;
    }
</style>

<style>
    .post-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .post-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .post-card.featured {
        grid-column: span 1;
    }

    .post-image {
        width: 100%;
        height: 250px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .post-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--warning);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .post-category {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: var(--primary);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .post-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .post-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 0.85rem;
        color: #9ca3af;
        flex-wrap: wrap;
    }

    .post-meta i {
        margin-right: 5px;
    }

    .post-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dark);
        line-height: 1.4;
    }

    .post-excerpt {
        color: #6b7280;
        margin-bottom: 20px;
        line-height: 1.6;
        flex: 1;
    }

    .post-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
    }

    .post-link:hover {
        gap: 12px;
    }

    /* Small Post Card */
    .post-card-small {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .post-card-small:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .post-image-small {
        width: 100%;
        height: 180px;
        background-size: cover;
        background-position: center;
    }

    .post-content-small {
        padding: 20px;
    }

    .post-category-small {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .post-title-small {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .post-meta-small {
        font-size: 0.85rem;
        color: #9ca3af;
    }

    .post-meta-small i {
        margin-right: 5px;
    }
</style>

<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .gallery-item {
        position: relative;
        height: 300px;
        overflow: hidden;
        border-radius: 15px;
        cursor: pointer;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 25px;
        color: white;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-info h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .gallery-info p {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .gallery-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Album Cards */
    .album-card {
        text-decoration: none;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .album-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .album-cover {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
    }

    .album-info {
        padding: 20px;
    }

    .album-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
    }

    .album-meta {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: #9ca3af;
    }

    .album-meta i {
        margin-right: 5px;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.95);
        animation: fadeIn 0.3s;
    }

    .lightbox.show {
        display: block;
    }

    .lightbox-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 80%;
        animation: zoomIn 0.3s;
    }

    .lightbox-caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 20px;
        font-size: 1.1rem;
    }

    .lightbox-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .lightbox-close:hover {
        color: #bbb;
    }

    .lightbox-prev,
    .lightbox-next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: white;
        font-weight: bold;
        font-size: 30px;
        transition: 0.6s ease;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .lightbox-prev {
        left: 20px;
        border-radius: 0 5px 5px 0;
    }

    .lightbox-next {
        right: 20px;
        border-radius: 5px 0 0 5px;
    }

    .lightbox-prev:hover,
    .lightbox-next:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
    }
</style>

<style>
    .schedule-box {
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .schedule-item {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: var(--light);
        border-radius: 15px;
        align-items: center;
        transition: all 0.3s ease;
    }

    .schedule-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .schedule-time {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        min-width: 100px;
    }

    .schedule-date {
        min-width: 60px;
        text-align: center;
        background: var(--primary);
        color: white;
        padding: 10px;
        border-radius: 10px;
    }

    .date-day {
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1;
    }

    .date-month {
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    .schedule-details {
        flex: 1;
    }

    .schedule-details h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .schedule-details p {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .schedule-details i {
        margin-right: 5px;
        opacity: 0.7;
    }

    .schedule-badge {
        padding: 6px 15px;
        border-radius: 50px;
        color: white;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    @media (max-width: 768px) {
        .schedule-box {
            grid-column: span 2;
        }
    }
</style>

<style>
    .testimonial-slider {
        position: relative;
        overflow: hidden;
        padding: 20px 60px;
    }

    .testimonial-track {
        display: flex;
        gap: 30px;
        transition: transform 0.5s ease;
    }

    .testimonial-card {
        min-width: calc(33.333% - 20px);
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        position: relative;
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .testimonial-rating {
        margin-bottom: 20px;
    }

    .testimonial-rating i {
        color: #d1d5db;
        font-size: 1.2rem;
        margin-right: 5px;
    }

    .testimonial-rating i.active {
        color: #fbbf24;
    }

    .testimonial-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #4b5563;
        margin-bottom: 25px;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .author-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .author-info h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 3px;
    }

    .author-info p {
        font-size: 0.9rem;
        color: #9ca3af;
    }

    .testimonial-quote {
        position: absolute;
        bottom: 20px;
        right: 30px;
        font-size: 4rem;
        color: var(--primary);
        opacity: 0.1;
    }

    .testimonial-controls button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: white;
        border: none;
        border-radius: 50%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        color: var(--dark);
        font-size: 1.2rem;
    }

    .testimonial-controls button:hover {
        background: var(--primary);
        color: white;
        box-shadow: 0 8px 25px rgba(0, 83, 197, 0.3);
    }

    .testimonial-prev {
        left: 0;
    }

    .testimonial-next {
        right: 0;
    }

    @media (max-width: 1024px) {
        .testimonial-card {
            min-width: calc(50% - 15px);
        }
    }

    @media (max-width: 768px) {
        .testimonial-card {
            min-width: calc(100% - 40px);
        }

        .testimonial-slider {
            padding: 20px 10px;
        }
    }
</style>

<style>
    .donation-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
    }

    .donation-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .donation-urgent {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--danger);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        z-index: 10;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .donation-image {
        width: 100%;
        height: 220px;
        background-size: cover;
        background-position: center;
    }

    .donation-content {
        padding: 30px;
    }

    .donation-category {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .donation-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .donation-description {
        color: #6b7280;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .donation-progress {
        margin-bottom: 20px;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .progress-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }

    .progress-percentage {
        font-size: 1.1rem;
        color: var(--primary);
        font-weight: 700;
    }

    .progress-bar {
        width: 100%;
        height: 10px;
        background: #e5e7eb;
        border-radius: 50px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 50px;
        transition: width 1s ease;
    }

    .progress-stats {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .amount-raised {
        font-weight: 700;
        color: var(--dark);
    }

    .amount-target {
        color: #9ca3af;
    }

    .donation-amount {
        background: var(--light);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
    }

    .amount-label {
        display: block;
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .amount-value {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    .donation-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: #9ca3af;
    }

    .donation-meta i {
        margin-right: 5px;
    }
</style>

<style>
    .cta-section {
        background: linear-gradient(135deg, #0053C5 0%, #003d91 100%);
        position: relative;
        overflow: hidden;
    }

    /* Optional: Tambahkan pattern atau overlay */
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .cta-section .container {
        position: relative;
        z-index: 1;
    }

    .cta-btn-primary {
        background: white;
        color: #0053C5;
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .cta-btn-primary:hover {
        background: #f0f0f0;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .cta-btn-outline {
        background: transparent;
        color: white;
        border: 2px solid white;
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .cta-btn-outline:hover {
        background: white;
        color: #0053C5;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 768px) {
        .cta-section h2 {
            font-size: 2rem !important;
        }

        .cta-section p {
            font-size: 1rem !important;
        }

        .cta-section .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
