<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    city: Object,
});

const form = useForm({
    name: props.city.name || '',
    province_id: props.city.province_id ?? '',
    county_id: props.city.county_id ?? '',
});

function submit() {
    form.put(`/admin/cities/${props.city.id}`);
}
</script>

<template>
    <Head title="ویرایش شهر" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">ویرایش شهر</h1>
            <Link href="/admin/cities" class="rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-700">بازگشت</Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">نام شهر</label>
                    <input v-model="form.name" type="text" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">شناسه استان</label>
                    <input v-model="form.province_id" type="number" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">شناسه شهرستان</label>
                    <input v-model="form.county_id" type="number" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white" :disabled="form.processing">
                    بروزرسانی شهر
                </button>
            </div>
        </form>
    </div>
</template>
