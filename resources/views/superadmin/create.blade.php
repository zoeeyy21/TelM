@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <a href="{{ route('superadmin.index') }}" class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
            <h1 class="text-4xl font-bold text-gray-900">Buat Produk Baru</h1>
            <p class="text-gray-600 mt-2">Tambahkan produk baru ke katalog Anda dengan detail lengkap</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('superadmin.store') }}" enctype="multipart/form-data" class="p-8 sm:p-10">
                @csrf

                <!-- Nama Produk -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        required>
                </div>

                <!-- Deskripsi Produk -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Deskripsi Produk *</label>
                    <textarea name="description" rows="6"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        required>{{ old('description') }}</textarea>
                </div>

                <!-- 🔥 KATEGORI PRODUK (BARU) -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Kategori Produk <span class="text-red-500">*</span>
                    </label>

                    <select name="category_id"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Harga *</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror"
                        required>
                </div>

                <!-- Gambar -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Gambar Produk</label>
                    <input type="file" name="image" class="w-full">
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-8 border-t">
                    <a href="{{ route('superadmin.index') }}"
                       class="flex-1 text-center bg-gray-200 py-3 rounded-lg font-semibold">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 bg-green-600 text-white py-3 rounded-lg font-semibold">
                        Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
