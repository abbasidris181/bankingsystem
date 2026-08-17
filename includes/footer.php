<footer class="text-center mt-16 py-6 text-gray-500">

    &copy; <?php echo date('Y'); ?>

    GPT Bank PLC.

    All Rights Reserved.

</footer>
        <?php if (isset($_SESSION["success"])): ?>

        <script>

            iziToast.success({

                title: "Success",

                message:
                    <?= json_encode($_SESSION["success"]) ?>,

                position: "topRight",

                timeout: 4000

            });

        </script>

        <?php

        unset($_SESSION["success"]);

        endif;

        ?>
</body>

</html>