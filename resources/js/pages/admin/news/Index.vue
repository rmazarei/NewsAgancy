<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    news: Object,
    categories: Array,
    cities: Array,
    filters: Object,
});

const filters = reactive({
    search: props.filters.search ?? '',
    category_id: props.filters.category_id ?? '',
    city_id: props.filters.city_id ?? '',
});

function applyFilters() {
    router.get('/admin/news', filters, {
        preserveState: true,
        replace: true,
    });
}

function destroy(id) {
    if (! window.confirm('آیا از حذف این خبر مطمئن هستید؟')) {
        return;
    }

    router.delete(`/admin/news/${id}`);
}

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
    <Head title="مدیریت اخبار" />

    <div class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">مدیریت اخبار</h1>
            </div>
            <Link href="/admin/news/create" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white">
                ثبت خبر جدید
            </Link>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-4">
                <input v-model="filters.search" type="text" placeholder="جستجو در عنوان" class="rounded-md border border-slate-300 px-3 py-2 text-sm" />
                <select v-model="filters.category_id" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                    <option value="">همه دسته‌بندی‌ها</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                </select>
                <select v-model="filters.city_id" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                    <option value="">همه شهرها</option>
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                </select>
                <button type="button" @click="applyFilters" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white">
                    اعمال فیلتر
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-right">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">عنوان</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">دسته‌بندی‌ها</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">شهرها</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">تاریخ انتشار</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="item in news.data" :key="item.id">
                        <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ item.title }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            <span v-for="category in item.categories" :key="category.id" class="ml-2 inline-block rounded-full bg-slate-100 px-2 py-1 text-xs">
                                {{ category.title }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            <span v-for="city in item.cities" :key="city.id" class="ml-2 inline-block rounded-full bg-sky-100 px-2 py-1 text-xs">
                                {{ city.name }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ formatDate(item.published_at) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <Link :href="`/admin/news/${item.id}/edit`" class="rounded-md border border-slate-300 px-2 py-1 text-xs">ویرایش</Link>
                                <button type="button" @click="destroy(item.id)" class="rounded-md border border-red-200 bg-red-50 px-2 py-1 text-xs text-red-600">حذف</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
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
