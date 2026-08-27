<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NewsCarousel from '@/components/NewsCarousel.vue';

const props = defineProps({
    news: Object,
    carouselNews: Array,
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
    <Head title="خانه" />

    <div class="space-y-10">
        <section class="rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 p-8 text-white shadow-lg">
            <p class="mb-2 text-sm text-slate-200">آخرین اخبار و گزارش‌ها</p>
            <h1 class="text-3xl font-black">خبرهای ایران و جهان</h1>
        </section>

        <div>
            <NewsCarousel :news="carouselNews" />
        </div>


        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">


            <article v-for="item in news.data" :key="item.id" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <img
                    v-if="item.main_image"
                    :src="item.main_image"
                    :alt="item.title"
                    class="h-52 w-full object-cover"
                />
                <div v-else class="flex h-52 items-center justify-center bg-slate-200 text-slate-500">
                    بدون تصویر
                </div>

                <div class="space-y-4 p-5">
                    <div class="flex flex-wrap gap-2">
                        <span v-for="category in item.categories" :key="category.id" class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-700">
                            <Link :href="`/?category=${category.id}`">
                                {{ category.title }}
                            </Link>
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900">{{ item.title }}</h2>
                    <p class="text-sm text-slate-500">{{ formatDate(item.published_at) }}</p>

                    <div class="line-clamp-3 text-sm leading-7 text-slate-600" v-html="item.content" />

                    <Link :href="`/news/${item.slug}`" class="inline-flex rounded-md bg-slate-900 px-3 py-2 text-sm text-white">ادامه مطلب</Link>
                </div>
            </article>
        </div>

        <div v-if="news.links && news.links.length > 3" class="flex justify-center gap-2">
            <template v-for="link in news.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="rounded-md border px-3 py-2 text-sm"
                    :class="link.active ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
