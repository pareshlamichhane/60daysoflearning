document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('learning-log-form');
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = {
            action: 'log_learning_entry',
            day: formData.get('day'),
            summary: formData.get('summary'),
            nonce: LearningAjax.nonce 
        };

        const response = await fetch(LearningAjax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(data)
        });

        const result = await response.json();
        document.getElementById('form-status').textContent = result.success
            ? '✅ Logged successfully!'
            : '❌ Error logging.';
    });
});
