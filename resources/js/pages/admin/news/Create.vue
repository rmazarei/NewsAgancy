<script setup>
import RichTextEditor from '@/components/RichTextEditor.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    categories: Array,
    cities: Array,
});

const form = useForm({
    title: '',
    content: '<p></p>',
    published_at: '',
    categories: [],
    cities: [],
    main_image: null,
    gallery: [],
});

const mainPreview = ref('');
const galleryPreviews = ref([]);

function handleMainImage(event) {
    const file = event.target.files?.[0];

    if (! file) {
        return;
    }

    form.main_image = file;
    mainPreview.value = URL.createObjectURL(file);
}

function handleGallery(event) {
    const files = Array.from(event.target.files || []);
    form.gallery = files;
    galleryPreviews.value = files.map((file) => URL.createObjectURL(file));
}

function submit() {
    form.post('/admin/news');
}
</script>

<template>
    <Head title="ثبت خبر جدید" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">ثبت خبر جدید</h1>
            <Link href="/admin/news" class="rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-700">بازگشت</Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm" >
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-700">عنوان</label>
                    <input v-model="form.title" type="text" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">تاریخ انتشار</label>
                    <input v-model="form.published_at" type="datetime-local" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">دسته‌بندی‌ها</label>
                    <select v-model="form.categories" multiple class="h-32 w-full rounded-md border border-slate-300 px-3 py-2">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                    </select>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-700">شهرها</label>
                    <select v-model="form.cities" multiple class="h-32 w-full rounded-md border border-slate-300 px-3 py-2">
                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                    </select>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-700">تصویر اصلی</label>
                    <input type="file" accept="image/*" @change="handleMainImage" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                    <img v-if="mainPreview" :src="mainPreview" alt="preview" class="mt-3 h-40 w-auto rounded-md object-cover" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-700">گالری تصاویر</label>
                    <input type="file" accept="image/*" multiple @change="handleGallery" class="w-full rounded-md border border-slate-300 px-3 py-2" />
                    <div v-if="galleryPreviews.length" class="mt-3 flex flex-wrap gap-3">
                        <img v-for="(preview, index) in galleryPreviews" :key="index" :src="preview" alt="gallery preview" class="h-20 w-20 rounded-md object-cover" />
                    </div>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-700">متن خبر</label>
                    <RichTextEditor v-model="form.content" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" @click="form.reset()" class="rounded-md border border-slate-300 px-4 py-2 text-sm">بازنشانی</button>
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white" :disabled="form.processing">
                    ذخیره خبر
                </button>
            </div>
        </form>
    </div>
</template>
