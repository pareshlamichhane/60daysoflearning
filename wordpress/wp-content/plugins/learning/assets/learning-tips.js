document.addEventListener("DOMContentLoaded", function () {
    if (typeof LearningTips !== 'undefined') {
        const tips = LearningTips.tips;
        const randomTip = tips[Math.floor(Math.random() * tips.length)];
        const box = document.createElement('div');
        box.style.border = "1px solid #2271b1";
        box.style.padding = "12px";
        box.style.marginTop = "20px";
        box.style.backgroundColor = "#f0f8ff";
        box.style.borderRadius = "8px";
        box.innerHTML = "<strong>Learning Tip of the Day:</strong><br>" + randomTip;

        const container = document.querySelector('.wrap h1');
        if (container) container.parentNode.insertBefore(box, container.nextSibling);
    }
});
