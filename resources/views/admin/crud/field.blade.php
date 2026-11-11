{{-- Satu input form. $nama = nama kolom/relasi, $f = definisi dari controller --}}
@php
    $id = 'f-' . $nama;
    $nilai = old($nama, $f['nilai']);
    $lebar = ($f['lebar'] ?? 'full') === 'half' ? 'half' : 'full';
    $wajib = in_array('required', $f['rules'] ?? []);
@endphp

<div class="field {{ $lebar }} {{ $errors->has($nama) ? 'salah' : '' }}">
    @if ($f['type'] === 'checkbox')
        <label class="cek" for="{{ $id }}">
            <input type="checkbox" id="{{ $id }}" name="{{ $nama }}" value="1" @checked($nilai)>
            {{ $f['label'] }}
        </label>
    @else
        <label for="{{ $id }}">{{ $f['label'] }} @if ($wajib)<span class="wajib">*</span>@endif</label>

        @switch($f['type'])
            @case('textarea')
                <textarea id="{{ $id }}" name="{{ $nama }}" rows="4">{{ $nilai }}</textarea>
                @break

            @case('lines')
                <textarea id="{{ $id }}" name="{{ $nama }}" rows="5" class="mono">{{ $nilai }}</textarea>
                @break

            @case('select')
                <select id="{{ $id }}" name="{{ $nama }}">
                    <option value="">— pilih —</option>
                    @foreach ($f['options'] as $val => $teks)
                        <option value="{{ $val }}" @selected((string) $nilai === (string) $val)>{{ $teks }}</option>
                    @endforeach
                </select>
                @break

            @case('relasi')
                @php $terpilih = collect(old($nama, $f['nilai']))->map(fn ($v) => (int) $v)->all(); @endphp
                <div class="relasi" id="{{ $id }}">
                    @foreach ($f['options'] as $grup => $opsi)
                        <fieldset>
                            <legend>{{ $grup }}</legend>
                            @foreach ($opsi as $val => $teks)
                                <label class="cek">
                                    <input type="checkbox" name="{{ $nama }}[]" value="{{ $val }}" @checked(in_array($val, $terpilih))>
                                    {{ $teks }}
                                </label>
                            @endforeach
                        </fieldset>
                    @endforeach
                </div>
                @break

            @case('file')
                @if ($f['nilai'])
                    <p class="file-now">File saat ini: <a href="{{ asset($f['nilai']) }}" target="_blank" rel="noopener">{{ basename($f['nilai']) }}</a></p>
                @endif
                <input type="file" id="{{ $id }}" name="{{ $nama }}" accept="application/pdf">
                @break

            @default
                <input type="{{ $f['type'] }}" id="{{ $id }}" name="{{ $nama }}" value="{{ $nilai }}">
        @endswitch
    @endif

    @if (! empty($f['help']))
        <small class="help">{{ $f['help'] }}</small>
    @endif
    @error($nama) <small class="err">{{ $message }}</small> @enderror
</div>
