var availableTags = ["Arabic","Bahasa Indonesia","Belgium","Brazilian Portuguese","Bulgarian","Cantonese","Chinese","Croatian","Czech","Danish","Deutsch","Dutch","English","Estonian","Finnish","French Canadian","French","Greek","Hebrew","Hindi","Hungarian","Icelandic","Italian","Japanese","Korean","Latvian","Lithuanian","Macedonian","Moldovan","Norwegian","Polish","Portuguese","Romanian","Russian","Serbian","Slovakian","Slovenian","Spanish","Swedish","Turkish","Ukrainian","Vietnamese"];
function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
jQuery( "#langs" )
// don't navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === jQuery.ui.keyCode.TAB &&
jQuery( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})
.autocomplete({
minLength: 0,
source: function( request, response ) {
// delegate back to autocomplete, but extract the last term
response( jQuery.ui.autocomplete.filter(
availableTags, extractLast( request.term ) ) );
},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );
// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
return false;
}
});

var countries = ["Saudi Arabia","Indonesia","Belgium","Brazil","Bulgaria","China","Croatia","Czech","Denmark","Germany","Netherlands","Estonia","Finland","Canada","France","Greece","Israel","India","Hungary","Iceland","Italy","Japan","South Korea","Latvia","Lithuania","Macedonia","Moldova","Norway","Poland","Portugal","Romania","Russia","Serbia","Slovakia","Slovenia","Spain","Sweden","Turkey","Ukraine","Vietname", "United Kingdom", "United States"];

function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
jQuery( "#countries" )
// don't navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === jQuery.ui.keyCode.TAB &&
jQuery( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})
.autocomplete({
minLength: 0,
source: function( request, response ) {
// delegate back to autocomplete, but extract the last term
response( jQuery.ui.autocomplete.filter(
countries, extractLast( request.term ) ) );
},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );
// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
return false;
}
});