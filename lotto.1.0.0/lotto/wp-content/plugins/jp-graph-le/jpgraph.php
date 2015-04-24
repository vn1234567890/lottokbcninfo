<?php
/*
Plugin Name: Graph for Jackpots Shortcode Plugin
Plugin URI: http://damyanov.eu
Description: [jpgraph] is the shortcode for the jackpots graph, [hotcold] for hot/cold numbers, [jpshotcold] for both
Version: The Plugin's Version Number, e.g.: 1.10
Author: Radostin Damyanov
Author URI: http://damyanov.eu
License: A "Slug" license name e.g. GPL2
*/

/*
<div id="jpgraphwrap"><div id="switchbuttons">
<a class="jpbtn green x-large tooltip" onclick="toggle(\'jp\')" href="javascript:;">Predicted Jackpots<span class="classic">All Lottery Jackpots Are Gathered Into 1 Visual Graph. Enables You To Research, Compare And Predict The Next Lottery Jackpot</span></a>
<a class="jpbtn green x-large tooltip" onclick="toggle(\'hc\')" href="javascript:;">Hot/Cold Numbers<span class="classic">All Winning Numbers Are Gathered Into 1 Visual Graph. Enables You To See The <div class="bold red">Hot</div> (Drawn More Than The Average) And <div class="bold blue">Cold</div> (Drawn Less Than The Average) And To Decide Which Numbers To Choose!</span></a>
</div>
*/
	
function jpgraph_i18n_init()  
{  
load_plugin_textdomain('jpgraph-i18n', false, dirname(plugin_basename(__FILE__)) . '/languages');  
}  

add_action('init', 'jpgraph_i18n_init');

function jpgraph_shortcode( $atts ) {

	wp_enqueue_style('jpgraph-style', plugins_url('graph-le.css', __FILE__));
	//wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css'); OLD
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
	wp_enqueue_script('google-jsapi','https://www.google.com/jsapi');
	//wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js', array('jquery'), '1.8.6'); OLD
	wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', array('jquery'), '1.10.4');
	//wp_enqueue_script('jpgraph', plugins_url('graph.min.js.php', __FILE__), array('jquery'), '1.0', true);
	//wp_enqueue_script('jpgraph', plugins_url('graph.js.php?view=graph&lang='.$lang, __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('jpgraph', home_url('?graph_js_php=graph', __FILE__), array('jquery'), '1.0', true);
	
	$PredictedJackpot = __( 'Predicted Jackpot:', 'jpgraph-i18n' );
	$CompareLottos = __( 'Compare Lottos', 'jpgraph-i18n' );
	$PredictedText = __( 'All Lottery Jackpots Are Gathered Into 1 Visual Graph. Enables You To Research, Compare And Predict The Next Lottery Jackpot.', 'jpgraph-i18n' );
	$lotto_mm = __( 'Mega Millions', 'jpgraph-i18n' );
	$lotto_pb = __( 'Powerball', 'jpgraph-i18n' );
	$lotto_em = __( 'Euro Millions', 'jpgraph-i18n' );
	$lotto_pa = __( 'Powerball Australia', 'jpgraph-i18n' );
	$lotto_hl = __( 'Hot Lotto', 'jpgraph-i18n' );
	$lotto_eg = __( 'El Gordo', 'jpgraph-i18n' );
	$lotto_fr = __( 'France Loto', 'jpgraph-i18n' );
	$lotto_uk = __( 'UK National Lottery', 'jpgraph-i18n' );
	$lotto_cs = __( 'California SuperLotto', 'jpgraph-i18n' );
	$lotto_oz = __( 'Oz Lotto', 'jpgraph-i18n' );
	$lotto_49 = __( 'Lotto 6/49', 'jpgraph-i18n' );
	$lotto_ho = __( 'Hoosier Lotto', 'jpgraph-i18n' );
	$lotto_ny = __( 'New York Lotto', 'jpgraph-i18n' );
	$lotto_fl = __( 'Florida Lotto', 'jpgraph-i18n' );
	$lotto_ms = __( 'Mega Sena', 'jpgraph-i18n' );
	$lotto_ie = __( 'Irish Lotto', 'jpgraph-i18n' );
	$lotto_tb = __( 'Thunderball', 'jpgraph-i18n' );
	$lotto_se = __( 'Superena Lotto', 'jpgraph-i18n' );
	$lotto_de = __( 'German Lotto', 'jpgraph-i18n' );
	$lotto_lp = __( 'La Primitiva', 'jpgraph-i18n' );

	return '<div id="predictedjps" style="width: 100%; margin-top: 10px;">

<div class="classic" style="margin-bottom: 10px">'.$PredictedText.'</div>

<div id="dashboard" style="">
<div id="chart" style="height: 300px;"></div>
<div id="control" style="height: 50px;"></div>
<div id="jpwrap"><div id="jpwraptext">'.$PredictedJackpot.'</div><div id="jp"></div></div>
<div id="lottos" style="position: relative; top: 10px;">
<ul id="btns">
	<li><a class="jpbtn green small" onclick="graph(\'mm\')" href="javascript:;">'.$lotto_mm.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'pb\')" href="javascript:;">'.$lotto_pb.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'em\')" href="javascript:;">'.$lotto_em.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'pa\')" href="javascript:;">'.$lotto_pa.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'hl\')" href="javascript:;">'.$lotto_hl.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'eg\')" href="javascript:;">'.$lotto_eg.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'fr\')" href="javascript:;">'.$lotto_fr.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'uk\')" href="javascript:;">'.$lotto_uk.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'cs\')" href="javascript:;">'.$lotto_cs.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'oz\')" href="javascript:;">'.$lotto_oz.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'49\')" href="javascript:;">'.$lotto_49.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ho\')" href="javascript:;">'.$lotto_ho.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ny\')" href="javascript:;">'.$lotto_ny.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'fl\')" href="javascript:;">'.$lotto_fl.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ms\')" href="javascript:;">'.$lotto_ms.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ie\')" href="javascript:;">'.$lotto_ie.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'tb\')" href="javascript:;">'.$lotto_tb.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'se\')" href="javascript:;">'.$lotto_se.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'de\')" href="javascript:;">'.$lotto_de.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'lp\')" href="javascript:;">'.$lotto_lp.'</a></li>
</ul>
</div>
<div id="compare"><select id="comparing" multiple="multiple"> <option value="mm">'.$lotto_mm.'</option> <option value="pb">'.$lotto_pb.'</option> <option value="em">'.$lotto_em.'</option> <option value="pa">'.$lotto_pa.'</option> <option value="hl">'.$lotto_hl.'</option> <option value="eg">'.$lotto_eg.'</option> <option value="fr">'.$lotto_fr.'</option> <option value="uk">'.$lotto_uk.'</option> <option value="cs">'.$lotto_cs.'</option> <option value="oz">'.$lotto_oz.'</option> <option value="49">'.$lotto_49.'</option> <option value="ho">'.$lotto_ho.'</option> <option value="ny">'.$lotto_ny.'</option> <option value="fl">'.$lotto_fl.'</option> <option value="ms">'.$lotto_ms.'</option> <option value="ie">'.$lotto_ie.'</option> <option value="tb">'.$lotto_tb.'</option> <option value="se">'.$lotto_se.'</option> <option value="de">'.$lotto_de.'</option> <option value="lp">'.$lotto_lp.'</option> </select><a class="jpbtn green x-large" onclick="compare()" href="javascript:;">'.$CompareLottos.'</a>

</div>
</div>

</div>';
}
add_shortcode('jpgraph', 'jpgraph_shortcode');

function hotcold_shortcode( $atts ) {
	
	wp_enqueue_style('jpgraph-style', plugins_url('graph-le.css', __FILE__));
	//wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css'); //OLD
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
	wp_enqueue_script('google-jsapi','https://www.google.com/jsapi');
	wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js', array('jquery'), '1.8.6');
	//wp_enqueue_script('jpgraph', plugins_url('graph.min.js.php', __FILE__), array('jquery'), '1.0', true);
	//wp_enqueue_script('jpgraph', plugins_url('graph.js.php?view=hotcold&lang='.$lang, __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('jpgraph', home_url('?graph_js_php=hotcold', __FILE__), array('jquery'), '1.0', true);
	
	$HotColdText = __( 'All Winning Numbers Are Gathered Into 1 Visual Graph. Enables You To See The <div class="bold red">Hot</div> (Drawn More Than The Average) And <div class="bold blue">Cold</div> (Drawn Less Than The Average) And To Decide Which Numbers To Choose!', 'jpgraph-i18n' );
	$lotto_mm = __( 'Mega Millions', 'jpgraph-i18n' );
	$lotto_pb = __( 'Powerball', 'jpgraph-i18n' );
	$lotto_em = __( 'Euro Millions', 'jpgraph-i18n' );
	$lotto_pa = __( 'Powerball Australia', 'jpgraph-i18n' );
	$lotto_hl = __( 'Hot Lotto', 'jpgraph-i18n' );
	$lotto_eg = __( 'El Gordo', 'jpgraph-i18n' );
	$lotto_fr = __( 'France Loto', 'jpgraph-i18n' );
	$lotto_uk = __( 'UK National Lottery', 'jpgraph-i18n' );
	$lotto_cs = __( 'California SuperLotto', 'jpgraph-i18n' );
	$lotto_oz = __( 'Oz Lotto', 'jpgraph-i18n' );
	$lotto_49 = __( 'Lotto 6/49', 'jpgraph-i18n' );
	$lotto_ho = __( 'Hoosier Lotto', 'jpgraph-i18n' );
	$lotto_ny = __( 'New York Lotto', 'jpgraph-i18n' );
	$lotto_fl = __( 'Florida Lotto', 'jpgraph-i18n' );
	$lotto_ms = __( 'Mega Sena', 'jpgraph-i18n' );
	$lotto_ie = __( 'Irish Lotto', 'jpgraph-i18n' );
	$lotto_tb = __( 'Thunderball', 'jpgraph-i18n' );
	$lotto_se = __( 'Superena Lotto', 'jpgraph-i18n' );
	$lotto_de = __( 'German Lotto', 'jpgraph-i18n' );
	$lotto_lp = __( 'La Primitiva', 'jpgraph-i18n' );
	
	if (!wp_is_mobile()) {
	
	return '<div id="hotcold" style="width: 100%;">

<div class="classic" style="margin-bottom: 10px;">'.$HotColdText.'</div>
	
<div id="hotcoldgraph" style="height: 400px;"></div>

<div id="hcdashboard">

<div id="stars" style="position: relative; height: 75px;">
	
	<div id="starsnumbers"></div>

</div>

<div id="slider" style="position: relative; margin: 30px 0 15px; left: 20px; width: 630px;"></div>

<div id="hot" class="bubble three-d red" style="height: 32px; width: 312px;">
	
	<div id="hotnumbers"></div>

</div>

<div id="cold" class="bubble three-d blue" style="height: 32px; width: 312px;">

	<div id="coldnumbers"></div>

</div>

</div>

<div id="lottos" style="position: relative; margin: 10px 0; width: 100%; height: 80px;">
<ul id="btns">
<li><a class="jpbtn green small" onclick="chooselotto(\'mm\')" href="javascript:;">'.$lotto_mm.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'pb\')" href="javascript:;">'.$lotto_pb.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'em\')" href="javascript:;">'.$lotto_em.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'pa\')" href="javascript:;">'.$lotto_pa.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'hl\')" href="javascript:;">'.$lotto_hl.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'eg\')" href="javascript:;">'.$lotto_eg.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'fr\')" href="javascript:;">'.$lotto_fr.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'uk\')" href="javascript:;">'.$lotto_uk.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'cs\')" href="javascript:;">'.$lotto_cs.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'oz\')" href="javascript:;">'.$lotto_oz.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'49\')" href="javascript:;">'.$lotto_49.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ho\')" href="javascript:;">'.$lotto_ho.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ny\')" href="javascript:;">'.$lotto_ny.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'fl\')" href="javascript:;">'.$lotto_fl.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ms\')" href="javascript:;">'.$lotto_ms.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ie\')" href="javascript:;">'.$lotto_ie.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'tb\')" href="javascript:;">'.$lotto_tb.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'se\')" href="javascript:;">'.$lotto_se.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'de\')" href="javascript:;">'.$lotto_de.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'lp\')" href="javascript:;">'.$lotto_lp.'</a></li>
</ul>
</div>

</div>';
	} else {
	return 'This tool is only available in desktop mode!';
	}
}

add_shortcode('hotcold', 'hotcold_shortcode');

add_action('init', 'graph_js_php_data');

function graph_js_php_data(){

	$siteroot = site_url('/');
	
	$plgroot = plugins_url( '/', __FILE__ );
	
	if(isset($_GET['graph_js_php']) && $_GET['graph_js_php'] == 'graph') {
	
	header("content-type: application/javascript");
	
	$checkAllText = __( 'Check all', 'jpgraph-i18n' );
	$uncheckAllText = __( 'Uncheck all', 'jpgraph-i18n' );
	$noneSelectedText = __( 'Select options', 'jpgraph-i18n' );
	$selectedText = __( '# selected', 'jpgraph-i18n' );
	$compareHeaderText = __( 'Compare up to 3 lottos', 'jpgraph-i18n' );
	$compareWarningText = __( 'You can compare up to 3 lottos only!', 'jpgraph-i18n' );
	$compareWarningText2 = __( 'Check a few boxes.', 'jpgraph-i18n' );
	$compareMin2lottos = __( 'Please select at least two or more lotteries to compare!', 'jpgraph-i18n' );
	$ISO639lang = __( 'en', 'jpgraph-i18n' );
	?>
	var plgroot = '<?=$plgroot;?>';
	var siteroot = '<?=$siteroot;?>';
	
	var i18n_checkAllText = '<?=$checkAllText;?>';
	var i18n_uncheckAllText = '<?=$uncheckAllText;?>';
	var i18n_noneSelectedText = '<?=$noneSelectedText;?>';
	var i18n_selectedText = '<?=$selectedText;?>';
	var i18n_compareHeaderText = '<?=$compareHeaderText;?>';
	var i18n_compareWarningText = '<?=$compareWarningText;?>';
	var i18n_compareWarningText2 = '<?=$compareWarningText2;?>';
	var i18n_compareMin2lottos = '<?=$compareMin2lottos;?>';
	var i18n_ISO639lang = '<?=$ISO639lang;?>';

	function chooselotto(e,t,n){var t=Math.round(t);var n=Math.round(n);if(isNaN(t)){var t=""}if(isNaN(n)){var n=""}$.ajax({url:siteroot+"?graph_js_php_db=true&view=hotcold&chooselotto=yes&lotto="+e+"&from="+t+"&to="+n,dataType:"script"})}function hotcold(e,t,n){var t=Math.round(t);var n=Math.round(n);if(isNaN(t)){var t=""}if(isNaN(n)){var n=""}$.ajax({url:siteroot+"?graph_js_php_db=true&view=hotcold&lotto="+e+"&from="+t+"&to="+n,dataType:"script"})}function toggle(e){if(e=="jp"){$("#predictedjps").show();$("#hotcold").hide()}else{if(e=="hc"){$("#predictedjps").hide();$("#hotcold").show();chooselotto("mm")}}}function graph(e){$.ajax({url:siteroot+"?graph_js_php_db=true&lotto="+e,dataType:"script",async:false})}function compare(){var e=$("select[id='comparing']").val();if(!e){alert(i18n_compareMin2lottos)}else{graph(e)}}(function(e){var t=0;e.widget("ech.multiselect",{options:{header:!0,height:175,minWidth:225,classes:"",checkAllText:i18n_checkAllText,uncheckAllText:i18n_uncheckAllText,noneSelectedText:i18n_noneSelectedText,selectedText:i18n_selectedText,selectedList:0,show:"",hide:"",autoOpen:!1,multiple:!0,position:{}},_create:function(){var t=this.element.hide(),n=this.options;this.speed=e.fx.speeds._default;this._isOpen=!1;t=(this.button=e('<button type="button"><span class="ui-icon ui-icon-triangle-2-n-s"></span></button>')).addClass("ui-multiselect ui-widget ui-state-default ui-corner-all").addClass(n.classes).attr({title:t.attr("title"),"aria-haspopup":!0,tabIndex:t.attr("tabIndex")}).insertAfter(t);(this.buttonlabel=e("<span />")).html(n.noneSelectedText).appendTo(t);var t=(this.menu=e("<div />")).addClass("ui-multiselect-menu ui-widget ui-widget-content ui-corner-all").addClass(n.classes).appendTo(document.body),r=(this.header=e("<div />")).addClass("ui-widget-header ui-corner-all ui-multiselect-header ui-helper-clearfix").appendTo(t);(this.headerLinkContainer=e("<ul />")).addClass("ui-helper-reset").html(function(){return!0===n.header?'<li><a class="ui-multiselect-all" href="#"><span class="ui-icon ui-icon-check"></span><span>'+n.checkAllText+'</span></a></li><li><a class="ui-multiselect-none" href="#"><span class="ui-icon ui-icon-closethick"></span><span>'+n.uncheckAllText+"</span></a></li>":"string"===typeof n.header?"<li>"+n.header+"</li>":""}).append('<li class="ui-multiselect-close"><a href="#" class="ui-multiselect-close"><span class="ui-icon ui-icon-circle-close"></span></a></li>').appendTo(r);(this.checkboxContainer=e("<ul />")).addClass("ui-multiselect-checkboxes ui-helper-reset").appendTo(t);this._bindEvents();this.refresh(!0);n.multiple||t.addClass("ui-multiselect-single")},_init:function(){!1===this.options.header&&this.header.hide();this.options.multiple||this.headerLinkContainer.find(".ui-multiselect-all, .ui-multiselect-none").hide();this.options.autoOpen&&this.open();this.element.is(":disabled")&&this.disable()},refresh:function(n){var r=this.element,i=this.options,s=this.menu,o=this.checkboxContainer,u=[],a=[],f=r.attr("id")||t++;r.find("option").each(function(t){e(this);var n=this.parentNode,r=this.innerHTML,s=this.title,o=this.value,t=this.id||"ui-multiselect-"+f+"-option-"+t,l=this.disabled,h=this.selected,p=["ui-corner-all"];"optgroup"===n.tagName.toLowerCase()&&(n=n.getAttribute("label"),-1===e.inArray(n,u)&&(a.push('<li class="ui-multiselect-optgroup-label"><a href="#">'+n+"</a></li>"),u.push(n)));l&&p.push("ui-state-disabled");h&&!i.multiple&&p.push("ui-state-active");a.push('<li class="'+(l?"ui-multiselect-disabled":"")+'">');a.push('<label for="'+t+'" title="'+s+'" class="'+p.join(" ")+'">');a.push('<input id="'+t+'" name="multiselect_'+f+'" type="'+(i.multiple?"checkbox":"radio")+'" value="'+o+'" title="'+r+'"');h&&(a.push(' checked="checked"'),a.push(' aria-selected="true"'));l&&(a.push(' disabled="disabled"'),a.push(' aria-disabled="true"'));a.push(" /><span>"+r+"</span></label></li>")});o.html(a.join(""));this.labels=s.find("label");this._setButtonWidth();this._setMenuWidth();this.button[0].defaultValue=this.update();n||this._trigger("refresh")},update:function(){var t=this.options,n=this.labels.find("input"),r=n.filter("[checked]"),i=r.length,t=0===i?t.noneSelectedText:e.isFunction(t.selectedText)?t.selectedText.call(this,i,n.length,r.get()):/\d/.test(t.selectedList)&&0<t.selectedList&&i<=t.selectedList?r.map(function(){return e(this).next().text()}).get().join(", "):t.selectedText.replace("#",i).replace("#",n.length);this.buttonlabel.html(t);return t},_bindEvents:function(){function t(){n[n._isOpen?"close":"open"]();return!1}var n=this,r=this.button;r.find("span").bind("click.multiselect",t);r.bind({click:t,keypress:function(e){switch(e.which){case 27:case 38:case 37:n.close();break;case 39:case 40:n.open()}},mouseenter:function(){r.hasClass("ui-state-disabled")||e(this).addClass("ui-state-hover")},mouseleave:function(){e(this).removeClass("ui-state-hover")},focus:function(){r.hasClass("ui-state-disabled")||e(this).addClass("ui-state-focus")},blur:function(){e(this).removeClass("ui-state-focus")}});this.header.delegate("a","click.multiselect",function(t){if(e(this).hasClass("ui-multiselect-close"))n.close();else n[e(this).hasClass("ui-multiselect-all")?"checkAll":"uncheckAll"]();t.preventDefault()});this.menu.delegate("li.ui-multiselect-optgroup-label a","click.multiselect",function(t){t.preventDefault();var r=e(this),i=r.parent().nextUntil("li.ui-multiselect-optgroup-label").find("input:visible:not(:disabled)"),s=i.get(),r=r.parent().text();!1!==n._trigger("beforeoptgrouptoggle",t,{inputs:s,label:r})&&(n._toggleChecked(i.filter("[checked]").length!==i.length,i),n._trigger("optgrouptoggle",t,{inputs:s,label:r,checked:s[0].checked}))}).delegate("label","mouseenter.multiselect",function(){e(this).hasClass("ui-state-disabled")||(n.labels.removeClass("ui-state-hover"),e(this).addClass("ui-state-hover").find("input").focus())}).delegate("label","keydown.multiselect",function(t){t.preventDefault();switch(t.which){case 9:case 27:n.close();break;case 38:case 40:case 37:case 39:n._traverse(t.which,this);break;case 13:e(this).find("input")[0].click()}}).delegate('input[type="checkbox"], input[type="radio"]',"click.multiselect",function(t){var r=e(this),i=this.value,s=this.checked,o=n.element.find("option");this.disabled||!1===n._trigger("click",t,{value:i,text:this.title,checked:s})?t.preventDefault():(r.focus(),r.attr("aria-selected",s),o.each(function(){if(this.value===i)this.selected=s;else if(!n.options.multiple)this.selected=!1}),n.options.multiple||(n.labels.removeClass("ui-state-active"),r.closest("label").toggleClass("ui-state-active",s),n.close()),n.element.trigger("change"),setTimeout(e.proxy(n.update,n),10))});e(document).bind("mousedown.multiselect",function(t){n._isOpen&&!e.contains(n.menu[0],t.target)&&!e.contains(n.button[0],t.target)&&t.target!==n.button[0]&&n.close()});e(this.element[0].form).bind("reset.multiselect",function(){setTimeout(e.proxy(n.refresh,n),10)})},_setButtonWidth:function(){var e=this.element.outerWidth(),t=this.options;if(/\d/.test(t.minWidth)&&e<t.minWidth)e=t.minWidth;this.button.width(e)},_setMenuWidth:function(){var e=this.menu,t=this.button.outerWidth()-parseInt(e.css("padding-left"),10)-parseInt(e.css("padding-right"),10)-parseInt(e.css("border-right-width"),10)-parseInt(e.css("border-left-width"),10);e.width(t||this.button.outerWidth())},_traverse:function(t,n){var r=e(n),i=38===t||37===t,r=r.parent()[i?"prevAll":"nextAll"]("li:not(.ui-multiselect-disabled, .ui-multiselect-optgroup-label)")[i?"last":"first"]();r.length?r.find("label").trigger("mouseover"):(r=this.menu.find("ul").last(),this.menu.find("label")[i?"last":"first"]().trigger("mouseover"),r.scrollTop(i?r.height():0))},_toggleState:function(e,t){return function(){this.disabled||(this[e]=t);t?this.setAttribute("aria-selected",!0):this.removeAttribute("aria-selected")}},_toggleChecked:function(t,n){var r=n&&n.length?n:this.labels.find("input"),i=this;r.each(this._toggleState("checked",t));r.eq(0).focus();this.update();var s=r.map(function(){return this.value}).get();this.element.find("option").each(function(){!this.disabled&&-1<e.inArray(this.value,s)&&i._toggleState("selected",t).call(this)});r.length&&this.element.trigger("change")},_toggleDisabled:function(e){this.button.attr({disabled:e,"aria-disabled":e})[e?"addClass":"removeClass"]("ui-state-disabled");this.menu.find("input").attr({disabled:e,"aria-disabled":e}).parent()[e?"addClass":"removeClass"]("ui-state-disabled");this.element.attr({disabled:e,"aria-disabled":e})},open:function(){var t=this.button,n=this.menu,r=this.speed,i=this.options;if(!(!1===this._trigger("beforeopen")||t.hasClass("ui-state-disabled")||this._isOpen)){var s=n.find("ul").last(),o=i.show,u=t.offset();e.isArray(i.show)&&(o=i.show[0],r=i.show[1]||this.speed);s.scrollTop(0).height(i.height);e.ui.position&&!e.isEmptyObject(i.position)?(i.position.of=i.position.of||t,n.show().position(i.position).hide().show(o,r)):n.css({top:u.top+t.outerHeight(),left:u.left}).show(o,r);this.labels.eq(0).trigger("mouseover").trigger("mouseenter").find("input").trigger("focus");t.addClass("ui-state-active");this._isOpen=!0;this._trigger("open")}},close:function(){if(!1!==this._trigger("beforeclose")){var t=this.options,n=t.hide,r=this.speed;e.isArray(t.hide)&&(n=t.hide[0],r=t.hide[1]||this.speed);this.menu.hide(n,r);this.button.removeClass("ui-state-active").trigger("blur").trigger("mouseleave");this._isOpen=!1;this._trigger("close")}},enable:function(){this._toggleDisabled(!1)},disable:function(){this._toggleDisabled(!0)},checkAll:function(){this._toggleChecked(!0);this._trigger("checkAll")},uncheckAll:function(){this._toggleChecked(!1);this._trigger("uncheckAll")},getChecked:function(){return this.menu.find("input").filter("[checked]")},destroy:function(){e.Widget.prototype.destroy.call(this);this.button.remove();this.menu.remove();this.element.show();return this},isOpen:function(){return this._isOpen},widget:function(){return this.menu},_setOption:function(t,n){var r=this.menu;switch(t){case"header":r.find("div.ui-multiselect-header")[n?"show":"hide"]();break;case"checkAllText":r.find("a.ui-multiselect-all span").eq(-1).text(n);break;case"uncheckAllText":r.find("a.ui-multiselect-none span").eq(-1).text(n);break;case"height":r.find("ul").last().height(parseInt(n,10));break;case"minWidth":this.options[t]=parseInt(n,10);this._setButtonWidth();this._setMenuWidth();break;case"selectedText":case"selectedList":case"noneSelectedText":this.options[t]=n;this.update();break;case"classes":r.add(this.button).removeClass(this.options.classes).addClass(n)}e.Widget.prototype._setOption.apply(this,arguments)}})})(jQuery);jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,t,n,r,i){return jQuery.easing[jQuery.easing.def](e,t,n,r,i)},easeInQuad:function(e,t,n,r,i){return r*(t/=i)*t+n},easeOutQuad:function(e,t,n,r,i){return-r*(t/=i)*(t-2)+n},easeInOutQuad:function(e,t,n,r,i){if((t/=i/2)<1){return r/2*t*t+n}return-r/2*(--t*(t-2)-1)+n},easeInCubic:function(e,t,n,r,i){return r*(t/=i)*t*t+n},easeOutCubic:function(e,t,n,r,i){return r*((t=t/i-1)*t*t+1)+n},easeInOutCubic:function(e,t,n,r,i){if((t/=i/2)<1){return r/2*t*t*t+n}return r/2*((t-=2)*t*t+2)+n},easeInQuart:function(e,t,n,r,i){return r*(t/=i)*t*t*t+n},easeOutQuart:function(e,t,n,r,i){return-r*((t=t/i-1)*t*t*t-1)+n},easeInOutQuart:function(e,t,n,r,i){if((t/=i/2)<1){return r/2*t*t*t*t+n}return-r/2*((t-=2)*t*t*t-2)+n},easeInQuint:function(e,t,n,r,i){return r*(t/=i)*t*t*t*t+n},easeOutQuint:function(e,t,n,r,i){return r*((t=t/i-1)*t*t*t*t+1)+n},easeInOutQuint:function(e,t,n,r,i){if((t/=i/2)<1){return r/2*t*t*t*t*t+n}return r/2*((t-=2)*t*t*t*t+2)+n},easeInSine:function(e,t,n,r,i){return-r*Math.cos(t/i*(Math.PI/2))+r+n},easeOutSine:function(e,t,n,r,i){return r*Math.sin(t/i*(Math.PI/2))+n},easeInOutSine:function(e,t,n,r,i){return-r/2*(Math.cos(Math.PI*t/i)-1)+n},easeInExpo:function(e,t,n,r,i){return t==0?n:r*Math.pow(2,10*(t/i-1))+n},easeOutExpo:function(e,t,n,r,i){return t==i?n+r:r*(-Math.pow(2,-10*t/i)+1)+n},easeInOutExpo:function(e,t,n,r,i){if(t==0){return n}if(t==i){return n+r}if((t/=i/2)<1){return r/2*Math.pow(2,10*(t-1))+n}return r/2*(-Math.pow(2,-10*--t)+2)+n},easeInCirc:function(e,t,n,r,i){return-r*(Math.sqrt(1-(t/=i)*t)-1)+n},easeOutCirc:function(e,t,n,r,i){return r*Math.sqrt(1-(t=t/i-1)*t)+n},easeInOutCirc:function(e,t,n,r,i){if((t/=i/2)<1){return-r/2*(Math.sqrt(1-t*t)-1)+n}return r/2*(Math.sqrt(1-(t-=2)*t)+1)+n},easeInElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0){return n}if((t/=i)==1){return n+r}if(!o){o=i*.3}if(u<Math.abs(r)){u=r;var s=o/4}else{var s=o/(2*Math.PI)*Math.asin(r/u)}return-(u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o))+n},easeOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0){return n}if((t/=i)==1){return n+r}if(!o){o=i*.3}if(u<Math.abs(r)){u=r;var s=o/4}else{var s=o/(2*Math.PI)*Math.asin(r/u)}return u*Math.pow(2,-10*t)*Math.sin((t*i-s)*2*Math.PI/o)+r+n},easeInOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0){return n}if((t/=i/2)==2){return n+r}if(!o){o=i*.3*1.5}if(u<Math.abs(r)){u=r;var s=o/4}else{var s=o/(2*Math.PI)*Math.asin(r/u)}if(t<1){return-.5*u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)+n}return u*Math.pow(2,-10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)*.5+r+n},easeInBack:function(e,t,n,r,i,s){if(s==undefined){s=1.70158}return r*(t/=i)*t*((s+1)*t-s)+n},easeOutBack:function(e,t,n,r,i,s){if(s==undefined){s=1.70158}return r*((t=t/i-1)*t*((s+1)*t+s)+1)+n},easeInOutBack:function(e,t,n,r,i,s){if(s==undefined){s=1.70158}if((t/=i/2)<1){return r/2*t*t*(((s*=1.525)+1)*t-s)+n}return r/2*((t-=2)*t*(((s*=1.525)+1)*t+s)+2)+n},easeInBounce:function(e,t,n,r,i){return r-jQuery.easing.easeOutBounce(e,i-t,0,r,i)+n},easeOutBounce:function(e,t,n,r,i){if((t/=i)<1/2.75){return r*7.5625*t*t+n}else{if(t<2/2.75){return r*(7.5625*(t-=1.5/2.75)*t+.75)+n}else{if(t<2.5/2.75){return r*(7.5625*(t-=2.25/2.75)*t+.9375)+n}else{return r*(7.5625*(t-=2.625/2.75)*t+.984375)+n}}}},easeInOutBounce:function(e,t,n,r,i){if(t<i/2){return jQuery.easing.easeInBounce(e,t*2,0,r,i)*.5+n}return jQuery.easing.easeOutBounce(e,t*2-i,0,r,i)*.5+r*.5+n}});(function(e){e.fn.flipCounter=function(t){function o(){var e=n.data("flipCounter");if(typeof e=="undefined"){return false}return true}function u(e){var t=n.data("flipCounter");var r=t[e];if(typeof r!=="undefined"){return r}return false}function f(e,t){var r=n.data("flipCounter");r[e]=t;n.data("flipCounter",r)}function l(){if(n.children('[name="'+u("counterFieldName")+'"]').length<1){n.append('<input type="hidden" name="'+u("counterFieldName")+'" value="'+u("number")+'" />')}var t=p();var r=m().length;if(r>t){for(i=0;i<r-t;i++){var s=e('<span class="'+u("digitClass")+'" style="'+g("0")+'" />');n.prepend(s)}}else{if(r<t){for(i=0;i<t-r;i++){n.children("."+u("digitClass")).first().remove()}}}n.find("."+u("digitClass")).each(function(){if(0==e(this).find("span").length){e(this).append('<span style="visibility:hidden">0</span>')}})}function c(){l();var t=m();var n=h();var r=0;e.each(n,function(n,i){digit=t.toString().charAt(r);e(this).attr("style",g(digit));e(this).find("span").text(digit.replace(" ","&nbsp;").toString());r++});v()}function h(){return n.children("."+u("digitClass"))}function p(){return h().length}function d(){var e=parseFloat(n.children('[name="'+u("counterFieldName")+'"]').val());if(e==e==false){return false}return e}function v(){n.children('[name="'+u("counterFieldName")+'"]').val(u("number"))}function m(){var t=u("number");if(typeof t!=="number"){e.error("Attempting to render non-numeric value.");return"0"}var n="";if(u("formatNumberOptions")){if(e.formatNumber){n=e.formatNumber(t,u("formatNumberOptions"))}else{e.error("The numberformatter jQuery plugin is not loaded. This plugin is required to use the formatNumberOptions setting.")}}else{if(t>=0){var r=u("numIntegralDigits");var i=r-t.toFixed().toString().length;for(var s=0;s<i;s++){n+="0"}n+=t.toFixed(u("numFractionalDigits"))}else{n="-"+Math.abs(t.toFixed(u("numFractionalDigits")))}}return n}function g(e){var t="height:"+u("digitHeight")+"px; width:"+u("digitWidth")+"px; display:inline-block; background-image:url('"+u("imagePath")+"'); background-repeat:no-repeat; ";var n=new Array;n["1"]=u("digitWidth")*0;n["2"]=u("digitWidth")*-1;n["3"]=u("digitWidth")*-2;n["4"]=u("digitWidth")*-3;n["5"]=u("digitWidth")*-4;n["6"]=u("digitWidth")*-5;n["7"]=u("digitWidth")*-6;n["8"]=u("digitWidth")*-7;n["9"]=u("digitWidth")*-8;n["0"]=u("digitWidth")*-9;n["."]=u("digitWidth")*-10;n["-"]=u("digitWidth")*-11;n[","]=u("digitWidth")*-12;n[" "]=u("digitWidth")*-13;if(e in n){return t+"background-position: "+n[e]+"px 0px;"}return t}function y(t){if(true==u("animating")){w()}if(typeof t!=="undefined"){t=e.extend(n.data("flipCounter"),t);n.data("flipCounter",t)}else{t=n.data("flipCounter")}if(false==u("start_time")){f("start_time",(new Date).getTime())}if(false==u("time")){f("time",0)}if(false==u("elapsed")){f("elapsed","0.0")}if(false==u("start_number")){f("start_number",u("number"));if(false==u("start_number")){f("start_number",0)}}b();var r=u("onAnimationStarted");if(typeof r=="function"){r.call(n,n)}}function b(){function l(){t+=10;r=Math.floor(t/10)/10;if(Math.round(r)==r){r+=".0"}f("elapsed",r);var u=(new Date).getTime()-e-t;var h=0;if(typeof a=="function"){h=a.apply(n,[false,t,i,s,o])}else{h=x(false,t,i,s,o)}f("number",h);f("time",t);c();if(t<o){f("interval",window.setTimeout(l,10-u))}else{w()}}var e=u("start_time");var t=u("time");var r=u("elapsed");var i=u("start_number");var s=u("end_number")-u("start_number");if(s==0){return false}var o=u("duration");var a=u("easing");f("animating",true);window.setTimeout(l,10)}function w(){if(false==u("animating")){return false}clearTimeout(u("interval"));f("start_time",false);f("start_number",false);f("end_number",false);f("time",0);f("animating",false);f("paused",false);var e=u("onAnimationStopped");if(typeof e=="function"){e.call(n,n)}}function E(){if(false==u("animating")||true==u("paused")){return false}clearTimeout(u("interval"));f("paused",true);var e=u("onAnimationPaused");if(typeof e=="function"){e.call(n,n)}}function S(){if(false==u("animating")||false==u("paused")){return false}f("paused",false);b();var e=u("onAnimationResumed");if(typeof e=="function"){e.call(n,n)}}function x(e,t,n,r,i){return t/i*r+n}var n=false;var r={number:0,numIntegralDigits:1,numFractionalDigits:0,digitClass:"counter-digit",counterFieldName:"counter-value",digitHeight:40,digitWidth:30,imagePath:plgroot+"img/flipCounter-medium.png",easing:false,duration:1e4,onAnimationStarted:false,onAnimationStopped:false,onAnimationPaused:false,onAnimationResumed:false,formatNumberOptions:false};var s={init:function(t){return this.each(function(){n=e(this);var i=e.extend(r,t);var s=n.data("flipCounter");t=e.extend(s,i);n.data("flipCounter",t);if(t.number===false||t.number==0){d()!==false?t.number=d():t.number=0;f("number",t.number)}f("animating",false);f("start_time",false);n.bind("startAnimation",function(e,t){y(t)});n.bind("pauseAnimation",function(e){E()});n.bind("resumeAnimation",function(e){S()});n.bind("stopAnimation",function(e){w()});n.htmlClean();c()})},renderCounter:function(t){return this.each(function(){n=e(this);if(!o()){e(this).flipCounter()}f("number",t);c()})},setNumber:function(t){return this.each(function(){n=e(this);if(!o()){e(this).flipCounter()}f("number",t);c()})},getNumber:function(){var t=false;this.each(t=function(){n=e(this);if(!o()){e(this).flipCounter()}t=u("number");return t});return t},startAnimation:function(t){return this.each(function(){n=e(this);if(!o()){e(this).flipCounter()}n.trigger("startAnimation",t)})},stopAnimation:function(){return this.each(function(){n=e(this);if(!o()){e(this).flipCounter()}n.trigger("stopAnimation")})},pauseAnimation:function(){return this.each(function(){n=e(this);if(!o()){e(this).flipCounter()}n.trigger("pauseAnimation")})},resumeAnimation:function(){return this.each(function(){n=e(this);if(!o()){e(this).flipCounter()}n.trigger("resumeAnimation")})}};if(s[t]){return s[t].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof t==="object"||!t){return s.init.apply(this,arguments)}else{e.error("Method "+t+" does not exist on jQuery.flipCounter")}}}})(jQuery);jQuery.fn.htmlClean=function(){this.contents().filter(function(){if(this.nodeType!=3){$(this).htmlClean();return false}else{return!/\S/.test(this.nodeValue)}}).remove()};$(function(){$(".jpbtn").first().addClass("orange");$(".jpbtn").click(function(){$(".jpbtn").removeClass("orange").addClass("green");$(this).addClass("orange")});var e=$(".message");$("#comparing").multiselect({header:i18n_compareHeaderText,click:function(t){if($(this).multiselect("widget").find("input:checked").length>3){e.addClass("error").removeClass("success").html(i18n_compareWarningText);return false}else{e.addClass("success").removeClass("error").html(i18n_compareWarningText2)}},position:{my:"left bottom",at:"left top"}});graph()});google.load("visualization","1.1",{packages:["corechart","controls"],language:i18n_ISO639lang});
	<?php
	exit();
	} else if(isset($_GET['graph_js_php']) && $_GET['graph_js_php'] == 'hotcold') {
	
	$siteroot = site_url('/');
	$plgroot = plugins_url( '/', __FILE__ );
	
	header("content-type: application/javascript");
	
	$checkAllText = __( 'Check all', 'jpgraph-i18n' );
	$uncheckAllText = __( 'Uncheck all', 'jpgraph-i18n' );
	$noneSelectedText = __( 'Select options', 'jpgraph-i18n' );
	$selectedText = __( '# selected', 'jpgraph-i18n' );
	$compareHeaderText = __( 'Compare up to 3 lottos', 'jpgraph-i18n' );
	$compareWarningText = __( 'You can compare up to 3 lottos only!', 'jpgraph-i18n' );
	$compareWarningText2 = __( 'Check a few boxes.', 'jpgraph-i18n' );
	$compareMin2lottos = __( 'Please select at least two or more lotteries to compare!', 'jpgraph-i18n' );
	$ISO639lang = __( 'en', 'jpgraph-i18n' );
	?>
	var siteroot = '<?=$siteroot;?>';
	
	var i18n_checkAllText = '<?=$checkAllText;?>';
	var i18n_uncheckAllText = '<?=$uncheckAllText;?>';
	var i18n_noneSelectedText = '<?=$noneSelectedText;?>';
	var i18n_selectedText = '<?=$selectedText;?>';
	var i18n_compareHeaderText = '<?=$compareHeaderText;?>';
	var i18n_compareWarningText = '<?=$compareWarningText;?>';
	var i18n_compareWarningText2 = '<?=$compareWarningText2;?>';
	var i18n_compareMin2lottos = '<?=$compareMin2lottos;?>';
	var i18n_ISO639lang = '<?=$ISO639lang;?>';
	
	(function(a){a.widget("ui.rangeSliderMouseTouch",a.ui.mouse,{_mouseInit:function(){var b=this;a.ui.mouse.prototype._mouseInit.apply(this);this._mouseDownEvent=!1;this.element.bind("touchstart."+this.widgetName,function(c){return b._touchStart(c)})},_mouseDestroy:function(){a(document).unbind("touchmove."+this.widgetName,this._touchMoveDelegate).unbind("touchend."+this.widgetName,this._touchEndDelegate);a.ui.mouse.prototype._mouseDestroy.apply(this)},_touchStart:function(e){e.which=1;e.preventDefault();this._fillTouchEvent(e);var c=this,f=this._mouseDownEvent;this._mouseDown(e);if(f!==this._mouseDownEvent){this._touchEndDelegate=function(b){c._touchEnd(b)},this._touchMoveDelegate=function(b){c._touchMove(b)},a(document).bind("touchmove."+this.widgetName,this._touchMoveDelegate).bind("touchend."+this.widgetName,this._touchEndDelegate)}},_touchEnd:function(b){this._fillTouchEvent(b);this._mouseUp(b);a(document).unbind("touchmove."+this.widgetName,this._touchMoveDelegate).unbind("touchend."+this.widgetName,this._touchEndDelegate);this._mouseDownEvent=!1;a(document).trigger("mouseup")},_touchMove:function(b){b.preventDefault();this._fillTouchEvent(b);return this._mouseMove(b)},_fillTouchEvent:function(d){var c;c=typeof d.targetTouches==="undefined"&&typeof d.changedTouches==="undefined"?d.originalEvent.targetTouches[0]||d.originalEvent.changedTouches[0]:d.targetTouches[0]||d.changedTouches[0];d.pageX=c.pageX;d.pageY=c.pageY}})})(jQuery);(function(a){a.widget("ui.rangeSliderDraggable",a.ui.rangeSliderMouseTouch,{cache:null,options:{containment:null},_create:function(){setTimeout(a.proxy(this._initElement,this),10)},_initElement:function(){this._mouseInit();this._cache()},_setOption:function(d,c){if(d=="containment"){this.options.containment=c===null||a(c).length==0?null:a(c)}},_mouseStart:function(b){this._cache();this.cache.click={left:b.pageX,top:b.pageY};this.cache.initialOffset=this.element.offset();this._triggerMouseEvent("mousestart");return !0},_mouseDrag:function(b){b=b.pageX-this.cache.click.left;b=this._constraintPosition(b+this.cache.initialOffset.left);this._applyPosition(b);this._triggerMouseEvent("sliderDrag");return !1},_mouseStop:function(){this._triggerMouseEvent("stop")},_constraintPosition:function(b){this.element.parent().length!==0&&this.cache.parent.offset!=null&&(b=Math.min(b,this.cache.parent.offset.left+this.cache.parent.width-this.cache.width.outer),b=Math.max(b,this.cache.parent.offset.left));return b},_applyPosition:function(d){var c={top:this.cache.offset.top,left:d};this.element.offset({left:d});this.cache.offset=c},_cacheIfNecessary:function(){this.cache===null&&this._cache()},_cache:function(){this.cache={};this._cacheMargins();this._cacheParent();this._cacheDimensions();this.cache.offset=this.element.offset()},_cacheMargins:function(){this.cache.margin={left:this._parsePixels(this.element,"marginLeft"),right:this._parsePixels(this.element,"marginRight"),top:this._parsePixels(this.element,"marginTop"),bottom:this._parsePixels(this.element,"marginBottom")}},_cacheParent:function(){if(this.options.parent!==null){var b=this.element.parent();this.cache.parent={offset:b.offset(),width:b.width()}}else{this.cache.parent=null}},_cacheDimensions:function(){this.cache.width={outer:this.element.outerWidth(),inner:this.element.width()}},_parsePixels:function(d,c){return parseInt(d.css(c),10)||0},_triggerMouseEvent:function(d){var c=this._prepareEventData();this.element.trigger(d,c)},_prepareEventData:function(){return{element:this.element,offset:this.cache.offset||null}}})})(jQuery);(function(a){a.widget("ui.rangeSliderBar",a.ui.rangeSliderDraggable,{options:{leftHandle:null,rightHandle:null,bounds:{min:0,max:100},type:"rangeSliderHandle",range:!1,drag:function(){},stop:function(){},values:{min:0,max:20},wheelSpeed:4,wheelMode:null},_values:{min:0,max:20},_waitingToInit:2,_wheelTimeout:!1,_create:function(){a.ui.rangeSliderDraggable.prototype._create.apply(this);this.element.css("position","absolute").css("top",0).addClass("ui-rangeSlider-bar");this.options.leftHandle.bind("initialize",a.proxy(this._onInitialized,this)).bind("mousestart",a.proxy(this._cache,this)).bind("stop",a.proxy(this._onHandleStop,this));this.options.rightHandle.bind("initialize",a.proxy(this._onInitialized,this)).bind("mousestart",a.proxy(this._cache,this)).bind("stop",a.proxy(this._onHandleStop,this));this._bindHandles();this._values=this.options.values;this._setWheelModeOption(this.options.wheelMode)},_setOption:function(d,c){d==="range"?this._setRangeOption(c):d==="wheelSpeed"?this._setWheelSpeedOption(c):d==="wheelMode"&&this._setWheelModeOption(c)},_setRangeOption:function(b){if(typeof b!="object"||b===null){b=!1}if(!(b===!1&&this.options.range===!1)){this.options.range=b!==!1?{min:typeof b.min==="undefined"?this.options.range.min||!1:b.min,max:typeof b.max==="undefined"?this.options.range.max||!1:b.max}:!1,this._setLeftRange(),this._setRightRange()}},_setWheelSpeedOption:function(b){if(typeof b==="number"&&b>0){this.options.wheelSpeed=b}},_setWheelModeOption:function(b){if(b===null||b===!1||b==="zoom"||b==="scroll"){this.options.wheelMode!==b&&this.element.parent().unbind("mousewheel.bar"),this._bindMouseWheel(b),this.options.wheelMode=b}},_bindMouseWheel:function(b){b==="zoom"?this.element.parent().bind("mousewheel.bar",a.proxy(this._mouseWheelZoom,this)):b==="scroll"&&this.element.parent().bind("mousewheel.bar",a.proxy(this._mouseWheelScroll,this))},_setLeftRange:function(){if(this.options.range==!1){return !1}var d=this._values.max,c={min:!1,max:!1};c.max=(this.options.range.min||!1)!==!1?this._leftHandle("substract",d,this.options.range.min):!1;c.min=(this.options.range.max||!1)!==!1?this._leftHandle("substract",d,this.options.range.max):!1;this._leftHandle("option","range",c)},_setRightRange:function(){var d=this._values.min,c={min:!1,max:!1};c.min=(this.options.range.min||!1)!==!1?this._rightHandle("add",d,this.options.range.min):!1;c.max=(this.options.range.max||!1)!==!1?this._rightHandle("add",d,this.options.range.max):!1;this._rightHandle("option","range",c)},_deactivateRange:function(){this._leftHandle("option","range",!1);this._rightHandle("option","range",!1)},_reactivateRange:function(){this._setRangeOption(this.options.range)},_onInitialized:function(){this._waitingToInit--;this._waitingToInit===0&&this._initMe()},_initMe:function(){this._cache();this.min(this._values.min);this.max(this._values.max);var d=this._leftHandle("position"),c=this._rightHandle("position")+this.options.rightHandle.width();this.element.offset({left:d});this.element.css("width",c-d)},_leftHandle:function(){return this._handleProxy(this.options.leftHandle,arguments)},_rightHandle:function(){return this._handleProxy(this.options.rightHandle,arguments)},_handleProxy:function(e,d){var f=Array.prototype.slice.call(d);return e[this.options.type].apply(e,f)},_cache:function(){a.ui.rangeSliderDraggable.prototype._cache.apply(this);this._cacheHandles()},_cacheHandles:function(){this.cache.rightHandle={};this.cache.rightHandle.width=this.options.rightHandle.width();this.cache.rightHandle.offset=this.options.rightHandle.offset();this.cache.leftHandle={};this.cache.leftHandle.offset=this.options.leftHandle.offset()},_mouseStart:function(b){a.ui.rangeSliderDraggable.prototype._mouseStart.apply(this,[b]);this._deactivateRange()},_mouseStop:function(b){a.ui.rangeSliderDraggable.prototype._mouseStop.apply(this,[b]);this._cacheHandles();this._values.min=this._leftHandle("value");this._values.max=this._rightHandle("value");this._reactivateRange();this._leftHandle().trigger("stop");this._rightHandle().trigger("stop")},_onDragLeftHandle:function(d,c){this._cacheIfNecessary();this._switchedValues()?(this._switchHandles(),this._onDragRightHandle(d,c)):(this._values.min=c.value,this.cache.offset.left=c.offset.left,this.cache.leftHandle.offset=c.offset,this._positionBar())},_onDragRightHandle:function(d,c){this._cacheIfNecessary();this._switchedValues()?(this._switchHandles(),this._onDragLeftHandle(d,c)):(this._values.max=c.value,this.cache.rightHandle.offset=c.offset,this._positionBar())},_positionBar:function(){var b=this.cache.rightHandle.offset.left+this.cache.rightHandle.width-this.cache.leftHandle.offset.left;this.cache.width.inner=b;this.element.css("width",b).offset({left:this.cache.leftHandle.offset.left})},_onHandleStop:function(){this._setLeftRange();this._setRightRange()},_switchedValues:function(){if(this.min()>this.max()){var b=this._values.min;this._values.min=this._values.max;this._values.max=b;return !0}return !1},_switchHandles:function(){var b=this.options.leftHandle;this.options.leftHandle=this.options.rightHandle;this.options.rightHandle=b;this._leftHandle("option","isLeft",!0);this._rightHandle("option","isLeft",!1);this._bindHandles();this._cacheHandles()},_bindHandles:function(){this.options.leftHandle.unbind(".bar").bind("sliderDrag.bar update.bar moving.bar",a.proxy(this._onDragLeftHandle,this));this.options.rightHandle.unbind(".bar").bind("sliderDrag.bar update.bar moving.bar",a.proxy(this._onDragRightHandle,this))},_constraintPosition:function(d){var c={};c.left=a.ui.rangeSliderDraggable.prototype._constraintPosition.apply(this,[d]);c.left=this._leftHandle("position",c.left);d=this._rightHandle("position",c.left+this.cache.width.outer-this.cache.rightHandle.width);c.width=d-c.left+this.cache.rightHandle.width;return c},_applyPosition:function(b){a.ui.rangeSliderDraggable.prototype._applyPosition.apply(this,[b.left]);this.element.width(b.width)},_mouseWheelZoom:function(f,c,h,g){f=this._values.min+(this._values.max-this._values.min)/2;c={};h={};this.options.range===!1||this.options.range.min===!1?(c.max=f,h.min=f):(c.max=f-this.options.range.min/2,h.min=f+this.options.range.min/2);if(this.options.range!==!1&&this.options.range.max!==!1){c.min=f-this.options.range.max/2,h.max=f+this.options.range.max/2}this._leftHandle("option","range",c);this._rightHandle("option","range",h);clearTimeout(this._wheelTimeout);this._wheelTimeout=setTimeout(a.proxy(this._wheelStop,this),200);this.zoomOut(g*this.options.wheelSpeed);return !1},_mouseWheelScroll:function(f,c,h,g){this._wheelTimeout===!1?this.startScroll():clearTimeout(this._wheelTimeout);this._wheelTimeout=setTimeout(a.proxy(this._wheelStop,this),200);this.scrollLeft(g*this.options.wheelSpeed);return !1},_wheelStop:function(){this.stopScroll();this._wheelTimeout=!1},min:function(b){return this._leftHandle("value",b)},max:function(b){return this._rightHandle("value",b)},startScroll:function(){this._deactivateRange()},stopScroll:function(){this._reactivateRange();this._triggerMouseEvent("stop");this._leftHandle().trigger("stop");this._rightHandle().trigger("stop")},scrollLeft:function(b){b=b||1;if(b<0){return this.scrollRight(-b)}b=this._leftHandle("moveLeft",b);this._rightHandle("moveLeft",b);this.update();this._triggerMouseEvent("scroll")},scrollRight:function(b){b=b||1;if(b<0){return this.scrollLeft(-b)}b=this._rightHandle("moveRight",b);this._leftHandle("moveRight",b);this.update();this._triggerMouseEvent("scroll")},zoomIn:function(d){d=d||1;if(d<0){return this.zoomOut(-d)}var c=this._rightHandle("moveLeft",d);d>c&&(c/=2,this._rightHandle("moveRight",c));this._leftHandle("moveRight",c);this.update();this._triggerMouseEvent("zoom")},zoomOut:function(d){d=d||1;if(d<0){return this.zoomIn(-d)}var c=this._rightHandle("moveRight",d);d>c&&(c/=2,this._rightHandle("moveLeft",c));this._leftHandle("moveLeft",c);this.update();this._triggerMouseEvent("zoom")},values:function(f,d){if(typeof f!=="undefined"&&typeof d!=="undefined"){var h=Math.min(f,d),g=Math.max(f,d);this._deactivateRange();this.options.leftHandle.unbind(".bar");this.options.rightHandle.unbind(".bar");this._values.min=this._leftHandle("value",h);this._values.max=this._rightHandle("value",g);this._bindHandles();this._reactivateRange();this.update()}return{min:this._values.min,max:this._values.max}},update:function(){this._values.min=this.min();this._values.max=this.max();this._cache();this._positionBar()}})})(jQuery);(function(d){function b(c,i,h,g){this.label1=c;this.label2=i;this.type=h;this.options=g;this.handle1=this.label1[this.type]("option","handle");this.handle2=this.label2[this.type]("option","handle");this.cache=null;this.left=c;this.right=i;this.updating=this.initialized=this.moving=!1;this.Init=function(){this.BindHandle(this.handle1);this.BindHandle(this.handle2);this.options.show==="show"?(setTimeout(d.proxy(this.PositionLabels,this),1),this.initialized=!0):setTimeout(d.proxy(this.AfterInit,this),1000)};this.AfterInit=function(){this.initialized=!0};this.Cache=function(){if(this.label1.css("display")!="none"){this.cache={},this.cache.label1={},this.cache.label2={},this.cache.handle1={},this.cache.handle2={},this.cache.offsetParent={},this.CacheElement(this.label1,this.cache.label1),this.CacheElement(this.label2,this.cache.label2),this.CacheElement(this.handle1,this.cache.handle1),this.CacheElement(this.handle2,this.cache.handle2),this.CacheElement(this.label1.offsetParent(),this.cache.offsetParent)}};this.CacheIfNecessary=function(){this.cache===null?this.Cache():(this.CacheWidth(this.label1,this.cache.label1),this.CacheWidth(this.label2,this.cache.label2),this.CacheHeight(this.label1,this.cache.label1),this.CacheHeight(this.label2,this.cache.label2),this.CacheWidth(this.label1.offsetParent(),this.cache.offsetParent))};this.CacheElement=function(f,e){this.CacheWidth(f,e);this.CacheHeight(f,e);e.offset=f.offset();e.margin={left:this.ParsePixels("marginLeft",f),right:this.ParsePixels("marginRight",f)};e.border={left:this.ParsePixels("borderLeftWidth",f),right:this.ParsePixels("borderRightWidth",f)}};this.CacheWidth=function(f,e){e.width=f.width();e.outerWidth=f.outerWidth()};this.CacheHeight=function(f,e){e.outerHeightMargin=f.outerHeight(!0)};this.ParsePixels=function(f,e){return parseInt(e.css(f),10)||0};this.BindHandle=function(e){e.bind("updating",d.proxy(this.onHandleUpdating,this));e.bind("update",d.proxy(this.onHandleUpdated,this));e.bind("moving",d.proxy(this.onHandleMoving,this));e.bind("stop",d.proxy(this.onHandleStop,this))};this.PositionLabels=function(){this.CacheIfNecessary();if(this.cache!=null){var f=this.GetRawPosition(this.cache.label1,this.cache.handle1),e=this.GetRawPosition(this.cache.label2,this.cache.handle2);this.ConstraintPositions(f,e);this.PositionLabel(this.label1,f.left,this.cache.label1);this.PositionLabel(this.label2,e.left,this.cache.label2)}};this.PositionLabel=function(f,e,k){var j=this.cache.offsetParent.offset.left+this.cache.offsetParent.border.left;j-e>=0?(f.css("right",""),f.offset({left:e})):(j+=this.cache.offsetParent.width,e=e+k.margin.left+k.outerWidth+k.margin.right,e=j-e,f.css("left",""),f.css("right",e))};this.ConstraintPositions=function(f,e){f.center<e.center&&f.outerRight>e.outerLeft?(f=this.getLeftPosition(f,e),this.getRightPosition(f,e)):f.center>e.center&&e.outerRight>f.outerLeft&&(e=this.getLeftPosition(e,f),this.getRightPosition(e,f))};this.getLeftPosition=function(f,e){f.left=(e.center+f.center)/2-f.cache.outerWidth-f.cache.margin.right+f.cache.border.left;return f};this.getRightPosition=function(f,e){e.left=(e.center+f.center)/2+e.cache.margin.left+e.cache.border.left;return e};this.ShowIfNecessary=function(){if(!(this.options.show==="show"||this.moving||!this.initialized||this.updating)){this.label1.stop(!0,!0).fadeIn(this.options.durationIn||0),this.label2.stop(!0,!0).fadeIn(this.options.durationIn||0),this.moving=!0}};this.HideIfNeeded=function(){if(this.moving===!0){this.label1.stop(!0,!0).delay(this.options.delayOut||0).fadeOut(this.options.durationOut||0),this.label2.stop(!0,!0).delay(this.options.delayOut||0).fadeOut(this.options.durationOut||0),this.moving=!1}};this.onHandleMoving=function(f,e){this.ShowIfNecessary();this.CacheIfNecessary();this.UpdateHandlePosition(e);this.PositionLabels()};this.onHandleUpdating=function(){this.updating=!0};this.onHandleUpdated=function(){this.updating=!1;this.cache=null};this.onHandleStop=function(){this.HideIfNeeded()};this.UpdateHandlePosition=function(e){this.cache!=null&&(e.element[0]==this.handle1[0]?this.UpdatePosition(e,this.cache.handle1):this.UpdatePosition(e,this.cache.handle2))};this.UpdatePosition=function(f,e){e.offset=f.offset};this.GetRawPosition=function(j,f){var m=f.offset.left+f.outerWidth/2,l=m-j.outerWidth/2,k=l-j.margin.left-j.border.left;return{left:l,outerLeft:k,top:f.offset.top-j.outerHeightMargin,right:l+j.outerWidth-j.border.left-j.border.right,outerRight:k+j.outerWidth+j.margin.left+j.margin.right,cache:j,center:m}};this.Init()}d.widget("ui.rangeSliderLabel",d.ui.rangeSliderMouseTouch,{options:{handle:null,formatter:!1,handleType:"rangeSliderHandle",show:"show",durationIn:0,durationOut:500,delayOut:500,isLeft:!1},cache:null,_positionner:null,_valueContainer:null,_innerElement:null,_create:function(){this.options.isLeft=this._handle("option","isLeft");this.element.addClass("ui-rangeSlider-label").css("position","absolute").css("display","block");this._valueContainer=d("<div class='ui-rangeSlider-label-value' />").appendTo(this.element);this._innerElement=d("<div class='ui-rangeSlider-label-inner' />").appendTo(this.element);this._toggleClass();this.options.handle.bind("moving",d.proxy(this._onMoving,this)).bind("update",d.proxy(this._onUpdate,this)).bind("switch",d.proxy(this._onSwitch,this));this.options.show!=="show"&&this.element.hide();this._mouseInit()},_handle:function(){return this.options.handle[this.options.handleType].apply(this.options.handle,Array.prototype.slice.apply(arguments))},_setOption:function(e,f){e==="show"?this._updateShowOption(f):(e==="durationIn"||e==="durationOut"||e==="delayOut")&&this._updateDurations(e,f)},_updateShowOption:function(c){this.options.show=c;this.options.show!=="show"?this.element.hide():(this.element.show(),this._display(this.options.handle[this.options.handleType]("value")),this._positionner.PositionLabels());this._positionner.options.show=this.options.show},_updateDurations:function(e,f){parseInt(f)===f&&(this._positionner.options[e]=f,this.options[e]=f)},_display:function(c){this.options.formatter==!1?this._displayText(Math.round(c)):this._displayText(this.options.formatter(c))},_displayText:function(c){this._valueContainer.text(c)},_toggleClass:function(){this.element.toggleClass("ui-rangeSlider-leftLabel",this.options.isLeft).toggleClass("ui-rangeSlider-rightLabel",!this.options.isLeft)},_mouseDown:function(c){this.options.handle.trigger(c)},_mouseUp:function(c){this.options.handle.trigger(c)},_mouseMove:function(c){this.options.handle.trigger(c)},_onMoving:function(e,f){this._display(f.value)},_onUpdate:function(){this.options.show==="show"&&this.update()},_onSwitch:function(e,f){this.options.isLeft=f;this._toggleClass();this._positionner.PositionLabels()},pair:function(a){if(this._positionner==null){this._positionner=new b(this.element,a,this.widgetName,{show:this.options.show,durationIn:this.options.durationIn,durationOut:this.options.durationOut,delayOut:this.options.delayOut}),a[this.widgetName]("positionner",this._positionner)}},positionner:function(c){if(typeof c!=="undefined"){this._positionner=c}return this._positionner},update:function(){this._positionner.cache=null;this._display(this._handle("value"));this.options.show=="show"&&this._positionner.PositionLabels()}})})(jQuery);(function(a){a.widget("ui.rangeSliderHandle",a.ui.rangeSliderDraggable,{currentMove:null,margin:0,parentElement:null,options:{isLeft:!0,bounds:{min:0,max:100},range:!1,value:0,step:!1},_value:0,_left:0,_create:function(){a.ui.rangeSliderDraggable.prototype._create.apply(this);this.element.css("position","absolute").css("top",0).addClass("ui-rangeSlider-handle").toggleClass("ui-rangeSlider-leftHandle",this.options.isLeft).toggleClass("ui-rangeSlider-rightHandle",!this.options.isLeft);this._value=this.options.value},_setOption:function(d,c){if(d==="isLeft"&&(c===!0||c===!1)&&c!=this.options.isLeft){this.options.isLeft=c,this.element.toggleClass("ui-rangeSlider-leftHandle",this.options.isLeft).toggleClass("ui-rangeSlider-rightHandle",!this.options.isLeft),this._position(this._value),this.element.trigger("switch",this.options.isLeft)}else{if(d==="step"&&this._checkStep(c)){this.options.step=c,this.update()}else{if(d==="bounds"){this.options.bounds=c,this.update()}else{if(d==="range"&&this._checkRange(c)){this.options.range=c,this.update()}}}}a.ui.rangeSliderDraggable.prototype._setOption.apply(this,[d,c])},_checkRange:function(b){return b===!1||(typeof b.min==="undefined"||b.min===!1||parseFloat(b.min)===b.min)&&(typeof b.max==="undefined"||b.max===!1||parseFloat(b.max)===b.max)},_checkStep:function(b){return b===!1||parseFloat(b)==b},_initElement:function(){a.ui.rangeSliderDraggable.prototype._initElement.apply(this);this.cache.parent.width===0||this.cache.parent.width===null?setTimeout(a.proxy(this._initElement,this),500):(this._position(this._value),this._triggerMouseEvent("initialize"))},_bounds:function(){return this.options.bounds},_cache:function(){a.ui.rangeSliderDraggable.prototype._cache.apply(this);this._cacheParent()},_cacheParent:function(){var b=this.element.parent();this.cache.parent={element:b,offset:b.offset(),padding:{left:this._parsePixels(b,"paddingLeft")},width:b.width()}},_position:function(b){this._applyPosition(this._getPositionForValue(b))},_constraintPosition:function(b){return this._getPositionForValue(this._getValueForPosition(b))},_applyPosition:function(b){a.ui.rangeSliderDraggable.prototype._applyPosition.apply(this,[b]);this._left=b;this._setValue(this._getValueForPosition(b));this._triggerMouseEvent("moving")},_prepareEventData:function(){var b=a.ui.rangeSliderDraggable.prototype._prepareEventData.apply(this);b.value=this._value;return b},_setValue:function(b){if(b!=this._value){this._value=b}},_constraintValue:function(e){e=Math.min(e,this._bounds().max);e=Math.max(e,this._bounds().min);e=this._round(e);if(this.options.range!==!1){var d=this.options.range.min||!1,f=this.options.range.max||!1;d!==!1&&(e=Math.max(e,this._round(d)));f!==!1&&(e=Math.min(e,this._round(f)))}return e},_round:function(b){if(this.options.step!==!1&&this.options.step>0){return Math.round(b/this.options.step)*this.options.step}return b},_getPositionForValue:function(b){if(this.cache.parent.offset==null){return 0}b=this._constraintValue(b);return(b-this.options.bounds.min)/(this.options.bounds.max-this.options.bounds.min)*(this.cache.parent.width-this.cache.width.outer)+this.cache.parent.offset.left},_getValueForPosition:function(b){return this._constraintValue(this._getRawValueForPositionAndBounds(b,this.options.bounds.min,this.options.bounds.max))},_getRawValueForPositionAndBounds:function(e,d,f){return(e-(this.cache.parent.offset==null?0:this.cache.parent.offset.left))/(this.cache.parent.width-this.cache.width.outer)*(f-d)+d},value:function(b){typeof b!="undefined"&&(this._cache(),b=this._constraintValue(b),this._position(b));return this._value},update:function(){this._cache();var d=this._constraintValue(this._value),c=this._getPositionForValue(d);d!=this._value?(this._triggerMouseEvent("updating"),this._position(d),this._triggerMouseEvent("update")):c!=this.cache.offset.left&&(this._triggerMouseEvent("updating"),this._position(d),this._triggerMouseEvent("update"))},position:function(b){typeof b!="undefined"&&(this._cache(),b=this._constraintPosition(b),this._applyPosition(b));return this._left},add:function(d,c){return d+c},substract:function(d,c){return d-c},stepsBetween:function(d,c){if(this.options.step===!1){return c-d}return(c-d)/this.options.step},multiplyStep:function(d,c){return d*c},moveRight:function(d){var c;if(this.options.step==!1){return c=this._left,this.position(this._left+d),this._left-c}c=this._value;this.value(this.add(c,this.multiplyStep(this.options.step,d)));return this.stepsBetween(c,this._value)},moveLeft:function(b){return -this.moveRight(-b)},stepRatio:function(){return this.options.step==!1?1:this.cache.parent.width/((this.options.bounds.max-this.options.bounds.min)/this.options.step)}})})(jQuery);(function(a){a.widget("ui.rangeSlider",{options:{bounds:{min:0,max:100},defaultValues:{min:20,max:50},wheelMode:null,wheelSpeed:4,arrows:!0,valueLabels:"show",formatter:null,durationIn:0,durationOut:400,delayOut:200,range:{min:!1,max:!1},step:!1},_values:null,_valuesChanged:!1,bar:null,leftHandle:null,rightHandle:null,innerBar:null,container:null,arrows:null,labels:null,changing:{min:!1,max:!1},changed:{min:!1,max:!1},_create:function(){this._values={min:this.options.defaultValues.min,max:this.options.defaultValues.max};this.labels={left:null,right:null,leftDisplayed:!0,rightDisplayed:!0};this.arrows={left:null,right:null};this.changing={min:!1,max:!1};this.changed={min:!1,max:!1};this.element.css("position")!=="absolute"&&this.element.css("position","relative");this.container=a("<div class='ui-rangeSlider-container' />").css("position","absolute").appendTo(this.element);this.innerBar=a("<div class='ui-rangeSlider-innerBar' />").css("position","absolute").css("top",0).css("left",0);this.leftHandle=this._createHandle({isLeft:!0,bounds:this.options.bounds,value:this._values.min,step:this.options.step}).appendTo(this.container);this.rightHandle=this._createHandle({isLeft:!1,bounds:this.options.bounds,value:this._values.max,step:this.options.step}).appendTo(this.container);this._createBar();this.container.prepend(this.innerBar);this.arrows.left=this._createArrow("left");this.arrows.right=this._createArrow("right");this.element.addClass("ui-rangeSlider");this.options.arrows?this.element.addClass("ui-rangeSlider-withArrows"):(this.arrows.left.css("display","none"),this.arrows.right.css("display","none"),this.element.addClass("ui-rangeSlider-noArrow"));this.options.valueLabels!=="hide"?this._createLabels():this._destroyLabels();this._bindResize();setTimeout(a.proxy(this.resize,this),1);setTimeout(a.proxy(this._initValues,this),1)},_bindResize:function(){var b=this;this._resizeProxy=function(c){b.resize(c)};a(window).resize(this._resizeProxy)},_initWidth:function(){this.container.css("width",this.element.width()-this.container.outerWidth(!0)+this.container.width());this.innerBar.css("width",this.container.width()-this.innerBar.outerWidth(!0)+this.innerBar.width())},_initValues:function(){this.values(this._values.min,this._values.max)},_setOption:function(d,c){if(d==="wheelMode"||d==="wheelSpeed"){this._bar("option",d,c),this.options[d]=this._bar("option",d)}else{if(d==="arrows"&&(c===!0||c===!1)&&c!==this.options.arrows){this._setArrowsOption(c)}else{if(d==="valueLabels"){this._setLabelsOption(c)}else{if(d==="durationIn"||d==="durationOut"||d==="delayOut"){this._setLabelsDurations(d,c)}else{if(d==="formatter"&&c!==null&&typeof c==="function"){this.options.formatter=c,this.options.valueLabels!=="hide"&&(this._destroyLabels(),this._createLabels())}else{if(d==="bounds"&&typeof c.min!=="undefined"&&typeof c.max!=="undefined"){this.bounds(c.min,c.max)}else{if(d==="range"){this._bar("option","range",c),this.options.range=this._bar("option","range"),this._changed(!0)}else{if(d==="step"){this.options.step=c,this._leftHandle("option","step",c),this._rightHandle("option","step",c),this._changed(!0)}}}}}}}}},_validProperty:function(e,d,f){if(e===null||typeof e[d]==="undefined"){return f}return e[d]},_setLabelsOption:function(b){if(!(b!=="hide"&&b!=="show"&&b!=="change")){this.options.valueLabels=b,b!=="hide"?(this._createLabels(),this._leftLabel("update"),this._rightLabel("update")):this._destroyLabels()}},_setArrowsOption:function(b){if(b===!0){this.element.removeClass("ui-rangeSlider-noArrow").addClass("ui-rangeSlider-withArrows"),this.arrows.left.css("display","block"),this.arrows.right.css("display","block"),this.options.arrows=!0}else{if(b===!1){this.element.addClass("ui-rangeSlider-noArrow").removeClass("ui-rangeSlider-withArrows"),this.arrows.left.css("display","none"),this.arrows.right.css("display","none"),this.options.arrows=!1}}this._initWidth()},_setLabelsDurations:function(d,c){parseInt(c,10)===c&&(this.labels.left!==null&&this._leftLabel("option",d,c),this.labels.right!==null&&this._rightLabel("option",d,c),this.options[d]=c)},_createHandle:function(b){return a("<div />")[this._handleType()](b).bind("sliderDrag",a.proxy(this._changing,this)).bind("stop",a.proxy(this._changed,this))},_createBar:function(){this.bar=a("<div />").prependTo(this.container).bind("sliderDrag scroll zoom",a.proxy(this._changing,this)).bind("stop",a.proxy(this._changed,this));this._bar({leftHandle:this.leftHandle,rightHandle:this.rightHandle,values:{min:this._values.min,max:this._values.max},type:this._handleType(),range:this.options.range,wheelMode:this.options.wheelMode,wheelSpeed:this.options.wheelSpeed});this.options.range=this._bar("option","range");this.options.wheelMode=this._bar("option","wheelMode");this.options.wheelSpeed=this._bar("option","wheelSpeed")},_createArrow:function(d){var c=a("<div class='ui-rangeSlider-arrow' />").append("<div class='ui-rangeSlider-arrow-inner' />").addClass("ui-rangeSlider-"+d+"Arrow").css("position","absolute").css(d,0).appendTo(this.element),d=d==="right"?a.proxy(this._scrollRightClick,this):a.proxy(this._scrollLeftClick,this);c.bind("mousedown touchstart",d);return c},_proxy:function(e,d,f){f=Array.prototype.slice.call(f);return e[d].apply(e,f)},_handleType:function(){return"rangeSliderHandle"},_barType:function(){return"rangeSliderBar"},_bar:function(){return this._proxy(this.bar,this._barType(),arguments)},_labelType:function(){return"rangeSliderLabel"},_leftLabel:function(){return this._proxy(this.labels.left,this._labelType(),arguments)},_rightLabel:function(){return this._proxy(this.labels.right,this._labelType(),arguments)},_leftHandle:function(){return this._proxy(this.leftHandle,this._handleType(),arguments)},_rightHandle:function(){return this._proxy(this.rightHandle,this._handleType(),arguments)},_getValue:function(d,c){c===this.rightHandle&&(d-=c.outerWidth());return d*(this.options.bounds.max-this.options.bounds.min)/(this.container.innerWidth()-c.outerWidth(!0))+this.options.bounds.min},_trigger:function(d){var c=this;setTimeout(function(){c.element.trigger(d,{label:c.element,values:c.values()})},1)},_changing:function(){if(this._updateValues()){this._trigger("valuesChanging"),this._valuesChanged=!0}},_changed:function(b){if(this._updateValues()||this._valuesChanged){this._trigger("valuesChanged"),b!==!0&&this._trigger("userValuesChanged"),this._valuesChanged=!1}},_updateValues:function(){var f=this._leftHandle("value"),d=this._rightHandle("value"),h=this._min(f,d),g=this._max(f,d),h=h!==this._values.min||g!==this._values.max;this._values.min=this._min(f,d);this._values.max=this._max(f,d);return h},_min:function(d,c){return Math.min(d,c)},_max:function(d,c){return Math.max(d,c)},_createLabel:function(e,c){var f;e===null?(f=this._getLabelConstructorParameters(e,c),e=a("<div />").appendTo(this.element)[this._labelType()](f)):(f=this._getLabelRefreshParameters(e,c),e[this._labelType()](f));return e},_getLabelConstructorParameters:function(d,c){return{handle:c,handleType:this._handleType(),formatter:this._getFormatter(),show:this.options.valueLabels,durationIn:this.options.durationIn,durationOut:this.options.durationOut,delayOut:this.options.delayOut}},_getLabelRefreshParameters:function(){return{formatter:this._getFormatter(),show:this.options.valueLabels,durationIn:this.options.durationIn,durationOut:this.options.durationOut,delayOut:this.options.delayOut}},_getFormatter:function(){if(this.options.formatter===!1||this.options.formatter===null){return this._defaultFormatter}return this.options.formatter},_defaultFormatter:function(b){return Math.round(b)},_destroyLabel:function(b){b!==null&&(b.remove(),b=null);return b},_createLabels:function(){this.labels.left=this._createLabel(this.labels.left,this.leftHandle);this.labels.right=this._createLabel(this.labels.right,this.rightHandle);this._leftLabel("pair",this.labels.right)},_destroyLabels:function(){this.labels.left=this._destroyLabel(this.labels.left);this.labels.right=this._destroyLabel(this.labels.right)},_stepRatio:function(){return this._leftHandle("stepRatio")},_scrollRightClick:function(b){b.preventDefault();this._bar("startScroll");this._bindStopScroll();this._continueScrolling("scrollRight",4*this._stepRatio(),1)},_continueScrolling:function(h,d,l,k){this._bar(h,l);k=k||5;k--;var j=this,i=Math.max(1,4/this._stepRatio());this._scrollTimeout=setTimeout(function(){k===0&&(d>16?d=Math.max(16,d/1.5):l=Math.min(i,l*2),k=5);j._continueScrolling(h,d,l,k)},d)},_scrollLeftClick:function(b){b.preventDefault();this._bar("startScroll");this._bindStopScroll();this._continueScrolling("scrollLeft",4*this._stepRatio(),1)},_bindStopScroll:function(){var b=this;this._stopScrollHandle=function(c){c.preventDefault();b._stopScroll()};a(document).bind("mouseup touchend",this._stopScrollHandle)},_stopScroll:function(){a(document).unbind("mouseup touchend",this._stopScrollHandle);this._bar("stopScroll");clearTimeout(this._scrollTimeout)},values:function(e,d){var f=this._bar("values",e,d);typeof e!=="undefined"&&typeof d!=="undefined"&&this._changed(!0);return f},min:function(b){this._values.min=this.values(b,this._values.max).min;return this._values.min},max:function(b){this._values.max=this.values(this._values.min,b).max;return this._values.max},bounds:function(d,c){typeof d!=="undefined"&&typeof c!=="undefined"&&parseFloat(d)===d&&parseFloat(c)===c&&d<c&&(this._setBounds(d,c),this._changed(!0));return this.options.bounds},_setBounds:function(d,c){this.options.bounds={min:d,max:c};this._leftHandle("option","bounds",this.options.bounds);this._rightHandle("option","bounds",this.options.bounds);this._bar("option","bounds",this.options.bounds)},zoomIn:function(b){this._bar("zoomIn",b)},zoomOut:function(b){this._bar("zoomOut",b)},scrollLeft:function(b){this._bar("startScroll");this._bar("scrollLeft",b);this._bar("stopScroll")},scrollRight:function(b){this._bar("startScroll");this._bar("scrollRight",b);this._bar("stopScroll")},resize:function(){this._initWidth();this._leftHandle("update");this._rightHandle("update")},destroy:function(){this.element.removeClass("ui-rangeSlider-withArrows").removeClass("ui-rangeSlider-noArrow");this.bar.detach();this.leftHandle.detach();this.rightHandle.detach();this.innerBar.detach();this.container.detach();this.arrows.left.detach();this.arrows.right.detach();this.element.removeClass("ui-rangeSlider");this._destroyLabels();delete this.options;a(window).unbind("resize",this._resizeProxy);a.Widget.prototype.destroy.apply(this,arguments)}})})(jQuery);(function(a){a.widget("ui.dateRangeSliderHandle",a.ui.rangeSliderHandle,{_steps:!1,_boundsValues:{},_create:function(){a.ui.rangeSliderHandle.prototype._create.apply(this);this._createBoundsValues()},_getValueForPosition:function(b){b=this._getRawValueForPositionAndBounds(b,this.options.bounds.min.valueOf(),this.options.bounds.max.valueOf());return this._constraintValue(new Date(b))},_setOption:function(d,c){d==="step"?(this.options.step=c,this._createSteps(),this.update()):(a.ui.rangeSliderHandle.prototype._setOption.apply(this,[d,c]),d==="bounds"&&this._createBoundsValues())},_createBoundsValues:function(){this._boundsValues={min:this.options.bounds.min.valueOf(),max:this.options.bounds.max.valueOf()}},_bounds:function(){return this._boundsValues},_createSteps:function(){if(this.options.step===!1||!this._isValidStep()){this._steps=!1}else{var f=new Date(this.options.bounds.min),d=new Date(this.options.bounds.max),h=f,g=0;for(this._steps=[];h<=d;){this._steps.push(h.valueOf()),h=this._addStep(f,g,this.options.step),g++}}},_isValidStep:function(){return typeof this.options.step==="object"},_addStep:function(e,d,f){e=new Date(e.valueOf());e=this._addThing(e,"FullYear",d,f.years);e=this._addThing(e,"Month",d,f.months);e=this._addThing(e,"Date",d,f.days);e=this._addThing(e,"Hours",d,f.hours);e=this._addThing(e,"Minutes",d,f.minutes);return e=this._addThing(e,"Seconds",d,f.seconds)},_addThing:function(f,d,h,g){if(h===0||(g||0)===0){return f}f["set"+d](f["get"+d]()+h*(g||0));return f},_round:function(e){if(this._steps===!1){return e}for(var d=this.options.bounds.min.valueOf(),f=Math.floor(this._steps.length*Math.max(0,(e-d)/(this.options.bounds.max.valueOf()-d)));this._steps[f]>e;){f--}for(;f+1<this._steps.length&&this._steps[f+1]<=e;){f++}if(f>=this._steps.length-1){return this._steps[this._steps.length-1]}else{if(f==0){return this._steps[0]}}d=this._steps[f];f=this._steps[f+1];if(e-d<f-e){return d}return f},update:function(){this._createBoundsValues();this._createSteps();a.ui.rangeSliderHandle.prototype.update.apply(this)},add:function(d,c){return this._addStep(new Date(d),1,c).valueOf()},substract:function(d,c){return this._addStep(new Date(d),-1,c).valueOf()},stepsBetween:function(i,d){if(this.options.step===!1){return val2-val1}var n=Math.min(i,d),m=Math.max(i,d),l=0,k=!1,j=i>d;for(this.add(n,this.options.step)-n<0&&(k=!0);n<m;){k?m=this.add(m,this.options.step):n=this.add(n,this.options.step),l++}return j?-l:l},multiplyStep:function(f,d){var h={},g;for(g in f){h[g]=f[g]*d}return h},stepRatio:function(){return this.options.step==!1?1:this.cache.parent.width/this._steps.length}})})(jQuery);(function(a){a.widget("ui.dateRangeSlider",a.ui.rangeSlider,{options:{bounds:{min:new Date(2010,0,1),max:new Date(2012,0,1)},defaultValues:{min:new Date(2010,1,11),max:new Date(2011,1,11)}},_create:function(){a.ui.rangeSlider.prototype._create.apply(this);this.element.addClass("ui-dateRangeSlider")},destroy:function(){this.element.removeClass("ui-dateRangeSlider");a.ui.rangeSlider.prototype.destroy.apply(this)},_setOption:function(d,c){(d==="defaultValues"||d==="bounds")&&typeof c!=="undefined"&&c!==null&&typeof c.min!=="undefined"&&typeof c.max!=="undefined"&&c.min instanceof Date&&c.max instanceof Date?a.ui.rangeSlider.prototype._setOption.apply(this,[d,{min:c.min.valueOf(),max:c.max.valueOf()}]):a.ui.rangeSlider.prototype._setOption.apply(this,this._toArray(arguments))},_handleType:function(){return"dateRangeSliderHandle"},option:function(d){if(d==="bounds"||d==="defaultValues"){var c=a.ui.rangeSlider.prototype.option.apply(this,arguments);return{min:new Date(c.min),max:new Date(c.max)}}return a.ui.rangeSlider.prototype.option.apply(this,this._toArray(arguments))},_defaultFormatter:function(e){var d=e.getMonth()+1,f=e.getDate();return""+e.getFullYear()+"-"+(d<10?"0"+d:d)+"-"+(f<10?"0"+f:f)},_getFormatter:function(){var b=this.options.formatter;if(this.options.formatter===!1||this.options.formatter===null){b=this._defaultFormatter}return function(c){return function(d){return c(new Date(d))}}(b)},values:function(e,c){var f=null,f=typeof e!=="undefined"&&typeof c!=="undefined"&&e instanceof Date&&c instanceof Date?a.ui.rangeSlider.prototype.values.apply(this,[e.valueOf(),c.valueOf()]):a.ui.rangeSlider.prototype.values.apply(this,this._toArray(arguments));return{min:new Date(f.min),max:new Date(f.max)}},min:function(b){if(typeof b!=="undefined"&&b instanceof Date){return new Date(a.ui.rangeSlider.prototype.min.apply(this,[b.valueOf()]))}return new Date(a.ui.rangeSlider.prototype.min.apply(this))},max:function(b){if(typeof b!=="undefined"&&b instanceof Date){return new Date(a.ui.rangeSlider.prototype.max.apply(this,[b.valueOf()]))}return new Date(a.ui.rangeSlider.prototype.max.apply(this))},bounds:function(e,c){var f;f=typeof e!=="undefined"&&e instanceof Date&&typeof c!=="undefined"&&c instanceof Date?a.ui.rangeSlider.prototype.bounds.apply(this,[e.valueOf(),c.valueOf()]):a.ui.rangeSlider.prototype.bounds.apply(this,this._toArray(arguments));return{min:new Date(f.min),max:new Date(f.max)}},_toArray:function(b){return Array.prototype.slice.call(b)}})})(jQuery);(function(a){a.widget("ui.editRangeSliderLabel",a.ui.rangeSliderLabel,{options:{type:"text",step:!1,id:""},_input:null,_text:"",_create:function(){a.ui.rangeSliderLabel.prototype._create.apply(this);this._createInput()},_setOption:function(d,c){d==="type"?this._setTypeOption(c):d==="step"&&this._setStepOption(c);a.ui.rangeSliderLabel.prototype._setOption.apply(this,[d,c])},_createInput:function(){this._input=a("<input type='"+this.options.type+"' />").addClass("ui-editRangeSlider-inputValue").appendTo(this._valueContainer);this._setInputName();this._input.bind("keyup",a.proxy(this._onKeyUp,this));this._input.blur(a.proxy(this._onChange,this));this.options.type==="number"&&(this.options.step!==!1&&this._input.attr("step",this.options.step),this._input.click(a.proxy(this._onChange,this)));this._input.val(this._text)},_setInputName:function(){this._input.attr("name",this.options.id+(this.options.isLeft?"left":"right"))},_onSwitch:function(d,c){a.ui.rangeSliderLabel.prototype._onSwitch.apply(this,[d,c]);this._setInputName()},_destroyInput:function(){this._input.detach();this._input=null},_onKeyUp:function(b){if(b.which==13){return this._onChange(b),!1}},_onChange:function(){var b=this._returnCheckedValue(this._input.val());b!==!1&&this._triggerValue(b)},_triggerValue:function(b){this.element.trigger("valueChange",[{isLeft:this.options.handle[this.options.handleType]("option","isLeft"),value:b}])},_returnCheckedValue:function(d){var c=parseFloat(d);if(isNaN(c)||c.toString()!=d){return !1}return c},_setTypeOption:function(b){if((b==="text"||b==="number")&&this.options.type!=b){this._destroyInput(),this.options.type=b,this._createInput()}},_setStepOption:function(b){this.options.step=b;this.options.type==="number"&&this._input.attr("step",b!==!1?b:"any")},_displayText:function(b){this._input.val(b);this._text=b}})})(jQuery);(function(a){a.widget("ui.editRangeSlider",a.ui.rangeSlider,{options:{type:"text",round:1},_create:function(){a.ui.rangeSlider.prototype._create.apply(this);this.element.addClass("ui-editRangeSlider")},destroy:function(){this.element.removeClass("ui-editRangeSlider");a.ui.rangeSlider.prototype.destroy.apply(this)},_setOption:function(d,c){(d==="type"||d==="step")&&this._setLabelOption(d,c);d==="type"&&(this.options[d]=this.labels.left===null?c:this._leftLabel("option",d));a.ui.rangeSlider.prototype._setOption.apply(this,[d,c])},_setLabelOption:function(d,c){this.labels.left!==null&&(this._leftLabel("option",d,c),this._rightLabel("option",d,c))},_labelType:function(){return"editRangeSliderLabel"},_createLabel:function(e,c){var f=a.ui.rangeSlider.prototype._createLabel.apply(this,[e,c]);e===null&&f.bind("valueChange",a.proxy(this._onValueChange,this));return f},_addPropertiesToParameter:function(b){b.type=this.options.type;b.step=this.options.step;b.id=this.element.attr("id");return b},_getLabelConstructorParameters:function(d,c){return this._addPropertiesToParameter(a.ui.rangeSlider.prototype._getLabelConstructorParameters.apply(this,[d,c]))},_getLabelRefreshParameters:function(d,c){return this._addPropertiesToParameter(a.ui.rangeSlider.prototype._getLabelRefreshParameters.apply(this,[d,c]))},_onValueChange:function(d,c){c.isLeft?this.min(c.value):this.max(c.value)}})})(jQuery);(function(a){a.widget("ui.rangeSliderMouseTouch",a.ui.mouse,{_mouseInit:function(){var b=this;a.ui.mouse.prototype._mouseInit.apply(this);this._mouseDownEvent=!1;this.element.bind("touchstart."+this.widgetName,function(c){return b._touchStart(c)})},_mouseDestroy:function(){a(document).unbind("touchmove."+this.widgetName,this._touchMoveDelegate).unbind("touchend."+this.widgetName,this._touchEndDelegate);a.ui.mouse.prototype._mouseDestroy.apply(this)},_touchStart:function(e){e.which=1;e.preventDefault();this._fillTouchEvent(e);var c=this,f=this._mouseDownEvent;this._mouseDown(e);if(f!==this._mouseDownEvent){this._touchEndDelegate=function(b){c._touchEnd(b)},this._touchMoveDelegate=function(b){c._touchMove(b)},a(document).bind("touchmove."+this.widgetName,this._touchMoveDelegate).bind("touchend."+this.widgetName,this._touchEndDelegate)}},_touchEnd:function(b){this._fillTouchEvent(b);this._mouseUp(b);a(document).unbind("touchmove."+this.widgetName,this._touchMoveDelegate).unbind("touchend."+this.widgetName,this._touchEndDelegate);this._mouseDownEvent=!1;a(document).trigger("mouseup")},_touchMove:function(b){b.preventDefault();this._fillTouchEvent(b);return this._mouseMove(b)},_fillTouchEvent:function(d){var c;c=typeof d.targetTouches==="undefined"&&typeof d.changedTouches==="undefined"?d.originalEvent.targetTouches[0]||d.originalEvent.changedTouches[0]:d.targetTouches[0]||d.changedTouches[0];d.pageX=c.pageX;d.pageY=c.pageY}})})(jQuery);(function(a){a.widget("ui.rangeSliderDraggable",a.ui.rangeSliderMouseTouch,{cache:null,options:{containment:null},_create:function(){setTimeout(a.proxy(this._initElement,this),10)},_initElement:function(){this._mouseInit();this._cache()},_setOption:function(d,c){if(d=="containment"){this.options.containment=c===null||a(c).length==0?null:a(c)}},_mouseStart:function(b){this._cache();this.cache.click={left:b.pageX,top:b.pageY};this.cache.initialOffset=this.element.offset();this._triggerMouseEvent("mousestart");return !0},_mouseDrag:function(b){b=b.pageX-this.cache.click.left;b=this._constraintPosition(b+this.cache.initialOffset.left);this._applyPosition(b);this._triggerMouseEvent("sliderDrag");return !1},_mouseStop:function(){this._triggerMouseEvent("stop")},_constraintPosition:function(b){this.element.parent().length!==0&&this.cache.parent.offset!=null&&(b=Math.min(b,this.cache.parent.offset.left+this.cache.parent.width-this.cache.width.outer),b=Math.max(b,this.cache.parent.offset.left));return b},_applyPosition:function(d){var c={top:this.cache.offset.top,left:d};this.element.offset({left:d});this.cache.offset=c},_cacheIfNecessary:function(){this.cache===null&&this._cache()},_cache:function(){this.cache={};this._cacheMargins();this._cacheParent();this._cacheDimensions();this.cache.offset=this.element.offset()},_cacheMargins:function(){this.cache.margin={left:this._parsePixels(this.element,"marginLeft"),right:this._parsePixels(this.element,"marginRight"),top:this._parsePixels(this.element,"marginTop"),bottom:this._parsePixels(this.element,"marginBottom")}},_cacheParent:function(){if(this.options.parent!==null){var b=this.element.parent();this.cache.parent={offset:b.offset(),width:b.width()}}else{this.cache.parent=null}},_cacheDimensions:function(){this.cache.width={outer:this.element.outerWidth(),inner:this.element.width()}},_parsePixels:function(d,c){return parseInt(d.css(c),10)||0},_triggerMouseEvent:function(d){var c=this._prepareEventData();this.element.trigger(d,c)},_prepareEventData:function(){return{element:this.element,offset:this.cache.offset||null}}})})(jQuery);(function(a){a.widget("ui.rangeSliderBar",a.ui.rangeSliderDraggable,{options:{leftHandle:null,rightHandle:null,bounds:{min:0,max:100},type:"rangeSliderHandle",range:!1,drag:function(){},stop:function(){},values:{min:0,max:20},wheelSpeed:4,wheelMode:null},_values:{min:0,max:20},_waitingToInit:2,_wheelTimeout:!1,_create:function(){a.ui.rangeSliderDraggable.prototype._create.apply(this);this.element.css("position","absolute").css("top",0).addClass("ui-rangeSlider-bar");this.options.leftHandle.bind("initialize",a.proxy(this._onInitialized,this)).bind("mousestart",a.proxy(this._cache,this)).bind("stop",a.proxy(this._onHandleStop,this));this.options.rightHandle.bind("initialize",a.proxy(this._onInitialized,this)).bind("mousestart",a.proxy(this._cache,this)).bind("stop",a.proxy(this._onHandleStop,this));this._bindHandles();this._values=this.options.values;this._setWheelModeOption(this.options.wheelMode)},_setOption:function(d,c){d==="range"?this._setRangeOption(c):d==="wheelSpeed"?this._setWheelSpeedOption(c):d==="wheelMode"&&this._setWheelModeOption(c)},_setRangeOption:function(b){if(typeof b!="object"||b===null){b=!1}if(!(b===!1&&this.options.range===!1)){this.options.range=b!==!1?{min:typeof b.min==="undefined"?this.options.range.min||!1:b.min,max:typeof b.max==="undefined"?this.options.range.max||!1:b.max}:!1,this._setLeftRange(),this._setRightRange()}},_setWheelSpeedOption:function(b){if(typeof b==="number"&&b>0){this.options.wheelSpeed=b}},_setWheelModeOption:function(b){if(b===null||b===!1||b==="zoom"||b==="scroll"){this.options.wheelMode!==b&&this.element.parent().unbind("mousewheel.bar"),this._bindMouseWheel(b),this.options.wheelMode=b}},_bindMouseWheel:function(b){b==="zoom"?this.element.parent().bind("mousewheel.bar",a.proxy(this._mouseWheelZoom,this)):b==="scroll"&&this.element.parent().bind("mousewheel.bar",a.proxy(this._mouseWheelScroll,this))},_setLeftRange:function(){if(this.options.range==!1){return !1}var d=this._values.max,c={min:!1,max:!1};c.max=(this.options.range.min||!1)!==!1?this._leftHandle("substract",d,this.options.range.min):!1;c.min=(this.options.range.max||!1)!==!1?this._leftHandle("substract",d,this.options.range.max):!1;this._leftHandle("option","range",c)},_setRightRange:function(){var d=this._values.min,c={min:!1,max:!1};c.min=(this.options.range.min||!1)!==!1?this._rightHandle("add",d,this.options.range.min):!1;c.max=(this.options.range.max||!1)!==!1?this._rightHandle("add",d,this.options.range.max):!1;this._rightHandle("option","range",c)},_deactivateRange:function(){this._leftHandle("option","range",!1);this._rightHandle("option","range",!1)},_reactivateRange:function(){this._setRangeOption(this.options.range)},_onInitialized:function(){this._waitingToInit--;this._waitingToInit===0&&this._initMe()},_initMe:function(){this._cache();this.min(this._values.min);this.max(this._values.max);var d=this._leftHandle("position"),c=this._rightHandle("position")+this.options.rightHandle.width();this.element.offset({left:d});this.element.css("width",c-d)},_leftHandle:function(){return this._handleProxy(this.options.leftHandle,arguments)},_rightHandle:function(){return this._handleProxy(this.options.rightHandle,arguments)},_handleProxy:function(e,d){var f=Array.prototype.slice.call(d);return e[this.options.type].apply(e,f)},_cache:function(){a.ui.rangeSliderDraggable.prototype._cache.apply(this);this._cacheHandles()},_cacheHandles:function(){this.cache.rightHandle={};this.cache.rightHandle.width=this.options.rightHandle.width();this.cache.rightHandle.offset=this.options.rightHandle.offset();this.cache.leftHandle={};this.cache.leftHandle.offset=this.options.leftHandle.offset()},_mouseStart:function(b){a.ui.rangeSliderDraggable.prototype._mouseStart.apply(this,[b]);this._deactivateRange()},_mouseStop:function(b){a.ui.rangeSliderDraggable.prototype._mouseStop.apply(this,[b]);this._cacheHandles();this._values.min=this._leftHandle("value");this._values.max=this._rightHandle("value");this._reactivateRange();this._leftHandle().trigger("stop");this._rightHandle().trigger("stop")},_onDragLeftHandle:function(d,c){this._cacheIfNecessary();this._switchedValues()?(this._switchHandles(),this._onDragRightHandle(d,c)):(this._values.min=c.value,this.cache.offset.left=c.offset.left,this.cache.leftHandle.offset=c.offset,this._positionBar())},_onDragRightHandle:function(d,c){this._cacheIfNecessary();this._switchedValues()?(this._switchHandles(),this._onDragLeftHandle(d,c)):(this._values.max=c.value,this.cache.rightHandle.offset=c.offset,this._positionBar())},_positionBar:function(){var b=this.cache.rightHandle.offset.left+this.cache.rightHandle.width-this.cache.leftHandle.offset.left;this.cache.width.inner=b;this.element.css("width",b).offset({left:this.cache.leftHandle.offset.left})},_onHandleStop:function(){this._setLeftRange();this._setRightRange()},_switchedValues:function(){if(this.min()>this.max()){var b=this._values.min;this._values.min=this._values.max;this._values.max=b;return !0}return !1},_switchHandles:function(){var b=this.options.leftHandle;this.options.leftHandle=this.options.rightHandle;this.options.rightHandle=b;this._leftHandle("option","isLeft",!0);this._rightHandle("option","isLeft",!1);this._bindHandles();this._cacheHandles()},_bindHandles:function(){this.options.leftHandle.unbind(".bar").bind("sliderDrag.bar update.bar moving.bar",a.proxy(this._onDragLeftHandle,this));this.options.rightHandle.unbind(".bar").bind("sliderDrag.bar update.bar moving.bar",a.proxy(this._onDragRightHandle,this))},_constraintPosition:function(d){var c={};c.left=a.ui.rangeSliderDraggable.prototype._constraintPosition.apply(this,[d]);c.left=this._leftHandle("position",c.left);d=this._rightHandle("position",c.left+this.cache.width.outer-this.cache.rightHandle.width);c.width=d-c.left+this.cache.rightHandle.width;return c},_applyPosition:function(b){a.ui.rangeSliderDraggable.prototype._applyPosition.apply(this,[b.left]);this.element.width(b.width)},_mouseWheelZoom:function(f,c,h,g){f=this._values.min+(this._values.max-this._values.min)/2;c={};h={};this.options.range===!1||this.options.range.min===!1?(c.max=f,h.min=f):(c.max=f-this.options.range.min/2,h.min=f+this.options.range.min/2);if(this.options.range!==!1&&this.options.range.max!==!1){c.min=f-this.options.range.max/2,h.max=f+this.options.range.max/2}this._leftHandle("option","range",c);this._rightHandle("option","range",h);clearTimeout(this._wheelTimeout);this._wheelTimeout=setTimeout(a.proxy(this._wheelStop,this),200);this.zoomOut(g*this.options.wheelSpeed);return !1},_mouseWheelScroll:function(f,c,h,g){this._wheelTimeout===!1?this.startScroll():clearTimeout(this._wheelTimeout);this._wheelTimeout=setTimeout(a.proxy(this._wheelStop,this),200);this.scrollLeft(g*this.options.wheelSpeed);return !1},_wheelStop:function(){this.stopScroll();this._wheelTimeout=!1},min:function(b){return this._leftHandle("value",b)},max:function(b){return this._rightHandle("value",b)},startScroll:function(){this._deactivateRange()},stopScroll:function(){this._reactivateRange();this._triggerMouseEvent("stop");this._leftHandle().trigger("stop");this._rightHandle().trigger("stop")},scrollLeft:function(b){b=b||1;if(b<0){return this.scrollRight(-b)}b=this._leftHandle("moveLeft",b);this._rightHandle("moveLeft",b);this.update();this._triggerMouseEvent("scroll")},scrollRight:function(b){b=b||1;if(b<0){return this.scrollLeft(-b)}b=this._rightHandle("moveRight",b);this._leftHandle("moveRight",b);this.update();this._triggerMouseEvent("scroll")},zoomIn:function(d){d=d||1;if(d<0){return this.zoomOut(-d)}var c=this._rightHandle("moveLeft",d);d>c&&(c/=2,this._rightHandle("moveRight",c));this._leftHandle("moveRight",c);this.update();this._triggerMouseEvent("zoom")},zoomOut:function(d){d=d||1;if(d<0){return this.zoomIn(-d)}var c=this._rightHandle("moveRight",d);d>c&&(c/=2,this._rightHandle("moveLeft",c));this._leftHandle("moveLeft",c);this.update();this._triggerMouseEvent("zoom")},values:function(f,d){if(typeof f!=="undefined"&&typeof d!=="undefined"){var h=Math.min(f,d),g=Math.max(f,d);this._deactivateRange();this.options.leftHandle.unbind(".bar");this.options.rightHandle.unbind(".bar");this._values.min=this._leftHandle("value",h);this._values.max=this._rightHandle("value",g);this._bindHandles();this._reactivateRange();this.update()}return{min:this._values.min,max:this._values.max}},update:function(){this._values.min=this.min();this._values.max=this.max();this._cache();this._positionBar()}})})(jQuery);(function(d){function b(c,i,h,g){this.label1=c;this.label2=i;this.type=h;this.options=g;this.handle1=this.label1[this.type]("option","handle");this.handle2=this.label2[this.type]("option","handle");this.cache=null;this.left=c;this.right=i;this.updating=this.initialized=this.moving=!1;this.Init=function(){this.BindHandle(this.handle1);this.BindHandle(this.handle2);this.options.show==="show"?(setTimeout(d.proxy(this.PositionLabels,this),1),this.initialized=!0):setTimeout(d.proxy(this.AfterInit,this),1000)};this.AfterInit=function(){this.initialized=!0};this.Cache=function(){if(this.label1.css("display")!="none"){this.cache={},this.cache.label1={},this.cache.label2={},this.cache.handle1={},this.cache.handle2={},this.cache.offsetParent={},this.CacheElement(this.label1,this.cache.label1),this.CacheElement(this.label2,this.cache.label2),this.CacheElement(this.handle1,this.cache.handle1),this.CacheElement(this.handle2,this.cache.handle2),this.CacheElement(this.label1.offsetParent(),this.cache.offsetParent)}};this.CacheIfNecessary=function(){this.cache===null?this.Cache():(this.CacheWidth(this.label1,this.cache.label1),this.CacheWidth(this.label2,this.cache.label2),this.CacheHeight(this.label1,this.cache.label1),this.CacheHeight(this.label2,this.cache.label2),this.CacheWidth(this.label1.offsetParent(),this.cache.offsetParent))};this.CacheElement=function(f,e){this.CacheWidth(f,e);this.CacheHeight(f,e);e.offset=f.offset();e.margin={left:this.ParsePixels("marginLeft",f),right:this.ParsePixels("marginRight",f)};e.border={left:this.ParsePixels("borderLeftWidth",f),right:this.ParsePixels("borderRightWidth",f)}};this.CacheWidth=function(f,e){e.width=f.width();e.outerWidth=f.outerWidth()};this.CacheHeight=function(f,e){e.outerHeightMargin=f.outerHeight(!0)};this.ParsePixels=function(f,e){return parseInt(e.css(f),10)||0};this.BindHandle=function(e){e.bind("updating",d.proxy(this.onHandleUpdating,this));e.bind("update",d.proxy(this.onHandleUpdated,this));e.bind("moving",d.proxy(this.onHandleMoving,this));e.bind("stop",d.proxy(this.onHandleStop,this))};this.PositionLabels=function(){this.CacheIfNecessary();if(this.cache!=null){var f=this.GetRawPosition(this.cache.label1,this.cache.handle1),e=this.GetRawPosition(this.cache.label2,this.cache.handle2);this.ConstraintPositions(f,e);this.PositionLabel(this.label1,f.left,this.cache.label1);this.PositionLabel(this.label2,e.left,this.cache.label2)}};this.PositionLabel=function(f,e,k){var j=this.cache.offsetParent.offset.left+this.cache.offsetParent.border.left;j-e>=0?(f.css("right",""),f.offset({left:e})):(j+=this.cache.offsetParent.width,e=e+k.margin.left+k.outerWidth+k.margin.right,e=j-e,f.css("left",""),f.css("right",e))};this.ConstraintPositions=function(f,e){f.center<e.center&&f.outerRight>e.outerLeft?(f=this.getLeftPosition(f,e),this.getRightPosition(f,e)):f.center>e.center&&e.outerRight>f.outerLeft&&(e=this.getLeftPosition(e,f),this.getRightPosition(e,f))};this.getLeftPosition=function(f,e){f.left=(e.center+f.center)/2-f.cache.outerWidth-f.cache.margin.right+f.cache.border.left;return f};this.getRightPosition=function(f,e){e.left=(e.center+f.center)/2+e.cache.margin.left+e.cache.border.left;return e};this.ShowIfNecessary=function(){if(!(this.options.show==="show"||this.moving||!this.initialized||this.updating)){this.label1.stop(!0,!0).fadeIn(this.options.durationIn||0),this.label2.stop(!0,!0).fadeIn(this.options.durationIn||0),this.moving=!0}};this.HideIfNeeded=function(){if(this.moving===!0){this.label1.stop(!0,!0).delay(this.options.delayOut||0).fadeOut(this.options.durationOut||0),this.label2.stop(!0,!0).delay(this.options.delayOut||0).fadeOut(this.options.durationOut||0),this.moving=!1}};this.onHandleMoving=function(f,e){this.ShowIfNecessary();this.CacheIfNecessary();this.UpdateHandlePosition(e);this.PositionLabels()};this.onHandleUpdating=function(){this.updating=!0};this.onHandleUpdated=function(){this.updating=!1;this.cache=null};this.onHandleStop=function(){this.HideIfNeeded()};this.UpdateHandlePosition=function(e){this.cache!=null&&(e.element[0]==this.handle1[0]?this.UpdatePosition(e,this.cache.handle1):this.UpdatePosition(e,this.cache.handle2))};this.UpdatePosition=function(f,e){e.offset=f.offset};this.GetRawPosition=function(j,f){var m=f.offset.left+f.outerWidth/2,l=m-j.outerWidth/2,k=l-j.margin.left-j.border.left;return{left:l,outerLeft:k,top:f.offset.top-j.outerHeightMargin,right:l+j.outerWidth-j.border.left-j.border.right,outerRight:k+j.outerWidth+j.margin.left+j.margin.right,cache:j,center:m}};this.Init()}d.widget("ui.rangeSliderLabel",d.ui.rangeSliderMouseTouch,{options:{handle:null,formatter:!1,handleType:"rangeSliderHandle",show:"show",durationIn:0,durationOut:500,delayOut:500,isLeft:!1},cache:null,_positionner:null,_valueContainer:null,_innerElement:null,_create:function(){this.options.isLeft=this._handle("option","isLeft");this.element.addClass("ui-rangeSlider-label").css("position","absolute").css("display","block");this._valueContainer=d("<div class='ui-rangeSlider-label-value' />").appendTo(this.element);this._innerElement=d("<div class='ui-rangeSlider-label-inner' />").appendTo(this.element);this._toggleClass();this.options.handle.bind("moving",d.proxy(this._onMoving,this)).bind("update",d.proxy(this._onUpdate,this)).bind("switch",d.proxy(this._onSwitch,this));this.options.show!=="show"&&this.element.hide();this._mouseInit()},_handle:function(){return this.options.handle[this.options.handleType].apply(this.options.handle,Array.prototype.slice.apply(arguments))},_setOption:function(e,f){e==="show"?this._updateShowOption(f):(e==="durationIn"||e==="durationOut"||e==="delayOut")&&this._updateDurations(e,f)},_updateShowOption:function(c){this.options.show=c;this.options.show!=="show"?this.element.hide():(this.element.show(),this._display(this.options.handle[this.options.handleType]("value")),this._positionner.PositionLabels());this._positionner.options.show=this.options.show},_updateDurations:function(e,f){parseInt(f)===f&&(this._positionner.options[e]=f,this.options[e]=f)},_display:function(c){this.options.formatter==!1?this._displayText(Math.round(c)):this._displayText(this.options.formatter(c))},_displayText:function(c){this._valueContainer.text(c)},_toggleClass:function(){this.element.toggleClass("ui-rangeSlider-leftLabel",this.options.isLeft).toggleClass("ui-rangeSlider-rightLabel",!this.options.isLeft)},_mouseDown:function(c){this.options.handle.trigger(c)},_mouseUp:function(c){this.options.handle.trigger(c)},_mouseMove:function(c){this.options.handle.trigger(c)},_onMoving:function(e,f){this._display(f.value)},_onUpdate:function(){this.options.show==="show"&&this.update()},_onSwitch:function(e,f){this.options.isLeft=f;this._toggleClass();this._positionner.PositionLabels()},pair:function(a){if(this._positionner==null){this._positionner=new b(this.element,a,this.widgetName,{show:this.options.show,durationIn:this.options.durationIn,durationOut:this.options.durationOut,delayOut:this.options.delayOut}),a[this.widgetName]("positionner",this._positionner)}},positionner:function(c){if(typeof c!=="undefined"){this._positionner=c}return this._positionner},update:function(){this._positionner.cache=null;this._display(this._handle("value"));this.options.show=="show"&&this._positionner.PositionLabels()}})})(jQuery);(function(a){a.widget("ui.rangeSliderHandle",a.ui.rangeSliderDraggable,{currentMove:null,margin:0,parentElement:null,options:{isLeft:!0,bounds:{min:0,max:100},range:!1,value:0,step:!1},_value:0,_left:0,_create:function(){a.ui.rangeSliderDraggable.prototype._create.apply(this);this.element.css("position","absolute").css("top",0).addClass("ui-rangeSlider-handle").toggleClass("ui-rangeSlider-leftHandle",this.options.isLeft).toggleClass("ui-rangeSlider-rightHandle",!this.options.isLeft);this._value=this.options.value},_setOption:function(d,c){if(d==="isLeft"&&(c===!0||c===!1)&&c!=this.options.isLeft){this.options.isLeft=c,this.element.toggleClass("ui-rangeSlider-leftHandle",this.options.isLeft).toggleClass("ui-rangeSlider-rightHandle",!this.options.isLeft),this._position(this._value),this.element.trigger("switch",this.options.isLeft)}else{if(d==="step"&&this._checkStep(c)){this.options.step=c,this.update()}else{if(d==="bounds"){this.options.bounds=c,this.update()}else{if(d==="range"&&this._checkRange(c)){this.options.range=c,this.update()}}}}a.ui.rangeSliderDraggable.prototype._setOption.apply(this,[d,c])},_checkRange:function(b){return b===!1||(typeof b.min==="undefined"||b.min===!1||parseFloat(b.min)===b.min)&&(typeof b.max==="undefined"||b.max===!1||parseFloat(b.max)===b.max)},_checkStep:function(b){return b===!1||parseFloat(b)==b},_initElement:function(){a.ui.rangeSliderDraggable.prototype._initElement.apply(this);this.cache.parent.width===0||this.cache.parent.width===null?setTimeout(a.proxy(this._initElement,this),500):(this._position(this._value),this._triggerMouseEvent("initialize"))},_bounds:function(){return this.options.bounds},_cache:function(){a.ui.rangeSliderDraggable.prototype._cache.apply(this);this._cacheParent()},_cacheParent:function(){var b=this.element.parent();this.cache.parent={element:b,offset:b.offset(),padding:{left:this._parsePixels(b,"paddingLeft")},width:b.width()}},_position:function(b){this._applyPosition(this._getPositionForValue(b))},_constraintPosition:function(b){return this._getPositionForValue(this._getValueForPosition(b))},_applyPosition:function(b){a.ui.rangeSliderDraggable.prototype._applyPosition.apply(this,[b]);this._left=b;this._setValue(this._getValueForPosition(b));this._triggerMouseEvent("moving")},_prepareEventData:function(){var b=a.ui.rangeSliderDraggable.prototype._prepareEventData.apply(this);b.value=this._value;return b},_setValue:function(b){if(b!=this._value){this._value=b}},_constraintValue:function(e){e=Math.min(e,this._bounds().max);e=Math.max(e,this._bounds().min);e=this._round(e);if(this.options.range!==!1){var d=this.options.range.min||!1,f=this.options.range.max||!1;d!==!1&&(e=Math.max(e,this._round(d)));f!==!1&&(e=Math.min(e,this._round(f)))}return e},_round:function(b){if(this.options.step!==!1&&this.options.step>0){return Math.round(b/this.options.step)*this.options.step}return b},_getPositionForValue:function(b){if(this.cache.parent.offset==null){return 0}b=this._constraintValue(b);return(b-this.options.bounds.min)/(this.options.bounds.max-this.options.bounds.min)*(this.cache.parent.width-this.cache.width.outer)+this.cache.parent.offset.left},_getValueForPosition:function(b){return this._constraintValue(this._getRawValueForPositionAndBounds(b,this.options.bounds.min,this.options.bounds.max))},_getRawValueForPositionAndBounds:function(e,d,f){return(e-(this.cache.parent.offset==null?0:this.cache.parent.offset.left))/(this.cache.parent.width-this.cache.width.outer)*(f-d)+d},value:function(b){typeof b!="undefined"&&(this._cache(),b=this._constraintValue(b),this._position(b));return this._value},update:function(){this._cache();var d=this._constraintValue(this._value),c=this._getPositionForValue(d);d!=this._value?(this._triggerMouseEvent("updating"),this._position(d),this._triggerMouseEvent("update")):c!=this.cache.offset.left&&(this._triggerMouseEvent("updating"),this._position(d),this._triggerMouseEvent("update"))},position:function(b){typeof b!="undefined"&&(this._cache(),b=this._constraintPosition(b),this._applyPosition(b));return this._left},add:function(d,c){return d+c},substract:function(d,c){return d-c},stepsBetween:function(d,c){if(this.options.step===!1){return c-d}return(c-d)/this.options.step},multiplyStep:function(d,c){return d*c},moveRight:function(d){var c;if(this.options.step==!1){return c=this._left,this.position(this._left+d),this._left-c}c=this._value;this.value(this.add(c,this.multiplyStep(this.options.step,d)));return this.stepsBetween(c,this._value)},moveLeft:function(b){return -this.moveRight(-b)},stepRatio:function(){return this.options.step==!1?1:this.cache.parent.width/((this.options.bounds.max-this.options.bounds.min)/this.options.step)}})})(jQuery);(function(a){a.widget("ui.rangeSlider",{options:{bounds:{min:0,max:100},defaultValues:{min:20,max:50},wheelMode:null,wheelSpeed:4,arrows:!0,valueLabels:"show",formatter:null,durationIn:0,durationOut:400,delayOut:200,range:{min:!1,max:!1},step:!1},_values:null,_valuesChanged:!1,bar:null,leftHandle:null,rightHandle:null,innerBar:null,container:null,arrows:null,labels:null,changing:{min:!1,max:!1},changed:{min:!1,max:!1},_create:function(){this._values={min:this.options.defaultValues.min,max:this.options.defaultValues.max};this.labels={left:null,right:null,leftDisplayed:!0,rightDisplayed:!0};this.arrows={left:null,right:null};this.changing={min:!1,max:!1};this.changed={min:!1,max:!1};this.element.css("position")!=="absolute"&&this.element.css("position","relative");this.container=a("<div class='ui-rangeSlider-container' />").css("position","absolute").appendTo(this.element);this.innerBar=a("<div class='ui-rangeSlider-innerBar' />").css("position","absolute").css("top",0).css("left",0);this.leftHandle=this._createHandle({isLeft:!0,bounds:this.options.bounds,value:this._values.min,step:this.options.step}).appendTo(this.container);this.rightHandle=this._createHandle({isLeft:!1,bounds:this.options.bounds,value:this._values.max,step:this.options.step}).appendTo(this.container);this._createBar();this.container.prepend(this.innerBar);this.arrows.left=this._createArrow("left");this.arrows.right=this._createArrow("right");this.element.addClass("ui-rangeSlider");this.options.arrows?this.element.addClass("ui-rangeSlider-withArrows"):(this.arrows.left.css("display","none"),this.arrows.right.css("display","none"),this.element.addClass("ui-rangeSlider-noArrow"));this.options.valueLabels!=="hide"?this._createLabels():this._destroyLabels();this._bindResize();setTimeout(a.proxy(this.resize,this),1);setTimeout(a.proxy(this._initValues,this),1)},_bindResize:function(){var b=this;this._resizeProxy=function(c){b.resize(c)};a(window).resize(this._resizeProxy)},_initWidth:function(){this.container.css("width",this.element.width()-this.container.outerWidth(!0)+this.container.width());this.innerBar.css("width",this.container.width()-this.innerBar.outerWidth(!0)+this.innerBar.width())},_initValues:function(){this.values(this._values.min,this._values.max)},_setOption:function(d,c){if(d==="wheelMode"||d==="wheelSpeed"){this._bar("option",d,c),this.options[d]=this._bar("option",d)}else{if(d==="arrows"&&(c===!0||c===!1)&&c!==this.options.arrows){this._setArrowsOption(c)}else{if(d==="valueLabels"){this._setLabelsOption(c)}else{if(d==="durationIn"||d==="durationOut"||d==="delayOut"){this._setLabelsDurations(d,c)}else{if(d==="formatter"&&c!==null&&typeof c==="function"){this.options.formatter=c,this.options.valueLabels!=="hide"&&(this._destroyLabels(),this._createLabels())}else{if(d==="bounds"&&typeof c.min!=="undefined"&&typeof c.max!=="undefined"){this.bounds(c.min,c.max)}else{if(d==="range"){this._bar("option","range",c),this.options.range=this._bar("option","range"),this._changed(!0)}else{if(d==="step"){this.options.step=c,this._leftHandle("option","step",c),this._rightHandle("option","step",c),this._changed(!0)}}}}}}}}},_validProperty:function(e,d,f){if(e===null||typeof e[d]==="undefined"){return f}return e[d]},_setLabelsOption:function(b){if(!(b!=="hide"&&b!=="show"&&b!=="change")){this.options.valueLabels=b,b!=="hide"?(this._createLabels(),this._leftLabel("update"),this._rightLabel("update")):this._destroyLabels()}},_setArrowsOption:function(b){if(b===!0){this.element.removeClass("ui-rangeSlider-noArrow").addClass("ui-rangeSlider-withArrows"),this.arrows.left.css("display","block"),this.arrows.right.css("display","block"),this.options.arrows=!0}else{if(b===!1){this.element.addClass("ui-rangeSlider-noArrow").removeClass("ui-rangeSlider-withArrows"),this.arrows.left.css("display","none"),this.arrows.right.css("display","none"),this.options.arrows=!1}}this._initWidth()},_setLabelsDurations:function(d,c){parseInt(c,10)===c&&(this.labels.left!==null&&this._leftLabel("option",d,c),this.labels.right!==null&&this._rightLabel("option",d,c),this.options[d]=c)},_createHandle:function(b){return a("<div />")[this._handleType()](b).bind("sliderDrag",a.proxy(this._changing,this)).bind("stop",a.proxy(this._changed,this))},_createBar:function(){this.bar=a("<div />").prependTo(this.container).bind("sliderDrag scroll zoom",a.proxy(this._changing,this)).bind("stop",a.proxy(this._changed,this));this._bar({leftHandle:this.leftHandle,rightHandle:this.rightHandle,values:{min:this._values.min,max:this._values.max},type:this._handleType(),range:this.options.range,wheelMode:this.options.wheelMode,wheelSpeed:this.options.wheelSpeed});this.options.range=this._bar("option","range");this.options.wheelMode=this._bar("option","wheelMode");this.options.wheelSpeed=this._bar("option","wheelSpeed")},_createArrow:function(d){var c=a("<div class='ui-rangeSlider-arrow' />").append("<div class='ui-rangeSlider-arrow-inner' />").addClass("ui-rangeSlider-"+d+"Arrow").css("position","absolute").css(d,0).appendTo(this.element),d=d==="right"?a.proxy(this._scrollRightClick,this):a.proxy(this._scrollLeftClick,this);c.bind("mousedown touchstart",d);return c},_proxy:function(e,d,f){f=Array.prototype.slice.call(f);return e[d].apply(e,f)},_handleType:function(){return"rangeSliderHandle"},_barType:function(){return"rangeSliderBar"},_bar:function(){return this._proxy(this.bar,this._barType(),arguments)},_labelType:function(){return"rangeSliderLabel"},_leftLabel:function(){return this._proxy(this.labels.left,this._labelType(),arguments)},_rightLabel:function(){return this._proxy(this.labels.right,this._labelType(),arguments)},_leftHandle:function(){return this._proxy(this.leftHandle,this._handleType(),arguments)},_rightHandle:function(){return this._proxy(this.rightHandle,this._handleType(),arguments)},_getValue:function(d,c){c===this.rightHandle&&(d-=c.outerWidth());return d*(this.options.bounds.max-this.options.bounds.min)/(this.container.innerWidth()-c.outerWidth(!0))+this.options.bounds.min},_trigger:function(d){var c=this;setTimeout(function(){c.element.trigger(d,{label:c.element,values:c.values()})},1)},_changing:function(){if(this._updateValues()){this._trigger("valuesChanging"),this._valuesChanged=!0}},_changed:function(b){if(this._updateValues()||this._valuesChanged){this._trigger("valuesChanged"),b!==!0&&this._trigger("userValuesChanged"),this._valuesChanged=!1}},_updateValues:function(){var f=this._leftHandle("value"),d=this._rightHandle("value"),h=this._min(f,d),g=this._max(f,d),h=h!==this._values.min||g!==this._values.max;this._values.min=this._min(f,d);this._values.max=this._max(f,d);return h},_min:function(d,c){return Math.min(d,c)},_max:function(d,c){return Math.max(d,c)},_createLabel:function(e,c){var f;e===null?(f=this._getLabelConstructorParameters(e,c),e=a("<div />").appendTo(this.element)[this._labelType()](f)):(f=this._getLabelRefreshParameters(e,c),e[this._labelType()](f));return e},_getLabelConstructorParameters:function(d,c){return{handle:c,handleType:this._handleType(),formatter:this._getFormatter(),show:this.options.valueLabels,durationIn:this.options.durationIn,durationOut:this.options.durationOut,delayOut:this.options.delayOut}},_getLabelRefreshParameters:function(){return{formatter:this._getFormatter(),show:this.options.valueLabels,durationIn:this.options.durationIn,durationOut:this.options.durationOut,delayOut:this.options.delayOut}},_getFormatter:function(){if(this.options.formatter===!1||this.options.formatter===null){return this._defaultFormatter}return this.options.formatter},_defaultFormatter:function(b){return Math.round(b)},_destroyLabel:function(b){b!==null&&(b.remove(),b=null);return b},_createLabels:function(){this.labels.left=this._createLabel(this.labels.left,this.leftHandle);this.labels.right=this._createLabel(this.labels.right,this.rightHandle);this._leftLabel("pair",this.labels.right)},_destroyLabels:function(){this.labels.left=this._destroyLabel(this.labels.left);this.labels.right=this._destroyLabel(this.labels.right)},_stepRatio:function(){return this._leftHandle("stepRatio")},_scrollRightClick:function(b){b.preventDefault();this._bar("startScroll");this._bindStopScroll();this._continueScrolling("scrollRight",4*this._stepRatio(),1)},_continueScrolling:function(h,d,l,k){this._bar(h,l);k=k||5;k--;var j=this,i=Math.max(1,4/this._stepRatio());this._scrollTimeout=setTimeout(function(){k===0&&(d>16?d=Math.max(16,d/1.5):l=Math.min(i,l*2),k=5);j._continueScrolling(h,d,l,k)},d)},_scrollLeftClick:function(b){b.preventDefault();this._bar("startScroll");this._bindStopScroll();this._continueScrolling("scrollLeft",4*this._stepRatio(),1)},_bindStopScroll:function(){var b=this;this._stopScrollHandle=function(c){c.preventDefault();b._stopScroll()};a(document).bind("mouseup touchend",this._stopScrollHandle)},_stopScroll:function(){a(document).unbind("mouseup touchend",this._stopScrollHandle);this._bar("stopScroll");clearTimeout(this._scrollTimeout)},values:function(e,d){var f=this._bar("values",e,d);typeof e!=="undefined"&&typeof d!=="undefined"&&this._changed(!0);return f},min:function(b){this._values.min=this.values(b,this._values.max).min;return this._values.min},max:function(b){this._values.max=this.values(this._values.min,b).max;return this._values.max},bounds:function(d,c){typeof d!=="undefined"&&typeof c!=="undefined"&&parseFloat(d)===d&&parseFloat(c)===c&&d<c&&(this._setBounds(d,c),this._changed(!0));return this.options.bounds},_setBounds:function(d,c){this.options.bounds={min:d,max:c};this._leftHandle("option","bounds",this.options.bounds);this._rightHandle("option","bounds",this.options.bounds);this._bar("option","bounds",this.options.bounds)},zoomIn:function(b){this._bar("zoomIn",b)},zoomOut:function(b){this._bar("zoomOut",b)},scrollLeft:function(b){this._bar("startScroll");this._bar("scrollLeft",b);this._bar("stopScroll")},scrollRight:function(b){this._bar("startScroll");this._bar("scrollRight",b);this._bar("stopScroll")},resize:function(){this._initWidth();this._leftHandle("update");this._rightHandle("update")},destroy:function(){this.element.removeClass("ui-rangeSlider-withArrows").removeClass("ui-rangeSlider-noArrow");this.bar.detach();this.leftHandle.detach();this.rightHandle.detach();this.innerBar.detach();this.container.detach();this.arrows.left.detach();this.arrows.right.detach();this.element.removeClass("ui-rangeSlider");this._destroyLabels();delete this.options;a(window).unbind("resize",this._resizeProxy);a.Widget.prototype.destroy.apply(this,arguments)}})})(jQuery);(function(a){a.widget("ui.dateRangeSliderHandle",a.ui.rangeSliderHandle,{_steps:!1,_boundsValues:{},_create:function(){a.ui.rangeSliderHandle.prototype._create.apply(this);this._createBoundsValues()},_getValueForPosition:function(b){b=this._getRawValueForPositionAndBounds(b,this.options.bounds.min.valueOf(),this.options.bounds.max.valueOf());return this._constraintValue(new Date(b))},_setOption:function(d,c){d==="step"?(this.options.step=c,this._createSteps(),this.update()):(a.ui.rangeSliderHandle.prototype._setOption.apply(this,[d,c]),d==="bounds"&&this._createBoundsValues())},_createBoundsValues:function(){this._boundsValues={min:this.options.bounds.min.valueOf(),max:this.options.bounds.max.valueOf()}},_bounds:function(){return this._boundsValues},_createSteps:function(){if(this.options.step===!1||!this._isValidStep()){this._steps=!1}else{var f=new Date(this.options.bounds.min),d=new Date(this.options.bounds.max),h=f,g=0;for(this._steps=[];h<=d;){this._steps.push(h.valueOf()),h=this._addStep(f,g,this.options.step),g++}}},_isValidStep:function(){return typeof this.options.step==="object"},_addStep:function(e,d,f){e=new Date(e.valueOf());e=this._addThing(e,"FullYear",d,f.years);e=this._addThing(e,"Month",d,f.months);e=this._addThing(e,"Date",d,f.days);e=this._addThing(e,"Hours",d,f.hours);e=this._addThing(e,"Minutes",d,f.minutes);return e=this._addThing(e,"Seconds",d,f.seconds)},_addThing:function(f,d,h,g){if(h===0||(g||0)===0){return f}f["set"+d](f["get"+d]()+h*(g||0));return f},_round:function(e){if(this._steps===!1){return e}for(var d=this.options.bounds.min.valueOf(),f=Math.floor(this._steps.length*Math.max(0,(e-d)/(this.options.bounds.max.valueOf()-d)));this._steps[f]>e;){f--}for(;f+1<this._steps.length&&this._steps[f+1]<=e;){f++}if(f>=this._steps.length-1){return this._steps[this._steps.length-1]}else{if(f==0){return this._steps[0]}}d=this._steps[f];f=this._steps[f+1];if(e-d<f-e){return d}return f},update:function(){this._createBoundsValues();this._createSteps();a.ui.rangeSliderHandle.prototype.update.apply(this)},add:function(d,c){return this._addStep(new Date(d),1,c).valueOf()},substract:function(d,c){return this._addStep(new Date(d),-1,c).valueOf()},stepsBetween:function(i,d){if(this.options.step===!1){return val2-val1}var n=Math.min(i,d),m=Math.max(i,d),l=0,k=!1,j=i>d;for(this.add(n,this.options.step)-n<0&&(k=!0);n<m;){k?m=this.add(m,this.options.step):n=this.add(n,this.options.step),l++}return j?-l:l},multiplyStep:function(f,d){var h={},g;for(g in f){h[g]=f[g]*d}return h},stepRatio:function(){return this.options.step==!1?1:this.cache.parent.width/this._steps.length}})})(jQuery);(function(a){a.widget("ui.dateRangeSlider",a.ui.rangeSlider,{options:{bounds:{min:new Date(2010,0,1),max:new Date(2012,0,1)},defaultValues:{min:new Date(2010,1,11),max:new Date(2011,1,11)}},_create:function(){a.ui.rangeSlider.prototype._create.apply(this);this.element.addClass("ui-dateRangeSlider")},destroy:function(){this.element.removeClass("ui-dateRangeSlider");a.ui.rangeSlider.prototype.destroy.apply(this)},_setOption:function(d,c){(d==="defaultValues"||d==="bounds")&&typeof c!=="undefined"&&c!==null&&typeof c.min!=="undefined"&&typeof c.max!=="undefined"&&c.min instanceof Date&&c.max instanceof Date?a.ui.rangeSlider.prototype._setOption.apply(this,[d,{min:c.min.valueOf(),max:c.max.valueOf()}]):a.ui.rangeSlider.prototype._setOption.apply(this,this._toArray(arguments))},_handleType:function(){return"dateRangeSliderHandle"},option:function(d){if(d==="bounds"||d==="defaultValues"){var c=a.ui.rangeSlider.prototype.option.apply(this,arguments);return{min:new Date(c.min),max:new Date(c.max)}}return a.ui.rangeSlider.prototype.option.apply(this,this._toArray(arguments))},_defaultFormatter:function(e){var d=e.getMonth()+1,f=e.getDate();return""+e.getFullYear()+"-"+(d<10?"0"+d:d)+"-"+(f<10?"0"+f:f)},_getFormatter:function(){var b=this.options.formatter;if(this.options.formatter===!1||this.options.formatter===null){b=this._defaultFormatter}return function(c){return function(d){return c(new Date(d))}}(b)},values:function(e,c){var f=null,f=typeof e!=="undefined"&&typeof c!=="undefined"&&e instanceof Date&&c instanceof Date?a.ui.rangeSlider.prototype.values.apply(this,[e.valueOf(),c.valueOf()]):a.ui.rangeSlider.prototype.values.apply(this,this._toArray(arguments));return{min:new Date(f.min),max:new Date(f.max)}},min:function(b){if(typeof b!=="undefined"&&b instanceof Date){return new Date(a.ui.rangeSlider.prototype.min.apply(this,[b.valueOf()]))}return new Date(a.ui.rangeSlider.prototype.min.apply(this))},max:function(b){if(typeof b!=="undefined"&&b instanceof Date){return new Date(a.ui.rangeSlider.prototype.max.apply(this,[b.valueOf()]))}return new Date(a.ui.rangeSlider.prototype.max.apply(this))},bounds:function(e,c){var f;f=typeof e!=="undefined"&&e instanceof Date&&typeof c!=="undefined"&&c instanceof Date?a.ui.rangeSlider.prototype.bounds.apply(this,[e.valueOf(),c.valueOf()]):a.ui.rangeSlider.prototype.bounds.apply(this,this._toArray(arguments));return{min:new Date(f.min),max:new Date(f.max)}},_toArray:function(b){return Array.prototype.slice.call(b)}})})(jQuery);(function(a){a.widget("ui.editRangeSliderLabel",a.ui.rangeSliderLabel,{options:{type:"text",step:!1,id:""},_input:null,_text:"",_create:function(){a.ui.rangeSliderLabel.prototype._create.apply(this);this._createInput()},_setOption:function(d,c){d==="type"?this._setTypeOption(c):d==="step"&&this._setStepOption(c);a.ui.rangeSliderLabel.prototype._setOption.apply(this,[d,c])},_createInput:function(){this._input=a("<input type='"+this.options.type+"' />").addClass("ui-editRangeSlider-inputValue").appendTo(this._valueContainer);this._setInputName();this._input.bind("keyup",a.proxy(this._onKeyUp,this));this._input.blur(a.proxy(this._onChange,this));this.options.type==="number"&&(this.options.step!==!1&&this._input.attr("step",this.options.step),this._input.click(a.proxy(this._onChange,this)));this._input.val(this._text)},_setInputName:function(){this._input.attr("name",this.options.id+(this.options.isLeft?"left":"right"))},_onSwitch:function(d,c){a.ui.rangeSliderLabel.prototype._onSwitch.apply(this,[d,c]);this._setInputName()},_destroyInput:function(){this._input.detach();this._input=null},_onKeyUp:function(b){if(b.which==13){return this._onChange(b),!1}},_onChange:function(){var b=this._returnCheckedValue(this._input.val());b!==!1&&this._triggerValue(b)},_triggerValue:function(b){this.element.trigger("valueChange",[{isLeft:this.options.handle[this.options.handleType]("option","isLeft"),value:b}])},_returnCheckedValue:function(d){var c=parseFloat(d);if(isNaN(c)||c.toString()!=d){return !1}return c},_setTypeOption:function(b){if((b==="text"||b==="number")&&this.options.type!=b){this._destroyInput(),this.options.type=b,this._createInput()}},_setStepOption:function(b){this.options.step=b;this.options.type==="number"&&this._input.attr("step",b!==!1?b:"any")},_displayText:function(b){this._input.val(b);this._text=b}})})(jQuery);(function(a){a.widget("ui.editRangeSlider",a.ui.rangeSlider,{options:{type:"text",round:1},_create:function(){a.ui.rangeSlider.prototype._create.apply(this);this.element.addClass("ui-editRangeSlider")},destroy:function(){this.element.removeClass("ui-editRangeSlider");a.ui.rangeSlider.prototype.destroy.apply(this)},_setOption:function(d,c){(d==="type"||d==="step")&&this._setLabelOption(d,c);d==="type"&&(this.options[d]=this.labels.left===null?c:this._leftLabel("option",d));a.ui.rangeSlider.prototype._setOption.apply(this,[d,c])},_setLabelOption:function(d,c){this.labels.left!==null&&(this._leftLabel("option",d,c),this._rightLabel("option",d,c))},_labelType:function(){return"editRangeSliderLabel"},_createLabel:function(e,c){var f=a.ui.rangeSlider.prototype._createLabel.apply(this,[e,c]);e===null&&f.bind("valueChange",a.proxy(this._onValueChange,this));return f},_addPropertiesToParameter:function(b){b.type=this.options.type;b.step=this.options.step;b.id=this.element.attr("id");return b},_getLabelConstructorParameters:function(d,c){return this._addPropertiesToParameter(a.ui.rangeSlider.prototype._getLabelConstructorParameters.apply(this,[d,c]))},_getLabelRefreshParameters:function(d,c){return this._addPropertiesToParameter(a.ui.rangeSlider.prototype._getLabelRefreshParameters.apply(this,[d,c]))},_onValueChange:function(d,c){c.isLeft?this.min(c.value):this.max(c.value)}})})(jQuery);(function(b){b.tooltipsy=function(d,a){this.options=a;this.$el=b(d);this.title=this.$el.attr("title")||"";this.$el.attr("title","");this.random=parseInt(Math.random()*10000);this.ready=false;this.shown=false;this.width=0;this.height=0;this.delaytimer=null;this.$el.data("tooltipsy",this);this.init()};b.tooltipsy.prototype.init=function(){var a=this;a.settings=b.extend({},a.defaults,a.options);a.settings.delay=parseInt(a.settings.delay);if(typeof a.settings.content==="function"){a.readify()}a.$el.bind("mouseenter",function(d){if(a.settings.delay>0){a.delaytimer=window.setTimeout(function(){a.enter(d)},a.settings.delay)}else{a.enter(d)}}).bind("mouseleave",function(d){window.clearTimeout(a.delaytimer);a.delaytimer=null;a.leave(d)})};b.tooltipsy.prototype.enter=function(e){var g=this;if(g.ready===false){g.readify()}if(g.shown===false){if((function(c){var d=0,f;for(f in c){if(c.hasOwnProperty(f)){d++}}return d})(g.settings.css)>0){g.$tip.css(g.settings.css)}g.width=g.$tipsy.outerWidth();g.height=g.$tipsy.outerHeight()}if(g.settings.alignTo==="cursor"){var h=[e.pageX+g.settings.offset[0],e.pageY+g.settings.offset[1]];if(h[0]+g.width>b(window).width()){var a={top:h[1]+"px",right:h[0]+"px",left:"auto"}}else{var a={top:h[1]+"px",left:h[0]+"px",right:"auto"}}}else{var h=[(function(c){if(g.settings.offset[0]<0){return c.left-Math.abs(g.settings.offset[0])-g.width}else{if(g.settings.offset[0]===0){return c.left-((g.width-g.$el.outerWidth())/2)}else{return c.left+g.$el.outerWidth()+g.settings.offset[0]}}})(g.offset(g.$el[0])),(function(c){if(g.settings.offset[1]<0){return c.top-Math.abs(g.settings.offset[1])-g.height}else{if(g.settings.offset[1]===0){return c.top-((g.height-g.$el.outerHeight())/2)}else{return c.top+g.$el.outerHeight()+g.settings.offset[1]}}})(g.offset(g.$el[0]))]}g.$tipsy.css({top:h[1]+"px",left:h[0]+"px"});g.settings.show(e,g.$tipsy.stop(true,true))};b.tooltipsy.prototype.leave=function(d){var a=this;if(d.relatedTarget===a.$tip[0]){a.$tip.bind("mouseleave",function(c){if(c.relatedTarget===a.$el[0]){return}a.settings.hide(c,a.$tipsy.stop(true,true))});return}a.settings.hide(d,a.$tipsy.stop(true,true))};b.tooltipsy.prototype.readify=function(){this.ready=true;this.$tipsy=b('<div id="tooltipsy'+this.random+'" style="position:absolute;z-index:2147483647;display:none">').appendTo("body");this.$tip=b('<div class="'+this.settings.className+'">').appendTo(this.$tipsy).html(this.settings.content!=""?this.settings.content:this.title);this.$tip.data("rootel",this.$el)};b.tooltipsy.prototype.offset=function(d){var a=ot=0;if(d.offsetParent){do{if(d.tagName!="BODY"){a+=d.offsetLeft-d.scrollLeft;ot+=d.offsetTop-d.scrollTop}}while(d=d.offsetParent)}return{left:a,top:ot}};b.tooltipsy.prototype.defaults={alignTo:"element",offset:[0,-1],content:"",show:function(d,a){a.fadeIn(100)},hide:function(d,a){a.fadeOut(100)},css:{},className:"tooltipsy",delay:200};b.fn.tooltipsy=function(a){return this.each(function(){new b.tooltipsy(this,a)})}})(jQuery);$(function(){$(".jpbtn").first().addClass("orange");$(".jpbtn").click(function(){$(".jpbtn").removeClass("orange").addClass("green");$(this).addClass("orange")});chooselotto("mm");$("#slider").bind("valuesChanged",function(b,a){hotcold(lotto,a.values.min,a.values.max)})});google.load("visualization","1.1",{packages:["corechart","controls"],language:i18n_ISO639lang});function chooselotto(a,c,b){var c=Math.round(c);var b=Math.round(b);if(isNaN(c)){var c=""}if(isNaN(b)){var b=""}$.ajax({url:siteroot+"?graph_js_php_db=true&view=hotcold&chooselotto=yes&lotto="+a+"&from="+c+"&to="+b,dataType:"script"})}function hotcold(a,c,b){var c=Math.round(c);var b=Math.round(b);if(isNaN(c)){var c=""}if(isNaN(b)){var b=""}$.ajax({url:siteroot+"?graph_js_php_db=true&view=hotcold&lotto="+a+"&from="+c+"&to="+b,dataType:"script"})}function toggle(a){if(a=="jp"){$("#predictedjps").show();$("#hotcold").hide()}else{if(a=="hc"){$("#predictedjps").hide();$("#hotcold").show();chooselotto("mm")}}}function graph(a){$.ajax({url:siteroot+"?graph_js_php_db=true&lotto="+a,dataType:"script",async:false})}function compare(){var a=$("select[id='comparing']").val();if(!a){alert(i18n_compareMin2lottos)}else{graph(a)}};
	<?php
	exit();
	}
}

add_action('init', 'graph_js_php_db');

function graph_js_php_db() {

	if(isset($_GET['graph_js_php_db'])) {
	
	$wpdb = new wpdb('lotteryp_read_db','V2w4Zru5qQFnS5fh','lottexpo','localhost'); // Lotterypros.com DB to get the data
	//$wpdb = new wpdb('root','','lp_last','localhost'); // for localhost usage only
	
	$lot = $_GET['lotto'];
	
	if ($lot == 'mm') {
	$total_lotto_numbers = 56;
	$total_stars_numbers = 46;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'pb') {
	$total_lotto_numbers = 59;
	$total_stars_numbers = 35;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'em') {
	$total_lotto_numbers = 50;
	$total_stars_numbers = 11;
	$picks = 5;
	$stars = 2;
	} else if ($lot == 'pa') {
	$total_lotto_numbers = 45;
	$total_stars_numbers = 45;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'hl') {
	$total_lotto_numbers = 39;
	$total_stars_numbers = 19;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'eg') {
	$total_lotto_numbers = 54;
	$total_stars_numbers = 10;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'fr') {
	$total_lotto_numbers = 49;
	$total_stars_numbers = 10;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'uk') {
	$total_lotto_numbers = 49;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'cs') {
	$total_lotto_numbers = 47;
	$total_stars_numbers = 27;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'oz') {
	$total_lotto_numbers = 45;
	$total_stars_numbers = 0;
	$picks = 7;
	$stars = 0;
	} else if ($lot == '49') {
	$total_lotto_numbers = 49;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'ho') {
	$total_lotto_numbers = 48;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'ny') {
	$total_lotto_numbers = 59;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'fl') {
	$total_lotto_numbers = 53;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'ms') {
	$total_lotto_numbers = 60;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'ie') {
	$total_lotto_numbers = 45;
	$total_stars_numbers = 1;
	$picks = 7;
	$stars = 45;
	} else if ($lot == 'tb') {
	$total_lotto_numbers = 39;
	$total_stars_numbers = 14;
	$picks = 5;
	$stars = 1;
	} else if ($lot == 'se') {
	$total_lotto_numbers = 90;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'de') {
	$total_lotto_numbers = 49;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	} else if ($lot == 'lp') {
	$total_lotto_numbers = 49;
	$total_stars_numbers = 0;
	$picks = 6;
	$stars = 0;
	}
	
	$ExtraNumbers = __( 'Extra numbers:', 'jpgraph-i18n' );
	$noExtraNumbers = __( 'This lotto do not have additional extra numbers!', 'jpgraph-i18n' );
	$drawnTimes = __( 'Drawn Times', 'jpgraph-i18n' );
	$ColdNumber = __( 'Cold number', 'jpgraph-i18n' );
	$HotNumber = __( 'Hot number', 'jpgraph-i18n' );
	$axisTitle = __( 'Lotto Numbers', 'jpgraph-i18n' );
	$drawNo = __( 'Draw No: ', 'jpgraph-i18n' );
	
	if (isset($_GET) && $_GET['view'] == 'hotcold') {
	
		if($_GET['from'] != '' && $_GET['to'] != '') {
		$from = (int)$_GET['from'];
		$to = (int)$_GET['to'];	
		$limit = 'LIMIT '.$from.', '.$to;
		} else {
		$limit = '';
		}
		
		if($_GET['chooselotto'] == 'yes')
		$chooselotto = true;
		
	$results = $wpdb->get_results("SELECT jpdate, n1, n2, n3, n4, n5, n6, n7, n8, n9 FROM `jackpots` WHERE `lotto` = '$lot' $limit", ARRAY_A);
	
	$draws = count($results);
	
	$numbers = array();
	$stars_numbers = array();
	
	
	foreach ($results as $draw) {
		
		$totalnrs = $picks + $stars;
		
		for ($p = 1; $p <= $picks; $p++) {
		if (!empty($draw['n'.$p]))
		array_push($numbers, $draw['n'.$p]);
		}
		
		for ($s = $picks + 1; $s <= $totalnrs; $s++) {
			if ($lot == 'eg' && empty($draw['n6'])) { // El Gordo contains 0 as stars number at n6 position
			array_push($stars_numbers, $draw['n6']);
			} else {
			if (!empty($draw['n'.$s]))
			array_push($stars_numbers, $draw['n'.$s]);
			}
		}
		
	}
		
	$draw_count_number = array_count_values($numbers); // Array [drawed_number]=> int(drawed_times)
	$draw_count_stars = array_count_values($stars_numbers); // Array [drawed_star_number]=> int(drawed_times)
	
	$hotcold = $draw_count_number;
	ksort($draw_count_number);
	
	$hotcold_stars = $draw_count_stars;
	ksort($draw_count_stars);
	
	arsort($hotcold); // Sort hottest numbers in reverse order
	$hot = $hotcold;
	
	asort($hotcold); // Sort coldest numbers in reverse order
	$cold = $hotcold;
	
	$hotarray = array();
	$coldarray = array();
	
	$hotcounter = 0;
	$coldcounter = 0;
	
		// Creating numbers array
		foreach($hot as $key => $value) {
		array_push($hotarray, $key);
		$hotcounter++;
		if($hotcounter==$picks)
		break;
		}
		
		foreach($cold as $key => $value) {
		array_push($coldarray, $key);
		$coldcounter++;
		if($coldcounter==$picks)
		break;
		}
		
	sort($hotarray);
	sort($coldarray);
	
	$hot_html = '';
	
	foreach($hotarray as $key => $value) {
	$hot_html .= '<div class="hotnumber">'.$value.'</div>';
	}
	
	$cold_html = '';
	
	foreach($coldarray as $key => $value) {
	$cold_html .= '<div class="coldnumber">'.$value.'</div>';
	}
	
	$drawed_stars_times = 0;
	
	foreach ($draw_count_stars as $key => $value) {
	$drawed_stars_times = $drawed_stars_times + $value;
	}
	
	if ($total_stars_numbers != 0) 
	$average_stars_draw = floor($drawed_stars_times / $total_stars_numbers);
	
	$stars_html = '<span style="float: left; font-family: arial; font-size: 16px; font-style: italic;">'.$ExtraNumbers.'</span><br />';
	
	$tooltipcount = 1;
	
	foreach ($draw_count_stars as $key => $value) {
		
		$DrawnNumberPopup = sprintf( __( 'Drawn number: %d<br />Drawn %s times', 'jpgraph-i18n' ), $key, $value );
		
		if ($value > $average_stars_draw) {
		$stars_html .= '<div class="hotstar" title="'.$DrawnNumberPopup.'">'.$key.'</div>';
		} else {
		$stars_html .= '<div class="coldstar" title="'.$DrawnNumberPopup.'">'.$key.'</div>';
		}
		
		$tooltipcount++;
	}
	
	if ($total_stars_numbers == 0 || $lot == 'ie')
	$stars_html = '<div style="position: relative; top: 25px; color: red; font-family: arial; font-size: 22px; font-style: italic; text-align: center;">'.$noExtraNumbers.'</div><br />';
	
	
	$drawed_times = 0;
	
	foreach ($draw_count_number as $key => $value) {
	$drawed_times = $drawed_times + $value;
	}
	
	$average_draw = floor($drawed_times / $total_lotto_numbers);
	
	$addRows = count($draw_count_number);
	
	$data = "var data = new google.visualization.DataTable();";
	
	$data .= "data.addColumn('number', '".$drawnTimes."');
			data.addColumn('number', '".$ColdNumber."');
			data.addColumn('number', '".$HotNumber."');
			//data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
			data.addRows(".$addRows.");";
	
	$cell = 0;
	
	foreach ($draw_count_number as $key => $value) {
	
		if ($value > $average_draw) {
		$columnIndex = 2; // Cold number
		} else {
		$columnIndex = 1; // Hot number
		}
		
		$DrawnNumberPopup = sprintf( __( 'Drawn number: %d', 'jpgraph-i18n' ), $key );
		$DrawnTimesPopup = sprintf( __( 'Drawn %d times', 'jpgraph-i18n' ), $value );
		
		$data .= "data.setCell(".$cell.", 0, ".$key.", '".$DrawnNumberPopup."');
		data.setCell(".$cell.", ".$columnIndex.", ".$value.", '".$DrawnTimesPopup."');";
		
		$cell++;
	}
	
	$data .= "new google.visualization.ColumnChart(document.getElementById('hotcoldgraph')).
			draw(data,{'allowHtml': true, 'chartArea': {width: '90%', height: '85%'}, 'isStacked': true, 'legend': {position: 'top'}, 'vAxis': {'title': '".$drawnTimes."'}, 'hAxis': {'title': '".$axisTitle."', 'viewWindowMode': 'explicit', viewWindow: { min: 1, max: ".$total_lotto_numbers." }, gridlines: { count: ".$total_lotto_numbers." }, textStyle: {fontSize: 6} }, 'vAxis': {format:'##', textStyle: { } } });
	
			var lotto = '".$lot."';";
			
		if($chooselotto) {
	
		$data .= "$('#slider').rangeSlider('destroy');
			
			$('#slider').rangeSlider({bounds:{min: 1, max: ".$draws."}, defaultValues:{min: 1, max: ".$draws."},formatter:function(val){var value = Math.round(val); return '".$drawNo."' + value.toString();}});";
				
		} else {
		
		//$data .= "$('#slider').rangeSlider({bounds:{min: 1, max: ".$draws."}, defaultValues:{min: ".($draws-10).", max: ".$draws."}, valueLabels:'change', delayOut: 4000, formatter:function(val){var value = Math.round(val); return 'Draw No: ' + value.toString();}});";
		
		}
		
		$data .= "$('#hotnumbers').html('".$hot_html."');$('#coldnumbers').html('".$cold_html."');$('#starsnumbers').html('".$stars_html."');$('.hotstar').tooltipsy({ css: {'padding': '10px', 'max-width': '250px', 'color': '#303030', 'background-color': '#FFCCAA', 'border': '1px solid #FF3334', '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'text-shadow': 'none' } }); $('.coldstar').tooltipsy({ css: {'padding': '10px', 'max-width': '250px', 'color': '#303030', 'background-color': '#9FDAEE', 'border': '1px solid #2BB0D7', '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'text-shadow': 'none' } });";
	
	header("content-type: text/javascript; charset: UTF-8");
	header("cache-control: must-revalidate");
	if(!ob_start("ob_gzhandler")) ob_start();
	echo $data; ob_flush(); exit();
	}
	
	$usd = array("mm", "pb", "cs", "ny", "lt", "fl", "ho", "hl");
	$aud = array("oz", "pa");
	$cad = array("s7", "49");
	$eur = array("em", "eg", "fr", "se", "de", "lp", "ie");
	$gbp = array("uk", "tb");
	$brl = array("ms");
	
	if (in_array($lot, $usd)) {
	$cur = '$';
	$rate = 1;
	} else if (in_array($lot, $aud)) {
	$cur = 'AUD';
	$rate = 1.0086;
	} else if (in_array($lot, $cad)) {
	$cur = 'CAD';
	$rate = 0.977326;
	} else if (in_array($lot, $eur)) {
	$cur = 'EUR';
	$rate = 1.2637;
	} else if (in_array($lot, $gbp)) {
	$cur = 'GBP';
	$rate = 1.5678;
	} else if (in_array($lot, $brl)) {
	$cur = 'BRL';
	$rate = 0.49;
	} else {
	$cur = '$';
	$rate = 1;
	}
	
	if (strlen($lot) <= 2) {
		$numlottos = 1;
		$columns = '1';
		
		$lot = substr($lot,0,2);
		
		if ($lot == 'mm') { $singlelotto = __( 'Mega Millions', 'jpgraph-i18n' ); }
		else if ($lot == 'pb') { $singlelotto = __( 'Powerball', 'jpgraph-i18n' ); }
		else if ($lot == 'em') { $singlelotto = __( 'Euro Millions', 'jpgraph-i18n' ); }
		else if ($lot == 'pa') { $singlelotto = __( 'Powerball Australia', 'jpgraph-i18n' ); }
		else if ($lot == 'hl') { $singlelotto = __( 'Hot Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'eg') { $singlelotto = __( 'El Gordo', 'jpgraph-i18n' ); }
		else if ($lot == 'fr') { $singlelotto = __( 'France Loto', 'jpgraph-i18n' ); }
		else if ($lot == 'uk') { $singlelotto = __( 'UK National Lottery', 'jpgraph-i18n' ); }
		else if ($lot == 'cs') { $singlelotto = __( 'California SuperLotto', 'jpgraph-i18n' ); }
		else if ($lot == 'oz') { $singlelotto = __( 'Oz Lotto', 'jpgraph-i18n' ); }
		else if ($lot == '49') { $singlelotto = __( 'Lotto 6/49', 'jpgraph-i18n' ); }
		else if ($lot == 'ho') { $singlelotto = __( 'Hoosier Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'ny') { $singlelotto = __( 'New York Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'fl') { $singlelotto = __( 'Florida Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'ms') { $singlelotto = __( 'Mega Sena', 'jpgraph-i18n' ); }
		else if ($lot == 'ie') { $singlelotto = __( 'Irish Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'tb') { $singlelotto = __( 'Thunderball', 'jpgraph-i18n' ); }
		else if ($lot == 'se') { $singlelotto = __( 'Superena Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'de') { $singlelotto = __( 'German Lotto', 'jpgraph-i18n' ); }
		else if ($lot == 'lp') { $singlelotto = __( 'La Primitiva', 'jpgraph-i18n' ); }
		
		$results = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lot'", ARRAY_A);
	
		$constant = array('mm' => 19047453.135654, 'pb' => 19047453.135654, 'em' => 14719940.287338, 'pa' => 1816190.887524, 'hl' => 491621.849854, 'eg' => 3573468.007424, 'fr' => 1552346.957704, 'uk' => 1531460.024304, 'cs' => 4537308.032264, 'oz' => 2785281.474584, '49' => 2444112.397234, 'ho' => 3143180.052374, 'ny' => 2938736.229644, 'fl' => 3488341.546134, 'ms' => 1906064.389734, 'ie' => 754314.388134, 'tb' => -477239.548045999, 'se' => 29198068.067464, 'de' => 1268969.781834, 'lp' => 833787.932324001);
		$seqdata = array('mm' => 38848.691105, 'pb' => 37154.175607, 'em' => 34190.707448, 'pa' => 31212.426052, 'hl' => 30134.366034, 'eg' => 32384.686155, 'fr' => 33101.729769, 'uk' => 33692.470331, 'cs' => 31787.829798, 'oz' => 30720.350099, '49' => 32677.594713, 'ho' => 32047.008952, 'ny' => 31622.666816, 'fl' => 34229.587841, 'ms' => 34909.764058, 'ie' => 31055.137589, 'tb' => 31106.950205, 'se' => 14336.974057, 'de' => 31147.248333, 'lp' => 31509.770994);
		
		$seq2data = -216.414871;
		$seq3data = 0.335585;
		$lag1data = 0.681567;
		$lag2data = 0.017282;
		$seq = count($results) + 1;
		$seq2 = $seq * $seq;
		$seq3 = $seq2 * $seq;
		$lag1n = $seq - 2;
		$lag2n = $seq - 3;
		$lag1 = $results[$lag1n]['jp'] * $rate;
		$lag2 = $results[$lag2n]['jp'] * $rate;
		$predictjp = $constant[$lot] + $seq * $seqdata[$lot] + $seq2 * $seq2data + $seq3 * $seq3data + $lag1 * $lag1data + $lag2 * $lag2data;  
		$predictjp = round($predictjp / $rate);
		$jplength = strlen($predictjp) - 3;
		$predictjpf = $cur.' '.number_format(round($predictjp, -$jplength));
		$predictjpend = round($predictjp, -$jplength);
		$predictjpstart = $predictjpend - 1000;
		
		$showpredictedjp = "$('#jp').flipCounter({number:".$predictjpstart."}); $('#jp').flipCounter('startAnimation', {end_number:".$predictjpend.", easing:jQuery.easing.easeInOutCubic, duration:300}); $('#jpwrap').css('display','block');";
		
		foreach ($results as $result) {
		if(!isset($google_JSON)){
			$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$singlelotto."',type:'number'}],rows: ["; 
		}
		
		$jpsingle = $cur.' '.number_format($result['jp']);
	
		$date = explode('-', $result['jpdate']);
		$month = (int)$date[1] - 1;
		$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	
			$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$result['jp'].",f: '".$jpsingle."'}]}";
	
		}
		
		$lastdraw = count($results)-1;
		
		$date = explode('-', $results[$lastdraw]['jpdate']);
		$month = (int)$date[1] - 1;
		$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
		$startmonth = 'new Date('.$date[0].', '.($month-1).', '.(int)$date[2].')';
		
		$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
		
	} else if (strlen($lot) > 2 && strlen($lot) <= 5) {
		
		$numlottos = 2;
		$columns = '1, 2';
		$lottos = explode(',', $lot);
		
		$lot = substr($lot,0,5);
			
		if ($lottos[0] == 'mm') { $lotto1 = __( 'Mega Millions', 'jpgraph-i18n' ); $cur1 = '$'; }
		else if ($lottos[0] == 'pb') { $lotto1 = __( 'Powerball', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'em') { $lotto1 = __( 'Euro Millions', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'pa') { $lotto1 = __( 'Powerball Australia', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'hl') { $lotto1 = __( 'Hot Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'eg') { $lotto1 = __( 'El Gordo', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'fr') { $lotto1 = __( 'France Loto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'uk') { $lotto1 = __( 'UK National Lottery', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'cs') { $lotto1 = __( 'California SuperLotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'oz') { $lotto1 = __( 'Oz Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == '49') { $lotto1 = __( 'Lotto 6/49', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ho') { $lotto1 = __( 'Hoosier Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ny') { $lotto1 = __( 'New York Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'fl') { $lotto1 = __( 'Florida Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ms') { $lotto1 = __( 'Mega Sena', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ie') { $lotto1 = __( 'Irish Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'tb') { $lotto1 = __( 'Thunderball', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'se') { $lotto1 = __( 'Superena Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'de') { $lotto1 = __( 'German Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'lp') { $lotto1 = __( 'La Primitiva', 'jpgraph-i18n' ); }
		
		if ($lottos[1] == 'mm') { $lotto2 = __( 'Mega Millions', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'pb') { $lotto2 = __( 'Powerball', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'em') { $lotto2 = __( 'Euro Millions', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'pa') { $lotto2 = __( 'Powerball Australia', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'hl') { $lotto2 = __( 'Hot Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'eg') { $lotto2 = __( 'El Gordo', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'fr') { $lotto2 = __( 'France Loto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'uk') { $lotto2 = __( 'UK National Lottery', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'cs') { $lotto2 = __( 'California SuperLotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'oz') { $lotto2 = __( 'Oz Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == '49') { $lotto2 = __( 'Lotto 6/49', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ho') { $lotto2 = __( 'Hoosier Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ny') { $lotto2 = __( 'New York Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'fl') { $lotto2 = __( 'Florida Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ms') { $lotto2 = __( 'Mega Sena', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ie') { $lotto2 = __( 'Irish Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'tb') { $lotto2 = __( 'Thunderball', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'se') { $lotto2 = __( 'Superena Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'de') { $lotto2 = __( 'German Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'lp') { $lotto2 = __( 'La Primitiva', 'jpgraph-i18n' ); }
		
		$firstlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[0]'", ARRAY_A);
		
		$secondlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[1]'", ARRAY_A);
		
		foreach($firstlotto as $f) {
			$numbers = $f['n1'].', '.$f['n2'].', '.$f['n3'].', '.$f['n4'].', '.$f['n5'].', '.$f['n6'].', '.$f['n7'].', '.$f['n8'].', '.$f['n9'];
			$first[$f['jpdate']] = array('jp' => $f['jp'],'jpdate' => $f['jpdate'], 'n' => $numbers);
			}
			
		foreach($secondlotto as $s) {
			$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
			$second[$s['jpdate']] = array('jp' => $s['jp'],'jpdate' => $s['jpdate'], 'n' => $numbers);
			}
		
		foreach($first as $firstcheck) {
			if (!array_key_exists($firstcheck['jpdate'], $second)) {
				$second[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
			}
		}
		
		ksort($second);
		$second = array_values($second);
		
		foreach($second as $secondcheck) {
			if (!array_key_exists($secondcheck['jpdate'], $first)) {
				$first[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
			}
		}
		
		ksort($first);
		$first = array_values($first);
	
		for ($x = 0; $x <= count($first)-1; $x++) {
		if(!isset($google_JSON)){
			$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$lotto1."',type:'number'},{id:'',label:'".$lotto2."',type:'number'}],rows: ["; 
		}
		
		$jpfirst = $cur.' '.number_format($first[$x]['jp']);
		$jpsecond = $cur.' '.number_format($second[$x]['jp']);
	
		$date = explode('-', $first[$x]['jpdate']);
		$month = (int)$date[1] - 1;
		$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	
			$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$first[$x]['jp'].",f: '".$jpfirst."'}, {v: ".$second[$x]['jp'].",f: '".$jpsecond."'}]}";
	
		}
		
		$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
		
		$showpredictedjp = '$("#jpwrap").css("display","none");';
		
		$lastdraw = count($first)-1;
		
		$date = explode('-', $first[$lastdraw]['jpdate']);
		$month = (int)$date[1] - 1;
		$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
		$startmonth = 'new Date('.$date[0].', '.($month-1).', '.(int)$date[2].')';
		
	} else if (strlen($lot) == 8) {
		$numlottos = 3;
		$columns = '1,2,3';
		
		$lot = substr($lot,0,8);
		$lottos = explode(',', $lot);
		
		if ($lottos[0] == 'mm') { $lotto1 = __( 'Mega Millions', 'jpgraph-i18n' ); $cur1 = '$'; }
		else if ($lottos[0] == 'pb') { $lotto1 = __( 'Powerball', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'em') { $lotto1 = __( 'Euro Millions', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'pa') { $lotto1 = __( 'Powerball Australia', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'hl') { $lotto1 = __( 'Hot Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'eg') { $lotto1 = __( 'El Gordo', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'fr') { $lotto1 = __( 'France Loto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'uk') { $lotto1 = __( 'UK National Lottery', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'cs') { $lotto1 = __( 'California SuperLotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'oz') { $lotto1 = __( 'Oz Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == '49') { $lotto1 = __( 'Lotto 6/49', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ho') { $lotto1 = __( 'Hoosier Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ny') { $lotto1 = __( 'New York Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'fl') { $lotto1 = __( 'Florida Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ms') { $lotto1 = __( 'Mega Sena', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'ie') { $lotto1 = __( 'Irish Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'tb') { $lotto1 = __( 'Thunderball', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'se') { $lotto1 = __( 'Superena Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'de') { $lotto1 = __( 'German Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[0] == 'lp') { $lotto1 = __( 'La Primitiva', 'jpgraph-i18n' ); }
		
		if ($lottos[1] == 'mm') { $lotto2 = __( 'Mega Millions', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'pb') { $lotto2 = __( 'Powerball', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'em') { $lotto2 = __( 'Euro Millions', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'pa') { $lotto2 = __( 'Powerball Australia', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'hl') { $lotto2 = __( 'Hot Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'eg') { $lotto2 = __( 'El Gordo', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'fr') { $lotto2 = __( 'France Loto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'uk') { $lotto2 = __( 'UK National Lottery', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'cs') { $lotto2 = __( 'California SuperLotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'oz') { $lotto2 = __( 'Oz Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == '49') { $lotto2 = __( 'Lotto 6/49', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ho') { $lotto2 = __( 'Hoosier Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ny') { $lotto2 = __( 'New York Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'fl') { $lotto2 = __( 'Florida Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ms') { $lotto2 = __( 'Mega Sena', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'ie') { $lotto2 = __( 'Irish Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'tb') { $lotto2 = __( 'Thunderball', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'se') { $lotto2 = __( 'Superena Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'de') { $lotto2 = __( 'German Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[1] == 'lp') { $lotto2 = __( 'La Primitiva', 'jpgraph-i18n' ); }
		
		if ($lottos[2]  == 'mm') { $lotto3 = __( 'Mega Millions', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'pb') { $lotto3 = __( 'Powerball', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'em') { $lotto3 = __( 'Euro Millions', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'pa') { $lotto3 = __( 'Powerball Australia', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'hl') { $lotto3 = __( 'Hot Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'eg') { $lotto3 = __( 'El Gordo', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'fr') { $lotto3 = __( 'France Loto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'uk') { $lotto3 = __( 'UK National Lottery', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'cs') { $lotto3 = __( 'California SuperLotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'oz') { $lotto3 = __( 'Oz Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == '49') { $lotto3 = __( 'Lotto 6/49', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'ho') { $lotto3 = __( 'Hoosier Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'ny') { $lotto3 = __( 'New York Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'fl') { $lotto3 = __( 'Florida Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'ms') { $lotto3 = __( 'Mega Sena', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'ie') { $lotto3 = __( 'Irish Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'tb') { $lotto3 = __( 'Thunderball', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'se') { $lotto3 = __( 'Superena Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'de') { $lotto3 = __( 'German Lotto', 'jpgraph-i18n' ); }
		else if ($lottos[2]  == 'lp') { $lotto3 = __( 'La Primitiva', 'jpgraph-i18n' ); }
		
		$firstlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[0]'", ARRAY_A);
		
		$secondlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[1]'", ARRAY_A);
		
		$thirdlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[2]'", ARRAY_A);
		
		foreach($firstlotto as $f) {
			$numbers = $f['n1'].', '.$f['n2'].', '.$f['n3'].', '.$f['n4'].', '.$f['n5'].', '.$f['n6'].', '.$f['n7'].', '.$f['n8'].', '.$f['n9'];
			$first[$f['jpdate']] = array('jp' => $f['jp'],'jpdate' => $f['jpdate'], 'n' => $numbers);
			}
			
		foreach($secondlotto as $s) {
			$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
			$second[$s['jpdate']] = array('jp' => $s['jp'],'jpdate' => $s['jpdate'], 'n' => $numbers);
			}
		
		foreach($thirdlotto as $t) {
			$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
			$third[$t['jpdate']] = array('jp' => $t['jp'],'jpdate' => $t['jpdate'], 'n' => $numbers);
			}
		
		foreach($first as $firstcheck) {
			if (!array_key_exists($firstcheck['jpdate'], $second)) {
				$second[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
			}
			if (!array_key_exists($firstcheck['jpdate'], $third)) {
				$third[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
			}
		}
		
		foreach($second as $secondcheck) {
			if (!array_key_exists($secondcheck['jpdate'], $first)) {
				$first[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
			}
			if (!array_key_exists($secondcheck['jpdate'], $third)) {
				$third[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
			}
		}
		
		foreach($third as $thirdcheck) {
			if (!array_key_exists($thirdcheck['jpdate'], $first)) {
				$first[$thirdcheck['jpdate']] = array('jp' => 0,'jpdate' => $thirdcheck['jpdate'], 'n' => 0);
			} 
			if (!array_key_exists($thirdcheck['jpdate'], $second)) {
				$second[$thirdcheck['jpdate']] = array('jp' => 0,'jpdate' => $thirdcheck['jpdate'], 'n' => 0);
			}
		}
		
		ksort($first);
		ksort($second);
		ksort($third);
		
		$second = array_values($second);
		$first = array_values($first);
		$third = array_values($third);
		
		for ($x = 0; $x <= count($first)-1; $x++) {
		if(!isset($google_JSON)){
			$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$lotto1."',type:'number'},{id:'',label:'".$lotto2."',type:'number'},{id:'',label:'".$lotto3."',type:'number'}],rows: ["; 
		}
		
		$jpfirst = $cur1.' '.number_format($first[$x]['jp']);
		$jpsecond = $cur.' '.number_format($second[$x]['jp']);
		$jpthird = $cur.' '.number_format($third[$x]['jp']);
		
		$date = explode('-', $first[$x]['jpdate']);
		$month = (int)$date[1] - 1;
		$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	
			$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$first[$x]['jp'].",f: '".$jpfirst."'}, {v: ".$second[$x]['jp'].",f: '".$jpsecond."'}, {v: ".$third[$x]['jp'].",f: '".$jpthird."'}]}";
	
		}
		
		$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
		
		$showpredictedjp = '$("#jpwrap").css("display","none");';
		
		$lastdraw = count($first)-1;
		
		$date = explode('-', $first[$lastdraw]['jpdate']);
		$month = (int)$date[1] - 1;
		$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
		$startmonth = 'new Date('.$date[0].', '.($month-1).', '.(int)$date[2].')';
		
	} else {
		$numlottos = 2;
		$columns = '1, 2';
		
		$lottos[0] = 'mm';
		$lotto1 = __( 'Mega Millions', 'jpgraph-i18n' ); $cur1 = '$';
		$lottos[1] = 'pb';
		$lotto2 = __( 'Powerball', 'jpgraph-i18n' );
		
		$firstlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[0]'", ARRAY_A);
		
		$secondlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[1]'", ARRAY_A);
		
		foreach($firstlotto as $f) {
			$numbers = $f['n1'].', '.$f['n2'].', '.$f['n3'].', '.$f['n4'].', '.$f['n5'].', '.$f['n6'].', '.$f['n7'].', '.$f['n8'].', '.$f['n9'];
			$first[$f['jpdate']] = array('jp' => $f['jp'],'jpdate' => $f['jpdate'], 'n' => $numbers);
			}
			
		foreach($secondlotto as $s) {
			$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
			$second[$s['jpdate']] = array('jp' => $s['jp'],'jpdate' => $s['jpdate'], 'n' => $numbers);
			}
		
		foreach($first as $firstcheck) {
			if (!array_key_exists($firstcheck['jpdate'], $second)) {
				$second[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
			}
		}
		
		ksort($second);
		$second = array_values($second);
		
		foreach($second as $secondcheck) {
			if (!array_key_exists($secondcheck['jpdate'], $first)) {
				$first[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
			}
		}
		
		ksort($first);
		$first = array_values($first);
	
		for ($x = 0; $x <= count($first)-1; $x++) {
		if(!isset($google_JSON)){
			$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$lotto1."',type:'number'},{id:'',label:'".$lotto2."',type:'number'}],rows: ["; 
		}
		
		$jpfirst = $cur.' '.number_format($first[$x]['jp']);
		$jpsecond = $cur.' '.number_format($second[$x]['jp']);
	
		$date = explode('-', $first[$x]['jpdate']);
		$month = (int)$date[1] - 1;
		$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	
			$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$first[$x]['jp'].",f: '".$jpfirst."'}, {v: ".$second[$x]['jp'].",f: '".$jpsecond."'}]}";
	
		}
		
		$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
		
		//require_once 'jsmin.php';
		//$gdata = JSMin::minify($gdata);
		
		$showpredictedjp = '$("#jpwrap").css("display","none");';
		
		$lastdraw = count($first)-1;
		
		$date = explode('-', $first[$lastdraw]['jpdate']);
		$month = (int)$date[1] - 1;
		$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
		$startmonth = 'new Date('.$date[0].', '.($month-3).', '.(int)$date[2].')';
	}
	
	$jpdata =  "var dashboard = new google.visualization.Dashboard(
				document.getElementById('dashboard'));
			
			var control = new google.visualization.ControlWrapper({
			'controlType': 'ChartRangeFilter',
			'containerId': 'control',
			'options': {
				// Filter by the date axis.
				'filterColumnIndex': 0,
				'ui': {
				'chartType': 'LineChart',
				'chartOptions': {
					'chartArea': {'width': '100%'},
					'hAxis': {'baselineColor': 'none'}
				},
				// Display a single series that shows the closing value of the stock.
				// Thus, this view has two columns: the date (axis) and the stock value (line series).
				'chartView': {
					'columns': [0, 1]
				},
				// 1 day in milliseconds = 24 * 60 * 60 * 1000 = 86,400,000
				'minRangeSize': 86400000
				}
			},
			'state': {'range': {'start': ".$startmonth.", 'end': ".$endmonth."}}
			});
		
			var chart = new google.visualization.ChartWrapper({
			'chartType': 'AreaChart',
			'containerId': 'chart',
			'options': {
				// Use the same chart area width as the control for axis alignment.
				'chartArea': {'height': '80%', 'width': '100%'},
				'hAxis': {'slantedText': false},
				//'vAxis': {'viewWindow': {'min': 0, 'max': 2000}},
				'legend': {position: 'top', textStyle: {color: 'red', fontSize: 16}}
				
			},
			// Convert the first column from 'date' to 'string'.
			'view': {
				'columns': [
				{
					'calc': function(dataTable, rowIndex) {
					return dataTable.getFormattedValue(rowIndex, 0);
					},
					'type': 'string'
				}, ".$columns."]
			}
			});
			
		var data = new google.visualization.DataTable(".$gdata.")
	
			
			dashboard.bind(control, chart);
			dashboard.draw(data);".$showpredictedjp;
	
	header("content-type: text/javascript; charset: UTF-8");
	header("cache-control: must-revalidate");
	if(!ob_start("ob_gzhandler")) ob_start();
	echo $jpdata; ob_flush(); exit();	
	}
}

function jpgraph_hotcold() {

	wp_enqueue_style('jpgraph-style', plugins_url('graph-le.css', __FILE__));
	
	wp_enqueue_script('google-jsapi','https://www.google.com/jsapi');
	wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js', array('jquery'), '1.8.6'); // hot/cold only work with that version of jquery-ui !!!
	wp_enqueue_script('jpgraph', home_url('?graph_js_php=graph', __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('hotcold', home_url('?graph_js_php=hotcold', __FILE__), array('jquery'), '1.0', true);
	
	$PredictedJackpot = __( 'Predicted Jackpot:', 'jpgraph-i18n' );
	$CompareLottos = __( 'Compare Lottos', 'jpgraph-i18n' );
	$PredictedText = __( 'All Lottery Jackpots Are Gathered Into 1 Visual Graph. Enables You To Research, Compare And Predict The Next Lottery Jackpot.', 'jpgraph-i18n' );
	$HotColdText = __( 'All Winning Numbers Are Gathered Into 1 Visual Graph. Enables You To See The <div class="bold red">Hot</div> (Drawn More Than The Average) And <div class="bold blue">Cold</div> (Drawn Less Than The Average) And To Decide Which Numbers To Choose!', 'jpgraph-i18n' );
	$lotto_mm = __( 'Mega Millions', 'jpgraph-i18n' );
	$lotto_pb = __( 'Powerball', 'jpgraph-i18n' );
	$lotto_em = __( 'Euro Millions', 'jpgraph-i18n' );
	$lotto_pa = __( 'Powerball Australia', 'jpgraph-i18n' );
	$lotto_hl = __( 'Hot Lotto', 'jpgraph-i18n' );
	$lotto_eg = __( 'El Gordo', 'jpgraph-i18n' );
	$lotto_fr = __( 'France Loto', 'jpgraph-i18n' );
	$lotto_uk = __( 'UK National Lottery', 'jpgraph-i18n' );
	$lotto_cs = __( 'California SuperLotto', 'jpgraph-i18n' );
	$lotto_oz = __( 'Oz Lotto', 'jpgraph-i18n' );
	$lotto_49 = __( 'Lotto 6/49', 'jpgraph-i18n' );
	$lotto_ho = __( 'Hoosier Lotto', 'jpgraph-i18n' );
	$lotto_ny = __( 'New York Lotto', 'jpgraph-i18n' );
	$lotto_fl = __( 'Florida Lotto', 'jpgraph-i18n' );
	$lotto_ms = __( 'Mega Sena', 'jpgraph-i18n' );
	$lotto_ie = __( 'Irish Lotto', 'jpgraph-i18n' );
	$lotto_tb = __( 'Thunderball', 'jpgraph-i18n' );
	$lotto_se = __( 'Superena Lotto', 'jpgraph-i18n' );
	$lotto_de = __( 'German Lotto', 'jpgraph-i18n' );
	$lotto_lp = __( 'La Primitiva', 'jpgraph-i18n' );

	$jpgraph_html = '<div id="predictedjps" style="width: 100%; margin-top: 10px;">

<div class="classic" style="margin-bottom: 10px">'.$PredictedText.'</div>

<div id="dashboard" style="">
<div id="chart" style="height: 300px;"></div>
<div id="control" style="height: 50px;"></div>
<div id="jpwrap"><div id="jpwraptext">'.$PredictedJackpot.'</div><div id="jp"></div></div>
<div id="lottos" style="position: relative; top: 10px;">
<ul id="btns">
	<li><a class="jpbtn green small" onclick="graph(\'mm\')" href="javascript:;">'.$lotto_mm.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'pb\')" href="javascript:;">'.$lotto_pb.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'em\')" href="javascript:;">'.$lotto_em.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'pa\')" href="javascript:;">'.$lotto_pa.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'hl\')" href="javascript:;">'.$lotto_hl.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'eg\')" href="javascript:;">'.$lotto_eg.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'fr\')" href="javascript:;">'.$lotto_fr.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'uk\')" href="javascript:;">'.$lotto_uk.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'cs\')" href="javascript:;">'.$lotto_cs.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'oz\')" href="javascript:;">'.$lotto_oz.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'49\')" href="javascript:;">'.$lotto_49.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ho\')" href="javascript:;">'.$lotto_ho.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ny\')" href="javascript:;">'.$lotto_ny.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'fl\')" href="javascript:;">'.$lotto_fl.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ms\')" href="javascript:;">'.$lotto_ms.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'ie\')" href="javascript:;">'.$lotto_ie.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'tb\')" href="javascript:;">'.$lotto_tb.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'se\')" href="javascript:;">'.$lotto_se.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'de\')" href="javascript:;">'.$lotto_de.'</a></li>
	<li><a class="jpbtn green small" onclick="graph(\'lp\')" href="javascript:;">'.$lotto_lp.'</a></li>
</ul>
</div>
<div id="compare"><select id="comparing" multiple="multiple"> <option value="mm">'.$lotto_mm.'</option> <option value="pb">'.$lotto_pb.'</option> <option value="em">'.$lotto_em.'</option> <option value="pa">'.$lotto_pa.'</option> <option value="hl">'.$lotto_hl.'</option> <option value="eg">'.$lotto_eg.'</option> <option value="fr">'.$lotto_fr.'</option> <option value="uk">'.$lotto_uk.'</option> <option value="cs">'.$lotto_cs.'</option> <option value="oz">'.$lotto_oz.'</option> <option value="49">'.$lotto_49.'</option> <option value="ho">'.$lotto_ho.'</option> <option value="ny">'.$lotto_ny.'</option> <option value="fl">'.$lotto_fl.'</option> <option value="ms">'.$lotto_ms.'</option> <option value="ie">'.$lotto_ie.'</option> <option value="tb">'.$lotto_tb.'</option> <option value="se">'.$lotto_se.'</option> <option value="de">'.$lotto_de.'</option> <option value="lp">'.$lotto_lp.'</option> </select><a class="jpbtn green x-large" onclick="compare()" href="javascript:;">'.$CompareLottos.'</a>

</div>
</div>

</div>';

$hotcold_html = '<div id="hotcold" style="width: 100%; height: 900px; margin-top: 50px;">

<div class="classic" style="margin-bottom: 10px;">'.$HotColdText.'</div>
	
<div id="hotcoldgraph" style="height: 400px;"></div>

<div id="hcdashboard">

<div id="stars" style="position: relative; height: 75px;">
	
	<div id="starsnumbers"></div>

</div>

<div id="slider" style="position: relative; margin: 30px 0 15px; left: 20px; width: 630px;"></div>

<div id="hot" class="bubble three-d red" style="height: 32px; width: 312px;">
	
	<div id="hotnumbers"></div>

</div>

<div id="cold" class="bubble three-d blue" style="height: 32px; width: 312px;">

	<div id="coldnumbers"></div>

</div>

</div>

<div id="lottos" style="position: relative; margin: 10px 0; width: 100%; height: 80px;">
<ul id="btns">
<li><a class="jpbtn green small" onclick="chooselotto(\'mm\')" href="javascript:;">'.$lotto_mm.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'pb\')" href="javascript:;">'.$lotto_pb.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'em\')" href="javascript:;">'.$lotto_em.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'pa\')" href="javascript:;">'.$lotto_pa.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'hl\')" href="javascript:;">'.$lotto_hl.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'eg\')" href="javascript:;">'.$lotto_eg.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'fr\')" href="javascript:;">'.$lotto_fr.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'uk\')" href="javascript:;">'.$lotto_uk.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'cs\')" href="javascript:;">'.$lotto_cs.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'oz\')" href="javascript:;">'.$lotto_oz.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'49\')" href="javascript:;">'.$lotto_49.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ho\')" href="javascript:;">'.$lotto_ho.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ny\')" href="javascript:;">'.$lotto_ny.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'fl\')" href="javascript:;">'.$lotto_fl.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ms\')" href="javascript:;">'.$lotto_ms.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'ie\')" href="javascript:;">'.$lotto_ie.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'tb\')" href="javascript:;">'.$lotto_tb.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'se\')" href="javascript:;">'.$lotto_se.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'de\')" href="javascript:;">'.$lotto_de.'</a></li>
<li><a class="jpbtn green small" onclick="chooselotto(\'lp\')" href="javascript:;">'.$lotto_lp.'</a></li>
</ul>
</div>

</div>';

return '<div id="jpshotcold">'.$jpgraph_html.$hotcold_html.'</div>';
}

add_shortcode('jpshotcold', 'jpgraph_hotcold');
?>