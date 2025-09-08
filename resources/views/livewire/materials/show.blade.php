<div class="container mx-auto p-0">
  <a wire:navigate href="{{ route('materials.index') }}" class="text-sm underline">← Volver</a>
  <h1 class="text-2xl font-bold mt-2">{{ $material->title }}</h1>
  <p class="text-gray-600">{{ $material->description }}</p>

  <div class="mt-2 text-xs text-gray-500">
    {{ strtoupper($material->level) }} • {{ $material->subject }}
    @if($material->year) • {{ $material->year }}@endif
    @if($material->semester) - S{{ $material->semester }}@endif
  </div>

  @if($material->type === 'pdf' && $material->file_path)
    <div class="mt-4 h-[80vh]">
      <iframe src="{{ asset('storage/'.$material->file_path) }}" class="w-full h-full" title="Visor PDF"></iframe>
    </div>
  @elseif($material->type === 'html' && $material->file_path)
    <div class="mt-4 border rounded">
      <iframe src="{{ asset('storage/'.$material->file_path) }}" class="w-full h-[80vh]" title="Presentación HTML"></iframe>
    </div>
  @elseif($material->type === 'link' && $material->link_url)
    <p class="mt-4"><a href="{{ $material->link_url }}" target="_blank" class="underline">Abrir recurso externo</a></p>
  @endif
</div>
