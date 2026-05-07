{{-- Reusable form partial untuk surat keluar --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

    {{-- Nomor Surat --}}
    <div class="sm:col-span-2">
        <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-1.5">
            Nomor Surat
        </label>
        <div class="flex gap-2">
            <input id="nomor_surat" type="text" name="nomor_surat"
                   value="{{ old('nomor_surat', $suratKeluar->nomor_surat ?? '') }}"
                   placeholder="Masukkan atau hasilkan nomor surat"
                   class="flex-1 rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                          {{ $errors->has('nomor_surat') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        </div>
        @error('nomor_surat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Tanggal Surat --}}
    <div>
        <label for="tgl_surat" class="block text-sm font-medium text-gray-700 mb-1.5">
            Tanggal Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input id="tgl_surat" type="date" name="tgl_surat"
               value="{{ old('tgl_surat', isset($suratKeluar) ? $suratKeluar->tgl_surat->format('Y-m-d') : '') }}"
               required
               class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                      {{ $errors->has('tgl_surat') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        @error('tgl_surat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label for="id_kategori" class="block text-sm font-medium text-gray-700 mb-1.5">
            Kategori Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <select id="id_kategori" name="id_kategori" required
                class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                       {{ $errors->has('id_kategori') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">
            <option value="">Pilih Kategori...</option>
            @foreach($kategoris as $k)
            <option value="{{ $k->id_kategori }}"
                {{ old('id_kategori', $suratKeluar->id_kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
            @endforeach
        </select>
        @error('id_kategori')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Tujuan Surat --}}
    <div class="sm:col-span-2">
        <label for="tujuan_surat" class="block text-sm font-medium text-gray-700 mb-1.5">
            Tujuan Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input id="tujuan_surat" type="text" name="tujuan_surat"
               value="{{ old('tujuan_surat', $suratKeluar->tujuan_surat ?? '') }}"
               placeholder="Nama instansi atau perorangan yang dituju" required
               class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                      {{ $errors->has('tujuan_surat') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        @error('tujuan_surat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Perihal --}}
    <div class="sm:col-span-2">
        <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1.5">
            Perihal <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <textarea id="perihal" name="perihal" rows="3" required
                  placeholder="Ringkasan isi atau perihal surat"
                  class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none
                         {{ $errors->has('perihal') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">{{ old('perihal', $suratKeluar->perihal ?? '') }}</textarea>
        @error('perihal')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Upload Berkas --}}
    <div class="sm:col-span-2">
        <label for="file_pdf" class="block text-sm font-medium text-gray-700 mb-1.5">
            Unggah Berkas (PDF/Gambar)
            @isset($suratKeluar) @if($suratKeluar->file_pdf) <span class="text-xs text-gray-400">(opsional — ganti file lama)</span> @endif @endisset
        </label>
        <div class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors"
             onclick="document.getElementById('file_pdf').click()">
            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
            </svg>
            <p class="text-sm text-gray-500"><span class="text-blue-600 font-medium">Unggah berkas</span> atau seret dan lepas</p>
            <p id="file-sk-name" class="text-xs text-gray-400 mt-1">PDF, JPG, PNG hingga 10MB</p>
        </div>
        <input id="file_pdf" type="file" name="file_pdf" accept=".pdf,.jpg,.png" class="hidden"
               onchange="document.getElementById('file-sk-name').textContent = this.files[0]?.name || 'PDF, JPG, PNG hingga 10MB'"/>
        @error('file_pdf')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

</div>
