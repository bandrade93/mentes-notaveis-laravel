<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    <body class="app sidebar-mini rtl">
        <div class="bg-overlay">
            <!-- <img src="{{ asset('assets/img/loading.svg') }}"> -->
        </div>
        <div id="app">
            <app-header title="{{ config('app.name') }}"></app-header>

            <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
            <div class="app-filter-sidebar__overlay" data-toggle="filter-sidebar"></div>

            <app-side></app-side>

            <main class="app-content">
                @yield('content')

            </main>
            <app-footer
                app-version="{{ config('app.version') }}"
                current-year="{{ date('Y') }}"
            ></app-footer>
        </div>
    </body>
</html>