

document.addEventListener("DOMContentLoaded", function () {

    const deleteButtons =
        document.querySelectorAll(".delete-customer");

    deleteButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const form =
                button.closest(".delete-form");

            const customerName =
                button.dataset.name;

            Swal.fire({

                title: "Delete customer?",

                text:
                    `Are you sure you want to delete ${customerName}?`,

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#dc2626",

                cancelButtonColor: "#64748b",

                confirmButtonText: "Yes, delete",

                cancelButtonText: "Cancel"

            }).then(function (result) {

                if (result.isConfirmed) {

                    form.submit();

                }

            });

        });

    });

});