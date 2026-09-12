<script>
document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('.gs-portal');
    if (!root) return;
    const sidebar = root.querySelector('.gs-sidebar');
    const overlay = root.querySelector('[data-portal-overlay]');
    const toggle = root.querySelector('[data-sidebar-open]');
    const mobile = window.matchMedia('(max-width: 1023px)');
    const setSidebar = (open, restore = false) => {
        sidebar?.classList.toggle('is-open', open);
        overlay?.classList.toggle('is-open', open);
        toggle?.setAttribute('aria-expanded', String(open));
        if (sidebar) sidebar.inert = mobile.matches && !open;
        if (open) sidebar?.querySelector('button, a')?.focus();
        else if (restore) toggle?.focus();
    };
    setSidebar(false);
    toggle?.addEventListener('click', () => setSidebar(true));
    root.querySelector('[data-sidebar-close]')?.addEventListener('click', () => setSidebar(false, true));
    overlay?.addEventListener('click', () => setSidebar(false, true));
    mobile.addEventListener('change', () => setSidebar(false));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            if (!root.querySelector('dialog[open]') && sidebar?.classList.contains('is-open')) setSidebar(false, true);
            root.querySelectorAll('details[open]').forEach(detail => detail.removeAttribute('open'));
        }
        if (event.key === 'Tab' && mobile.matches && sidebar?.classList.contains('is-open') && !root.querySelector('dialog[open]')) {
            const items = [...sidebar.querySelectorAll('a, button')];
            if (event.shiftKey && document.activeElement === items[0]) { event.preventDefault(); items.at(-1)?.focus(); }
            if (!event.shiftKey && document.activeElement === items.at(-1)) { event.preventDefault(); items[0]?.focus(); }
        }
    });
    root.querySelectorAll('.gs-nav a').forEach(link => link.addEventListener('click', () => setSidebar(false)));
    root.querySelectorAll('[data-open-dialog]').forEach(button => button.addEventListener('click', () => {
        root.querySelectorAll('details[open]').forEach(detail => detail.removeAttribute('open'));
        setSidebar(false);
        document.getElementById(button.dataset.openDialog)?.showModal();
    }));
    root.querySelectorAll('[data-close-dialog]').forEach(button => button.addEventListener('click', () => button.closest('dialog').close()));
    root.querySelectorAll('dialog').forEach(dialog => dialog.addEventListener('click', event => {
        const rect = dialog.getBoundingClientRect();
        if (event.target === dialog && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) dialog.close();
    }));
    root.querySelector('[data-student-search]')?.addEventListener('input', event => {
        const term = event.target.value.trim().toLocaleLowerCase(); let visible = 0;
        root.querySelectorAll('[data-student-row]').forEach(row => { row.hidden = !row.dataset.studentRow.toLocaleLowerCase().includes(term); if (!row.hidden) visible++; });
        const empty = root.querySelector('[data-search-empty]'); if (empty) empty.hidden = visible !== 0;
        const count = root.querySelector('[data-visible-count]'); if (count) count.textContent = String(visible);
    });
    root.querySelectorAll('form[data-loading-label]').forEach(form => form.addEventListener('submit', () => {
        const button = form.querySelector('[data-submit-button]');
        if (button) { button.dataset.originalLabel = button.textContent; button.textContent = form.dataset.loadingLabel; button.disabled = true; }
    }));
    window.addEventListener('pageshow', () => root.querySelectorAll('[data-original-label]').forEach(button => { button.textContent = button.dataset.originalLabel; button.disabled = false; }));
});
</script>
