<template>
    <div class="container my-5 p-3">
      <div class="row">
        <!-- Feature Section -->
        <div class="col-md-6 text-center">
          <img src="/storage/img/FAQs-amico.svg" alt="Feature Image" class="img-fluid rounded">
        </div>

        <!-- FAQ Section -->
        <div class="col-md-6">
          <h2 class="font-weight-bold mb-4">Frequently Asked Questions</h2>
          <div class="accordion" id="faqAccordion">
            <div class="card" v-for="(faq, index) in faqs" :key="index">
              <div class="card-header d-flex justify-content-between align-items-center" @click="toggleFaq(index)">
                <h5 class="mb-0">
                  <button class="btn btn-link text-decoration-none text-dark" type="button">
                    {{ faq.question }}
                  </button>
                </h5>
                <i :class="['fas', 'fa-chevron-down', { 'rotate': faq.open }]" aria-hidden="true" style="margin-left: auto;"></i>
              </div>
              <div :class="['collapse', { 'show': faq.open }]" aria-labelledby="headingOne" data-parent="#faqAccordion">
                <div class="card-body">
                  {{ faq.answer }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { reactive } from 'vue';

  const faqs = reactive([
    { question: 'What is Tripid Kard?', answer: 'Tripid Kard is a loyalty card that allows you to unlock savings at various merchants.', open: false },
    { question: 'How do I join?', answer: 'You can join by signing up on our website and purchasing a Tripid Kard.', open: false },
    { question: 'Where can I use Tripid Kard?', answer: 'Tripid Kard can be used at all participating merchants listed on our website.', open: false },
    { question: 'Where can I use Tripid Kard?', answer: 'Tripid Kard can be used at all participating merchants listed on our website.', open: false },
    { question: 'Where can I use Tripid Kard?', answer: 'Tripid Kard can be used at all participating merchants listed on our website.', open: false },
  ]);

  const toggleFaq = (index) => {
    faqs.forEach((faq, i) => {
      faq.open = i === index ? !faq.open : false;
    });
  };
  </script>

  <style scoped>
  .text-gray {
    color: gray;
  }

  .btn-link {
    text-decoration: none;
    color: #007bff;
  }

  .btn-link:hover {
    text-decoration: underline;
  }

  .img-fluid {
    max-width: 100%;
    height: auto;
  }

  .lead {
    font-size: 1.25rem;
    font-weight: 300;
  }

  .rotate {
    transition: transform 0.3s;
  }

  .rotate {
    transform: rotate(180deg);
  }

  .card-header {
    cursor: pointer;
  }
  </style>
