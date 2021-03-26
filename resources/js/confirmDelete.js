/**
 * 
 * @param {HTMLButtonElement} triggerButton 
 * @param {string} confirmText 
 * @param {string} modalId 
 * @param {string} confirmButtonId 
 */
module.exports.confirmDelete = function confirmDelete(
  triggerButton,
  confirmText,
  modalId = '#delete-modal',
  confirmButtonId = '#confirm-delete',
) {
triggerButton.addEventListener('click', (event) => {
  const modaljQuery = $(modalId);
  if (!modaljQuery) {
    console.warn(`Unable to find ${modalId}`);
    return;
  }

  /** @type {HTMLElement} */
  const modal = modaljQuery[0];
  
  /** @type {HTMLButtonElement} */
  const confirmButton = modal.querySelector(confirmButtonId);
  if (!confirmButton) {
    console.warn('Unable to find a #confirm-delete button on modal.')
    return;
  }

  // customise message in modal
  const body = modal.querySelector('.modal-body');
  body.textContent = confirmText;

  // user clicked submit on a form, but prevent that from submitting for now
  event.preventDefault();

  confirmButton.addEventListener('click', () => {
    // clicking on the modal's confirm button will submit the form
    // that user's original button click would have done.
    triggerButton.form.submit();
  })

  // display modal
  modaljQuery.modal();
})
}
