<x-layout>
    <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py-12">
        <h2 class="text-4xl text-center font-bold mb-4">Login</h2>
        <form action="{{ route('login.authenticate') }}" method="POST">
            @csrf
            <x-inputs.text id="email" name="email" label="Email" placeholder="Enter your email" type="email"
                required />
            <x-inputs.text id="password" name="password" label="Password" placeholder="Enter your password"
                type="password" required />
            <x-button type="submit" label="Login" />

            <p class="text-center mt-4">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register here</a>
            </p>

        </form>
    </div>
</x-layout>
