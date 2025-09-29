import "./bootstrap";

import Alpine from "alpinejs";
import IMask from "imask";

window.Alpine = Alpine;

document.addEventListener("DOMContentLoaded", () => {
    const phoneInputs = document.querySelectorAll('input[data-mask="phone"]');

    phoneInputs.forEach((input) => {
        IMask(input, {
            mask: "+{0}000000000000000",
            lazy: true,
            blocks: {
                0: {
                    mask: IMask.MaskedRange,
                    from: 1,
                    to: 999,
                },
            },
        });
    });
});

Alpine.start();
