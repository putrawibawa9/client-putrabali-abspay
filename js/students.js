        document.querySelectorAll('[data-modal-toggle="edit-user-modal"]').forEach(button => {
    button.addEventListener('click', () => {
        // Get modal and form elements
        const modal = document.getElementById('edit-user-modal');
        const form = modal.querySelector('form');

         // Retrieve student ID and populate the form's action URL
        const studentId = button.dataset.id;
        form.action = `/students/${studentId}`;

        // Populate modal fields
        form.querySelector('#name').value = button.dataset.name || '';
        form.querySelector('#wa_number').value = button.dataset.wa_number || '';
        form.querySelector('#gender').value = button.dataset.gender || '';
        form.querySelector('#school').value = button.dataset.school || '';
        form.querySelector('#enroll_date').value = button.dataset.enroll_date || '';
        applyHeardFromValue(form, button.dataset.heard_from || '');

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
});

function setupHeardFromField(form) {
    const select = form.querySelector('[data-heard-from-select]');
    const otherWrap = form.querySelector('[data-heard-from-other-wrap]');
    const otherInput = form.querySelector('[data-heard-from-other]');

    if (!select || !otherWrap || !otherInput) {
        return;
    }

    const syncValue = () => {
        const isOther = select.value === 'Lainnya';
        otherWrap.classList.toggle('hidden', !isOther);
        otherInput.required = isOther;

        if (!isOther) {
            otherInput.value = '';
        }
    };

    select.addEventListener('change', syncValue);
    syncValue();
}

function applyHeardFromValue(form, value) {
    const select = form.querySelector('[data-heard-from-select]');
    const otherWrap = form.querySelector('[data-heard-from-other-wrap]');
    const otherInput = form.querySelector('[data-heard-from-other]');

    if (!select || !otherWrap || !otherInput) {
        return;
    }

    const normalizedValue = (value || '').trim();
    const knownOptions = Array.from(select.options).map((option) => option.value);

    if (normalizedValue && knownOptions.includes(normalizedValue)) {
        select.value = normalizedValue;
        otherInput.value = '';
        otherWrap.classList.add('hidden');
    } else if (normalizedValue) {
        select.value = 'Lainnya';
        otherInput.value = normalizedValue;
        otherWrap.classList.remove('hidden');
    } else {
        select.value = '';
        otherInput.value = '';
        otherWrap.classList.add('hidden');
    }

    otherInput.required = select.value === 'Lainnya';
}

document.querySelectorAll('#edit-user-modal form, #add-user-modal form').forEach((form) => {
    setupHeardFromField(form);
});

// Close modal
document.querySelectorAll('[data-modal-close]').forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.fixed');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
});
