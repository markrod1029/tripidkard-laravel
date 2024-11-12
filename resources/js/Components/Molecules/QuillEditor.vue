<template>
    <div ref="editorContainer" class="editor-container"></div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import Quill from 'quill';
  
  const props = defineProps({
    modelValue: {
      type: String,
      default: ''
    }
  });
  
  const editorContainer = ref(null);
  
  onMounted(() => {
    const editor = new Quill(editorContainer.value, {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'align': [] }],
          ['bold', 'italic', 'underline'],
          ['link'],
          ['image']
        ]
      }
    });
  
    editor.on('text-change', () => {
      props.modelValue = editor.root.innerHTML;  // Updates v-model when text is changed
    });
  
    if (props.modelValue) {
      editor.root.innerHTML = props.modelValue;
    }
  });
  </script>
  
  <style scoped>
  .editor-container {
    min-height: 200px;
    border: 1px solid #ccc;
    padding: 10px;
  }
  </style>
  