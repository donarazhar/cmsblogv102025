@extends('admin.layouts.app')

@section('title', 'Tambah Halaman')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Tambah Halaman</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.pages.index') }}">Halaman</a>
                    <span>/</span>
                    <span>Tambah</span>
                </div>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @include('admin.pages._form', ['page' => null, 'parentPages' => $parentPages])
@endsection
