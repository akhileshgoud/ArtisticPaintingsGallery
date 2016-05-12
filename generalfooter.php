<script>
	$(function(){
	 
		$(document).on( 'scroll', function(){
	 
			if ($(window).scrollTop() > 100) {
				$('.scroll-up').addClass('show');
			} else {
				$('.scroll-up').removeClass('show');
			}
		});
	});
</script>

<div class="scroll-up">
	<a href="#top-anchor"><span class="glyphicon glyphicon-chevron-up" style="padding-top:20%;"></span></a>
</div>

<div id="myFooter" class="row">
    <div class="col-md-12">
        <footer class="text-center">
            <strong><a href="http://www.akhileshgoud.me" target="blank" id="footer-link">Developed by Akhilesh Goud!</a></strong>
		</footer>
    </div>
</div>