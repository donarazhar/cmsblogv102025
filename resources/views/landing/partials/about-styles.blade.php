<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 70px 0 50px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .page-header-content {
        position: relative;
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .page-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* ===== SECTION COMMON ===== */
    .section {
        padding: 60px 0;
    }

    .section-light {
        background: var(--bg);
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-badge {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .section-title {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .section-desc {
        font-size: 0.95rem;
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ===== HISTORY SECTION ===== */
    .history-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .history-image {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 83, 197, 0.15);
    }

    .history-image img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .history-image:hover img {
        transform: scale(1.05);
    }

    .history-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 60%, rgba(0, 83, 197, 0.1) 100%);
        pointer-events: none;
    }

    .history-content {
        max-width: 500px;
    }

    .history-content .section-badge {
        margin-bottom: 16px;
    }

    .history-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .history-text {
        color: var(--text);
        line-height: 1.8;
        font-size: 0.95rem;
    }

    .history-text p {
        margin-bottom: 16px;
    }

    .history-text p:last-child {
        margin-bottom: 0;
    }

    /* ===== VISION MISSION ===== */
    .vm-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .vm-card {
        background: var(--white);
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 83, 197, 0.08);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .vm-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
    }

    .vm-card.mission::before {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    }

    .vm-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 83, 197, 0.12);
    }

    .vm-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--white);
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0, 83, 197, 0.25);
    }

    .vm-card.mission .vm-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
    }

    .vm-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 14px;
    }

    .vm-text {
        color: var(--text);
        line-height: 1.7;
        font-size: 0.9rem;
    }

    .mission-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .mission-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: var(--text);
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .mission-item i {
        color: #10b981;
        font-size: 1rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* ===== VALUES SECTION ===== */
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .value-card {
        background: var(--white);
        padding: 28px 24px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);
        transition: var(--transition);
        border: 1px solid var(--border);
    }

    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 83, 197, 0.1);
        border-color: var(--primary);
    }

    .value-icon {
        width: 56px;
        height: 56px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--primary);
        margin: 0 auto 16px;
        transition: var(--transition);
    }

    .value-card:hover .value-icon {
        background: var(--primary);
        color: var(--white);
        transform: scale(1.1);
    }

    .value-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .value-text {
        color: var(--text-light);
        font-size: 0.85rem;
        line-height: 1.5;
    }

    /* ===== FACILITIES SECTION ===== */
    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .facility-card {
        background: var(--white);
        padding: 24px 20px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);
        transition: var(--transition);
        border-top: 3px solid transparent;
    }

    .facility-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 83, 197, 0.1);
        border-top-color: var(--primary);
    }

    .facility-icon {
        width: 52px;
        height: 52px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--primary);
        margin: 0 auto 14px;
        transition: var(--transition);
    }

    .facility-card:hover .facility-icon {
        background: var(--primary);
        color: var(--white);
    }

    .facility-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 6px;
    }

    .facility-text {
        color: var(--text-light);
        font-size: 0.8rem;
        line-height: 1.5;
    }

    /* ===== STAFF SECTION ===== */
    .staff-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 24px;
    }

    .staff-card {
        background: var(--white);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 83, 197, 0.06);
        transition: var(--transition);
    }

    .staff-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 83, 197, 0.12);
    }

    .staff-image-wrapper {
        width: 100%;
        height: 220px;
        background: var(--bg);
        position: relative;
        overflow: hidden;
    }

    .staff-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .staff-card:hover .staff-image {
        transform: scale(1.08);
    }

    .staff-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 3rem;
        font-weight: 700;
    }

    .staff-body {
        padding: 20px;
        text-align: center;
    }

    .staff-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .staff-position {
        font-size: 0.85rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 10px;
    }

    .staff-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .staff-meta-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .staff-meta-item i {
        font-size: 0.7rem;
        color: var(--text-light);
    }

    /* ===== CTA SECTION ===== */
    .cta-section {
        padding: 70px 0;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .cta-content {
        position: relative;
        text-align: center;
        max-width: 650px;
        margin: 0 auto;
    }

    .cta-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 800;
        margin-bottom: 14px;
    }

    .cta-text {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 28px;
        line-height: 1.6;
    }

    .cta-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-cta-primary {
        background: var(--white);
        color: var(--primary);
    }

    .btn-cta-primary:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-cta-outline {
        background: transparent;
        color: var(--white);
        border: 2px solid rgba(255, 255, 255, 0.4);
    }

    .btn-cta-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--white);
    }

    /* Content Wrapper specific to wysiwyg */
    .content-wrapper h1, .content-wrapper h2, .content-wrapper h3, .content-wrapper h4 {
        color: var(--dark);
        font-weight: 700;
        margin-top: 1.5em;
        margin-bottom: 0.8em;
    }
    .content-wrapper p { margin-bottom: 1.2em; }
    .content-wrapper ul, .content-wrapper ol { margin-bottom: 1.5em; padding-left: 2em; }
    .content-wrapper ul li { list-style-type: disc; margin-bottom: 0.5em; }
    .content-wrapper ol li { list-style-type: decimal; margin-bottom: 0.5em; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .history-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .history-content {
            max-width: 100%;
            text-align: center;
        }

        .history-image img {
            height: 300px;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 60px 0 40px;
        }

        .section {
            padding: 50px 0;
        }

        .vm-grid {
            grid-template-columns: 1fr;
        }

        .vm-card {
            padding: 28px 24px;
        }

        .values-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .facilities-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .staff-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .cta-section {
            padding: 50px 0;
        }
    }

    @media (max-width: 480px) {

        .values-grid,
        .facilities-grid {
            grid-template-columns: 1fr;
        }

        .staff-grid {
            grid-template-columns: 1fr;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .btn-cta {
            width: 100%;
            justify-content: center;
        }

        .history-image img {
            height: 250px;
        }
    }
</style>
