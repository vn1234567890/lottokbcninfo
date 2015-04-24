
<?php 

require( 'wp-load.php' );
get_header();

?>

<div id="switchbuttons">
<a class="jpbtn green x-large tooltip" onclick="toggle('jp')" href="javascript:;">Predicted Jackpots<span class="classic">All Lottery Jackpots Are Gathered Into 1 Visual Graph. Enables You To Research, Compare And Predict The Next Lottery Jackpot</span></a>
<a class="jpbtn green x-large tooltip" onclick="toggle('hc')" href="javascript:;">Hot/Cold Numbers<span class="classic">All Winning Numbers Are Gathered Into 1 Visual Graph. Enables You To See The Hot (Drawn More Than The Average) And Cold (Drawn Less Than The Average) And To Decide Which Numbers To Choose!</span></a>
</div>

<div id="predictedjps" style="width: 762px; height: 500px;">

<div id="dashboard">
<div id="chart" style="height: 300px;"></div>
<div id="control" style="height: 50px;"></div>
<div id="jpwrap"><div id="jp"></div></div>
<div id="lottos" style="position: relative; top: 10px; height: 40px;">
<ul id="btns">
	<li><a class="jpbtn green x-small" onclick="graph('mm')" href="javascript:;">Mega Millions</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('pb')" href="javascript:;">Powerball</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('em')" href="javascript:;">Euro Millions</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('pa')" href="javascript:;">Powerball Australia</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('hl')" href="javascript:;">Hot Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('eg')" href="javascript:;">El Gordo</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('fr')" href="javascript:;">France Loto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('uk')" href="javascript:;">UK National Lottery</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('cs')" href="javascript:;">California SuperLotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('oz')" href="javascript:;">Oz Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('49')" href="javascript:;">Lotto 6/49</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('ho')" href="javascript:;">Hoosier Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('ny')" href="javascript:;">New York Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('fl')" href="javascript:;">Florida Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('ms')" href="javascript:;">Mega Sena</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('ie')" href="javascript:;">Irish Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('tb')" href="javascript:;">Thunderball</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('se')" href="javascript:;">Superena Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('de')" href="javascript:;">German Lotto</a></li>
	<li><a class="jpbtn green x-small" onclick="graph('lp')" href="javascript:;">La Primitiva</a></li>
</ul>
</div>
<div id="compare"><select id="comparing" multiple="multiple"> <option value="mm">Mega Millions</option> <option value="pb">Powerball</option> <option value="em">Euro Millions</option> <option value="pa">Powerball Australia</option> <option value="hl">Hot Lotto</option> <option value="eg">El Gordo</option> <option value="fr">France Loto</option> <option value="uk">UK National Lottery</option> <option value="cs">California SuperLotto</option> <option value="oz">Oz Lotto</option> <option value="49">Lotto 6/49</option> <option value="ho">Hoosier Lotto</option> <option value="ny">New York Lotto</option> <option value="fl">Florida Lotto</option> <option value="ms">Mega Sena</option> <option value="ie">Irish Lotto</option> <option value="tb">Thunderball</option> <option value="se">Superena Lotto</option> <option value="de">German Lotto</option> <option value="lp">La Primitiva</option> </select><a class="jpbtn green x-large" onclick="compare()" href="javascript:;">Compare lottos</a>

</div>
</div>

</div>

<div id="hotcold" style="width: 762px;  height: 500px; display: none;">

<div id="hotcoldgraph" style="height: 400px;"></div>

<div id="hcdashboard">

<div id="slider" style="position: relative; margin: 20px 0px 20px 0px"></div>

<div id="hot" class="bubble three-d red" style="height: 32px; width: 359px;">

	<div id="hotnumbers"></div>

</div>

<div id="cold" class="bubble three-d blue" style="height: 32px; width: 359px;">

	<div id="coldnumbers"></div>

</div>

</div>

<div id="lottos" style="position: relative; top: 10px; width: 762px; height: 80px;">
<ul id="btns">
<li><a class="jpbtn green x-small" onclick="chooselotto('mm')" href="javascript:;">Mega Millions</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('pb')" href="javascript:;">Powerball</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('em')" href="javascript:;">Euro Millions</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('pa')" href="javascript:;">Powerball Australia</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('hl')" href="javascript:;">Hot Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('eg')" href="javascript:;">El Gordo</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('fr')" href="javascript:;">France Loto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('uk')" href="javascript:;">UK National Lottery</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('cs')" href="javascript:;">California SuperLotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('oz')" href="javascript:;">Oz Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('49')" href="javascript:;">Lotto 6/49</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('ho')" href="javascript:;">Hoosier Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('ny')" href="javascript:;">New York Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('fl')" href="javascript:;">Florida Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('ms')" href="javascript:;">Mega Sena</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('ie')" href="javascript:;">Irish Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('tb')" href="javascript:;">Thunderball</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('se')" href="javascript:;">Superena Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('de')" href="javascript:;">German Lotto</a></li>
<li><a class="jpbtn green x-small" onclick="chooselotto('lp')" href="javascript:;">La Primitiva</a></li>
</ul>
</div>

</div>

