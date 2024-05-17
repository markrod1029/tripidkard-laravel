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
    { question: 'What is Tripidkard?', answer: 'ripidkard is an online platform that offers exclusive deals, discounts, and promotions for various merchants and services, ranging from dining, travel, leisure, and more', open: false },
    { question: 'How does Tripidkard work?', answer: 'Tripidkard provides users with access to exclusive discounts and deals by purchasing a membership subscription. Once subscribed, users can explore and redeem offers from a wide range of merchants listed on the platform.', open: false },
    { question: 'How can I become a member of Tripidkard?', answer: 'To become a Tripidkard member, simply visit our website and sign up for a membership subscription. Choose from our available subscription plans and follow the steps to complete the registration process.', open: false },
    { question: 'What types of merchants are available on Tripidkard?', answer: 'Tripidkard features a diverse selection of merchants, including restaurants, cafes, hotels, travel agencies, spas, fitness centers, entertainment venues, and more. We partner with various businesses to offer exclusive discounts and deals to our members.', open: false },
    { question: 'Can I use Tripidkard internationally?', answer: 'While Tripidkard primarily focuses on deals and discounts within the Philippines, some offers may be applicable internationally. Make sure to check the details of each offer for any restrictions or limitations.', open: false },
    { question: 'How often are new offers added to Tripidkard?', answer: 'New offers and deals are added to Tripidkard regularly, providing members with fresh discounts and promotions to explore. Keep an eye on our platform for the latest updates and additions.', open: false },


    { question: 'How can I contact Tripidkard for support or inquiries?', answer: 'For any questions, concerns, or inquiries regarding Tripidkard, you can reach out to our customer support team through the contact information provided on our website. We are here to assist you with any assistance you may need.', open: false },
    { question: 'Is my personal information secure with Tripidkard?', answer: 'Yes, Tripidkard values the privacy and security of its members personal information. We implement robust security measures to safeguard your data and ensure a safe and secure online experience.', open: false },
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
