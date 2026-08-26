<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Object,
});

function destroy(id) {
    if (! window.confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟')) {
        return;
    }

    router.delete(`/admin/categories/${id}`);
}
</script>

<template>
    <Head title="دسته‌بندی‌ها" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">مدیریت دسته‌بندی‌ها</h1>
            <Link href="/admin/categories/create" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white">ثبت دسته‌بندی</Link>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-right">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">عنوان</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">ترتیب</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="category in categories.data" :key="category.id">
                        <td class="px-4 py-3 text-sm text-slate-800">{{ category.title }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ category.order }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <Link :href="`/admin/categories/${category.id}/edit`" class="rounded-md border border-slate-300 px-2 py-1 text-xs">ویرایش</Link>
                                <button type="button" @click="destroy(category.id)" class="rounded-md border border-red-200 bg-red-50 px-2 py-1 text-xs text-red-600">حذف</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
