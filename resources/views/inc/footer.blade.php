        </div><!-- bodycontainer -->
        
        <!-- Footer -->
        <div id="footer">
            <!-- Copyright -->
            <ul class="copyright">
                <li>Todos los derechos reservados. &copy; 2021. </li>
            </ul>

        </div>

        <!-- Scripts -->
        <!-- ALL JS FILES -->
        <script src="{{ asset('js/all.js') }}"></script>
        <!--<script src="js/all.js"></script>-->
        <!-- ALL PLUGINS -->
        <script src="{{ asset('js/custom.js') }}"></script>
        <!--<script src="js/custom.js"></script>-->
        <script src="{{ asset('js/timeline.min.js') }}"></script>
        <!--<script src="js/timeline.min.js"></script>-->
        
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery.scrolly.min.js') }}"></script>
        <script src="{{ asset('js/jquery.scrollex.min.js') }}"></script>
        <script src="{{ asset('js/browser.min.js') }}"></script>
        <script src="{{ asset('js/breakpoints.min.js') }}"></script>
        <script src="{{ asset('js/util.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>


        <script>
            timeline(document.querySelectorAll('.timeline'), {
                forceVerticalMode: 700,
                mode: 'horizontal',
                verticalStartPosition: 'left',
                visibleItems: 4
            });
        </script>
    </body>
</html>
