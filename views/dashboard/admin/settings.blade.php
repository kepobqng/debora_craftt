@extends('dashboard.layouts.app')

@section('navigation')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Dashboard
    </a>
    <a href="{{ route('admin.users') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Users
    </a>
    <a href="{{ route('admin.settings') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">
        Settings
    </a>
    <a href="{{ route('admin.reports') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Reports
    </a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h1 class="text-2xl font-bold text-black mb-6">Admin Settings</h1>
            
            <div class="space-y-6">
                <!-- System Settings -->
                <div>
                    <h3 class="text-lg font-medium text-black mb-4">System Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="site-name" class="block text-sm font-medium text-gray-700">Site Name</label>
                            <input type="text" id="site-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black" value="{{ config('app.name') }}">
                        </div>
                        <div>
                            <label for="site-description" class="block text-sm font-medium text-gray-700">Site Description</label>
                            <textarea id="site-description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-black focus:border-black">Your site description here</textarea>
                        </div>
                    </div>
                </div>

                <!-- User Registration Settings -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-black mb-4">User Registration</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-black">Allow New Registrations</h4>
                                <p class="text-sm text-gray-500">Enable or disable new user registrations</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-black rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-black">Email Verification</h4>
                                <p class="text-sm text-gray-500">Require email verification for new users</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-black rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-black mb-4">Security Settings</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-black">Two-Factor Authentication</h4>
                                <p class="text-sm text-gray-500">Require 2FA for admin accounts</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-black rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="pt-6 border-t border-gray-200">
                    <button class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                        Save Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection