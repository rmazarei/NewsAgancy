<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
    <div dir="rtl" lang="fa" class="min-h-screen bg-slate-50 text-slate-800">
        <header class="border-b border-slate-200 bg-white shadow-sm">
            <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
                <div class="flex items-center gap-6">
                    <Link href="/" class="text-xl font-black text-slate-900">لارا نیوز</Link>
                    <Link href="/" class="text-sm text-slate-600 hover:text-slate-900">خانه</Link>
                </div>

                <div class="flex items-center gap-3">
                    <Link v-if="user" href="/admin/dashboard" class="rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-700">داشبورد</Link>
                    <Link v-else href="/login" class="rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-700">ورود</Link>
                    <Link v-if="!user" href="/register" class="rounded-md bg-slate-900 px-3 py-2 text-sm text-white">ثبت‌نام</Link>
                </div>
            </nav>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-8">
            <slot />
        </main>
    </div>
</template>
