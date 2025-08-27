<x-app-layout title="Profile">
    <div class="max-w-lg p-6 mx-auto bg-white rounded shadow">
        <h2 class="mb-4 text-xl font-semibold">Edit Profile</h2>

        @if (session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded">
                <input type="password" name="password_confirmation" placeholder="Confirm password" class="w-full px-3 py-2 mt-2 border rounded">
            </div>

            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Save</button>
        </form>

        <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded">Delete Account</button>
        </form>
    </div>
</x-app-layout>
