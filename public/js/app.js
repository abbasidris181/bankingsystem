

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


const accountType =
    document.getElementById("account_type");

const interestSection =
    document.getElementById("interest-section");

const overdraftSection =
    document.getElementById("overdraft-section");


if (accountType) {

    accountType.addEventListener(
        "change",
        function () {

            interestSection.classList.add("hidden");
            overdraftSection.classList.add("hidden");


            if (accountType.value === "savings") {

                interestSection.classList.remove("hidden");

            }


            if (accountType.value === "current") {

                overdraftSection.classList.remove("hidden");

            }

        }
    );

}