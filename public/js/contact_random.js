var array = [
	{	"url": "img/vmc-contact.jpg",
	 	"alt": "Lodge, John C. from the Virtual Motor City Collection, Wayne State Univerity Library System's Digital Collections" 
	},
	{
		"url": "img/vmc-contact_2.jpg",
		"alt": "Michigan Bell Telephone Co from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	},
	{
		"url": "img/vmc-contact_3.jpg",
		"alt": "Telephones : First Phone Book In Detroit : Operators from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	},
	{
		"url": "img/vmc-contact_4.jpg",
		"alt": "Telephones : First Phone Book In Detroit : Operators from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	},
	{
		"url": "img/vmc-contact_5.jpg",
		"alt": "Michigan Bell Telephone Co. Equipment from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	},
	{
		"url": "img/vmc-contact_6.jpg",
		"alt": "Portraits at desk mug on phone from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	},
	{
		"url": "img/vmc-contact_7.jpg",
		"alt": "Corrigan, Douglas from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	},
	{
		"url": "img/vmc-contact_8.jpg",
		"alt": "Michigan Bell Telephone Co from the Virtual Motor City Collection, Wayne State University Library System's Digital Collections"
	}
];
var obj = '';
function getImage(array) {
	var random = array[Math.floor(Math.random() * array.length)];
	obj = random;
	$("p.caption").html(obj.alt);
	$("#imagery").attr('alt', obj.alt);
	$("#imagery").attr('src', obj.url);
}