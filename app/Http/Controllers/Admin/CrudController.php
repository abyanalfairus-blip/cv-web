<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controller dasar untuk CRUD (tambah, lihat, ubah, hapus) di panel admin.
 *
 * Setiap tabel cukup membuat turunan kelas ini dan menentukan:
 *   - $model   : kelas model Eloquent
 *   - $judul   : nama yang tampil di halaman
 *   - $route   : nama route resource, mis. 'kontak' -> admin.kontak.*
 *   - fields() : daftar input form beserta aturan validasinya
 *   - kolom()  : kolom yang tampil di tabel daftar
 *
 * Jenis input yang didukung (kunci 'type'):
 *   text, email, url, textarea, number, date, select, checkbox,
 *   file      -> upload PDF ke folder public/{folder}
 *   lines     -> relasi hasMany diisi per baris (mis. poin pengalaman)
 *   relasi    -> relasi belongsToMany diisi dengan checkbox (mis. skill)
 */
abstract class CrudController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;

    protected string $judul;

    protected string $route;

    /** True jika tabel punya kolom profil_id (diisi otomatis). */
    protected bool $milikProfil = true;

    abstract protected function fields(): array;

    /** Kolom tabel daftar: label => nama atribut atau closure($baris). */
    abstract protected function kolom(): array;

    /** Query dasar daftar data. */
    protected function query(): Builder
    {
        return $this->model::query()->orderBy('urutan')->orderBy('id');
    }

    /** Relasi yang dimuat saat menampilkan daftar (mencegah N+1). */
    protected function with(): array
    {
        return [];
    }

    /* ======================= AKSI RESOURCE ======================= */

    public function index(): View
    {
        $data = $this->query()->with($this->with())->get();

        $baris = $data->map(fn (Model $m) => [
            'id'   => $m->getKey(),
            'sel'  => collect($this->kolom())->map(
                fn ($k) => is_callable($k) ? $k($m) : data_get($m, $k)
            )->all(),
        ]);

        return view('admin.crud.index', [
            'judul' => $this->judul,
            'route' => $this->route,
            'kolom' => array_keys($this->kolom()),
            'baris' => $baris,
        ]);
    }

    public function create(): View
    {
        return $this->form(new $this->model);
    }

    public function store(Request $request): RedirectResponse
    {
        $item = new $this->model;
        $this->simpan($request, $item);

        return redirect()->route("admin.{$this->route}.index")
            ->with('pesan', "{$this->judul} berhasil ditambahkan.");
    }

    public function edit(string $id): View
    {
        return $this->form($this->model::findOrFail($id));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $this->simpan($request, $this->model::findOrFail($id));

        return redirect()->route("admin.{$this->route}.index")
            ->with('pesan', "{$this->judul} berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->model::findOrFail($id)->delete();

        return redirect()->route("admin.{$this->route}.index")
            ->with('pesan', "{$this->judul} berhasil dihapus.");
    }

    /* ======================= PROSES FORM ======================= */

    protected function form(Model $item): View
    {
        $fields = collect($this->fields())->map(function ($f, $nama) use ($item) {
            $f['nilai'] = match ($f['type']) {
                'lines'  => $this->nilaiLines($item, $nama, $f),
                'relasi' => $item->exists ? $item->{$nama}->pluck('id')->all() : [],
                'date'   => optional($item->{$nama})->format('Y-m-d'),
                default  => $item->{$nama},
            };
            if (isset($f['options']) && is_callable($f['options'])) {
                $f['options'] = $f['options']();
            }

            return $f;
        });

        return view('admin.crud.form', [
            'judul'  => $this->judul,
            'route'  => $this->route,
            'item'   => $item,
            'fields' => $fields,
            'aksi'   => $item->exists
                ? route("admin.{$this->route}.update", $item->getKey())
                : route("admin.{$this->route}.store"),
        ]);
    }

    /** Validasi lalu simpan kolom biasa, file, dan relasi. */
    protected function simpan(Request $request, Model $item): void
    {
        $fields = $this->fields();

        $aturan = collect($fields)->mapWithKeys(fn ($f, $nama) => match ($f['type']) {
            'relasi'   => [$nama => ['array'], "{$nama}.*" => ['integer']],
            'checkbox' => [$nama => ['nullable']],
            'file'     => [$nama => array_merge(['nullable', 'file', 'mimes:pdf', 'max:5120'], $f['rules'] ?? [])],
            default    => [$nama => $f['rules'] ?? ['nullable']],
        })->all();

        $valid = $request->validate($aturan, [], collect($fields)->map(fn ($f) => strtolower($f['label']))->all());

        foreach ($fields as $nama => $f) {
            switch ($f['type']) {
                case 'lines':
                case 'relasi':
                    break; // disimpan setelah model punya id
                case 'checkbox':
                    $item->{$nama} = $request->boolean($nama);
                    break;
                case 'file':
                    if ($request->hasFile($nama)) {
                        $file = $request->file($nama);
                        $namaFile = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.pdf';
                        $file->move(public_path($f['folder']), $namaFile);
                        $item->{$nama} = $f['folder'] . '/' . $namaFile;
                    }
                    break;
                default:
                    $item->{$nama} = $valid[$nama] ?? null;
            }
        }

        if ($this->milikProfil && ! $item->profil_id) {
            $item->profil_id = Profil::firstOrFail()->id;
        }

        $item->save();

        foreach ($fields as $nama => $f) {
            if ($f['type'] === 'relasi') {
                $item->{$nama}()->sync($request->input($nama, []));
            }
            if ($f['type'] === 'lines') {
                $this->simpanLines($item, $nama, $f, (string) $request->input($nama));
            }
        }
    }

    /**
     * Relasi hasMany diisi lewat textarea: satu baris = satu data.
     * Jika 'kolom' berisi 2 nama (mis. ['nama', 'keterangan']), pisahkan dengan " | ".
     */
    protected function simpanLines(Model $item, string $relasi, array $f, string $teks): void
    {
        $kolom = $f['kolom'];
        $baris = collect(preg_split('/\r\n|\r|\n/', $teks))->map('trim')->filter()->values();

        $item->{$relasi}()->delete();
        $item->{$relasi}()->createMany($baris->map(function ($b, $i) use ($kolom) {
            $bagian = array_map('trim', explode('|', $b, count($kolom)));
            $data = ['urutan' => $i + 1];
            foreach ($kolom as $k => $namaKolom) {
                $data[$namaKolom] = $bagian[$k] ?? null;
            }

            return $data;
        })->all());
    }

    protected function nilaiLines(Model $item, string $relasi, array $f): string
    {
        if (! $item->exists) {
            return '';
        }

        return $item->{$relasi}->map(
            fn ($r) => collect($f['kolom'])->map(fn ($k) => $r->{$k})->filter()->implode(' | ')
        )->implode("\n");
    }
}
