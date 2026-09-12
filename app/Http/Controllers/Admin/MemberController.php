<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'member');

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('nis', 'like', "%{$searchTerm}%")
                    ->orWhere('nip', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('tipe')) {
            $query->where('member_type', $request->input('tipe'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $members = $query->withCount('borrowings')->latest()->paginate(10)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create(): View
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'member_type' => ['required', Rule::in(['siswa', 'guru'])],
            'nis' => ['nullable', 'required_if:member_type,siswa', 'string', 'max:30', 'unique:users,nis'],
            'nip' => ['nullable', 'required_if:member_type,guru', 'string', 'max:30', 'unique:users,nip'],
            'class' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $member = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'role' => 'member',
            'member_type' => $validated['member_type'],
            'nis' => $validated['nis'] ?? null,
            'nip' => $validated['nip'] ?? null,
            'class' => $validated['class'] ?? null,
            'major' => $validated['major'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::record('member_created', "Anggota baru '{$member->name}' ditambahkan oleh Admin.");

        return redirect()->route('admin.members.index')->with('success', 'Anggota perpustakaan berhasil ditambahkan.');
    }

    /**
     * Show member detail.
     */
    public function show(User $member): View
    {
        $member->load(['borrowings.book', 'fines']);

        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the member.
     */
    public function edit(User $member): View
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, User $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$member->id],
            'username' => ['required', 'string', 'max:50', 'unique:users,username,'.$member->id],
            'member_type' => ['required', Rule::in(['siswa', 'guru'])],
            'nis' => ['nullable', 'string', 'max:30', 'unique:users,nis,'.$member->id],
            'nip' => ['nullable', 'string', 'max:30', 'unique:users,nip,'.$member->id],
            'class' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'member_type' => $validated['member_type'],
            'nis' => $validated['nis'] ?? null,
            'nip' => $validated['nip'] ?? null,
            'class' => $validated['class'] ?? null,
            'major' => $validated['major'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $member->update($data);

        ActivityLog::record('member_updated', "Data anggota '{$member->name}' diperbarui oleh Admin.");

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Toggle member status (active/inactive).
     */
    public function toggleStatus(User $member): RedirectResponse
    {
        $newStatus = $member->status === 'active' ? 'inactive' : 'active';
        $member->update(['status' => $newStatus]);

        ActivityLog::record('member_status_toggled', "Status anggota '{$member->name}' diubah menjadi {$newStatus}.");

        return back()->with('success', "Status anggota {$member->name} berhasil diubah menjadi {$newStatus}.");
    }

    /**
     * Remove the specified member.
     */
    public function destroy(User $member): RedirectResponse
    {
        if ($member->borrowings()->where('status', 'borrowed')->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $name = $member->name;
        $member->delete();

        ActivityLog::record('member_deleted', "Anggota '{$name}' telah dihapus dari sistem.");

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
