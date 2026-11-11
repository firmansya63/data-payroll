<div class="grid gap-4 md:grid-cols-2">
  <label class="block text-sm font-semibold text-slate-600">Nama <span class="text-rose-500">*</span>
    <input name="name" value="{{ old('name', $user->name ?? '') }}" required autocomplete="name" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
    @error('name')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
  </label>
  <label class="block text-sm font-semibold text-slate-600">Email <span class="text-rose-500">*</span>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required autocomplete="email" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
    @error('email')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
  </label>
  <label class="block text-sm font-semibold text-slate-600">Role <span class="text-rose-500">*</span>
    <select name="role" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
      <option value="admin" @selected(old('role', $user->role ?? 'attendance') === 'admin')>Admin — akses penuh</option>
      <option value="attendance" @selected(old('role', $user->role ?? 'attendance') === 'attendance')>Absensi Saja — scanner QR</option>
    </select>
    @error('role')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
  </label>
  <div></div>
  <label class="block text-sm font-semibold text-slate-600">{{ isset($user) ? 'Password Baru' : 'Password' }} <span class="text-rose-500">{{ isset($user) ? '' : '*' }}</span>
    <input type="password" name="password" {{ isset($user) ? '' : 'required' }} minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
    @error('password')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
  </label>
  <label class="block text-sm font-semibold text-slate-600">Konfirmasi Password {{ isset($user) ? 'Baru' : '' }} <span class="text-rose-500">{{ isset($user) ? '' : '*' }}</span>
    <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }} minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
  </label>
</div>
@if(isset($user))<p class="mt-3 text-xs text-slate-500">Kosongkan password jika tidak ingin mengubahnya.</p>@endif
