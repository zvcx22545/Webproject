document.querySelectorAll('.toggle-icon').forEach(function(icon) {
    icon.addEventListener('click', function() {
        var targetId = this.getAttribute('data-target');
        var targetInput = document.getElementById(targetId);
        if (targetInput.type === 'password') {
            targetInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            targetInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});