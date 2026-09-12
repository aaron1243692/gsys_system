(() => {
    const root = document.querySelector('[data-registration]');
    if (!root) return;
    const form = root.querySelector('[data-registration-form]');
    const panels = [...root.querySelectorAll('[data-step]')];
    const indicators = [...root.querySelectorAll('[data-step-indicator]')];
    const back = root.querySelector('[data-back]');
    const next = root.querySelector('[data-next]');
    const actions = root.querySelector('[data-step-actions]');
    const error = root.querySelector('[data-form-error]');
    let step = 1;

    const fieldsForStep = () => [...root.querySelector(`[data-step="${step}"]`).querySelectorAll('input, select')];
    const render = () => {
        panels.forEach(panel => { panel.hidden = Number(panel.dataset.step) !== step; });
        indicators.forEach(indicator => indicator.toggleAttribute('aria-current', Number(indicator.dataset.stepIndicator) === step));
        back.hidden = step === 1;
        next.textContent = step === panels.length ? (root.dataset.portal === 'student' ? 'Register' : 'Create Account') : 'Continue';
        error.textContent = '';
        root.querySelector(`[data-step="${step}"] input, [data-step="${step}"] select`)?.focus();
    };
    const valid = () => {
        for (const field of fieldsForStep()) if (!field.reportValidity()) return false;
        const password = form.elements.password;
        const confirmation = form.elements.password_confirmation;
        if (password && confirmation && step === Number(password.closest('[data-step]').dataset.step) && password.value !== confirmation.value) {
            confirmation.setCustomValidity('Passwords do not match.');
            confirmation.reportValidity();
            error.textContent = 'Passwords do not match.';
            return false;
        }
        return true;
    };
    next.addEventListener('click', () => {
        if (!valid()) return;
        if (root.dataset.portal === 'student' && step === panels.length - 1) {
            const middle = form.elements.middle_name.value.trim();
            const suffix = form.elements.suffix.value.trim();
            const values = {
                name: [form.elements.first_name.value.trim(), middle, form.elements.last_name.value.trim(), suffix].filter(Boolean).join(' '),
                birthdate: form.elements.birthdate.value,
                sex: form.elements.sex.value,
                address: form.elements.address.value.trim() || 'Not provided',
                grade_level: form.elements.grade_level.value,
                school_year: form.elements.school_year.value,
                email: form.elements.email.value,
                username: form.elements.username.value,
            };
            root.querySelectorAll('[data-review-value]').forEach(node => { node.textContent = values[node.dataset.reviewValue] || '—'; });
        }
        if (step < panels.length) { step++; render(); return; }
        panels.forEach(panel => { panel.hidden = true; });
        indicators.forEach(indicator => indicator.removeAttribute('aria-current'));
        actions.hidden = true;
        error.textContent = '';
        root.querySelector('[data-success]').hidden = false;
        root.querySelector('[data-success]').focus();
    });
    back.addEventListener('click', () => { if (step > 1) { step--; render(); } });
    form.addEventListener('submit', event => event.preventDefault());
    form.elements.password_confirmation?.addEventListener('input', event => event.target.setCustomValidity(''));
    root.querySelectorAll('[data-password-toggle]').forEach(button => button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('input');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.textContent = show ? 'Hide' : 'Show';
        button.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    }));
    render();
})();
