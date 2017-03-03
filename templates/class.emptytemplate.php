<?php
class EmptyTemplate{
	public $PageTitle;
	public $HTMLFORM;
	public $Settings;
	public $Database;
	public $HtmlComponents;
	public $PageID;
	public $_DATA;
	public $Site;
	
	

	
	
/*	public function __construct($PageTitle, HTMLFORM $HTMLFORM, Settings $Settings ,Database $Database=NULL){
		$this->PageTitle=$PageTitle;
		$this->HTMLFORM=$HTMLFORM;
		$this->Settings=$Settings;
		$this->Database=$Database;
	}*/
	public function __construct($Site){
		//$this->PageID= isset($_GET['p']) ? $_GET['p'] : "" ;
		//$this->CategoryID=isset($_GET['c']) ? $_GET['c'] : "" ;		
		$this->Site=$Site;
	}
	
	public function HTML_LOGICS(){

	}
	
	public function HTML_DOC(){
	?>
    <!DOCTYPE html>
	<html dir="ltr" lang="en-US">
	<?php
	}
	
	public function HTML_Header(){ 
	
	global $_DIR_ASSETS;
	global $_CORE_DIR_ASSETS;
	global $_USE_CORE_BS;
	
	$_CORE_DIR = trim($_DIR_ASSETS)!='' ? '//'.$_DIR_ASSETS.'/' : '//'.$_CORE_DIR_ASSETS.'/' ;
	
	?><head>
	<title><?php echo $this->PageTitle; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $this->HTML_Meta_Local(); ?><!--JS-->	
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="<?php echo $_CORE_DIR;?>js/core/corelib.js"></script>
    <script src="<?php echo $_CORE_DIR;?>js/core/utils.js"></script>
    <script src="<?php echo $_CORE_DIR;?>js/core/nested_form_processor.js"></script>
	<script src="<?php echo $_CORE_DIR;?>js/core/bootstrap.min.js"></script>
	<script src="<?php echo $_CORE_DIR;?>js/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?php echo $_CORE_DIR;?>js/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $_CORE_DIR;?>js/piety/jquery.peity.min.js"></script>
	<script src="<?php echo $_CORE_DIR;?>js/inspina/inspina.js"></script>

	
	<!--CSS--><?php if( $_USE_CORE_BS ) {  ?>
	<link href="<?php echo $_CORE_DIR;?>resources/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<link href="<?php echo $_CORE_DIR;?>resources/css/bootstrap-theme.min.css" media="screen" rel="stylesheet" type="text/css" />-->
	<link href="<?php echo $_CORE_DIR;?>resources/css/animate.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo $_CORE_DIR;?>resources/css/style-inspina.css" media="screen" rel="stylesheet" type="text/css" /><!--inspina theme--><?php }?>
	
    <link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" >
	<!--<link href="<?php echo $_CORE_DIR;?>resources/css/font-awesome/css/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="//oss.maxcdn.com/fontawesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" >-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"  rel="stylesheet" >
	<link href="<?php echo $_CORE_DIR;?>resources/css/core.css" media="screen" rel="stylesheet" type="text/css" />
	<!--END-->

    <?php 
		$this->HTML_Header_Local_Base();
		$this->HTML_Header_Local(); 
		
		//scan for _ajax in fs
		if(isset($this->Datalogic->FS_LAYOUT)){
			$FS_LAYOUT = $this->Datalogic->FS_LAYOUT;
			$_AJAX ='';
			foreach(array_keys($FS_LAYOUT) as $FSID){
				if( $FS_LAYOUT[ $FSID ]['_ajax']===false || empty($FS_LAYOUT[ $FSID ]['_ajax']) ){
					$_AJAX = 'data-ajax="off" ';
				}
			}
		}
	?>
    
    </head>	
    <body <?php echo $_AJAX; echo $BodyCSS = isset( $this->BodyCSS )? 'class="'.$this->BodyCSS.'"' : '' ; ?>>
	
	<?php
		//FOR AJAX
		echo '<input type="hidden" name="CURRCID" value="'.$this->Site->CURRCID.'">';
	}
	//For local META
	public function HTML_Meta_Local(){

	}
	
	//For base local CSS/JS
	public function HTML_Header_Local_Base(){

	}
	
	//For local CSS/JS
	public function HTML_Header_Local(){

	}
	
	//For local JS
	public function HTML_Footer_Local(){
	
	}
	
	//Content
	public function HTML_Content(){
	
	}
	
	
	public function HTML_Footer(){ 
	?><!--
    <script src="<?php echo $this->Settings->_HOST_DIR;?>js/core/nanobar.js"></script>
    <script>
			var nanobar = new Nanobar();
			nanobar.go(100);
		</script>-->
    <?php
		$this->HTML_Footer_Local();
	?>
    
    </body>
	</html>
    <?php
	}
	public function RenderHTML(){
		
		$this->HTML_LOGICS();
		$this->HTML_DOC();
		$this->HTML_Header();
		$this->HTML_Content();
		$this->HTML_Footer();
	}
	
	public function Navigation_Child($ChildCIDs, $Child='li', $ChildCSS='', $Level=1 , $MaxLevel=1, $StartTier=false){

		if(is_array($ChildCIDs)){			
		
			foreach($ChildCIDs as $c){ //echo $c;
				if(isset($this->Site->CATEGORY_DEF[$c]['Category'])) $Category = $this->Site->CATEGORY_DEF[$c]['Category'];			
				$c_Tree = $this->Site->_GET_TREE( $c );
				$c_URL = $this->Site->_GET_URL( $c_Tree ) ;
				$Icon = $this->Site->_GET_ICON ( $c );
				$Class = $this->Site->_COUNT_TREE_DIFF($c_Tree)==0 ? 'active' : '';
				if($ChildCSS!='') $Class = $ChildCSS.' '.$Class;
				if(isset($this->Site->CATEGORY_DEF[$c]['Target'])) $target = $this->Site->CATEGORY_DEF[$c]['Target'];
				
				if( $this->Site->CATEGORY_DEF[$c]['Status']=='Active'){

				?><<?php echo $Child; ?> class="<?php echo $Class; ?>">
		<a href="<?php echo $c_URL;?>" target="<?php echo $target; ?>"><?php if($StartTier) echo '<i class="fa ',$Icon,'"></i>'; ?><span class="nav-label"><?php echo $Category; ?></span><?php if( isset($this->Site->CATEGORY_DEF[$c]['Children']) && $Level!=$MaxLevel ) echo '<span class="fa arrow"></span>'; ?></a>
			<?php if( isset($this->Site->CATEGORY_DEF[$c]['Children']) && $Level!=$MaxLevel ) { 
					$Level = $Level + 1;	
					//echo 'have child';
					$this->Navigation_Parent($this->Site->CATEGORY_DEF[$c]['Children'] , 'nav nav-second-level collapse' ,$ChildCSS, 'ul', 'li' , $Level, $MaxLevel); } ?>
	</<?php echo $Child; ?>>	
			<?php }
			
			}// if active 
		
		}
	}
	
	public function Navigation_Parent($ChildCIDs, $ParentCSS='' ,$ChildCSS='', $Parent='ul', $Child='li', $Level=1, $MaxLevel=1 ,$ID='',$StartTier=false){
		$Numofchild = !empty($ChildCIDs) ? count($ChildCIDs) : 0;
		if($Numofchild>0){
?><<?php echo $Parent; ?> class='<?php echo $ParentCSS; ?>' id='<?php echo $ID; ?>'>
	<?php $this->Navigation_Child($ChildCIDs, $Child ,$ChildCSS, $Level, $MaxLevel, $StartTier);?></<?php echo $Parent; ?>><?php
		}
	}
	
	public function Print_HTML_List_Main( $config ){
		
		$ListArray = $config['ListArray']; //array containing the data $ListArray[ KeyIndex ] = content....
		$ParentCSS = $config['ParentCSS'];
		$ChildCSS = $config['ChildCSS'];
		$Parent = $config['Parent']; //Parent HTML tag EG Ul, OL
		$Child = $config['Child']; //Chidl HMTL tag EG li
		$Level = $config['Level']; //Current level in nested array
		$MaxLevel = $config['MaxLevel']; //Max level drill down in nested array
		$ID = $config['ID']; // HTML ID attribute
		$StartTier = $config['StartTier']; // To differentiate top level in nested array
		$ContentMethod = $config['ContentMethod']; //Content method class to call
		$ActiveIndex = $config['ActiveIndex']; //Array of active index(s) 
		
		$this->Print_HTML_List($ListArray, $ParentCSS ,$ChildCSS, $Parent, $Child, $Level, $MaxLevel,$ID,$StartTier, $ContentMethod,$ActiveIndex);
	}
	
	public function Print_HTML_List($ListArray, $ParentCSS='' ,$ChildCSS='', $Parent='ul', $Child='li', $Level=1, $MaxLevel=1 ,$ID='',$StartTier=false , $ContentMethod='PlaceHolderText',$ActiveIndex=''){
	?>
	<<?php echo $Parent; ?> class='<?php echo $ParentCSS; ?>' id='<?php echo $ID; ?>'>
		<?php $this->Print_HTML_List_Child($ListArray, $Child ,$ChildCSS, $Level, $MaxLevel, $StartTier, $ContentMethod, $ActiveIndex);?>
	</<?php echo $Parent; ?>>
	<?php
	}
	
	//Method to generate html list (ul, li)
	//Note: currently it can only generate non nested version...
	public function Print_HTML_List_Child($ListArray, $Child='li', $ChildCSS='', $Level=1 , $MaxLevel=1, $StartTier=false, $ContentMethod , $ActiveIndex){
		if(is_array($ListArray)){
			
			foreach( array_keys($ListArray) as $index){ 
			
				if(in_array($index, $ActiveIndex)) $Class = 'active '.$ChildCSS; 
			
			?>
				<<?php echo $Child; ?> class="<?php echo $Class; ?>">
				<?php
					if( method_exists($this, $ContentMethod)){
						$this->$ContentMethod( $ListArray[$index], $index );
					} else {
						echo $ContentMethod,'() is undefined at template class';
					}
				?>
				</<?php echo $Child; ?>>
				<?php
			}
		}
	}
	
	public function PlaceHolderText( $data, $index ){
		echo 'Customise your content...';
	}
	
	public function PlaceHolderContent( $data='', $index='' ){
		ob_start();
		?>
		                        <h2>Welcome Amelia</h2>
                        <small>You have 42 messages and 6 notifications.</small>
                        <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="pull-right">
                                    09:00 pm
                                </span>
                                <span class="label label-success">1</span> Please contact me
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    10:16 am
                                </span>
                                <span class="label label-info">2</span> Sign a contract
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    08:22 pm
                                </span>
                                <span class="label label-primary">3</span> Open new shop
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    11:06 pm
                                </span>
                                <span class="label label-default">4</span> Call back to Sylvia
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    12:00 am
                                </span>
                                <span class="label label-primary">5</span> Write a letter to Sandra
                            </li>
                        </ul>
		<?php
				$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	

	/***************************************************************************/
	//BOOTSTRAP METHODS
	/***************************************************************************/
	public function _GET_GRID_CONTENT( $GInfoArr ){
		$InfoArr = explode('#',$GInfoArr);
		switch($InfoArr[0]){
			//WIDGET
			case 'WID':
				//_echo ('<h1>WID</h1>');
				$this->Widget->Widget_Driver( $InfoArr[1] );	
			break;
			
			//STANDARD FORM
			case 'FS':
				//_echo ('<h1>FS</h1>');
				$FSID = $InfoArr[1];	
				$this->_FORM_RENDERFORM_CORE( $FSID );
			break;
			
			default:
				echo $GInfoArr;
		}		
	}
	//Grid generator
	public function _BUILD_GRID( $Arr='' ){
		$GRID = $Arr==''?  $this->GRID : $Arr;
		//_print_r( $GRID );
		if(isset($GRID)){			
		
			foreach( array_keys($GRID) as $attr_info ){
				//echo $css;
				
				//Check attr_info is attribute info
				preg_match('/(#)/', $attr_info, $matches );
				
				//print <div> if there are matches for '#'
				//echo sizeof($matches);
				if( sizeof($matches) ){
					//PRINT GRID
					echo '<div ',$this->_BUILD_GRID_ATTRIBUTES ( $attr_info ),'/>';	
					if(is_array($GRID[$attr_info])) $this->_BUILD_GRID( $GRID[$attr_info] );
					echo '</div>';
				} else {
					
					//PRINT WDIGET CONTENT
					if( $attr_info=='_content' ) {		

						if(is_array( $GRID[$attr_info] )){
							
							foreach( array_keys($GRID[$attr_info]) as $k){
								//_echo('attr_info='.$attr_info.' k='.$k.'<br>');
								$this->_GET_GRID_CONTENT( $GRID[$attr_info][$k] );
							}
						} else {
							//_echo('attr_info='.$attr_info.'<br>');
							$this->_GET_GRID_CONTENT( $GRID[$attr_info] );							
						}
																	

					}
					//print_r($GRID[$attr_info] );
				}
				//print_r($matches);

				
			}
			
		}
	}
	//Process grid div attributes and print div
	private function _BUILD_GRID_ATTRIBUTES( $attr_info ){
		//print_r($attr_info);
		$attr_info_arr = explode('#',$attr_info);
		//print_r( $attr_info_arr);
		$attributes='';
		foreach( $attr_info_arr as $attr_val ){
			//echo $attr_val;
			$attr_val_arr = explode('.',$attr_val);
				
			if(trim($attr_val_arr[0])!='') {
				//print_r($attr_val_arr);
				
				//Get attribute name
				//echo $attr_val_arr[0];
				$value = $attr_val_arr[0]=='class' ?  $attr_val_arr[2] :  $attr_val_arr[1]; 
				$$attr_val_arr[0] = $value;
				
				if(trim($value!='')) $attributes = $attributes.$attr_val_arr[0].'="'.$value.'" ';
			}
				
		}
		return $attributes;
	}




}
?>