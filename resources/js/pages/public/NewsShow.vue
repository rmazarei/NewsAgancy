<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    news: Object,
});

function formatDate(value) {
    if (! value) {
        return 'نامشخص';
    }

    return new Intl.DateTimeFormat('fa-IR', {
        dateStyle: 'medium',
    }).format(new Date(value));
}
</script>

<template>
    <Head :title="news.title" />

    <article class="space-y-6">
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-4 flex flex-wrap gap-2">
                <span v-for="category in news.categories" :key="category.id" class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-700">
                    {{ category.title }}
                </span>
            </div>

            <h1 class="text-3xl font-black text-slate-900">{{ news.title }}</h1>
            <p class="mt-3 text-sm text-slate-500">{{ formatDate(news.published_at) }}</p>
        </div>

        <img
            v-if="news.main_image"
            :src="news.main_image"
            :alt="news.title"
            class="h-[420px] w-full rounded-2xl object-cover shadow-sm"
        />

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="prose prose-lg max-w-none rtl text-slate-800" v-html="news.content" />
        </div>

        <div v-if="news.gallery_urls && news.gallery_urls.length" class="grid gap-4 md:grid-cols-3">
            <img
                v-for="(image, index) in news.gallery_urls"
                :key="index"
                :src="image"
                :alt="`${news.title} - ${index + 1}`"
                class="h-48 w-full rounded-xl object-cover shadow-sm"
            />
        </div>

        <div class="flex justify-end">
            <Link href="/" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white">بازگشت به صفحه اصلی</Link>
        </div>
    </article>
</template>
