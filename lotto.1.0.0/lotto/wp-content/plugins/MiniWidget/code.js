// JavaScript Document

function alertit() 
{
	

var thehighest = document.luckyform.thehighest.value ; 
var hmany = document.luckyform.hmany.value ; 
var withmega = document.luckyform.withmega.value ;
var withzeros = document.luckyform.withzeros.value; 
var hmanymega = document.luckyform.hmanymega.value ; 
var withmegahighest = document.luckyform.withmegahighest.value ; 
var withZerosNumber;
var randomnumbers ; 
var output = "Your Lucky Nmbers Are <br />";
var i = 0 ;

for (i=0; i< hmany ; i++ ) 
{
	if (withzeros == 1 )  
	{
		
randomnumbers = Math.floor(Math.random()* 500000 ) ;
		
		withZerosNumber = (randomnumbers%thehighest ) ; 
		output = output+ withZerosNumber+"-"  ; 
	}
		
	else
	{
randomnumbers = Math.floor(Math.random()* 500000 ) ;
		withZerosNumber = (randomnumbers%thehighest )+1 ;
	    output = output+withZerosNumber+"-" ;	
	}

}
if (withmega == 1 )
{
	output = output + "<br />" + " Your Mega Bonus Numbers Are <br />"; 
	for (i=0;i<hmanymega;i++)
	{
		if (withzeros == 1 )
		{
randomnumbers = Math.floor(Math.random()* 500000 ) ;
			
			withZerosNumber = (randomnumbers%withmegahighest ) ; 
			output = output+withZerosNumber+"-" ; 
		}
	
	    else
	    {
randomnumbers = Math.floor(Math.random()* 500000 ) ;
		withZerosNumber = (randomnumbers%withmegahighest ) +1 ;
	    output = output+ withZerosNumber+"-" ;	
	    }
	
	}
}


/*output = withmega + thehighest + hmany + hmanymega + withzeros + withmegahighest ;*/


document.getElementById('towrite').innerHTML = output ; 

}
