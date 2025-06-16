@extends('partials.header')
@section('title', 'About')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-6">About This Application</h1>
        <p class="mb-4">
            This application was created to help smaller scale organizations easily manage and promote their events. We believe that everyone should have access to simple and effective event management tools, regardless of their size or technical expertise.
        </p>
        <p class="mb-4">
            Our platform is designed to be user-friendly and accessible, making it easy for anyone to organize, share, and keep track of their events. Whether you're hosting a community gathering, a workshop, or a local festival, our goal is to support your success.
        </p>
        <h2 class="text-2xl font-semibold mt-8 mb-4">Meet the Developers</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-linear-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-4">
                <h3 class="font-bold text-xl mb-2">Wim</h3>
                <p>
                    Wim is passionate about web development and enjoys solving complex problems. He worked on integrating the different components and ensuring the application runs smoothly.
                </p>
            </div>
            <div class="bg-linear-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-4">
                <h3 class="font-bold text-xl mb-2">Brent</h3>
                <p>
                    Brent specializes in user experience and design. He focused on making the application intuitive and visually appealing for all users.
                </p>
            </div>
            <div class="bg-linear-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-4">
                <h3 class="font-bold text-xl mb-2">Jordy</h3>
                <p>
                    Jordy contributed to the backend and overall architecture of this project. He also handled much of the testing and deployment.
                </p>
            </div>
        </div>
        <p class="mt-8">
            We are three students who created this website as our end project, and we hope it serves your needs well!
        </p>
    </div>
@endsection