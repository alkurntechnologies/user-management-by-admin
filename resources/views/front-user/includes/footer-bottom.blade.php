    


    </div>
    <script src="{{ asset('/') }}/assets/front-end/js/popper.min.js"></script>
    <script src="{{ asset('/') }}/assets/front-end/js/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}/assets/front-end/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
		jQuery(window).scroll(function () {
		    if (jQuery(window).scrollTop() >= 100) {
		        jQuery('.site-header').addClass('fixed-header');
		    } else {
		        jQuery('.site-header').removeClass('fixed-header');
		    }
		});
        $(document).ready(function () {
            $('select').selectpicker();
        });
       
	</script>

    <script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

	<script src="{{ URL::asset('/assets/admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>



<script type="text/javascript">
	var oneYearFromNow = new Date();
	oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() - 18);
	$('#dob').datepicker({
		endDate: oneYearFromNow
	});
</script>

<script>
    $(document).on('click', '.toggle-password', function(e) {
        e.preventDefault();
        $(this).find('i').toggleClass("fa-eye fa-eye-slash");
        var input = $(this).prev(".password");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>


<!-- <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->

	