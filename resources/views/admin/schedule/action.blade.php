<div class="flex justify-center gap-2">
    <a href="{{ route('admin.schedule.show', $row->id) }}"
        class="px-3 py-1 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.schedule.edit', $row->id) }}"
        class="px-3 py-1 text-xs rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('admin.schedule.destroy', $row->id) }}" method="POST"
        onsubmit="return confirm('Yakin hapus jadwal ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-3 py-1 text-xs rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>