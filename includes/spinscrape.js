/** @file servscrape.js
 *	Purpose:  contains javascript to grab Spinitron Data
 *
 * @author Keith Gudger
 * @copyright  (c) 2019, Keith Gudger, all rights reserved
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    Release: 1.0
 * @package    KSQD
 *
 */
		function Ready(show_id) {
			var xmlhttp;
			let xm_ext = "";
			let dj_elem = document.getElementById('dj_number');
			if (dj_elem != null) {
				let dj_id = dj_elem.getAttribute('data-dj-number');
				if(dj_id != null){
//					alert('Variable "dj_number" is ' + dj_id);
					xm_ext = "&dj_number=" + dj_id;
				}    
			}
			try {
				xmlhttp=new XMLHttpRequest();
				console.log("xmlhttp");
			} catch(e) {
				xmlhttp = false;
				console.log(e);
			}
			if (xmlhttp) {
				console.log("xmlhttp2");
				xmlhttp.onreadystatechange=function()
				{
					console.log("readystatechange");
					console.log("State is " + xmlhttp.readyState + " Status is " + xmlhttp.status);
					if (xmlhttp.readyState==4)
					{  if ( (xmlhttp.status==200) || (xmlhttp.status==0) )
						{
							console.log("Good Status");
							var returnedList = (xmlhttp.responseText);
							fillForm(returnedList);
						}
					}
				}
			}
			xmlhttp.open("GET","https://ksqd.org/spinserv.php?show_id=" + show_id + xm_ext, true);
			xmlhttp.setRequestHeader ("Accept", "text/plain");
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send();
		}
		function fillForm(returnData) {
			var rData = JSON.parse(returnData)
			if (typeof (rData["airs"]) !== 'undefined') {
				console.log("airs exists");
				for (var airs in rData["airs"]) {
					console.log("airs data");
					document.getElementById('spinairs').innerHTML += rData["airs"][airs] + "<br>";
				}
			}
			if (typeof (rData["plist"]) !== 'undefined') {
				console.log("plist exists");
				for (var indx in rData["plist"]["text"]) {
					console.log("plist data");
					document.getElementById('spinlist').innerHTML += 
						"<a href='" + rData["plist"]["href"][indx] + "'>" + 
						rData["plist"]["text"][indx] + "</a><br>";
				}
			}
			if (typeof (rData["descrip"]) !== 'undefined') {
				console.log("descrip exists");
				var i = 0;
				var sdes = document.getElementById('spindesc');
				if (sdes) {
					sdes.innerHTML = " " ; 
					for (var descrip in rData["descrip"]) {
						console.log("descrip data");
						sdes.innerHTML += 
							rData["descrip"][descrip];
					}
				}
			}
			if (typeof (rData["djref"]) !== 'undefined') {
				console.log("djref exists");
				var i = 0;
				for (var djref in rData["djref"]) {
					console.log("djref data");
					var sdes = document.getElementById('spindjrf' + i++);
					if (sdes) {
						sdes.innerHTML = 
							rData["djref"][djref];
					}
				}
			}
			if (typeof (rData["djname"]) !== 'undefined') {
				console.log("djname exists");
				var i = 0;
				for (var djname in rData["djname"]) {
						console.log("djname data");
					var sdes = document.getElementById('spindjname' + i);
					if (sdes) {
						sdes.innerHTML = 
							rData["djname"][djname];
					} // first name place, then 2nd next
					sdes = document.getElementById('spindjnm' + i++);
					if (sdes) {
						sdes.innerHTML = 
							rData["djname"][djname];
					}
				}
			}
			if (typeof (rData["djimage"]) !== 'undefined') {
				console.log("djimage exists");
				var i = 0;
				for (var djimage in rData["djimage"]) {
					console.log("djimage data");
					var sdes = document.getElementById('spindjimg' + i++);
					if (sdes) {
						sdes.src = 
							rData["djimage"][djimage];
					}
				}
			}
			if (typeof (rData["djtext"]) !== 'undefined') {
				console.log("djtext exists");
				var i = 0;
				for (var djtext in rData["djtext"]) {
					console.log("djtext data");
					var sdes = document.getElementById('spindjtxt' + i);
					if (sdes) {
						sdes.innerHTML = 
							rData["djtext"][i++];
					}
				}
			}
		}
