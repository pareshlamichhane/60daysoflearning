jQuery(document).ready(function($) {
    $('#learning-log-form').on('submit', function(e) {
        e.preventDefault();
        const data = {
            action: 'log_learning_entry',
            day: $(this).find('[name="day"]').val(),
            summary: $(this).find('[name="summary"]').val(),
            nonce: $(this).find('[name="nonce"]').val()
        };

        $.post(LearningAjax.ajax_url, data, function(response) {
            $('#learning-log-response').html('<p>' + response.data + '</p>');
        });
    });
});
