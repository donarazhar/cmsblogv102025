@extends('landing.layouts.app')

@section('title', $title)

@section('content')
<div class="container py-12" style="padding: 80px 0 60px;">
    <div class="row justify-content-center" style="display: flex; justify-content: center;">
        <div class="col-lg-10" style="width: 100%; max-width: 900px;">
            <div class="card shadow-sm border-0 rounded-4" style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-body p-4 p-md-5" style="padding: 40px;">
                    <div class="content-wrapper" style="line-height: 1.8; font-size: 1.05rem; color: #4b5563;">
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Styling khusus untuk konten hasil WYSIWYG editor agar tampil rapi di public */
    .content-wrapper h1, .content-wrapper h2, .content-wrapper h3, .content-wrapper h4 {
        color: var(--dark);
        font-weight: 700;
        margin-top: 1.5em;
        margin-bottom: 0.8em;
    }
    
    .content-wrapper h1 { font-size: 2rem; }
    .content-wrapper h2 { font-size: 1.75rem; }
    .content-wrapper h3 { font-size: 1.5rem; }
    
    .content-wrapper p {
        margin-bottom: 1.2em;
    }
    
    .content-wrapper ul, .content-wrapper ol {
        margin-bottom: 1.5em;
        padding-left: 2em;
    }
    
    .content-wrapper ul li {
        list-style-type: disc;
        margin-bottom: 0.5em;
    }
    
    .content-wrapper ol li {
        list-style-type: decimal;
        margin-bottom: 0.5em;
    }
    
    .content-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5em 0;
    }
    
    .content-wrapper blockquote {
        border-left: 4px solid var(--primary);
        padding-left: 1rem;
        font-style: italic;
        color: #6b7280;
        margin: 1.5em 0;
        background: #f9fafb;
        padding: 1rem;
        border-radius: 0 8px 8px 0;
    }
    
    .content-wrapper table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5em 0;
    }
    
    .content-wrapper th, .content-wrapper td {
        border: 1px solid #e5e7eb;
        padding: 0.75rem;
    }
    
    .content-wrapper th {
        background-color: #f9fafb;
        font-weight: 600;
        text-align: left;
    }
</style>
@endpush
@endsection
