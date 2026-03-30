<x-layout>
    <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py-12">
        <h2 class="text-4xl text-center font-bold mb-4">Register</h2>
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <!-- Form fields go here -->
            <x-inputs.text id="name" name="name" label="Name" placeholder="Enter your name" required />
            <x-inputs.text id="email" name="email" label="Email" placeholder="Enter your email" type="email"
                required />
            <x-inputs.text id="password" name="password" label="Password" placeholder="Enter your password"
                type="password" required />
            <x-inputs.text id="password_confirmation" name="password_confirmation"
                label="Confirm
                Password" placeholder="Confirm your password" type="password" required />
            <x-button type="submit" class="w-full mt-4">Register</x-button>

            <p class="text-center mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login here</a>
            </p>

        </form>
    </div>
</x-layout>

