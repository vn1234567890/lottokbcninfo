<?php
/*
Plugin Name: The Full Lucky Numbers Widget 
Plugin URI: http://abunada.biz
Description:Generate winning numbers for lottery, gambling, betting; find your personal lucky numbers, or determine your lucky days! Try your fortune online with our totally free generators of lucky numbers!
Author: Ahmad Abunada	
Version: 1.01
Author URI: http://abunada.biz

	
*/


function widget_LuckyNumbersCreator_init() {


	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; 
	function widget_LuckyNumbersCreator($args) {

		
		extract($args);



		$options = get_option('widget_LuckyNumbersCreator');
		$title = empty($options['title']) ? 'Lucky Numbers' : $options['title'];
		
$text = "
	<script type=\"text/javascript\">


var monthtext=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];

function populatedropdown(dayfield, monthfield, yearfield){
var today=new Date()
var dayfield=document.getElementById(dayfield)
var monthfield=document.getElementById(monthfield)
var yearfield=document.getElementById(yearfield)
for (var i=0; i<31; i++)
dayfield.options[i]=new Option(i, i+1)
dayfield.options[today.getDate()]=new Option(today.getDate(), today.getDate(), true, true) //select today's day
for (var m=0; m<12; m++)
monthfield.options[m]=new Option(monthtext[m], monthtext[m])
monthfield.options[today.getMonth()]=new Option(monthtext[today.getMonth()], monthtext[today.getMonth()], true, true) //select today's month
var thisyear=today.getFullYear()
for (var y=0; y<20; y++){
yearfield.options[y]=new Option(thisyear, thisyear)
thisyear+=1
}
yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
}


function loadXMLDoc()
{


var counter = 0 ;
var str = \"\"; 
var name = document.form1.name.value ; 
var howmany = document.form1.howmany.value ; 
var highest = document.form1.highest.value ;
var day = document.form1.day.value; 
var month = document.form1.month.value;
var year = document.form1.year.value; 
var drawday = document.form1.drawday.value; 
var drawmonth = document.form1.drawmonth.value;
var drawyear = document.form1.drawyear.value ;
var mega = document.form1.mega.value;
var howmanymega = document.form1.howmanymega.value ; 
var y1,y2,y3,y4,z ; 
var megahighest = document.form1.megahighest.value ; 
var zeros = document.form1.zeros.value; 
y1 = year / 1000 ;
 
z = year % 1000 ; 
y2 = z / 100 ;

z = z%100 ;
y3 = z / 10 ;
 
y4 = z % 10 ; 

var drawy1, drawy2, drawy3 , drawy4,g = 0; 
drawy1 = drawyear / 1000 ;
 
g = drawyear % 1000 ; 
drawy2 = g / 100 ;

g = g%100 ;
drawy3 = g / 10 ;
 
drawy4 = g % 10 ; 


y1 = parseInt(y1); 
y2 = parseInt(y2); 
y3 = parseInt(y3); 
y4 = parseInt(y4); 

drawy1 = parseInt(drawy1); 
drawy2 = parseInt(drawy2); 
drawy3 = parseInt(drawy3); 
drawy4 = parseInt(drawy4); 



var numbers = new Array();

if (name.length >= 3 )
{
while ( counter < name.length ) 
{
z = name.charAt(counter) ;
if (z=='a' || z=='A' ) 
   numbers[counter] = (27 + Math.floor(Math.random()*500000) ) % highest ;  
 
  if (z=='b' || z=='B' ) 
   numbers[counter] = (28 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='c' || z=='C' ) 
numbers[counter] = (29 + Math.floor(Math.random()*500000) )% highest ;  
   
    if (z=='d' || z=='D' ) 
  numbers[counter] = (30 + Math.floor(Math.random()*500000) )% highest ;  
   
    if (z=='e' || z=='E' ) 
   numbers[counter] = (31 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='f' || z=='F' ) 
   numbers[counter] = (32 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='g' || z=='G' ) 
  numbers[counter] = (33 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='h' || z=='H' ) 
   numbers[counter] = (34 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='i' || z=='I' ) 
   numbers[counter] = (35 + Math.floor(Math.random()*500000) ) % highest ;   
  
    if (z=='j' || z=='J' ) 
   numbers[counter] = (36 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='k' || z=='K' ) 
   numbers[counter] = (37 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='l' || z=='L' ) 
  numbers[counter] = (38 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='M' || z=='m' ) 
   numbers[counter] = (39 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='n' || z=='N' ) 
   numbers[counter] =(40 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='o' || z=='O' ) 
numbers[counter] = (41 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='p' || z=='P' ) 
  numbers[counter] = (42 + Math.floor(Math.random()*500000) ) % highest ;  
  if (z=='q' || z=='Q' ) 
numbers[counter] = (43 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='r' || z=='R' ) 
  numbers[counter] = (44 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='s' || z=='S' ) 
numbers[counter] = (45 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='T' || z=='t' ) 
numbers[counter] = (46 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='u' || z=='U' ) 
numbers[counter] = (46 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='v' || z=='V' ) 
numbers[counter] = (48 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='w' || z=='W' ) 
numbers[counter] = (49 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='x' || z=='X' ) 
numbers[counter] = (50 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='y' || z=='Y' ) 
 numbers[counter] = (51 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='z' || z=='Z' ) 
numbers[counter] = (52 + Math.floor(Math.random()*500000) ) % highest ;   
   
  //str = str + \"\t\" + getcharvalue(thename.charAt(counter) ) ; 
  counter++ ;
}

var bdate = (day + month+( Math.floor(Math.random()*500000) ))% highest; 
var byear = (year+ ( Math.floor(Math.random()*500000) ) )%highest;
var drawing = (day+ ( Math.floor(Math.random()*500000) )+ year+month) % highest; 
var drawing2= (month+year + ( Math.floor(Math.random()*500000) )) % highest; 
var drawing3 = (day+month+( Math.floor(Math.random()*500000) )) % highest; 
var bdate2 = (day*( Math.floor(Math.random()*500000) )) % highest ; 
var bdate3 = (year*( Math.floor(Math.random()*500000) )) % highest; 
var mix = (day *( Math.floor(Math.random()*500000) )) % highest;
var mix2 = (month * ( Math.floor(Math.random()*500000) )) % highest;
var mix3 = ((year * ( Math.floor(Math.random()*500000) )) + (month)) % highest ;

var currentTime = new Date();
var themonth = currentTime.getMonth() + 1;
var theday = currentTime.getDate();
var theyear = currentTime.getFullYear();

 
var i ;
numbers[counter] = bdate; 
counter++;
numbers[counter] = byear ;
counter++; 
numbers[counter]= drawing ; 
counter++;
numbers[counter] = drawing2 ;
counter++; 
numbers[counter] = drawing3; 
counter++; 
numbers[counter] = bdate2; 
counter++; 
numbers[counter]= bdate3; 
counter++; 
numbers[counter]= mix ;
counter++; 
numbers[counter]= mix2;
counter++; 
numbers[counter]= mix3 ;
var megano;
var megazero ; 

str = str + \" Your Lucky Numbers Are <br />\" ; 
for (i=0; i<howmany; i++)
{
if (zeros ==1 ) 
str = str + numbers[i] +\" - \"; 
else 
{
zerono = numbers[i] + 1 ;
str = str + zerono +\" - \";

}

}

str= str+\"<br />\"; 
if (mega == 1 )
{
str = str + \" Your Mega Bonus Are <br /> \" ; 
for (j=0; j<howmanymega; j++ )
{
if (zeros ==1 ) 
{
megano= numbers[i]% megahighest; 
str = str + (megano )+\" - \"; 
}
else
{
megazero = numbers[i] + 1 ;
megano= megazero% megahighest; 
str = str + (megano )+\" - \"; 
}
i++;
}
}

document.getElementById('myDiv').innerHTML =\"\"+ str+\"\" ;
}
else
document.getElementById('myDiv').innerHTML =\" Your Name must be at least 3 charcaters \" ;

}
</script>


		
	  <form name=\"form1\" method=\"post\" action=\"\">
    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Your First Name</span></td>
      </tr>
      <tr>
        <td><input name=\"name\" type=\"text\" id=\"name\"></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Your Birthdate </span></td>
      </tr>
      <tr>
        <td><select name=\"day\" id=\"day\">
          <option value=\"1\" selected=\"selected\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\">6</option>
          <option value=\"7\">7</option>
          <option value=\"8\">8</option>
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
        </select>
          <select name=\"month\" id=\"select3\">
            <option value=\"1\" selected=\"selected\">1</option>
            <option value=\"2\">2</option>
            <option value=\"3\">3</option>
            <option value=\"4\">4</option>
            <option value=\"5\">5</option>
            <option value=\"6\">6</option>
            <option value=\"7\">7</option>
            <option value=\"8\">8</option>
            <option value=\"9\">9</option>
            <option value=\"10\">10</option>
            <option value=\"11\">11</option>
            <option value=\"12\">12</option>
         
          </select>
		  
		  <select name=\"year\" id=\"year\"> 
          <option value=\"1900\">1900</option> 
          <option value=\"1901\">1901</option> 
          <option value=\"1902\">1902</option> 
          <option value=\"1903\">1903</option> 
          <option value=\"1904\">1904</option> 
          <option value=\"1905\">1905</option> 
          <option value=\"1906\">1906</option> 
          <option value=\"1907\">1907</option> 
          <option value=\"1908\">1908</option> 
          <option value=\"1909\">1909</option> 
          <option value=\"1910\">1910</option> 
          <option value=\"1911\">1911</option> 
          <option value=\"1912\">1912</option> 
          <option value=\"1913\">1913</option> 
          <option value=\"1914\">1914</option> 
          <option value=\"1915\">1915</option> 
          <option value=\"1916\">1916</option> 
          <option value=\"1917\">1917</option> 
          <option value=\"1918\">1918</option> 
          <option value=\"1919\">1919</option> 
          <option value=\"1920\">1920</option> 
          <option value=\"1921\">1921</option> 
          <option value=\"1922\">1922</option> 
          <option value=\"1923\">1923</option> 
          <option value=\"1924\">1924</option> 
          <option value=\"1925\">1925</option> 
          <option value=\"1926\">1926</option> 
          <option value=\"1927\">1927</option> 
          <option value=\"1928\">1928</option> 
          <option value=\"1929\">1929</option> 
          <option value=\"1930\">1930</option> 
          <option value=\"1931\">1931</option> 
          <option value=\"1932\">1932</option> 
          <option value=\"1933\">1933</option> 
          <option value=\"1934\">1934</option> 
          <option value=\"1935\">1935</option> 
          <option value=\"1936\">1936</option> 
          <option value=\"1937\">1937</option> 
          <option value=\"1938\">1938</option> 
          <option value=\"1939\">1939</option> 
          <option value=\"1940\">1940</option> 
          <option value=\"1941\">1941</option> 
          <option value=\"1942\">1942</option> 
          <option value=\"1943\">1943</option> 
          <option value=\"1944\">1944</option> 
          <option value=\"1945\">1945</option> 
          <option value=\"1946\">1946</option> 
          <option value=\"1947\">1947</option> 
          <option value=\"1948\">1948</option> 
          <option value=\"1949\">1949</option> 
          <option value=\"1950\">1950</option> 
          <option value=\"1951\">1951</option> 
          <option value=\"1952\">1952</option> 
          <option value=\"1953\">1953</option> 
          <option value=\"1954\">1954</option> 
          <option value=\"1955\">1955</option> 
          <option value=\"1956\">1956</option> 
          <option value=\"1957\">1957</option> 
          <option value=\"1958\">1958</option> 
          <option value=\"1959\">1959</option> 
          <option value=\"1960\" selected=\"selected\">1960</option> 
          <option value=\"1961\">1961</option> 
          <option value=\"1962\">1962</option> 
          <option value=\"1963\">1963</option> 
          <option value=\"1964\">1964</option> 
          <option value=\"1965\">1965</option> 
          <option value=\"1966\">1966</option> 
          <option value=\"1967\">1967</option> 
          <option value=\"1968\">1968</option> 
          <option value=\"1969\">1969</option> 
          <option value=\"1970\">1970</option> 
          <option value=\"1971\">1971</option> 
          <option value=\"1972\">1972</option> 
          <option value=\"1973\">1973</option> 
          <option value=\"1974\">1974</option> 
          <option value=\"1975\">1975</option> 
          <option value=\"1976\">1976</option> 
          <option value=\"1977\">1977</option> 
          <option value=\"1978\">1978</option> 
          <option value=\"1979\">1979</option> 
          <option value=\"1980\">1980</option> 
          <option value=\"1981\">1981</option> 
          <option value=\"1982\">1982</option> 
          <option value=\"1983\">1983</option> 
          <option value=\"1984\">1984</option> 
          <option value=\"1985\">1985</option> 
          <option value=\"1986\">1986</option> 
          <option value=\"1987\">1987</option> 
          <option value=\"1988\">1988</option> 
          <option value=\"1989\">1989</option> 
          <option value=\"1990\">1990</option> 
          <option value=\"1991\">1991</option> 
          <option value=\"1992\">1992</option> 
          <option value=\"1993\">1993</option> 
          <option value=\"1994\">1994</option> 
          <option value=\"1995\">1995</option> 
          <option value=\"1996\">1996</option> 
          <option value=\"1997\">1997</option> 
          <option value=\"1998\">1998</option> 
          <option value=\"1999\">1999</option> 
          <option value=\"2000\">2000</option> 
          <option value=\"2001\">2001</option> 
          <option value=\"2002\">2002</option> 
          <option value=\"2003\">2003</option> 
          <option value=\"2004\">2004</option> 
          <option value=\"2005\">2005</option> 
          <option value=\"2006\">2006</option> 
          <option value=\"2007\">2007</option> 
          <option value=\"2008\">2008</option> 
          <option value=\"2009\">2009</option> 
          <option value=\"2010\">2010</option> 
          <option value=\"2011\">2011</option> 
        </select>		  </td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Drawing Date </span></td>
      </tr>
      <tr>
        <td>


	<select id=\"drawday\" name=\"drawday\" >
</select> 
<select id=\"drawmonth\" name=\"drawmonth\">
</select> 
<select id=\"drawyear\" name=\"drawday\">
</select>
	<script type=\"text/javascript\">
	
		window.onload=function(){
populatedropdown(\"drawday\", \"drawmonth\", \"drawyear\")
}

</script>



</td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">How many Numbers </span></td>
      </tr>
      <tr>
        <td><select name=\"howmany\" id=\"select2\">
          <option value=\"1\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\" selected>6</option>
          <option value=\"7\">7</option>
        </select></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Highest Number Drawn</span></td>
      </tr>
      <tr>
        <td>
		<select name=\"highest\" id=\"highest\">
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
		
		
		</td>
      </tr>
	  
	  
	 
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	 <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Include Zeros</span></td>
      </tr>
      <tr>
        <td><select name=\"zeros\" id=\"zeros\">
          <option value=\"1\">Yes</option>
          <option value=\"0\">No</option>
        </select></td>
      </tr>

	  
	  
	  
	  
	  
	  
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Mega Bonus </span></td>
      </tr>
      <tr>
        <td><select name=\"mega\" id=\"mega\">
          <option value=\"1\">Yes</option>
          <option value=\"0\">No</option>
        </select></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
	  
	  
	  
	  
	  
	  
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">How many Bonus Numbers? </span></td>
      </tr>
      <tr>
        <td width=\"1068\"><label>
          <select name=\"howmanymega\" id=\"howmanymega\">
            <option value=\"1\" selected=\"selected\">1</option>
            <option value=\"2\">2</option>
            <option value=\"3\">3</option>
            <option value=\"4\">4</option>
            <option value=\"5\">5</option>
            <option value=\"6\">6</option>
            <option value=\"7\">7</option>
          </select>
        </label></td>
      </tr>
	  
	    <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Highest Mega Number Drawn</span></td>
      </tr>
      <tr>
        <td>
		<select name=\"megahighest\" id=\"megahighest\">
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
		
		
		</td>
      </tr>
	  
	  
	  
	  
	  
	  
	  <tr>
	  <td align=\"center\"><button type=\"button\" onClick=\"loadXMLDoc()\">Get My Lucky Number </button>
        <div align=\"center\"></div></td>
	  </tr>
    </table>
  </form>

<div id=\"myDiv\" style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; border-style:solid;
border-width:3px;\"></div>

<p align=\"center\"><h5><a href=\"http://www.lotterypros.com/lucky-number-generator/\">Lucky Numbers Generator</a></h5></p>";

        
 		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $text."<br />";
		echo $after_widget;
	}

	
	function widget_LuckyNumbersCreator_control() {

		$options = get_option('widget_LuckyNumbersCreator');

		if ( $_POST['LuckyNumbersCreator-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['LuckyNumbersCreator-title']));
		}

		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_LuckyNumbersCreator', $options);
		}

		
?>
		<div>
		<label for="LuckyNumbersCreator-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="LuckyNumbersCreator-title" name="LuckyNumbersCreator-title" value="<?php echo $title; ?>" /></label>
		
				<input type="hidden" name="LuckyNumbersCreator-submit" id="LuckyNumbersCreator-submit" value="1" />
		</div>

	<?php
	}

	register_sidebar_widget('Lucky Number', 'widget_LuckyNumbersCreator');

	register_widget_control('Lucky Number', 'widget_LuckyNumbersCreator_control');
}

add_action('plugins_loaded', 'widget_LuckyNumbersCreator_init');

function lucky_numbers_gen() {

$text = "<script type=\"text/javascript\">

var monthtext=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];

function populatedropdown(dayfield, monthfield, yearfield){
var today=new Date()
var dayfield=document.getElementById(dayfield)
var monthfield=document.getElementById(monthfield)
var yearfield=document.getElementById(yearfield)
for (var i=0; i<31; i++)
dayfield.options[i]=new Option(i, i+1)
dayfield.options[today.getDate()]=new Option(today.getDate(), today.getDate(), true, true) //select today's day
for (var m=0; m<12; m++)
monthfield.options[m]=new Option(monthtext[m], monthtext[m])
monthfield.options[today.getMonth()]=new Option(monthtext[today.getMonth()], monthtext[today.getMonth()], true, true) //select today's month
var thisyear=today.getFullYear()
for (var y=0; y<20; y++){
yearfield.options[y]=new Option(thisyear, thisyear)
thisyear+=1
}
yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
}


function loadXMLDoc()
{


var counter = 0 ;
var str = \"\"; 
var name = document.form1.name.value ; 
var howmany = document.form1.howmany.value ; 
var highest = document.form1.highest.value ;
var day = document.form1.day.value; 
var month = document.form1.month.value;
var year = document.form1.year.value; 
var drawday = document.form1.drawday.value; 
var drawmonth = document.form1.drawmonth.value;
var drawyear = document.form1.drawyear.value ;
var mega = document.form1.mega.value;
var howmanymega = document.form1.howmanymega.value ; 
var y1,y2,y3,y4,z ; 
var megahighest = document.form1.megahighest.value ; 
var zeros = document.form1.zeros.value; 
y1 = year / 1000 ;
 
z = year % 1000 ; 
y2 = z / 100 ;

z = z%100 ;
y3 = z / 10 ;
 
y4 = z % 10 ; 

var drawy1, drawy2, drawy3 , drawy4,g = 0; 
drawy1 = drawyear / 1000 ;
 
g = drawyear % 1000 ; 
drawy2 = g / 100 ;

g = g%100 ;
drawy3 = g / 10 ;
 
drawy4 = g % 10 ; 


y1 = parseInt(y1); 
y2 = parseInt(y2); 
y3 = parseInt(y3); 
y4 = parseInt(y4); 

drawy1 = parseInt(drawy1); 
drawy2 = parseInt(drawy2); 
drawy3 = parseInt(drawy3); 
drawy4 = parseInt(drawy4); 



var numbers = new Array();

if (name.length >= 3 )
{
while ( counter < name.length ) 
{
z = name.charAt(counter) ;
if (z=='a' || z=='A' ) 
   numbers[counter] = (27 + Math.floor(Math.random()*500000) ) % highest ;  
 
  if (z=='b' || z=='B' ) 
   numbers[counter] = (28 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='c' || z=='C' ) 
numbers[counter] = (29 + Math.floor(Math.random()*500000) )% highest ;  
   
    if (z=='d' || z=='D' ) 
  numbers[counter] = (30 + Math.floor(Math.random()*500000) )% highest ;  
   
    if (z=='e' || z=='E' ) 
   numbers[counter] = (31 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='f' || z=='F' ) 
   numbers[counter] = (32 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='g' || z=='G' ) 
  numbers[counter] = (33 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='h' || z=='H' ) 
   numbers[counter] = (34 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='i' || z=='I' ) 
   numbers[counter] = (35 + Math.floor(Math.random()*500000) ) % highest ;   
  
    if (z=='j' || z=='J' ) 
   numbers[counter] = (36 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='k' || z=='K' ) 
   numbers[counter] = (37 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='l' || z=='L' ) 
  numbers[counter] = (38 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='M' || z=='m' ) 
   numbers[counter] = (39 + Math.floor(Math.random()*500000) ) % highest ;   
   
    if (z=='n' || z=='N' ) 
   numbers[counter] =(40 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='o' || z=='O' ) 
numbers[counter] = (41 + Math.floor(Math.random()*500000) ) % highest ;  
   
    if (z=='p' || z=='P' ) 
  numbers[counter] = (42 + Math.floor(Math.random()*500000) ) % highest ;  
  if (z=='q' || z=='Q' ) 
numbers[counter] = (43 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='r' || z=='R' ) 
  numbers[counter] = (44 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='s' || z=='S' ) 
numbers[counter] = (45 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='T' || z=='t' ) 
numbers[counter] = (46 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='u' || z=='U' ) 
numbers[counter] = (46 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='v' || z=='V' ) 
numbers[counter] = (48 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='w' || z=='W' ) 
numbers[counter] = (49 + Math.floor(Math.random()*500000) ) % highest ;  
    if (z=='x' || z=='X' ) 
numbers[counter] = (50 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='y' || z=='Y' ) 
 numbers[counter] = (51 + Math.floor(Math.random()*500000) ) % highest ;   
    if (z=='z' || z=='Z' ) 
numbers[counter] = (52 + Math.floor(Math.random()*500000) ) % highest ;   
   
  //str = str + \"\t\" + getcharvalue(thename.charAt(counter) ) ; 
  counter++ ;
}

var bdate = (day + month+( Math.floor(Math.random()*500000) ))% highest; 
var byear = (year+ ( Math.floor(Math.random()*500000) ) )%highest;
var drawing = (day+ ( Math.floor(Math.random()*500000) )+ year+month) % highest; 
var drawing2= (month+year + ( Math.floor(Math.random()*500000) )) % highest; 
var drawing3 = (day+month+( Math.floor(Math.random()*500000) )) % highest; 
var bdate2 = (day*( Math.floor(Math.random()*500000) )) % highest ; 
var bdate3 = (year*( Math.floor(Math.random()*500000) )) % highest; 
var mix = (day *( Math.floor(Math.random()*500000) )) % highest;
var mix2 = (month * ( Math.floor(Math.random()*500000) )) % highest;
var mix3 = ((year * ( Math.floor(Math.random()*500000) )) + (month)) % highest ;

var currentTime = new Date();
var themonth = currentTime.getMonth() + 1;
var theday = currentTime.getDate();
var theyear = currentTime.getFullYear();

 
var i ;
numbers[counter] = bdate; 
counter++;
numbers[counter] = byear ;
counter++; 
numbers[counter]= drawing ; 
counter++;
numbers[counter] = drawing2 ;
counter++; 
numbers[counter] = drawing3; 
counter++; 
numbers[counter] = bdate2; 
counter++; 
numbers[counter]= bdate3; 
counter++; 
numbers[counter]= mix ;
counter++; 
numbers[counter]= mix2;
counter++; 
numbers[counter]= mix3 ;
var megano;
var megazero ; 

str = str + \" Your Lucky Numbers Are <br />\" ; 
for (i=0; i<howmany; i++)
{
if (zeros ==1 ) 
str = str + numbers[i] +\" - \"; 
else 
{
zerono = numbers[i] + 1 ;
str = str + zerono +\" - \";

}

}

str= str+\"<br />\"; 
if (mega == 1 )
{
str = str + \" Your Mega Bonus Are <br /> \" ; 
for (j=0; j<howmanymega; j++ )
{
if (zeros ==1 ) 
{
megano= numbers[i]% megahighest; 
str = str + (megano )+\" - \"; 
}
else
{
megazero = numbers[i] + 1 ;
megano= megazero% megahighest; 
str = str + (megano )+\" - \"; 
}
i++;
}
}

document.getElementById('myDiv').innerHTML =\"\"+ str+\"\" ;
}
else
document.getElementById('myDiv').innerHTML =\" Your Name must be at least 3 charcaters \" ;

}
</script>

<div style=\"width: 185px;\">
<form name=\"form1\" method=\"post\" action=\"\">
    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Your First Name</span></td>
      </tr>
      <tr>
        <td><input name=\"name\" type=\"text\" id=\"name\"></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Your Birthdate </span></td>
      </tr>
      <tr>
        <td><select name=\"day\" id=\"day\">
          <option value=\"1\" selected=\"selected\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\">6</option>
          <option value=\"7\">7</option>
          <option value=\"8\">8</option>
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
        </select>
          <select name=\"month\" id=\"select3\">
            <option value=\"1\" selected=\"selected\">1</option>
            <option value=\"2\">2</option>
            <option value=\"3\">3</option>
            <option value=\"4\">4</option>
            <option value=\"5\">5</option>
            <option value=\"6\">6</option>
            <option value=\"7\">7</option>
            <option value=\"8\">8</option>
            <option value=\"9\">9</option>
            <option value=\"10\">10</option>
            <option value=\"11\">11</option>
            <option value=\"12\">12</option>
         
          </select>
		  
		  <select name=\"year\" id=\"year\"> 
          <option value=\"1900\">1900</option> 
          <option value=\"1901\">1901</option> 
          <option value=\"1902\">1902</option> 
          <option value=\"1903\">1903</option> 
          <option value=\"1904\">1904</option> 
          <option value=\"1905\">1905</option> 
          <option value=\"1906\">1906</option> 
          <option value=\"1907\">1907</option> 
          <option value=\"1908\">1908</option> 
          <option value=\"1909\">1909</option> 
          <option value=\"1910\">1910</option> 
          <option value=\"1911\">1911</option> 
          <option value=\"1912\">1912</option> 
          <option value=\"1913\">1913</option> 
          <option value=\"1914\">1914</option> 
          <option value=\"1915\">1915</option> 
          <option value=\"1916\">1916</option> 
          <option value=\"1917\">1917</option> 
          <option value=\"1918\">1918</option> 
          <option value=\"1919\">1919</option> 
          <option value=\"1920\">1920</option> 
          <option value=\"1921\">1921</option> 
          <option value=\"1922\">1922</option> 
          <option value=\"1923\">1923</option> 
          <option value=\"1924\">1924</option> 
          <option value=\"1925\">1925</option> 
          <option value=\"1926\">1926</option> 
          <option value=\"1927\">1927</option> 
          <option value=\"1928\">1928</option> 
          <option value=\"1929\">1929</option> 
          <option value=\"1930\">1930</option> 
          <option value=\"1931\">1931</option> 
          <option value=\"1932\">1932</option> 
          <option value=\"1933\">1933</option> 
          <option value=\"1934\">1934</option> 
          <option value=\"1935\">1935</option> 
          <option value=\"1936\">1936</option> 
          <option value=\"1937\">1937</option> 
          <option value=\"1938\">1938</option> 
          <option value=\"1939\">1939</option> 
          <option value=\"1940\">1940</option> 
          <option value=\"1941\">1941</option> 
          <option value=\"1942\">1942</option> 
          <option value=\"1943\">1943</option> 
          <option value=\"1944\">1944</option> 
          <option value=\"1945\">1945</option> 
          <option value=\"1946\">1946</option> 
          <option value=\"1947\">1947</option> 
          <option value=\"1948\">1948</option> 
          <option value=\"1949\">1949</option> 
          <option value=\"1950\">1950</option> 
          <option value=\"1951\">1951</option> 
          <option value=\"1952\">1952</option> 
          <option value=\"1953\">1953</option> 
          <option value=\"1954\">1954</option> 
          <option value=\"1955\">1955</option> 
          <option value=\"1956\">1956</option> 
          <option value=\"1957\">1957</option> 
          <option value=\"1958\">1958</option> 
          <option value=\"1959\">1959</option> 
          <option value=\"1960\" selected=\"selected\">1960</option> 
          <option value=\"1961\">1961</option> 
          <option value=\"1962\">1962</option> 
          <option value=\"1963\">1963</option> 
          <option value=\"1964\">1964</option> 
          <option value=\"1965\">1965</option> 
          <option value=\"1966\">1966</option> 
          <option value=\"1967\">1967</option> 
          <option value=\"1968\">1968</option> 
          <option value=\"1969\">1969</option> 
          <option value=\"1970\">1970</option> 
          <option value=\"1971\">1971</option> 
          <option value=\"1972\">1972</option> 
          <option value=\"1973\">1973</option> 
          <option value=\"1974\">1974</option> 
          <option value=\"1975\">1975</option> 
          <option value=\"1976\">1976</option> 
          <option value=\"1977\">1977</option> 
          <option value=\"1978\">1978</option> 
          <option value=\"1979\">1979</option> 
          <option value=\"1980\">1980</option> 
          <option value=\"1981\">1981</option> 
          <option value=\"1982\">1982</option> 
          <option value=\"1983\">1983</option> 
          <option value=\"1984\">1984</option> 
          <option value=\"1985\">1985</option> 
          <option value=\"1986\">1986</option> 
          <option value=\"1987\">1987</option> 
          <option value=\"1988\">1988</option> 
          <option value=\"1989\">1989</option> 
          <option value=\"1990\">1990</option> 
          <option value=\"1991\">1991</option> 
          <option value=\"1992\">1992</option> 
          <option value=\"1993\">1993</option> 
          <option value=\"1994\">1994</option> 
          <option value=\"1995\">1995</option> 
          <option value=\"1996\">1996</option> 
          <option value=\"1997\">1997</option> 
          <option value=\"1998\">1998</option> 
          <option value=\"1999\">1999</option> 
          <option value=\"2000\">2000</option> 
          <option value=\"2001\">2001</option> 
          <option value=\"2002\">2002</option> 
          <option value=\"2003\">2003</option> 
          <option value=\"2004\">2004</option> 
          <option value=\"2005\">2005</option> 
          <option value=\"2006\">2006</option> 
          <option value=\"2007\">2007</option> 
          <option value=\"2008\">2008</option> 
          <option value=\"2009\">2009</option> 
          <option value=\"2010\">2010</option> 
          <option value=\"2011\">2011</option> 
        </select>		  </td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Drawing Date </span></td>
      </tr>
      <tr>
        <td>


	<select id=\"drawday\" name=\"drawday\" >
</select> 
<select id=\"drawmonth\" name=\"drawmonth\">
</select> 
<select id=\"drawyear\" name=\"drawday\">
</select>
	<script type=\"text/javascript\">
	
		window.onload=function(){
populatedropdown(\"drawday\", \"drawmonth\", \"drawyear\")
}

</script>



</td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">How many Numbers </span></td>
      </tr>
      <tr>
        <td><select name=\"howmany\" id=\"select2\">
          <option value=\"1\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
          <option value=\"6\" selected>6</option>
          <option value=\"7\">7</option>
        </select></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Highest Number Drawn</span></td>
      </tr>
      <tr>
        <td>
		<select name=\"highest\" id=\"highest\">
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
		
		
		</td>
      </tr>
	  
	  
	 
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	 <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Include Zeros</span></td>
      </tr>
      <tr>
        <td><select name=\"zeros\" id=\"zeros\">
          <option value=\"1\">Yes</option>
          <option value=\"0\">No</option>
        </select></td>
      </tr>

	  
	  
	  
	  
	  
	  
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Mega Bonus </span></td>
      </tr>
      <tr>
        <td><select name=\"mega\" id=\"mega\">
          <option value=\"1\">Yes</option>
          <option value=\"0\">No</option>
        </select></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
	  
	  
	  
	  
	  
	  
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">How many Bonus Numbers? </span></td>
      </tr>
      <tr>
        <td width=\"1068\"><label>
          <select name=\"howmanymega\" id=\"howmanymega\">
            <option value=\"1\" selected=\"selected\">1</option>
            <option value=\"2\">2</option>
            <option value=\"3\">3</option>
            <option value=\"4\">4</option>
            <option value=\"5\">5</option>
            <option value=\"6\">6</option>
            <option value=\"7\">7</option>
          </select>
        </label></td>
      </tr>
	  
	    <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;\">Highest Mega Number Drawn</span></td>
      </tr>
      <tr>
        <td>
		<select name=\"megahighest\" id=\"megahighest\">
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
		
		
		</td>
      </tr>
	  
	  
	  
	  
	  
	  
	  <tr>
	  <td align=\"center\"><button type=\"button\" onClick=\"loadXMLDoc()\">Get My Lucky Number </button>
        <div align=\"center\"></div></td>
	  </tr>
    </table>
  </form>

<div id=\"myDiv\" style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; border-style:solid;
border-width:3px;\"></div></div>";

return $text;

}

add_shortcode('luckynumbers', 'lucky_numbers_gen');

?>