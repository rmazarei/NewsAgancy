<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    stats: Object,
});

const cards = [
    { label: 'کل خبرها', value: props.stats.news },
    { label: 'دسته‌بندی‌ها', value: props.stats.categories },
    { label: 'شهرها', value: props.stats.cities },
];
</script>

<template>
    <Head title="داشبورد" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">داشبورد مدیریت</h1>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div v-for="card in cards" :key="card.label" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="text-sm text-slate-500">{{ card.label }}</div>
                <div class="mt-3 text-3xl font-bold text-slate-900">{{ card.value }}</div>
            </div>
        </div>
    </div>
</template>
