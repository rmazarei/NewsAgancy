<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    cities: Object,
});

function destroy(id) {
    if (! window.confirm('آیا از حذف این شهر مطمئن هستید؟')) {
        return;
    }

    router.delete(`/admin/cities/${id}`);
}
</script>

<template>
    <Head title="شهرها" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">مدیریت شهرها</h1>
            <Link href="/admin/cities/create" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white">ثبت شهر</Link>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-right">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">نام</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">استان</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">شهرستان</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="city in cities.data" :key="city.id">
                        <td class="px-4 py-3 text-sm text-slate-800">{{ city.name }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ city.province?.name ?? city.province_id }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ city.county?.name ?? city.county_id }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <Link :href="`/admin/cities/${city.id}/edit`" class="rounded-md border border-slate-300 px-2 py-1 text-xs">ویرایش</Link>
                                <button type="button" @click="destroy(city.id)" class="rounded-md border border-red-200 bg-red-50 px-2 py-1 text-xs text-red-600">حذف</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
