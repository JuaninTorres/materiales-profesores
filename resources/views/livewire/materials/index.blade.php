<div class="container mx-auto p-0">
  <h1 class="text-2xl font-bold mb-4">Materiales</h1>

  <div class="grid md:grid-cols-6 gap-3 mb-4">
    <input wire:model.live.debounce.300ms="q" type="search" placeholder="Buscar..."
           class="md:col-span-2 border rounded px-3 py-2">
    <select wire:model.live="level" class="border rounded px-3 py-2">
      <option value="">Nivel</option>
      <option value="colegio">Colegio</option>
      <option value="cft">CFT</option>
      <option value="particulares">Particulares</option>
    </select>
    <input wire:model.live="subject" placeholder="Asignatura" class="border rounded px-3 py-2">
    <input wire:model.live="course" placeholder="Curso" class="border rounded px-3 py-2">
    <div class="flex gap-2">
      <input wire:model.live="year" type="number" placeholder="Año" class="border rounded px-3 py-2 w-24">
      <select wire:model.live="semester" class="border rounded px-3 py-2 w-28">
        <option value="">Semestre</option>
        <option value="1">1</option><option value="2">2</option>
      </select>
    </div>
  </div>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($materials as $m)
      <a wire:navigate href="{{ route('materials.show',$m->code) }}"
         class="block border rounded-xl p-4 hover:shadow bg-white">
        <div class="text-sm text-gray-500">{{ $m->code }}</div>
        <div class="font-semibold">{{ $m->title }}</div>
        <div class="text-xs text-gray-600">
          {{ strtoupper($m->level) }} • {{ $m->subject }}
          @if($m->year) • {{ $m->year }}@endif
          @if($m->semester) - S{{ $m->semester }}@endif
        </div>
      </a>
    @endforeach
  </div>

  <div class="mt-4">{{ $materials->links() }}</div>
</div>
