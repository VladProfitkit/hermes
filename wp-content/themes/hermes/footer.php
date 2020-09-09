            </div>
        </main>

    </div>

    <footer>
        <div id="footer">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 address">
                        <p><b>Адрес:</b><br>
                        <?php echo aw_option('address', true) ?></p>
                    </div>
                    <div class="col-md-3 phone">
                        <p><?php echo aw_phone('span', '') ?>
                        <?php echo aw_option('phone_comment') ?></p>
                    </div>
                    <div class="col-md-6 copy">
                        <h5><?php echo aw_option('name') ?></h5>
                        <p><?php echo aw_option('subname') ?><br>
                        &copy; <?php echo (date('Y') > 2017 ? '2017&ndash;' : '') . date('Y') ?> <?php echo aw_option('copy_text') ?></p>

                        <div class="my-5"><a href="https://awart.ru/" target="_blank">Создание сайта &laquo;Awart&raquo;</a></div>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
