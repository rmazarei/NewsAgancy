<script setup>
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import { computed, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'متن خبر را وارد کنید...',
    },
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    content: props.modelValue || '<p></p>',
    extensions: [
        StarterKit,
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                rel: 'noopener noreferrer nofollow',
                target: '_blank',
            },
        }),
        Image.configure({
            inline: false,
        }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm max-w-none min-h-[220px] rounded-md border border-slate-300 bg-white p-4 text-right focus:outline-none rtl',
        },
    },
    onUpdate({ editor }) {
        emit('update:modelValue', editor.getHTML());
    },
});

const isActive = computed(() => editor.value?.isActive('bold'));

watch(
    () => props.modelValue,
    (value) => {
        if (! editor.value) {
            return;
        }

        const editorHtml = editor.value.getHTML();

        if (value !== editorHtml) {
            editor.value.commands.setContent(value || '<p></p>', false);
        }
    },
);

function toggleBold() {
    editor.value?.chain().focus().toggleBold().run();
}

function toggleItalic() {
    editor.value?.chain().focus().toggleItalic().run();
}

function toggleBulletList() {
    editor.value?.chain().focus().toggleBulletList().run();
}

function toggleOrderedList() {
    editor.value?.chain().focus().toggleOrderedList().run();
}

function setLink() {
    const url = window.prompt('آدرس لینک را وارد کنید:');

    if (! url) {
        return;
    }

    editor.value?.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
}

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div class="overflow-hidden rounded-lg border border-slate-300 bg-white">
        <div class="flex flex-wrap gap-2 border-b border-slate-200 bg-slate-50 p-2">
            <button type="button" class="rounded border px-2 py-1 text-sm" @click="toggleBold">بولد</button>
            <button type="button" class="rounded border px-2 py-1 text-sm" @click="toggleItalic">ایتالیک</button>
            <button type="button" class="rounded border px-2 py-1 text-sm" @click="toggleBulletList">لیست</button>
            <button type="button" class="rounded border px-2 py-1 text-sm" @click="toggleOrderedList">شماره‌دار</button>
            <button type="button" class="rounded border px-2 py-1 text-sm" @click="setLink">لینک</button>
        </div>
        <EditorContent :editor="editor" class="rtl" />
    </div>
</template>
