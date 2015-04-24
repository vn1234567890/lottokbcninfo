<?php
/*
Plugin Name: Mini Numbers Widget
Plugin URI: http://abunada.biz
Description:Generate winning numbers for lottery, gambling, betting; find your personal lucky numbers, or determine your lucky days! Try your fortune online with our totally free generators of lucky numbers!
Author: Ahmad Abunada	
Version: 1.01
Author URI: http://abunada.biz

	
*/


function widget_thewidget_init() {


	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; 
	function widget_thewidget($args) {

		
		extract($args);



		$options = get_option('widget_thewidget');
		$title = empty($options['title']) ? 'Min Lucky Numbers' : $options['title'];
		
$text= "<script language=\"javascript\" type=\"text/javascript\">
function alertwidget() 
{
	

var thehighest = document.luckyform2.thehighest.value ; 
var hmany = document.luckyform2.hmany.value ; 
var withmega = document.luckyform2.withmega.value ;
var withzeros = document.luckyform2.withzeros.value; 
var hmanymega = document.luckyform2.hmanymega.value ; 
var withmegahighest = document.luckyform2.withmegahighest.value ; 
var withZerosNumber;
var output = \"Your Lucky Numbers Are <br />\";
var i = 0 ;

for (i=0; i< hmany ; i++ ) 
{
	if (withzeros == 1 )  
	{
	
	
randomnumbers = Math.floor(Math.random()* 500000 ) ;
		
		withZerosNumber = (randomnumbers%thehighest ) ; 
		output = output+ withZerosNumber+\"-\"  ; 
	}
		
	else
	{randomnumbers = Math.floor(Math.random()* 500000 ) ;
		
		withZerosNumber = (randomnumbers%thehighest )  +1 ;
	    output = output+withZerosNumber+\"-\" ;	
	}

}
if (withmega == 1 )
{
	output = output + \"<br />\" + \" Your Mega Bonus Numbers Are <br />\"; 
	for (i=0;i<hmanymega;i++)
	{
		if (withzeros == 1 )
		{randomnumbers = Math.floor(Math.random()* 500000 ) ;
		
		withZerosNumber = (randomnumbers% withmegahighest ) ; 
			output = output+withZerosNumber+\"-\" ; 
		}
	
	    else
	    {
		randomnumbers = Math.floor(Math.random()* 500000 ) ;
		
		withZerosNumber = (randomnumbers%withmegahighest ) ; 
	    output = output+ withZerosNumber+\"-\" ;	
	    }
	
	}
}


/*output = withmega + thehighest + hmany + hmanymega + withzeros + withmegahighest ;*/


document.getElementById('towrite2').innerHTML = output ; 

}


</script>
<form id=\"luckyform2\" name=\"luckyform2\" method=\"post\" action=\"\">
  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
      <td width=\"17%\">How Many Numbers?</td>
      <td width=\"61%\"><div align=\"center\">
        <select name=\"hmany\" id=\"select2\">
          <option value=\"1\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\" selected=\"selected\">6</option>
          <option value=\"7\">7</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td colspan=\"2\"><hr /></td>
    </tr>
    <tr>
      <td>Highest Number Drawn</td>
      <td><div align=\"center\">
        <select name=\"thehighest\" id=\"thehighest\">
          <option value=\"9\">9</option>
          <option value=\"10\">10</option>
          <option value=\"11\">11</option>
          <option value=\"12\">12</option>
          <option value=\"13\">13</option>
          <option value=\"14\">14</option>
          <option value=\"15\">15</option>
          <option value=\"16\">16</option>
          <option value=\"17\">17</option>
          <option value=\"18\">18</option>
          <option value=\"19\">19</option>
          <option value=\"20\">20</option>
          <option value=\"21\">21</option>
          <option value=\"22\">22</option>
          <option value=\"23\">23</option>
          <option value=\"24\">24</option>
          <option value=\"25\">25</option>
          <option value=\"26\">26</option>
          <option value=\"27\">27</option>
          <option value=\"28\">28</option>
          <option value=\"29\">29</option>
          <option value=\"30\">30</option>
          <option value=\"31\">31</option>
          <option value=\"32\">32</option>
          <option value=\"33\">33</option>
          <option value=\"34\">34</option>
          <option value=\"35\">35</option>
          <option value=\"36\">36</option>
          <option value=\"37\">37</option>
          <option value=\"38\">38</option>
          <option value=\"39\">39</option>
          <option value=\"40\">40</option>
          <option value=\"41\">41</option>
          <option value=\"42\">42</option>
          <option value=\"43\">43</option>
          <option value=\"44\">44</option>
          <option value=\"45\">45</option>
          <option value=\"46\">46</option>
          <option value=\"47\">47</option>
          <option value=\"48\">48</option>
          <option value=\"49\" >49</option>
          <option value=\"50\">50</option>
          <option value=\"51\">51</option>
          <option value=\"52\">52</option>
          <option value=\"53\">53</option>
          <option value=\"54\">54</option>
          <option value=\"55\">55</option>
          <option value=\"56\">56</option>
          <option value=\"57\">57</option>
          <option value=\"58\">58</option>
          <option value=\"59\">59</option>
          <option value=\"60\">60</option>
          <option value=\"61\">61</option>
          <option value=\"62\">62</option>
          <option value=\"63\">63</option>
          <option value=\"64\">64</option>
          <option value=\"65\">65</option>
          <option value=\"66\">66</option>
          <option value=\"67\">67</option>
          <option value=\"68\">68</option>
          <option value=\"69\">69</option>
          <option value=\"70\">70</option>
          <option value=\"71\">71</option>
          <option value=\"72\">72</option>
          <option value=\"73\">73</option>
          <option value=\"74\">74</option>
          <option value=\"75\">75</option>
          <option value=\"76\">76</option>
          <option value=\"77\">77</option>
          <option value=\"78\">78</option>
          <option value=\"79\">79</option>
          <option value=\"80\">80</option>
          <option value=\"81\">81</option>
          <option value=\"82\">82</option>
          <option value=\"83\">83</option>
          <option value=\"84\">84</option>
          <option value=\"85\">85</option>
          <option value=\"86\">86</option>
          <option value=\"87\">87</option>
          <option value=\"88\">88</option>
          <option value=\"89\">89</option>
          <option value=\"90\" selected=\"selected\">90</option>
          <option value=\"91\">91</option>
          <option value=\"92\">92</option>
          <option value=\"93\">93</option>
          <option value=\"94\">94</option>
          <option value=\"95\">95</option>
          <option value=\"96\">96</option>
          <option value=\"97\">97</option>
          <option value=\"98\">98</option>
          <option value=\"99\">99</option>
        </select>
      </div></td>
    </tr>
     <tr>
      <td colspan=\"2\"><hr /></td>
    </tr>
    <tr>
      <td>How Many Mega Bonus Numbers?</td>
      <td><div align=\"center\">
        <select name=\"hmanymega\" id=\"hmanymega\">
          <option value=\"1\" selected=\"selected\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\">6</option>
          <option value=\"7\">7</option>
        </select>
      </div></td>
    </tr>
	 <tr>
      <td colspan=\"2\"><hr /></td>
    </tr>
    <tr>
      <td width=\"17%\">Include Zeros?</td>
      <td width=\"61%\">&nbsp;
          <div align=\"center\">
            <select name=\"withzeros\" id=\"withzeros\">
              <option value=\"1\">Yes</option>
              <option value=\"0\">No</option>
              </select>
      </div></td>
    </tr>
	 <tr>
      <td colspan=\"2\"><hr /></td>
    </tr>
    <tr>
      <td>Mega Bonus</td>
      <td>&nbsp;
          <div align=\"center\">
            <select name=\"withmega\" id=\"withmega\">
              <option value=\"1\">Yes</option>
              <option value=\"0\">No</option>
              </select>
      </div></td>
    </tr>
	 <tr>
      <td colspan=\"2\"><hr /></td>
    </tr>
    <tr>
      <td>Highest Mega Number Drawn</td>
      <td>&nbsp;
          <div align=\"center\">
            <select name=\"withmegahighest\" id=\"withmegahighest\">
              <option value=\"9\">9</option>
              <option value=\"10\">10</option>
              <option value=\"11\">11</option>
              <option value=\"12\">12</option>
              <option value=\"13\">13</option>
              <option value=\"14\">14</option>
              <option value=\"15\">15</option>
              <option value=\"16\">16</option>
              <option value=\"17\">17</option>
              <option value=\"18\">18</option>
              <option value=\"19\">19</option>
              <option value=\"20\">20</option>
              <option value=\"21\">21</option>
              <option value=\"22\">22</option>
              <option value=\"23\">23</option>
              <option value=\"24\">24</option>
              <option value=\"25\">25</option>
              <option value=\"26\">26</option>
              <option value=\"27\">27</option>
              <option value=\"28\">28</option>
              <option value=\"29\">29</option>
              <option value=\"30\">30</option>
              <option value=\"31\">31</option>
              <option value=\"32\">32</option>
              <option value=\"33\">33</option>
              <option value=\"34\">34</option>
              <option value=\"35\">35</option>
              <option value=\"36\">36</option>
              <option value=\"37\">37</option>
              <option value=\"38\">38</option>
              <option value=\"39\" selected=\"selected\">39</option>
              <option value=\"40\">40</option>
              <option value=\"41\">41</option>
              <option value=\"42\">42</option>
              <option value=\"43\">43</option>
              <option value=\"44\">44</option>
              <option value=\"45\">45</option>
              <option value=\"46\">46</option>
              <option value=\"47\">47</option>
              <option value=\"48\">48</option>
              <option value=\"49\" >49</option>
              <option value=\"50\">50</option>
              <option value=\"51\">51</option>
              <option value=\"52\">52</option>
              <option value=\"53\">53</option>
              <option value=\"54\">54</option>
              <option value=\"55\">55</option>
              <option value=\"56\">56</option>
              <option value=\"57\">57</option>
              <option value=\"58\">58</option>
              <option value=\"59\">59</option>
              <option value=\"60\">60</option>
              <option value=\"61\">61</option>
              <option value=\"62\">62</option>
              <option value=\"63\">63</option>
              <option value=\"64\">64</option>
              <option value=\"65\">65</option>
              <option value=\"66\">66</option>
              <option value=\"67\">67</option>
              <option value=\"68\">68</option>
              <option value=\"69\">69</option>
              <option value=\"70\">70</option>
              <option value=\"71\">71</option>
              <option value=\"72\">72</option>
              <option value=\"73\">73</option>
              <option value=\"74\">74</option>
              <option value=\"75\">75</option>
              <option value=\"76\">76</option>
              <option value=\"77\">77</option>
              <option value=\"78\">78</option>
              <option value=\"79\">79</option>
              <option value=\"80\">80</option>
              <option value=\"81\">81</option>
              <option value=\"82\">82</option>
              <option value=\"83\">83</option>
              <option value=\"84\">84</option>
              <option value=\"85\">85</option>
              <option value=\"86\">86</option>
              <option value=\"87\">87</option>
              <option value=\"88\">88</option>
              <option value=\"89\">89</option>
              <option value=\"90\" >90</option>
              <option value=\"91\">91</option>
              <option value=\"92\">92</option>
              <option value=\"93\">93</option>
              <option value=\"94\">94</option>
              <option value=\"95\">95</option>
              <option value=\"96\">96</option>
              <option value=\"97\">97</option>
              <option value=\"98\">98</option>
              <option value=\"99\">99</option>
              </select>
      </div></td>
    </tr>
  </table>
  <p align=\"center\">
 <button type=\"button\" onClick=\"alertwidget()\">Get My Lucky Number </button>  </p>
  <label></label>
</form>
<div id=\"towrite2\"><h2></h2></div>
<div align=\"center\"><a href=\"http://www.lotterypros.com\">Play Lottery Online </a></div>

";

        
 		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $text."<br />";
		echo $after_widget;
	}

	
	function widget_thewidget_control() {

		$options = get_option('widget_thewidget');

		if ( $_POST['thewidget-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['thewidget-title']));
		}

		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_thewidget', $options);
		}

		
?>
		<div>
		<label for="thewidget-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="thewidget-title" name="thewidget-title" value="<?php echo $title; ?>" /></label>
		
				<input type="hidden" name="thewidget-submit" id="thewidget-submit" value="1" />
		</div>

	<?php
	}


function replace_content($content)
{
if (is_home()) 
{
$newstr = "Find Out Your Lucky Numbers "; 
$content = str_replace('[#Lucky#]', $newstr,$content);
return $content;
}
else
{
$newstr = "

<form id=\"luckyform\" name=\"luckyform\" method=\"post\" action=\"\">
 
 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
      <td width=\"17%\">How Many Numbers?</td>
      <td width=\"7%\"><div align=\"center\">
        <select name=\"hmany\" id=\"select2\">
          <option value=\"1\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\" selected=\"selected\">6</option>
          <option value=\"7\">7</option>
        </select>
      </div></td>
      <td width=\"15%\">Include Zeros?</td>
      <td width=\"61%\">&nbsp;
        <select name=\"withzeros\" id=\"withzeros\">
          <option value=\"1\">Yes</option>
          <option value=\"0\">No</option>
        </select></td>
    </tr>
    <tr>
      <td>Highest Number Drawn</td>
      <td><div align=\"center\">
        <select name=\"thehighest\" id=\"thehighest\">
          <option value=\"9\">9</option>
          <option value=\"10\">10</option>
          <option value=\"11\">11</option>
          <option value=\"12\">12</option>
          <option value=\"13\">13</option>
          <option value=\"14\">14</option>
          <option value=\"15\">15</option>
          <option value=\"16\">16</option>
          <option value=\"17\">17</option>
          <option value=\"18\">18</option>
          <option value=\"19\">19</option>
          <option value=\"20\">20</option>
          <option value=\"21\">21</option>
          <option value=\"22\">22</option>
          <option value=\"23\">23</option>
          <option value=\"24\">24</option>
          <option value=\"25\">25</option>
          <option value=\"26\">26</option>
          <option value=\"27\">27</option>
          <option value=\"28\">28</option>
          <option value=\"29\">29</option>
          <option value=\"30\">30</option>
          <option value=\"31\">31</option>
          <option value=\"32\">32</option>
          <option value=\"33\">33</option>
          <option value=\"34\">34</option>
          <option value=\"35\">35</option>
          <option value=\"36\">36</option>
          <option value=\"37\">37</option>
          <option value=\"38\">38</option>
          <option value=\"39\">39</option>
          <option value=\"40\">40</option>
          <option value=\"41\">41</option>
          <option value=\"42\">42</option>
          <option value=\"43\">43</option>
          <option value=\"44\">44</option>
          <option value=\"45\">45</option>
          <option value=\"46\">46</option>
          <option value=\"47\">47</option>
          <option value=\"48\">48</option>
          <option value=\"49\" >49</option>
          <option value=\"50\">50</option>
          <option value=\"51\">51</option>
          <option value=\"52\">52</option>
          <option value=\"53\">53</option>
          <option value=\"54\">54</option>
          <option value=\"55\">55</option>
          <option value=\"56\">56</option>
          <option value=\"57\">57</option>
          <option value=\"58\">58</option>
          <option value=\"59\">59</option>
          <option value=\"60\">60</option>
          <option value=\"61\">61</option>
          <option value=\"62\">62</option>
          <option value=\"63\">63</option>
          <option value=\"64\">64</option>
          <option value=\"65\">65</option>
          <option value=\"66\">66</option>
          <option value=\"67\">67</option>
          <option value=\"68\">68</option>
          <option value=\"69\">69</option>
          <option value=\"70\">70</option>
          <option value=\"71\">71</option>
          <option value=\"72\">72</option>
          <option value=\"73\">73</option>
          <option value=\"74\">74</option>
          <option value=\"75\">75</option>
          <option value=\"76\">76</option>
          <option value=\"77\">77</option>
          <option value=\"78\">78</option>
          <option value=\"79\">79</option>
          <option value=\"80\">80</option>
          <option value=\"81\">81</option>
          <option value=\"82\">82</option>
          <option value=\"83\">83</option>
          <option value=\"84\">84</option>
          <option value=\"85\">85</option>
          <option value=\"86\">86</option>
          <option value=\"87\">87</option>
          <option value=\"88\">88</option>
          <option value=\"89\">89</option>
          <option value=\"90\" selected=\"selected\">90</option>
          <option value=\"91\">91</option>
          <option value=\"92\">92</option>
          <option value=\"93\">93</option>
          <option value=\"94\">94</option>
          <option value=\"95\">95</option>
          <option value=\"96\">96</option>
          <option value=\"97\">97</option>
          <option value=\"98\">98</option>
          <option value=\"99\">99</option>
        </select>
      </div></td>
      <td>Mega Bonus</td>
      <td>&nbsp;
        <select name=\"withmega\" id=\"withmega\">
          <option value=\"1\">Yes</option>
          <option value=\"0\">No</option>
        </select></td>
    </tr>
    <tr>
      <td>How Many Mega Bonus Numbers?</td>
      <td><div align=\"center\">
        <select name=\"hmanymega\" id=\"hmanymega\">
          <option value=\"1\" selected=\"selected\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\">6</option>
          <option value=\"7\">7</option>
        </select>
      </div></td>
      <td>Highest Mega Number Drawn</td>
      <td>&nbsp;
        <select name=\"withmegahighest\" id=\"withmegahighest\">
          <option value=\"9\">9</option>
          <option value=\"10\">10</option>
          <option value=\"11\">11</option>
          <option value=\"12\">12</option>
          <option value=\"13\">13</option>
          <option value=\"14\">14</option>
          <option value=\"15\">15</option>
          <option value=\"16\">16</option>
          <option value=\"17\">17</option>
          <option value=\"18\">18</option>
          <option value=\"19\">19</option>
          <option value=\"20\">20</option>
          <option value=\"21\">21</option>
          <option value=\"22\">22</option>
          <option value=\"23\">23</option>
          <option value=\"24\">24</option>
          <option value=\"25\">25</option>
          <option value=\"26\">26</option>
          <option value=\"27\">27</option>
          <option value=\"28\">28</option>
          <option value=\"29\">29</option>
          <option value=\"30\">30</option>
          <option value=\"31\">31</option>
          <option value=\"32\">32</option>
          <option value=\"33\">33</option>
          <option value=\"34\">34</option>
          <option value=\"35\">35</option>
          <option value=\"36\">36</option>
          <option value=\"37\">37</option>
          <option value=\"38\">38</option>
          <option value=\"39\" selected=\"selected\">39</option>
          <option value=\"40\">40</option>
          <option value=\"41\">41</option>
          <option value=\"42\">42</option>
          <option value=\"43\">43</option>
          <option value=\"44\">44</option>
          <option value=\"45\">45</option>
          <option value=\"46\">46</option>
          <option value=\"47\">47</option>
          <option value=\"48\">48</option>
          <option value=\"49\" >49</option>
          <option value=\"50\">50</option>
          <option value=\"51\">51</option>
          <option value=\"52\">52</option>
          <option value=\"53\">53</option>
          <option value=\"54\">54</option>
          <option value=\"55\">55</option>
          <option value=\"56\">56</option>
          <option value=\"57\">57</option>
          <option value=\"58\">58</option>
          <option value=\"59\">59</option>
          <option value=\"60\">60</option>
          <option value=\"61\">61</option>
          <option value=\"62\">62</option>
          <option value=\"63\">63</option>
          <option value=\"64\">64</option>
          <option value=\"65\">65</option>
          <option value=\"66\">66</option>
          <option value=\"67\">67</option>
          <option value=\"68\">68</option>
          <option value=\"69\">69</option>
          <option value=\"70\">70</option>
          <option value=\"71\">71</option>
          <option value=\"72\">72</option>
          <option value=\"73\">73</option>
          <option value=\"74\">74</option>
          <option value=\"75\">75</option>
          <option value=\"76\">76</option>
          <option value=\"77\">77</option>
          <option value=\"78\">78</option>
          <option value=\"79\">79</option>
          <option value=\"80\">80</option>
          <option value=\"81\">81</option>
          <option value=\"82\">82</option>
          <option value=\"83\">83</option>
          <option value=\"84\">84</option>
          <option value=\"85\">85</option>
          <option value=\"86\">86</option>
          <option value=\"87\">87</option>
          <option value=\"88\">88</option>
          <option value=\"89\">89</option>
          <option value=\"90\" >90</option>
          <option value=\"91\">91</option>
          <option value=\"92\">92</option>
          <option value=\"93\">93</option>
          <option value=\"94\">94</option>
          <option value=\"95\">95</option>
          <option value=\"96\">96</option>
          <option value=\"97\">97</option>
          <option value=\"98\">98</option>
          <option value=\"99\">99</option>
        </select></td>
    </tr>
    <tr>
      <td colspan=\"4\"><div align=\"center\">    <button type=\"button\" onClick=\"alertit()\">Get My Lucky Number </button></div></td>
    </tr>
  </table>
</form>
<div id=\"towrite\"><h2></h2></div>

<div id=\"theurl\"> <a href=\"http://www.lotterypros.com\">Play Lottery Online</a></div> 
" ;

$find = "[#Lucky#]";
$content = preg_replace($find, $newstr, $content, 1);
$content = str_replace('[#Lucky#]', "",$content);

return $content;
}

}
add_filter('the_content','replace_content');








	register_sidebar_widget('Mini Lucky Number', 'widget_thewidget');

	register_widget_control('Mini Lucky Number', 'widget_thewidget_control');
}

add_action('plugins_loaded', 'widget_thewidget_init');
add_action('wp_head', 'mfDevLoadScripts', 0);
function mfDevLoadScripts() {
	wp_deregister_script( 'thescript' );
    wp_register_script( 'thescript', '/wp-content/plugins/MiniWidget/code.js',TRUE);
    wp_enqueue_script( 'thescript' );
}

?>