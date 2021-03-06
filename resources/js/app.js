
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { confirmDelete } = require('./confirmDelete');

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

/*
 * Handle custom deletion confirmation modal. 
 */
require('./confirmDelete');

(function prepareConfirmDelete() {
  const deleteButtons = document.querySelectorAll('.delete');
  if (!deleteButtons) {
    // cannot proceed without buttons to trigger deletion
    return;
  }

  if (!document.querySelector('#delete-modal')) {
    // cannot proceed without a #delete-modal available on the page
    return;
  }

  deleteButtons.forEach(button => {
    const name = button.getAttribute('data-name');
    if (name === null || name === '') {
      return;
    }

    confirmDelete(button, `Are you sure you want to delete ${name}?`);
  });
}) ();
