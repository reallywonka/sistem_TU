{{-- Reusable partial: form fields untuk surat masuk (create & edit) --}}
{{-- Variabel: $kategoris (collection), $suratMasuk (optional, untuk edit) --}}

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

    {{-- Nomor Surat --}}
    <div>
        <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-1.5">
            Nomor Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input id="nomor_surat" type="text" name="nomor_surat"
               value="{{ old('nomor_surat', $suratMasuk->nomor_surat ?? '') }}"
               placeholder="Masukkan nomor surat" required
               class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                      {{ $errors->has('nomor_surat') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        @error('nomor_surat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label for="id_kategori" class="block text-sm font-medium text-gray-700 mb-1.5">
            Kategori Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <select id="id_kategori" name="id_kategori" required
                class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                       {{ $errors->has('id_kategori') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">
            <option value="">Pilih kategori...</option>
            @foreach($kategoris as $k)
            <option value="{{ $k->id_kategori }}"
                {{ old('id_kategori', $suratMasuk->id_kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
            @endforeach
        </select>
        @error('id_kategori')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Tanggal Surat --}}
    <div>
        <label for="tgl_surat" class="block text-sm font-medium text-gray-700 mb-1.5">
            Tanggal Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input id="tgl_surat" type="date" name="tgl_surat"
               value="{{ old('tgl_surat', isset($suratMasuk) ? $suratMasuk->tgl_surat->format('Y-m-d') : '') }}"
               required
               class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                      {{ $errors->has('tgl_surat') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        @error('tgl_surat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Tanggal Diterima --}}
    <div>
        <label for="tgl_diterima" class="block text-sm font-medium text-gray-700 mb-1.5">
            Tanggal Diterima <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input id="tgl_diterima" type="date" name="tgl_diterima"
               value="{{ old('tgl_diterima', isset($suratMasuk) ? $suratMasuk->tgl_diterima->format('Y-m-d') : '') }}"
               required
               class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                      {{ $errors->has('tgl_diterima') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        @error('tgl_diterima')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Asal Surat --}}
    <div class="sm:col-span-2">
        <label for="asal_surat" class="block text-sm font-medium text-gray-700 mb-1.5">
            Asal Surat <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <input id="asal_surat" type="text" name="asal_surat"
               value="{{ old('asal_surat', $suratMasuk->asal_surat ?? '') }}"
               placeholder="Masukkan instansi/pengirim asal surat" required
               class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                      {{ $errors->has('asal_surat') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
        @error('asal_surat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Perihal --}}
    <div class="sm:col-span-2">
        <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1.5">
            Perihal <span class="text-red-500" aria-hidden="true">*</span>
        </label>
        <textarea id="perihal" name="perihal" rows="3" required
                  placeholder="Tuliskan ringkasan perihal surat"
                  class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none
                         {{ $errors->has('perihal') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">{{ old('perihal', $suratMasuk->perihal ?? '') }}</textarea>
        @error('perihal')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Upload PDF --}}
    <div class="sm:col-span-2">
        <label for="file_pdf" class="block text-sm font-medium text-gray-700 mb-1.5">
            Unggah Pindai Surat (PDF)
            @isset($suratMasuk) @if($suratMasuk->file_pdf) <span class="text-xs text-gray-400">(biarkan kosong untuk tetap menggunakan file lama)</span> @endif @endisset
        </label>

        {{-- Existing file --}}
        @isset($suratMasuk) @if($suratMasuk->file_pdf)
        <div class="mb-2 flex items-center gap-2 text-sm text-gray-600">
            <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
            File saat ini: <a href="{{ route('surat-masuk.download', $suratMasuk->id_surat_masuk) }}" class="text-blue-600 hover:underline">Download PDF</a>
        </div>
        @endif @endisset

        {{-- Drop zone --}}
        <div id="drop-zone"
             class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors"
             onclick="document.getElementById('file_pdf').click()"
             ondragover="event.preventDefault(); this.classList.add('border-blue-500', 'bg-blue-50')"
             ondragleave="this.classList.remove('border-blue-500', 'bg-blue-50')"
             ondrop="handleDrop(event)">
            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
            </svg>
            <p class="text-sm text-gray-500"><span class="text-blue-600 font-medium">Unggah berkas</span> atau seret dan lepas</p>
            <p id="file-name-display" class="text-xs text-gray-400 mt-1">PDF hingga 10MB</p>
        </div>
        <input id="file_pdf" type="file" name="file_pdf" accept=".pdf" class="hidden"
               onchange="updateFileName(this)"/>
        @error('file_pdf')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

</div>

@push('scripts')
<script>
    function updateFileName(input) {
        const display = document.getElementById('file-name-display');
        display.textContent = input.files[0] ? input.files[0].name : 'PDF hingga 10MB';
        display.className = input.files[0] ? 'text-xs text-blue-600 mt-1 font-medium' : 'text-xs text-gray-400 mt-1';
    }

    function handleDrop(event) {
        event.preventDefault();
        const input = document.getElementById('file_pdf');
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            input.files = files;
            updateFileName(input);
        }
        event.currentTarget.classList.remove('border-blue-500', 'bg-blue-50');
    }
</script>
@endpush
