<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
});

const form = useForm({
    title: props.category.title || '',
    order: props.category.order ?? 0,
});

function submit() {
    form.put(`/admin/categories/${props.category.id}`);
}
</script>

<template>
    <Head title="ویرایش دسته‌بندی" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">ویرایش دسته‌بندی</h1>
            <Link href="/admin/categories" class="rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-700">بازگشت</Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">عنوان</label>
                    <input v-model="form.title" type="text" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">ترتیب</label>
                    <input v-model="form.order" type="number" min="0" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white" :disabled="form.processing">
                    بروزرسانی دسته‌بندی
                </button>
            </div>
        </form>
    </div>
</template>
