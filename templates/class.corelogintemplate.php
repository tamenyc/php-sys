<?php
class CoreLoginTemplate extends EmptyTemplate{

	public $BodyCSS='gray-gr-bg';
	
	//For base local CSS/JS
	public function HTML_Header_Local_Base(){
	?><!--<?php echo strtoupper( $this->Site->SUBDOMAIN); ?> ASSETS FILES -->
	<script src="<?php echo $this->Settings->_HOST_DIR;?>js/custom/custom.js"></script>
	<link href="<?php echo $this->Settings->_HOST_DIR;?>resources/css/fonts.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<?php echo strtoupper( $this->Site->SUBDOMAIN ); ?> ASSETS FILES END -->
	<?php
	}
	
	public function RenderHTML(){
		//_E_TRACE( 'CoreLoginTemplate.RenderHTML()' );
		global $_COY_NAME;
		$this->HTML_Header_Main();
		//echo '<div class="login-bg-lay fix-pos"></div>';
		//echo '<div class="login-bg fix-pos"></div>';
		//echo '<div class="mask-bg fix-pos"></div>';
		echo '<div class="middle-box text-center loginscreen animated fadeInDown white-bg">'; ?>
		<div>
		<img src='https://summer.tgate.sg/Files/Login%20Logo.jpg' class="LoginLogo"/>
		<h3><?php echo $_COY_NAME; ?></h3>	
		<?php $this->HTML_Content(); ?>
		<a href="#"><small>Forgot password?</small></a>
        <!--<p class="text-muted text-center"><small>Do not have an account?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
		</div>
		<?php
		echo '</div>';
		
	}

	
	
	public function HTML_Header_Main(){
		$this->HTML_LOGICS();
		$this->HTML_DOC();
		$this->HTML_Header();
	}
	
	public function HTML_Footer_Main(){
		$this->HTML_Footer();
	}
}	
?>
