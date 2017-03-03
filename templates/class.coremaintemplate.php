<?php
class CoreMainTemplate extends EmptyTemplate{


	/*public function __construct($PageTitle, HTMLFORM $HTMLFORM, Settings $Settings, Database $Database){
		$this->PageTitle=$PageTitle;
		$this->HTMLFORM=$HTMLFORM;
		$this->Settings=$Settings;
		$this->Database=$Database;		
	}*/
	
	//For base local CSS/JS
	public function HTML_Header_Local_Base(){
	?><!--<?php echo strtoupper( $this->Site->SUBDOMAIN); ?> ASSETS FILES -->
	<script src="<?php echo $this->Settings->_HOST_DIR;?>js/custom/custom.js"></script>
	<link href="<?php echo $this->Settings->_HOST_DIR;?>resources/css/fonts.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<?php echo strtoupper( $this->Site->SUBDOMAIN ); ?> ASSETS FILES END -->
	<?php
	}
	
	public function RenderHTML(){
		$this->HTML_Header_Main();
		echo '<div id="wrapper">';
		$this->Nav();
		$this->Content();
		echo '</div>';
		$this->HTML_Footer_Main();
	}
	
	public function PageHeader(){
		?>
		<div class="row border-bottom">	
            <nav class="navbar navbar-static-top" role="navigation"  style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post" action="#">
                        <div class="form-group">
                            <!--<input placeholder="Search for something..." class="form-control" name="top-search" id="top-search" type="text">-->
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="<?php echo $this->Site->_GET_URL( '', 'Logout'); ?>">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
		</div>
		<?php 

		$this->BreadCrumb();
	}
	
	public function BreadCrumb( $Category='' ){	
		$BreadCrumb_Arr = $this->Site->BreadCrumb_Arr(); 
		//print_r( $BreadCrumb_Arr );
		if( trim($Category)=='' ) $Category = $this->Site->_GET_CATEGORY();
		$this->BreadCrumbHTML( $Category , $BreadCrumb_Arr );
	}
	
	public function BreadCrumbHTML( $Category='', $BreadCrumb_Arr='' ){ ?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $Category; ?></h2>
			<?php 

				$config['ListArray'] = $BreadCrumb_Arr; //array containing the data $ListArray[ KeyIndex ] = content....
				$config['ParentCSS'] = 'breadcrumb';
				$config['ChildCSS'] = '';
				$config['Parent'] ='ol'; //Parent HTML tag EG Ul, OL
				$config['Child'] = 'li'; //Chidl HMTL tag EG li
				$config['Level'] = 1; //Current level in nested array
				$config['MaxLevel'] = 1; //Max level drill down in nested array
				$config['ID'] = ''; // HTML ID attribute
				$config['StartTier'] = false ; // To differentiate top level in nested array
				$config['ContentMethod'] = 'Bs_Breadcrumb_li_V0'; //Content method class to call
				$config['ActiveIndex'] = array($this->Site->CURRCID); //Array of active index(s) 
				
				$this->Print_HTML_List_Main( $config );
			?>
		</div>
		<div class="col-lg-2"></div>
	</div>
	<?php
	}
	//Inspina Bootstrap Breadcrumb li content
	public function Bs_Breadcrumb_li_V0( $data , $index ){
		//echo $data['Link'];
		if(isset($this->Site->CATEGORY_DEF[$index]['Target'])) $target = ' target="'.$this->Site->CATEGORY_DEF[$index]['Target'].'"';
		echo '<a href="'.$data['Link'].$target.'">'.$data['Category'].'</a>';
	}
	
	public function Nav(){
	?>
 <nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
							<span><img alt="image" class="coy-logo" src="https://summer.tgate.sg/Files/Login%20Logo.jpg" /></span>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="clear"> 
									<?php if(isset($_SESSION['Username']) && isset($_SESSION['Login']) ){?>
									<span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION['Name'];?></strong></span>
									<span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
									<?php } ?>
								</span>
							</a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="<?php echo $this->Site->_GET_URL( '', 'Logout'); ?>">Logout</a></li>
                            </ul>
                    </div>
                    <div class="logo-element"><img alt="image" class="" src="https://summer.tgate.sg/Files/Login%20Logo.jpg" /></div>
                </li>
            </ul>
			<?php $this->PageNav(); ?>	
        </div>
</nav>   
	
    	
<?php
	//$this->SideNav();
	?>

	<?php
	}
	
	public function SideNav(){
	
	}
	
	
	public function Content(){
	?>
    
<div class="gray-bg" id="page-wrapper">
	<?php 
	$this->PageHeader(); 
	$this->HTML_Content();
	$this->Footer();
	?>
</div>
	<?php 
	}
	
	
	public function PageNav(){
		$Tier=1;
		$ChildCIDs = $this->Site->_GET_CATEGORY_CHILDREN($Tier);
		
		//Print main naviagation
		$this->Navigation_Parent($ChildCIDs, "nav metismenu" ,'',  'ul', 'li', $Level=1, $MaxLevel=30 , 'side-menu',$StartTier=true); ?>
	
    <nav class="subpage-nav">
        
        <ul class="subpage-links">
        	<?php if(!isset($_SESSION['Username']) && !isset($_SESSION['Login']) ){?>			
            <li class="<?php echo $this->Site->_iscurrpage_css('/client/','active'); ?>"><a href="/client/">Login</a></li>
            <li class="<?php echo $this->Site->_iscurrpage_css('/client/new-account/','active'); ?>"><a href="/client/new-account/">Create Account</a></li>
			<li class="<?php echo $this->Site->_iscurrpage_css('/client/forgot-password/','active'); ?>"><a href="/client/forgot-password/">Forgot Password</a></li>
			<?php } else {
			
			//$this->Navigation_Child($ChildCIDs);	
			}?>
        </ul>
    </nav>
    <?php
	}
	
	
	public function PageNavContent(){
		$Tier=2;
		$ChildCIDs = $this->Site->_GET_CATEGORY_CHILDREN($Tier);	
		
		$this->Navigation_Parent($ChildCIDs,'pageNav','','ul','li');
	}
	
	
	public function Footer(){
		global $_COY_NAME;
	?>
   <!-- 
<footer id="footer">
	<div class="footer">
        <div class="pull-right"><strong>Copyright</strong> <?php echo $_COY_NAME; ?> &copy; </div>
  </div>
</footer>-->
<div id="back-to-top" style="display: block;">
	<a href="#"><i class="fa fa-angle-up"></i></a>
</div>
	<?php
	}
	//Standard form print
	public function HTML_Content(){
		
		$this->_BUILD_GRID();			
	}
	
	public function _FORM_RENDERFORM_CORE( $FSID ){
		
		//ob_start();
		$this->_FORM_RENDERFORM_BOOTSTRAP( $FSID );
		//$content = ob_get_contents();
		//ob_end_clean();
		

		if( $this->DoModal($FSID) ){			
			//$this->MODAL($FSID, $content);
		} else {
			//print_r($content);
		}
	}
	
	public function _FORM_RENDERFORM_BOOTSTRAP( $FSID ){

		if(isset($this->Datalogic->FS[ $FSID ])){
			
			//	if(isset( $this->HTMLFORM->FS_LAYOUT['_main']['_width'] )) $width = $this->HTMLFORM->FS_LAYOUT['_main']['_width'];
				
			//	echo '<div class="wrapper wrapper-content animated fadeInRight">';
				//echo '<div class="row">';			
				//echo '<div class="'.$width.'">';	
				
				echo '<div class="ibox">';
				echo '<div class="ibox-title">';
				if(isset( $this->HTMLFORM->FS_LAYOUT[ $FSID ]['_display_title'] )) {
					if( !empty($this->HTMLFORM->FS_LAYOUT[ $FSID ]['_display_title'])) echo '<h5>'.$this->HTMLFORM->FS_LAYOUT[ $FSID ]['_display_title'].'</h5>';
				}				
				echo '</div>';
				echo '<div class="ibox-content">';

				$this->HTMLFORM->_RENDER_FILTERFORM( $FSID );	

				echo '<div class="clients-list">';
				$this->HTMLFORM->_FORM_RENDERFORM( $FSID );	
				$this->HTMLFORM->_FORM_CONSTANT( $FSID );
				echo '</div>';
				echo '</div>';
				echo '</div>';
				//echo '</div>';
				//echo '</div>';	

		}
	}
	public function DoModal ( $FSID ){
		//Determine if print modal
		$$DoModal = false;
		if( isset( $this->HTMLFORM->FS_LAYOUT[$FSID]['_modal'] ) ){
			$DoModal = $this->HTMLFORM->FS_LAYOUT[$FSID]['_modal']===true ? true: false ;
		}	
		return $DoModal;
	}
	public function MODAL( $FSID, $Content ){
		$FSID_P = str_replace('.','_',$FSID);
		?>
		<div id="Modal_<?php echo $FSID_P; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><!--Modal Header--></h4>
		</div>
		<div class="modal-body">
		<?php echo $Content; ?>
		</div>
		<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
		</div>
		</div>
		</div>
		</div>
		<?php
	}
	public function STANDARD_CLIENT_LIST(){
	?>
<div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-8">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h2>Clients</h2>
                            <div class="input-group">
                                <input type="text" placeholder="Search client " class="input form-control">
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Search</button>
                                </span>
                            </div>
                            <div class="clients-list">
                            <div class="nav nav-tabs">
                                <span class="pull-right small text-muted">1406 Elements</span>
                            </div>
                            
								<div class="tab-pane active" id="tab-1">
                                    <!--<div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td>
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link">Anthony Jackson</a></td>
                                                    <td> Tellus Institute</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> gravida@rbisit.com</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><img alt="image" src="img/a3.jpg"> </td>
                                                    <td><a data-toggle="tab" href="#contact-2" class="client-link">Rooney Lindsay</a></td>
                                                    <td>Proin Limited</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> rooney@proin.com</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><img alt="image" src="img/a4.jpg"> </td>
                                                    <td><a data-toggle="tab" href="#contact-3" class="client-link">Lionel Mcmillan</a></td>
                                                    <td>Et Industries</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +432 955 908</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a5.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-4" class="client-link">Edan Randall</a></td>
                                                    <td>Integer Sem Corp.</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +422 600 213</td>
                                                    <td class="client-status"><span class="label label-warning">Waiting</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a6.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-2" class="client-link">Jasper Carson</a></td>
                                                    <td>Mone Industries</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +400 468 921</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a7.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-3" class="client-link">Reuben Pacheco</a></td>
                                                    <td>Magna Associates</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> pacheco@manga.com</td>
                                                    <td class="client-status"><span class="label label-info">Phoned</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a1.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link">Simon Carson</a></td>
                                                    <td>Erat Corp.</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> Simon@erta.com</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a3.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-2" class="client-link">Rooney Lindsay</a></td>
                                                    <td>Proin Limited</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> rooney@proin.com</td>
                                                    <td class="client-status"><span class="label label-warning">Waiting</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a4.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-3" class="client-link">Lionel Mcmillan</a></td>
                                                    <td>Et Industries</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +432 955 908</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a5.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-4" class="client-link">Edan Randall</a></td>
                                                    <td>Integer Sem Corp.</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +422 600 213</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a2.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link">Anthony Jackson</a></td>
                                                    <td> Tellus Institute</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> gravida@rbisit.com</td>
                                                    <td class="client-status"><span class="label label-danger">Deleted</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a7.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-2" class="client-link">Reuben Pacheco</a></td>
                                                    <td>Magna Associates</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> pacheco@manga.com</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a5.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-3"class="client-link">Edan Randall</a></td>
                                                    <td>Integer Sem Corp.</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +422 600 213</td>
                                                    <td class="client-status"><span class="label label-info">Phoned</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a6.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-4" class="client-link">Jasper Carson</a></td>
                                                    <td>Mone Industries</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +400 468 921</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a7.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-2" class="client-link">Reuben Pacheco</a></td>
                                                    <td>Magna Associates</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> pacheco@manga.com</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a1.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link">Simon Carson</a></td>
                                                    <td>Erat Corp.</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> Simon@erta.com</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a3.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-3" class="client-link">Rooney Lindsay</a></td>
                                                    <td>Proin Limited</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> rooney@proin.com</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a4.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-4" class="client-link">Lionel Mcmillan</a></td>
                                                    <td>Et Industries</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +432 955 908</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a5.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-1" class="client-link">Edan Randall</a></td>
                                                    <td>Integer Sem Corp.</td>
                                                    <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                    <td> +422 600 213</td>
                                                    <td class="client-status"><span class="label label-info">Phoned</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a2.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-2" class="client-link">Anthony Jackson</a></td>
                                                    <td> Tellus Institute</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> gravida@rbisit.com</td>
                                                    <td class="client-status"><span class="label label-warning">Waiting</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="client-avatar"><a href=""><img alt="image" src="img/a7.jpg"></a> </td>
                                                    <td><a data-toggle="tab" href="#contact-4" class="client-link">Reuben Pacheco</a></td>
                                                    <td>Magna Associates</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> pacheco@manga.com</td>
                                                    <td class="client-status"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>-->
                               </div>
                            

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="ibox ">

                        <div class="ibox-content">
                            <div class="tab-content">
                                <div id="contact-1" class="tab-pane active">
                                    <div class="row m-b-lg">
                                        <div class="col-lg-4 text-center">
                                            <h2>Nicki Smith</h2>

                                            <div class="m-b-sm">
                                                <img alt="image" class="img-circle" src="img/a2.jpg"
                                                     style="width: 62px">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <strong>
                                                About me
                                            </strong>

                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua.
                                            </p>
                                            <button type="button" class="btn btn-primary btn-sm btn-block"><i
                                                    class="fa fa-envelope"></i> Send Message
                                            </button>
                                        </div>
                                    </div>
                                    <div class="client-detail">
                                    <div class="full-height-scroll">

                                        <strong>Last activity</strong>

                                        <ul class="list-group clear-list">
                                            <li class="list-group-item fist-item">
                                                <span class="pull-right"> 09:00 pm </span>
                                                Please contact me
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> 10:16 am </span>
                                                Sign a contract
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> 08:22 pm </span>
                                                Open new shop
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> 11:06 pm </span>
                                                Call back to Sylvia
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> 12:00 am </span>
                                                Write a letter to Sandra
                                            </li>
                                        </ul>
                                        <strong>Notes</strong>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.
                                        </p>
                                        <hr/>
                                        <strong>Timeline activity</strong>
                                        <div id="vertical-timeline" class="vertical-container dark-timeline">
                                            <div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon gray-bg">
                                                    <i class="fa fa-coffee"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <p>Conference on the sales results for the previous year.
                                                    </p>
                                                    <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon gray-bg">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <p>Many desktop publishing packages and web page editors now use Lorem.
                                                    </p>
                                                    <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon gray-bg">
                                                    <i class="fa fa-bolt"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <p>There are many variations of passages of Lorem Ipsum available.
                                                    </p>
                                                    <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon navy-bg">
                                                    <i class="fa fa-warning"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <p>The generated Lorem Ipsum is therefore.
                                                    </p>
                                                    <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon gray-bg">
                                                    <i class="fa fa-coffee"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <p>Conference on the sales results for the previous year.
                                                    </p>
                                                    <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon gray-bg">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <p>Many desktop publishing packages and web page editors now use Lorem.
                                                    </p>
                                                    <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div id="contact-2" class="tab-pane">
                                    <div class="row m-b-lg">
                                        <div class="col-lg-4 text-center">
                                            <h2>Edan Randall</h2>

                                            <div class="m-b-sm">
                                                <img alt="image" class="img-circle" src="img/a3.jpg"
                                                     style="width: 62px">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <strong>
                                                About me
                                            </strong>

                                            <p>
                                                Many desktop publishing packages and web page editors now use Lorem Ipsum as their default tempor incididunt model text.
                                            </p>
                                            <button type="button" class="btn btn-primary btn-sm btn-block"><i
                                                    class="fa fa-envelope"></i> Send Message
                                            </button>
                                        </div>
                                    </div>
                                    <div class="client-detail">
                                        <div class="full-height-scroll">

                                            <strong>Last activity</strong>

                                            <ul class="list-group clear-list">
                                                <li class="list-group-item fist-item">
                                                    <span class="pull-right"> 09:00 pm </span>
                                                    Lorem Ipsum available
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 10:16 am </span>
                                                    Latin words, combined
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 08:22 pm </span>
                                                    Open new shop
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 11:06 pm </span>
                                                    The generated Lorem Ipsum
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 12:00 am </span>
                                                    Content here, content here
                                                </li>
                                            </ul>
                                            <strong>Notes</strong>
                                            <p>
                                                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.
                                            </p>
                                            <hr/>
                                            <strong>Timeline activity</strong>
                                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon navy-bg">
                                                        <i class="fa fa-warning"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>The generated Lorem Ipsum is therefore.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="contact-3" class="tab-pane">
                                    <div class="row m-b-lg">
                                        <div class="col-lg-4 text-center">
                                            <h2>Jasper Carson</h2>

                                            <div class="m-b-sm">
                                                <img alt="image" class="img-circle" src="img/a4.jpg"
                                                     style="width: 62px">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <strong>
                                                About me
                                            </strong>

                                            <p>
                                                Latin professor at Hampden-Sydney College in Virginia, looked  embarrassing hidden in the middle.
                                            </p>
                                            <button type="button" class="btn btn-primary btn-sm btn-block"><i
                                                    class="fa fa-envelope"></i> Send Message
                                            </button>
                                        </div>
                                    </div>
                                    <div class="client-detail">
                                        <div class="full-height-scroll">

                                            <strong>Last activity</strong>

                                            <ul class="list-group clear-list">
                                                <li class="list-group-item fist-item">
                                                    <span class="pull-right"> 09:00 pm </span>
                                                    Aldus PageMaker including
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 10:16 am </span>
                                                    Finibus Bonorum et Malorum
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 08:22 pm </span>
                                                    Write a letter to Sandra
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 11:06 pm </span>
                                                    Standard chunk of Lorem
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 12:00 am </span>
                                                    Open new shop
                                                </li>
                                            </ul>
                                            <strong>Notes</strong>
                                            <p>
                                                Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.
                                            </p>
                                            <hr/>
                                            <strong>Timeline activity</strong>
                                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon navy-bg">
                                                        <i class="fa fa-warning"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>The generated Lorem Ipsum is therefore.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="contact-4" class="tab-pane">
                                    <div class="row m-b-lg">
                                        <div class="col-lg-4 text-center">
                                            <h2>Reuben Pacheco</h2>

                                            <div class="m-b-sm">
                                                <img alt="image" class="img-circle" src="img/a5.jpg"
                                                     style="width: 62px">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <strong>
                                                About me
                                            </strong>

                                            <p>
                                                Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero,written in 45 BC. This book is a treatise on.
                                            </p>
                                            <button type="button" class="btn btn-primary btn-sm btn-block"><i
                                                    class="fa fa-envelope"></i> Send Message
                                            </button>
                                        </div>
                                    </div>
                                    <div class="client-detail">
                                        <div class="full-height-scroll">

                                            <strong>Last activity</strong>

                                            <ul class="list-group clear-list">
                                                <li class="list-group-item fist-item">
                                                    <span class="pull-right"> 09:00 pm </span>
                                                    The point of using
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 10:16 am </span>
                                                    Lorem Ipsum is that it has
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 08:22 pm </span>
                                                    Text, and a search for 'lorem ipsum'
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 11:06 pm </span>
                                                    Passages of Lorem Ipsum
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> 12:00 am </span>
                                                    If you are going
                                                </li>
                                            </ul>
                                            <strong>Notes</strong>
                                            <p>
                                                Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                            </p>
                                            <hr/>
                                            <strong>Timeline activity</strong>
                                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon navy-bg">
                                                        <i class="fa fa-warning"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>The generated Lorem Ipsum is therefore.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="company-1" class="tab-pane">
                                    <div class="m-b-lg">
                                            <h2>Tellus Institute</h2>

                                            <p>
                                                Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero,written in 45 BC. This book is a treatise on.
                                            </p>
                                            <div>
                                                <small>Active project completion with: 48%</small>
                                                <div class="progress progress-mini">
                                                    <div style="width: 48%;" class="progress-bar"></div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="client-detail">
                                        <div class="full-height-scroll">

                                            <strong>Last activity</strong>

                                            <ul class="list-group clear-list">
                                                <li class="list-group-item fist-item">
                                                    <span class="pull-right"> <span class="label label-primary">NEW</span> </span>
                                                    The point of using
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> <span class="label label-warning">WAITING</span></span>
                                                    Lorem Ipsum is that it has
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> <span class="label label-danger">BLOCKED</span> </span>
                                                    If you are going
                                                </li>
                                            </ul>
                                            <strong>Notes</strong>
                                            <p>
                                                Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                            </p>
                                            <hr/>
                                            <strong>Timeline activity</strong>
                                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon navy-bg">
                                                        <i class="fa fa-warning"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>The generated Lorem Ipsum is therefore.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="company-2" class="tab-pane">
                                    <div class="m-b-lg">
                                        <h2>Penatibus Consulting</h2>

                                        <p>
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some.
                                        </p>
                                        <div>
                                            <small>Active project completion with: 22%</small>
                                            <div class="progress progress-mini">
                                                <div style="width: 22%;" class="progress-bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="client-detail">
                                        <div class="full-height-scroll">

                                            <strong>Last activity</strong>

                                            <ul class="list-group clear-list">
                                                <li class="list-group-item fist-item">
                                                    <span class="pull-right"> <span class="label label-warning">WAITING</span> </span>
                                                    Aldus PageMaker
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><span class="label label-primary">NEW</span> </span>
                                                    Lorem Ipsum, you need to be sure
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"> <span class="label label-danger">BLOCKED</span> </span>
                                                    The generated Lorem Ipsum
                                                </li>
                                            </ul>
                                            <strong>Notes</strong>
                                            <p>
                                                Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                            </p>
                                            <hr/>
                                            <strong>Timeline activity</strong>
                                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon navy-bg">
                                                        <i class="fa fa-warning"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>The generated Lorem Ipsum is therefore.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="company-3" class="tab-pane">
                                    <div class="m-b-lg">
                                        <h2>Ultrices Incorporated</h2>

                                        <p>
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
                                        </p>
                                        <div>
                                            <small>Active project completion with: 72%</small>
                                            <div class="progress progress-mini">
                                                <div style="width: 72%;" class="progress-bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="client-detail">
                                        <div class="full-height-scroll">

                                            <strong>Last activity</strong>

                                            <ul class="list-group clear-list">
                                                <li class="list-group-item fist-item">
                                                    <span class="pull-right"> <span class="label label-danger">BLOCKED</span> </span>
                                                    Hidden in the middle of text
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><span class="label label-primary">NEW</span> </span>
                                                    Non-characteristic words etc.
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right">  <span class="label label-warning">WAITING</span> </span>
                                                    Bonorum et Malorum
                                                </li>
                                            </ul>
                                            <strong>Notes</strong>
                                            <p>
                                                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.
                                            </p>
                                            <hr/>
                                            <strong>Timeline activity</strong>
                                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>There are many variations of passages of Lorem Ipsum available.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon navy-bg">
                                                        <i class="fa fa-warning"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>The generated Lorem Ipsum is therefore.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-coffee"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Conference on the sales results for the previous year.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-block">
                                                    <div class="vertical-timeline-icon gray-bg">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                    <div class="vertical-timeline-content">
                                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                                        </p>
                                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
	<?php
	}
	public function HTML_LOGICS(){
			$this->HTMLFORM->_FORM_LOGICS();
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
