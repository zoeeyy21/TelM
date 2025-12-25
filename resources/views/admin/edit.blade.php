@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <a href="{{ route('admin.index') }}" class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
            <h1 class="text-4xl font-bold text-gray-900">Edit Produk</h1>
            <p class="text-gray-600 mt-2">Perbarui informasi produk Anda</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- ===========================1==========================  -->
            <!-- Isi form action agar data dapat di proses di controller admin.update dengan parameter produk id -->
            <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-10">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="mb-8">
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-3">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ $product->name }}" placeholder="Masukkan nama produk" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror" 
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Deskripsi Produk -->
                <div class="mb-8">
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" placeholder="Jelaskan fitur, manfaat, dan detail produk Anda..." rows="6" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('description') border-red-500 @enderror" 
                        required>{{ $product->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-8">
                    <label for="price" class="block text-sm font-semibold text-gray-900 mb-3">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-medium">Rp</span>
                        <input type="number" step="0.01" min="0" name="price" id="price" value="{{ $product->price }}" placeholder="0" 
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('price') border-red-500 @enderror" 
                            required>
                    </div>
                    @error('price')
                        <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Image Section -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Gambar Produk</h2>

                    <!-- Current Image -->
                    @if($product->image)
                        <div class="mb-8">
                            <p class="text-sm font-medium text-gray-700 mb-3">Gambar Saat Ini:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="w-full max-w-xs h-auto rounded-lg shadow-md border-2 border-gray-200">
                                <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Aktif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- File Input -->
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-3">Perbarui Gambar:</p>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 hover:border-blue-500 transition cursor-pointer group" onclick="document.getElementById('image').click()">
                            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" class="hidden">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm font-medium text-gray-700">Klik untuk upload</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF maksimal 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="hidden">
                        <p class="text-sm font-medium text-gray-700 mb-3">Preview Gambar Baru:</p>
                        <div class="bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg p-4">
                            <img id="preview" class="w-full max-w-xs h-auto rounded-lg shadow-md" />
                            <button type="button" onclick="removeImage()" class="mt-4 inline-flex items-center space-x-2 text-red-600 hover:text-red-700 font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Hapus Gambar Baru</span>
                            </button>
                        </div>
                    </div>

                    @error('image')
                        <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-8">
                    <a href="{{ route('admin.index') }}" class="flex-1 inline-flex items-center justify-center space-x-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="flex-1 inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Update Produk</span>
                    </button>
                </div>
            </form> 
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    const previewDiv = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const fileInput = document.getElementById('image');
            const previewDiv = document.getElementById('imagePreview');
            fileInput.value = '';
            previewDiv.classList.add('hidden');
        }
    </script>
</div>
@endsection
