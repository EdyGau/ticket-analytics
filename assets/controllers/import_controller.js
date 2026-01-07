import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["results"];

    async submit(event) {
        event.preventDefault();
        const form = event.currentTarget;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button');

        submitBtn.disabled = true;
        submitBtn.innerHTML = "Processing...";

        try {
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.ok) {
                this.resultsTarget.innerHTML = await response.text();
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = "Execute Analysis";
        }
    }
}