document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('learning-log-form');
    const status = document.getElementById('form-status');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        formData.append('action', 'log_learning_entry');
        formData.append('nonce', LearningAjax.nonce);

        const res = await fetch(LearningAjax.ajax_url, {
            method: 'POST',
            body: formData
        });

        const result = await res.json();
        if (result.success) {
            status.textContent = '✅ ' + result.data;
            form.reset();
        } else {
            status.textContent = '❌ ' + result.data;
        }
    });
});
