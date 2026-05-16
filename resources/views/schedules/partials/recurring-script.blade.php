<script>
    document.addEventListener('DOMContentLoaded', () => {
        const impactMessages = {
            update_future: 'Perubahan akan dipakai untuk meeting yang dibuat setelah tanggal efektif. Meeting yang sudah terjadi tetap tidak berubah.',
            keep_existing: 'Recurring template akan berubah, tetapi meeting yang sudah ter-generate dibiarkan seperti sekarang.',
            delete_future: 'Meeting mendatang yang masih mengikuti recurring schedule ini akan dibersihkan mulai tanggal efektif.'
        };

        const setupRecurringForm = (form) => {
            if (!form) {
                return;
            }

            const frequencySelect = form.querySelector('[data-frequency-select]');
            const weeklyField = form.querySelector('[data-weekly-field]');
            const monthlyField = form.querySelector('[data-monthly-field]');
            const dayOfWeekInput = weeklyField ? weeklyField.querySelector('[name="day_of_week"]') : null;
            const dayOfMonthInput = monthlyField ? monthlyField.querySelector('[name="day_of_month"]') : null;
            const impactSelect = form.querySelector('[data-impact-select]');
            const impactCopy = form.querySelector('[data-impact-copy]');

            const syncFrequencyFields = () => {
                if (!frequencySelect) {
                    return;
                }

                const isWeekly = frequencySelect.value === 'weekly';

                if (weeklyField) {
                    weeklyField.classList.toggle('hidden', !isWeekly);
                }

                if (monthlyField) {
                    monthlyField.classList.toggle('hidden', isWeekly);
                }

                if (dayOfWeekInput) {
                    dayOfWeekInput.required = isWeekly;
                    if (!isWeekly) {
                        dayOfWeekInput.value = '';
                    }
                }

                if (dayOfMonthInput) {
                    dayOfMonthInput.required = !isWeekly;
                    if (isWeekly) {
                        dayOfMonthInput.value = '';
                    } else if (!dayOfMonthInput.value) {
                        dayOfMonthInput.value = 1;
                    }
                }
            };

            const syncImpactCopy = () => {
                if (!impactSelect || !impactCopy) {
                    return;
                }

                impactCopy.textContent = impactMessages[impactSelect.value] || impactMessages.update_future;
            };

            if (frequencySelect) {
                frequencySelect.addEventListener('change', syncFrequencyFields);
                syncFrequencyFields();
            }

            if (impactSelect) {
                impactSelect.addEventListener('change', syncImpactCopy);
                syncImpactCopy();
            }
        };

        document.querySelectorAll('[data-recurring-form]').forEach(setupRecurringForm);

        document.querySelectorAll('[data-schedule-panel-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const panelId = button.dataset.schedulePanelToggle;
                const panel = document.getElementById(panelId);

                if (!panel) {
                    return;
                }

                const willOpen = panel.classList.contains('hidden');
                panel.classList.toggle('hidden', !willOpen);
                button.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });
        });
    });
</script>
