   <!--   Core JS Files   -->
   <script src="../../../../assets/js/core/jquery-3.7.1.min.js"></script>
   <script src="../../../../assets/js/core/popper.min.js"></script>
   <script src="../../../../assets/js/core/bootstrap.min.js"></script>

   <!-- jQuery Scrollbar -->
   <script src="../../../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

   <!-- Chart JS -->
   <script src="../../../../assets/js/plugin/chart.js/chart.min.js"></script>

   <!-- jQuery Sparkline -->
   <script src="../../../../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

   <!-- Chart Circle -->
   <script src="../../../../assets/js/plugin/chart-circle/circles.min.js"></script>

   <!-- Datatables -->
   <script src="../../../../assets/js/plugin/datatables/datatables.min.js"></script>

   <!-- Bootstrap Notify -->
   <script src="../../../../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

   <!-- jQuery Vector Maps -->
   <script src="../../../../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
   <script src="../../../../assets/js/plugin/jsvectormap/world.js"></script>

   <!-- Sweet Alert -->
   <script src="../../../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

   <script>
    (function() {
        const overlay = document.getElementById('loading-overlay');
        
        function showLoadingOverlay() {
            document.body.classList.add('loading');
            overlay.style.display = 'flex';
            overlay.classList.remove('hidden');
            
            setTimeout(hideLoadingOverlay, 1000);
        }
    
        function hideLoadingOverlay() {
            overlay.classList.add('hidden');
            
            setTimeout(() => {
                overlay.style.display = 'none';
                document.body.classList.remove('loading');
            }, 300);
        }
    
        showLoadingOverlay();
    
        document.addEventListener('click', (event) => {
            if (event.target.closest('.export-link')) {
                hideLoadingOverlay();
            }
        });
    })();
    </script>