<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import { Link } from '@inertiajs/vue3';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

defineProps({
    news: {
        type: Array,
        required: true,
    },
});

const modules = [Autoplay, Pagination, Navigation];
</script>


<template>
    <div class="relative">
        <swiper
            :modules="modules"
            :slides-per-view="1"
            :space-between="20"
            :loop="true"
            :autoplay="{ delay: 3000, disableOnInteraction: false }"
            :pagination="{ clickable: true }"
            :navigation="true"
            dir="rtl"
            class="news-carousel"
        >
            <swiper-slide v-for="item in news" :key="item.id">
                <div class="relative h-80 overflow-hidden rounded-2xl">
                    <img
                        v-if="item.main_image"
                        :src="item.main_image"
                        :alt="item.title"
                        class="absolute inset-0 h-full w-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-0 right-0 p-6 text-white">
                        <h2 class="text-2xl font-bold mb-2">{{ item.title }}</h2>
                        <Link
                            :href="`/news/${item.slug}`"
                            class="inline-block bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm"
                        >
                            ادامه مطلب
                        </Link>
                    </div>
                </div>
            </swiper-slide>
        </swiper>
    </div>
</template>

<style scoped>
.news-carousel {
    padding-bottom: 40px; /* فضای برای نقاط pagination */
}
.news-carousel .swiper-pagination-bullet {
    background: #fff;
    opacity: 0.7;
}
.news-carousel .swiper-pagination-bullet-active {
    background: #3b82f6;
    opacity: 1;
}
.news-carousel .swiper-button-prev,
.news-carousel .swiper-button-next {
    color: #fff;
}
</style>
