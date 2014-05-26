        <?php Debug::showAll(); ?>

        <!-- load jQuery lib -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <!-- load all js scripts -->
        <?php foreach(Plugins::loadPluginsJSFiles() as $value) echo $value; ?>
    </body>
</html>