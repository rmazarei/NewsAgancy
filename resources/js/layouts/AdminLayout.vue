<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user ?? {});
const hasAdminRole = computed(() => {
    const roles = user.value.roles ?? [];

    return roles.includes('admin') || user.value.role === 'admin';
});

const navItems = [
    { label: 'داشبورد', href: '/admin/dashboard' },
    { label: 'اخبار', href: '/admin/news' },
    { label: 'دسته‌بندی‌ها', href: '/admin/categories' },
    { label: 'شهرها', href: '/admin/cities' },
];
</script>

<template>
    <div dir="rtl" lang="fa" class="min-h-screen bg-slate-100 text-slate-900">
        <header class="border-b border-slate-200 bg-white shadow-sm">
            <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4">
                <div class="flex items-center gap-3">
                    <Link href="/admin/dashboard" class="text-lg font-bold text-slate-900">
                        لارا نیوز
                    </Link>
                </div>

<!--                <div v-if="hasAdminRole" class="hidden items-center gap-2 md:flex">-->
                <div class="hidden items-center gap-2 md:flex">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                    >
                        {{ item.label }}
                    </Link>
                </div>

                <div class="flex items-center gap-3">
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">
                        {{ user.name ?? 'کاربر' }}
                    </span>
                    <Link href="/logout" method="post" as="button" class="rounded-md bg-slate-900 px-3 py-2 text-sm text-white">
                        خروج
                    </Link>
                </div>
            </nav>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8">
            <slot />
        </main>
    </div>
</template>
